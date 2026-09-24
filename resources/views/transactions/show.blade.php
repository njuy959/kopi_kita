@extends('layouts.dashboard')

@section('title', 'Transaksi')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-[#1F1F1F]">
                Transaksi
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola dan lihat seluruh transaksi KOPI KITA.
            </p>
        </div>

        <a
            href="{{ route('pos.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#5C3D2E] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#6F452F]"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 2h13m-3 4a1 1 0 11-2 0m-6 0a1 1 0 11-2 0"
                />
            </svg>

            Transaksi Baru
        </a>

    </div>


    {{-- FILTER --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

        <form
            action="{{ route('transactions.index') }}"
            method="GET"
            class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4"
        >

            {{-- SEARCH --}}
            <div class="lg:col-span-2">

                <label
                    for="search"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Cari Transaksi
                </label>

                <div class="relative">

                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                            />
                        </svg>
                    </div>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Nomor transaksi atau nama kasir..."
                        class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-10 pr-4 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10"
                    >

                </div>

            </div>


            {{-- PAYMENT METHOD --}}
            <div>

                <label
                    for="payment_method"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Metode Pembayaran
                </label>

                <select
                    id="payment_method"
                    name="payment_method"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10"
                >

                    <option value="">
                        Semua Metode
                    </option>

                    <option
                        value="cash"
                        {{ request('payment_method') === 'cash' ? 'selected' : '' }}
                    >
                        Cash
                    </option>

                    <option
                        value="qris"
                        {{ request('payment_method') === 'qris' ? 'selected' : '' }}
                    >
                        QRIS
                    </option>

                    <option
                        value="debit"
                        {{ request('payment_method') === 'debit' ? 'selected' : '' }}
                    >
                        Debit
                    </option>

                    <option
                        value="e-wallet"
                        {{ request('payment_method') === 'e-wallet' ? 'selected' : '' }}
                    >
                        E-Wallet
                    </option>

                </select>

            </div>


            {{-- DATE --}}
            <div>

                <label
                    for="date"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Tanggal
                </label>

                <input
                    type="date"
                    id="date"
                    name="date"
                    value="{{ request('date') }}"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10"
                >

            </div>


            {{-- BUTTONS --}}
            <div class="flex items-end gap-2 md:col-span-2 lg:col-span-4">

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#5C3D2E] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#6F452F]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                        />
                    </svg>

                    Cari
                </button>

                <a
                    href="{{ route('transactions.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- TOTAL TRANSACTIONS --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Total Transaksi
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#1F1F1F]">
                        {{ method_exists($transactions, 'total') ? $transactions->total() : $transactions->count() }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#F5E6CA] text-[#5C3D2E]">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- TOTAL PAGE --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Data Ditampilkan
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#1F1F1F]">
                        {{ $transactions->count() }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- CASH --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Cash
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#1F1F1F]">
                        {{ $transactions->where('payment_method', 'cash')->count() }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 8c-1.105 0-2 .672-2 1.5S10.895 11 12 11s2 .672 2 1.5S13.105 14 12 14m0-6V6m0 8v2m8-4a8 8 0 11-16 0 8 8 0 0116 0z"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- QRIS --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        QRIS
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#1F1F1F]">
                        {{ $transactions->where('payment_method', 'qris')->count() }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 0h2m2 0h2v2m-4 2h2v2m2-4h2"
                        />
                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- TABLE --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        {{-- TABLE HEADER --}}
        <div class="flex flex-col gap-2 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-lg font-bold text-[#1F1F1F]">
                    Riwayat Transaksi
                </h2>

                <p class="text-sm text-gray-500">
                    Daftar transaksi yang tersimpan di sistem.
                </p>
            </div>

        </div>


        {{-- DESKTOP TABLE --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-[#F7F5F2]">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            #
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Invoice
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Kasir
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                            Pembayaran
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                            Total
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-500">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($transactions as $transaction)

                        @php
                            $invoice = $transaction->invoice_number
                                ?? $transaction->transaction_code
                                ?? ('TRX-' . str_pad($transaction->id, 6, '0', STR_PAD_LEFT));

                            $total = $transaction->grand_total
                                ?? $transaction->total
                                ?? 0;

                            $paymentMethod = strtolower($transaction->payment_method ?? '-');

                            $userName = optional($transaction->user)->name
                                ?? 'Kasir';

                            $date = $transaction->transaction_date
                                ?? $transaction->created_at;
                        @endphp

                        <tr class="transition hover:bg-[#F7F5F2]">

                            {{-- NUMBER --}}
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">

                                {{ method_exists($transactions, 'firstItem') ? $transactions->firstItem() + $loop->index : $loop->iteration }}

                            </td>


                            {{-- INVOICE --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <a
                                    href="{{ route('transactions.show', $transaction) }}"
                                    class="font-bold text-[#5C3D2E] hover:underline"
                                >
                                    {{ $invoice }}
                                </a>

                            </td>


                            {{-- CASHIER --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#F5E6CA] font-bold text-[#5C3D2E]">
                                        {{ strtoupper(substr($userName, 0, 1)) }}
                                    </div>

                                    <span class="text-sm font-medium text-gray-700">
                                        {{ $userName }}
                                    </span>

                                </div>

                            </td>


                            {{-- DATE --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <p class="text-sm font-medium text-gray-700">
                                    {{ $date ? \Carbon\Carbon::parse($date)->format('d M Y') : '-' }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    {{ $date ? \Carbon\Carbon::parse($date)->format('H:i') : '-' }}
                                </p>

                            </td>


                            {{-- PAYMENT --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                @php
                                    $paymentLabel = match ($paymentMethod) {
                                        'cash' => 'Cash',
                                        'qris' => 'QRIS',
                                        'debit' => 'Debit',
                                        'e-wallet', 'ewallet', 'e_wallet' => 'E-Wallet',
                                        default => ucfirst($paymentMethod),
                                    };

                                    $paymentClass = match ($paymentMethod) {
                                        'cash' => 'bg-green-100 text-green-700',
                                        'qris' => 'bg-purple-100 text-purple-700',
                                        'debit' => 'bg-blue-100 text-blue-700',
                                        'e-wallet', 'ewallet', 'e_wallet' => 'bg-orange-100 text-orange-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp

                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $paymentClass }}">
                                    {{ $paymentLabel }}
                                </span>

                            </td>


                            {{-- TOTAL --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right">

                                <span class="text-sm font-bold text-[#1F1F1F]">
                                    Rp{{ number_format((float) $total, 0, ',', '.') }}
                                </span>

                            </td>


                            {{-- ACTION --}}
                            <td class="whitespace-nowrap px-6 py-4 text-center">

                                <a
                                    href="{{ route('transactions.show', $transaction) }}"
                                    class="inline-flex items-center gap-1 rounded-lg bg-[#5C3D2E] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#6F452F]"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />
                                    </svg>

                                    Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-16 text-center"
                            >

                                <div class="mx-auto flex max-w-sm flex-col items-center">

                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#F5E6CA] text-[#5C3D2E]">

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-8 w-8"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"
                                            />
                                        </svg>

                                    </div>

                                    <h3 class="mt-4 text-lg font-bold text-gray-800">
                                        Belum Ada Transaksi
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Transaksi yang berhasil diproses akan muncul di sini.
                                    </p>

                                    <a
                                        href="{{ route('pos.index') }}"
                                        class="mt-5 rounded-xl bg-[#5C3D2E] px-5 py-3 text-sm font-semibold text-white hover:bg-[#6F452F]"
                                    >
                                        Buat Transaksi
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- MOBILE CARD --}}
        <div class="divide-y divide-gray-100 md:hidden">

            @forelse($transactions as $transaction)

                @php
                    $invoice = $transaction->invoice_number
                        ?? $transaction->transaction_code
                        ?? ('TRX-' . str_pad($transaction->id, 6, '0', STR_PAD_LEFT));

                    $total = $transaction->grand_total
                        ?? $transaction->total
                        ?? 0;

                    $paymentMethod = strtolower($transaction->payment_method ?? '-');

                    $userName = optional($transaction->user)->name
                        ?? 'Kasir';

                    $date = $transaction->transaction_date
                        ?? $transaction->created_at;
                @endphp

                <a
                    href="{{ route('transactions.show', $transaction) }}"
                    class="block p-5 transition active:bg-gray-50"
                >

                    <div class="flex items-start justify-between gap-4">

                        <div class="min-w-0">

                            <p class="truncate font-bold text-[#5C3D2E]">
                                {{ $invoice }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                {{ $date ? \Carbon\Carbon::parse($date)->format('d M Y, H:i') : '-' }}
                            </p>

                        </div>

                        <span class="shrink-0 text-sm font-bold text-[#1F1F1F]">
                            Rp{{ number_format((float) $total, 0, ',', '.') }}
                        </span>

                    </div>


                    <div class="mt-4 flex items-center justify-between">

                        <div class="flex items-center gap-2">

                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#F5E6CA] text-xs font-bold text-[#5C3D2E]">
                                {{ strtoupper(substr($userName, 0, 1)) }}
                            </div>

                            <span class="text-sm text-gray-600">
                                {{ $userName }}
                            </span>

                        </div>


                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                            {{ strtoupper($paymentMethod) }}
                        </span>

                    </div>

                </a>

            @empty

                <div class="px-5 py-16 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#F5E6CA] text-[#5C3D2E]">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"
                            />
                        </svg>

                    </div>

                    <p class="mt-4 font-bold text-gray-800">
                        Belum ada transaksi
                    </p>

                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        @if(method_exists($transactions, 'links'))

            <div class="border-t border-gray-200 px-5 py-4">

                {{ $transactions->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>

@endsection