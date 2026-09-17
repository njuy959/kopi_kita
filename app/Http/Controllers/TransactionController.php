<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'invoice_number',
                    'like',
                    "%{$search}%"
                )
                ->orWhereHas('user', function ($user) use ($search) {
                    $user->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );
                });
            });
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

        if ($request->filled('cashier')) {
            $query->where(
                'user_id',
                $request->cashier
            );
        }

        if ($request->filled('payment_method')) {
            $query->where(
                'payment_method',
                $request->payment_method
            );
        }

        $transactions = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $cashiers = \App\Models\User::where(
            'role',
            'cashier'
        )
        ->orderBy('name')
        ->get();

        return view(
            'transactions.index',
            compact(
                'transactions',
                'cashiers'
            )
        );
    }

    public function show(Transaction $transaction)
    {
        $transaction->load([
            'user',
            'items.product',
        ]);

        return view(
            'transactions.show',
            compact('transaction')
        );
    }
}