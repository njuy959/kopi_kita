<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockHistory;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $query = Product::with('category')
            ->where('is_active', true)
            ->where('stock', '>', 0);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($category) use ($search) {
                        $category->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        if ($request->filled('category')) {
            $query->where(
                'category_id',
                $request->category
            );
        }

        $products = $query
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('pos.index', compact(
            'products',
            'categories'
        ));
    }

    public function products(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($category) use ($search) {
                        $category->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        if ($request->filled('category')) {
            $query->where(
                'category_id',
                $request->category
            );
        }

        return response()->json(
            $query->orderBy('name')->get()
        );
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => [
                'required',
                'in:cash,qris,debit,e_wallet'
            ],
            'paid_amount' => [
                'nullable',
                'numeric',
                'min:0'
            ],
        ]);

        try {
            $transaction = DB::transaction(function () use ($validated) {

                $items = $validated['items'];

                $subtotal = 0;
                $transactionItems = [];

                foreach ($items as $item) {

                    $product = Product::where(
                        'id',
                        $item['product_id']
                    )
                    ->lockForUpdate()
                    ->first();

                    if (!$product) {
                        throw ValidationException::withMessages([
                            'items' => 'Produk tidak ditemukan.',
                        ]);
                    }

                    if (!$product->is_active) {
                        throw ValidationException::withMessages([
                            'items' => "Produk {$product->name} tidak tersedia.",
                        ]);
                    }

                    $quantity = (int) $item['quantity'];

                    if ($product->stock < $quantity) {
                        throw ValidationException::withMessages([
                            'items' => "Stok {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}.",
                        ]);
                    }

                    $price = (float) $product->price;

                    $itemSubtotal = $price * $quantity;

                    $subtotal += $itemSubtotal;

                    $transactionItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $itemSubtotal,
                    ];
                }

                $discount = (float) ($validated['discount'] ?? 0);

                if ($discount > $subtotal) {
                    $discount = $subtotal;
                }

                $total = $subtotal - $discount;

                $paymentMethod = $validated['payment_method'];

                if ($paymentMethod === 'cash') {

                    $paidAmount = (float) (
                        $validated['paid_amount'] ?? 0
                    );

                    if ($paidAmount < $total) {
                        throw ValidationException::withMessages([
                            'paid_amount' => 'Jumlah pembayaran kurang dari total.',
                        ]);
                    }

                    $changeAmount = $paidAmount - $total;

                } else {

                    $paidAmount = $total;
                    $changeAmount = 0;
                }

                $transaction = Transaction::create([
                    'invoice_number' => $this->generateInvoiceNumber(),
                    'user_id' => Auth::id(),
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'total' => $total,
                    'payment_method' => $paymentMethod,
                    'paid_amount' => $paidAmount,
                    'change_amount' => $changeAmount,
                    'status' => 'paid',
                ]);

                foreach ($transactionItems as $item) {

                    $product = $item['product'];

                    $stockBefore = $product->stock;

                    $product->decrement(
                        'stock',
                        $item['quantity']
                    );

                    $product->refresh();

                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    StockHistory::create([
                        'product_id' => $product->id,
                        'user_id' => Auth::id(),
                        'type' => 'sale',
                        'quantity' => $item['quantity'],
                        'stock_before' => $stockBefore,
                        'stock_after' => $product->stock,
                        'description' =>
                            'Penjualan ' . $transaction->invoice_number,
                    ]);
                }

                return $transaction;
            });

            return redirect()
                ->route(
                    'pos.receipt',
                    $transaction
                )
                ->with(
                    'success',
                    'Transaksi berhasil diproses.'
                );

        } catch (ValidationException $e) {
            throw $e;

        } catch (Throwable $e) {

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Transaksi gagal diproses. Tidak ada data yang diubah.'
                );
        }
    }

    public function receipt(Transaction $transaction)
    {
        $transaction->load([
            'user',
            'items.product',
        ]);

        return view(
            'pos.receipt',
            compact('transaction')
        );
    }

    private function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');

        $lastTransaction = Transaction::whereDate(
            'created_at',
            now()->toDateString()
        )
        ->lockForUpdate()
        ->latest('id')
        ->first();

        $number = $lastTransaction
            ? ((int) substr($lastTransaction->invoice_number, -4)) + 1
            : 1;

        return sprintf(
            'TRX-%s-%04d',
            $date,
            $number
        );
    }
}