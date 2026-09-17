<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
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

        if ($request->filled('stock')) {

            if ($request->stock === 'low') {
                $query->where('stock', '<=', 5);
            }

            if ($request->stock === 'empty') {
                $query->where('stock', 0);
            }

            if ($request->stock === 'available') {
                $query->where('stock', '>', 5);
            }
        }

        $products = $query
            ->orderBy('stock')
            ->paginate(15)
            ->withQueryString();

        return view(
            'stocks.index',
            compact('products')
        );
    }

    public function history(Request $request)
    {
        $query = StockHistory::with([
            'product',
            'user',
        ]);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas(
                'product',
                function ($product) use ($search) {
                    $product->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );
                }
            );
        }

        if ($request->filled('type')) {
            $query->where(
                'type',
                $request->type
            );
        }

        if ($request->filled('date_from')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->date_from
            );
        }

        if ($request->filled('date_to')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->date_to
            );
        }

        $histories = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'stocks.history',
            compact('histories')
        );
    }

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],
            'description' => [
                'nullable',
                'string',
                'max:500'
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $product
        ) {

            $lockedProduct = Product::where(
                'id',
                $product->id
            )
            ->lockForUpdate()
            ->firstOrFail();

            $stockBefore = $lockedProduct->stock;

            $lockedProduct->increment(
                'stock',
                $validated['quantity']
            );

            $lockedProduct->refresh();

            StockHistory::create([
                'product_id' => $lockedProduct->id,
                'user_id' => Auth::id(),
                'type' => 'in',
                'quantity' => $validated['quantity'],
                'stock_before' => $stockBefore,
                'stock_after' => $lockedProduct->stock,
                'description' =>
                    $validated['description']
                    ?? 'Penambahan stok',
            ]);
        });

        return back()->with(
            'success',
            'Stok berhasil ditambahkan.'
        );
    }

    public function remove(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],
            'description' => [
                'nullable',
                'string',
                'max:500'
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $product
        ) {

            $lockedProduct = Product::where(
                'id',
                $product->id
            )
            ->lockForUpdate()
            ->firstOrFail();

            if (
                $lockedProduct->stock
                < $validated['quantity']
            ) {
                throw ValidationException::withMessages([
                    'quantity' =>
                        'Jumlah stok yang dikurangi melebihi stok tersedia.',
                ]);
            }

            $stockBefore = $lockedProduct->stock;

            $lockedProduct->decrement(
                'stock',
                $validated['quantity']
            );

            $lockedProduct->refresh();

            StockHistory::create([
                'product_id' => $lockedProduct->id,
                'user_id' => Auth::id(),
                'type' => 'out',
                'quantity' => $validated['quantity'],
                'stock_before' => $stockBefore,
                'stock_after' => $lockedProduct->stock,
                'description' =>
                    $validated['description']
                    ?? 'Pengurangan stok',
            ]);
        });

        return back()->with(
            'success',
            'Stok berhasil dikurangi.'
        );
    }

    public function adjustment(
        Request $request,
        Product $product
    ) {
        $validated = $request->validate([
            'stock' => [
                'required',
                'integer',
                'min:0'
            ],
            'description' => [
                'required',
                'string',
                'max:500'
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $product
        ) {

            $lockedProduct = Product::where(
                'id',
                $product->id
            )
            ->lockForUpdate()
            ->firstOrFail();

            $stockBefore = $lockedProduct->stock;
            $stockAfter = $validated['stock'];

            $lockedProduct->update([
                'stock' => $stockAfter,
            ]);

            StockHistory::create([
                'product_id' => $lockedProduct->id,
                'user_id' => Auth::id(),
                'type' => 'adjustment',
                'quantity' => abs(
                    $stockAfter - $stockBefore
                ),
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'description' =>
                    $validated['description'],
            ]);
        });

        return back()->with(
            'success',
            'Stok berhasil disesuaikan.'
        );
    }
}