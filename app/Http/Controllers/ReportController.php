<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return redirect()->route('reports.sales');
    }

    public function sales(Request $request)
    {
        [$startDate, $endDate] = $this->getDateRange($request);

        $transactionsQuery = Transaction::whereBetween(
            'created_at',
            [
                $startDate->startOfDay(),
                $endDate->endOfDay(),
            ]
        )->where('status', 'paid');

        $totalSales = (clone $transactionsQuery)->sum('total');

        $totalTransactions = (clone $transactionsQuery)->count();

        $totalProductsSold = TransactionItem::whereHas(
            'transaction',
            function ($query) use ($startDate, $endDate) {

                $query->whereBetween(
                    'created_at',
                    [
                        $startDate->startOfDay(),
                        $endDate->endOfDay(),
                    ]
                )
                ->where('status', 'paid');
            }
        )->sum('quantity');

        $averageTransaction = $totalTransactions > 0
            ? $totalSales / $totalTransactions
            : 0;

        $salesChart = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as transactions')
            )
            ->whereBetween(
                'created_at',
                [
                    $startDate->startOfDay(),
                    $endDate->endOfDay(),
                ]
            )
            ->where('status', 'paid')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        return view(
            'reports.sales',
            compact(
                'startDate',
                'endDate',
                'totalSales',
                'totalTransactions',
                'totalProductsSold',
                'averageTransaction',
                'salesChart'
            )
        );
    }

    public function products(Request $request)
    {
        [$startDate, $endDate] = $this->getDateRange($request);

        $products = TransactionItem::select(
                'product_id',
                'product_name',
                DB::raw('SUM(quantity) as total_sold'),
                DB::raw('SUM(subtotal) as total_revenue')
            )
            ->whereHas(
                'transaction',
                function ($query) use ($startDate, $endDate) {

                    $query->whereBetween(
                        'created_at',
                        [
                            $startDate->startOfDay(),
                            $endDate->endOfDay(),
                        ]
                    )
                    ->where('status', 'paid');
                }
            )
            ->groupBy(
                'product_id',
                'product_name'
            )
            ->orderByDesc('total_sold')
            ->get();

        return view(
            'reports.products',
            compact(
                'startDate',
                'endDate',
                'products'
            )
        );
    }

    private function getDateRange(Request $request): array
    {
        $range = $request->get('range', 'today');

        switch ($range) {

            case 'yesterday':

                $startDate = Carbon::yesterday();
                $endDate = Carbon::yesterday();

                break;

            case '7days':

                $startDate = Carbon::today()->subDays(6);
                $endDate = Carbon::today();

                break;

            case '30days':

                $startDate = Carbon::today()->subDays(29);
                $endDate = Carbon::today();

                break;

            case 'custom':

                $startDate = $request->filled('date_from')
                    ? Carbon::parse($request->date_from)
                    : Carbon::today();

                $endDate = $request->filled('date_to')
                    ? Carbon::parse($request->date_to)
                    : Carbon::today();

                break;

            default:

                $startDate = Carbon::today();
                $endDate = Carbon::today();

                break;
        }

        return [
            $startDate,
            $endDate,
        ];
    }
}