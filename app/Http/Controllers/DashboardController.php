<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIK HARI INI
        |--------------------------------------------------------------------------
        */

        $today = now()->toDateString();

        $productsCount = Product::where('is_active', true)->count();

        $transactionsCount = Transaction::whereDate('created_at', $today)
            ->where('status', 'paid')
            ->count();

        $revenueToday = Transaction::whereDate('created_at', $today)
            ->where('status', 'paid')
            ->sum('total');

        $lowStockCount = Product::where('stock', '<=', 5)
            ->where('is_active', true)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | PRODUK STOK MENIPIS
        |--------------------------------------------------------------------------
        */

        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', 5)
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->orderBy('name', 'asc')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PRODUK FAVORIT
        |--------------------------------------------------------------------------
        */

        $favoriteProducts = TransactionItem::query()
            ->select(
                'product_id',
                'product_name',
                DB::raw('SUM(quantity) as total_sold'),
                DB::raw('SUM(subtotal) as total_revenue')
            )
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'paid');
            })
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI TERBARU
        |--------------------------------------------------------------------------
        */

        $recentTransactions = Transaction::with('user')
            ->latest('created_at')
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('dashboard.index', compact(
            'productsCount',
            'transactionsCount',
            'revenueToday',
            'lowStockCount',
            'lowStockProducts',
            'favoriteProducts',
            'recentTransactions'
        ));
    }
}
