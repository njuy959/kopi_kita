<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where(
                'name',
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->filled('category')) {
            $query->where(
                'category_id',
                $request->category
            );
        }

        if ($request->filled('status')) {

            $query->where(
                'is_active',
                $request->status === 'active'
            );
        }

        if ($request->stock === 'low') {
            $query->where('stock', '<=', 5);
        }

        if ($request->stock === 'empty') {
            $query->where('stock', 0);
        }

        $products = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view(
            'products.index',
            compact('products', 'categories')
        );
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view(
            'products.create',
            compact('categories')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'category_id' => [
                'required',
                'exists:categories,id'
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'price' => [
                'required',
                'numeric',
                'min:0'
            ],
            'stock' => [
                'required',
                'integer',
                'min:0'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
            'is_active' => [
                'nullable',
                'boolean'
            ],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        $validated['is_active'] = $request->boolean(
            'is_active'
        );

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Produk berhasil ditambahkan.'
            );
    }

    public function show(Product $product)
    {
        $product->load('category');

        return view(
            'products.show',
            compact('product')
        );
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view(
            'products.edit',
            compact('product', 'categories')
        );
    }

    public function update(
        Request $request,
        Product $product
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'category_id' => [
                'required',
                'exists:categories,id'
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'price' => [
                'required',
                'numeric',
                'min:0'
            ],
            'stock' => [
                'required',
                'integer',
                'min:0'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
            'is_active' => [
                'nullable',
                'boolean'
            ],
        ]);

        if ($request->hasFile('image')) {

            if (
                $product->image &&
                Storage::disk('public')->exists(
                    $product->image
                )
            ) {
                Storage::disk('public')->delete(
                    $product->image
                );
            }

            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        $validated['is_active'] = $request->boolean(
            'is_active'
        );

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Produk berhasil diperbarui.'
            );
    }

    public function destroy(Product $product)
    {
        /*
         * Produk yang sudah digunakan transaksi
         * tidak langsung dihapus secara permanen.
         */
        if ($product->transactionItems()->exists()) {

            $product->update([
                'is_active' => false,
            ]);

            return redirect()
                ->route('products.index')
                ->with(
                    'success',
                    'Produk sudah digunakan dalam transaksi sehingga dinonaktifkan.'
                );
        }

        if (
            $product->image &&
            Storage::disk('public')->exists(
                $product->image
            )
        ) {
            Storage::disk('public')->delete(
                $product->image
            );
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Produk berhasil dihapus.'
            );
    }
}