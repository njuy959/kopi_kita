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
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $products = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact(
            'products',
            'categories'
        ));
    }


    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'is_active' => [
                'required',
                Rule::in(['0', '1', 0, 1]),
            ],
        ]);


        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        } else {
            $validated['image'] = null;
        }


        $validated['is_active'] = (bool) $request->input('is_active');


        Product::create($validated);


        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }


    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }


    public function edit(Product $product)
    {
        $product->load('category');

        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact(
            'product',
            'categories'
        ));
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'is_active' => [
                'required',
                Rule::in(['0', '1', 0, 1]),
            ],
        ]);


        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        } else {

            unset($validated['image']);

        }


        $validated['is_active'] = (bool) $request->input('is_active');


        $product->update($validated);


        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }


    public function destroy(Product $product)
    {
        if ($product->transactionItems()->exists()) {
            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'Produk tidak dapat dihapus karena sudah digunakan dalam transaksi.'
                );
        }


        if ($product->stockHistories()->exists()) {
            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'Produk tidak dapat dihapus karena memiliki riwayat stok.'
                );
        }


        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }


        $product->delete();


        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}