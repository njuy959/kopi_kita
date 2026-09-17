<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $todayTransactions = Transaction::whereDate(
            'created_at',
            $today
        )->where('status', 'paid');

        $totalSalesToday = (clone $todayTransactions)->sum('total');

        $totalTransactionsToday = (clone $todayTransactions)->count();

        $totalProductsSoldToday = TransactionItem::whereHas(
            'transaction',
            function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->where('status', 'paid');
            }
        )->sum('quantity');

        $lowStockProducts = Product::where(
            'stock',
            '<=',
            5
        )->where('is_active', true)->count();

        $topProducts = TransactionItem::select(
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

        $recentTransactions = Transaction::with('user')
            ->latest()
            ->limit(10)
            ->get();

        $salesLast7Days = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $sales = Transaction::whereDate(
                    'created_at',
                    $date
                )
                ->where('status', 'paid')
                ->sum('total');

            $salesLast7Days[] = [
                'date' => $date->format('d/m'),
                'total' => $sales,
            ];
        }

        $salesLast30Days = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $sales = Transaction::whereDate(
                    'created_at',
                    $date
                )
                ->where('status', 'paid')
                ->sum('total');

            $salesLast30Days[] = [
                'date' => $date->format('d/m'),
                'total' => $sales,
            ];
        }

        return view('dashboard.index', compact(
            'totalSalesToday',
            'totalTransactionsToday',
            'totalProductsSoldToday',
            'lowStockProducts',
            'topProducts',
            'recentTransactions',
            'salesLast7Days',
            'salesLast30Days'
        ));
    }
}