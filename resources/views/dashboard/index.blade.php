@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div>
            <p class="text-sm font-medium text-[#8B6F5A]">
                Selamat datang kembali 👋
            </p>

            <h1 class="mt-1 text-2xl font-extrabold tracking-tight text-[#1F1F1F] sm:text-3xl">
                Dashboard KOPI KITA
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Pantau aktivitas coffee shop kamu hari ini.
            </p>
        </div>


        {{-- DATE --}}
        <div class="flex items-center gap-3 rounded-2xl border border-gray-100 bg-white px-4 py-3 shadow-sm">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F5E6CA] text-[#5C3D2E]">

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M8 2v4m8-4v4M3 10h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"
                    />
                </svg>

            </div>

            <div>
                <p class="text-xs text-gray-400">
                    Hari ini
                </p>

                <p class="text-sm font-bold text-[#1F1F1F]">
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>

        </div>

    </div>



    {{-- =========================================================
        STAT CARDS
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- PRODUCTS --}}
        <div class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Total Produk
                    </p>

                    <h2 class="mt-2 text-3xl font-extrabold text-[#1F1F1F]">
                        {{ number_format($productsCount ?? 0, 0, ',', '.') }}
                    </h2>

                    <p class="mt-2 text-xs text-gray-400">
                        Produk tersedia di sistem
                    </p>
                </div>


                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F5E6CA] text-[#5C3D2E] transition group-hover:scale-105">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M20 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2ZM6 7V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2M9 12h6"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- TRANSACTIONS --}}
        <div class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Transaksi Hari Ini
                    </p>

                    <h2 class="mt-2 text-3xl font-extrabold text-[#1F1F1F]">
                        {{ number_format($transactionsCount ?? 0, 0, ',', '.') }}
                    </h2>

                    <p class="mt-2 text-xs text-gray-400">
                        Transaksi yang tercatat hari ini
                    </p>
                </div>


                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F5E6CA] text-[#5C3D2E] transition group-hover:scale-105">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M6 2h12v20l-3-2-3 2-3-2-3 2V2Zm3 5h6M9 11h6M9 15h4"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- REVENUE --}}
        <div class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

            <div class="flex items-start justify-between">

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-500">
                        Pendapatan Hari Ini
                    </p>

                    <h2 class="mt-2 truncate text-2xl font-extrabold text-[#1F1F1F] sm:text-3xl">
                        Rp {{ number_format($revenueToday ?? 0, 0, ',', '.') }}
                    </h2>

                    <p class="mt-2 text-xs text-gray-400">
                        Total pendapatan hari ini
                    </p>

                </div>


                <div class="ml-3 flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#F5E6CA] text-[#5C3D2E] transition group-hover:scale-105">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M12 3v18m4-14.5c-.7-.9-2-1.5-4-1.5-2.5 0-4 1.2-4 3s1.5 2.8 4 3.5 4 1.5 4 3.5-1.5 3.5-4 3.5c-2 0-3.5-.6-4.5-1.7"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- LOW STOCK --}}
        <div class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Stok Menipis
                    </p>

                    <h2 class="mt-2 text-3xl font-extrabold text-[#1F1F1F]">
                        {{ number_format($lowStockCount ?? 0, 0, ',', '.') }}
                    </h2>

                    <p class="mt-2 text-xs text-gray-400">
                        Produk dengan stok ≤ 5
                    </p>
                </div>


                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-50 text-orange-600 transition group-hover:scale-105">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M12 9v4m0 4h.01M10.3 3.8 2.9 17a2 2 0 0 0 1.75 3h14.7a2 2 0 0 0 1.75-3L13.7 3.8a2 2 0 0 0-3.4 0Z"
                        />
                    </svg>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        QUICK ACTION
    ========================================================== --}}
    <div class="rounded-2xl bg-[#5C3D2E] p-5 shadow-sm sm:p-6">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div class="text-white">

                <p class="text-sm font-medium text-white/70">
                    KOPI KITA POS
                </p>

                <h2 class="mt-1 text-xl font-extrabold sm:text-2xl">
                    Siap melayani pelanggan?
                </h2>

                <p class="mt-1 text-sm text-white/70">
                    Mulai transaksi baru dari halaman POS Kasir.
                </p>

            </div>


            <a
                href="{{ route('pos.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-bold text-[#5C3D2E] shadow-sm transition hover:bg-[#F5E6CA]"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13 5 5m2 8 1 5h10m-8 0a1 1 0 1 1-2 0m10 0a1 1 0 1 1-2 0"
                    />
                </svg>

                Buka POS

            </a>

        </div>

    </div>



    {{-- =========================================================
        LOWER CONTENT
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">


        {{-- =====================================================
            FAVORITE PRODUCTS
        ====================================================== --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">

                <div>
                    <h2 class="font-bold text-[#1F1F1F]">
                        Menu Favorit
                    </h2>

                    <p class="mt-0.5 text-xs text-gray-400">
                        Produk yang paling sering terjual
                    </p>
                </div>


                @if(auth()->user()->role === 'admin')
                    <a
                        href="{{ route('reports.products') }}"
                        class="text-xs font-bold text-[#5C3D2E] hover:underline"
                    >
                        Lihat laporan
                    </a>
                @endif

            </div>


            <div class="p-5">

                @if(isset($favoriteProducts) && $favoriteProducts->count())

                    <div class="space-y-4">

                        @foreach($favoriteProducts as $index => $product)

                            <div class="flex items-center gap-3">

                                {{-- NUMBER --}}
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#F5E6CA] text-sm font-extrabold text-[#5C3D2E]">
                                    {{ $index + 1 }}
                                </div>


                                {{-- IMAGE --}}
                                <div class="h-11 w-11 shrink-0 overflow-hidden rounded-xl bg-[#F5E6CA]">

                                    @if(!empty($product->image))

                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <div class="flex h-full w-full items-center justify-center text-[#8B6F5A]">

                                            <svg
                                                class="h-5 w-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M8 10h.01M16 10h.01M9 16c1.5 1 4.5 1 6 0m6-4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                                />
                                            </svg>

                                        </div>

                                    @endif

                                </div>


                                {{-- NAME --}}
                                <div class="min-w-0 flex-1">

                                    <p class="truncate text-sm font-bold text-gray-700">
                                        {{ $product->name }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-gray-400">
                                        {{ $product->category?->name ?? 'Tanpa kategori' }}
                                    </p>

                                </div>


                                {{-- SOLD --}}
                                <div class="text-right">

                                    <p class="text-sm font-extrabold text-[#5C3D2E]">
                                        {{ number_format($product->total_sold ?? 0, 0, ',', '.') }}
                                    </p>

                                    <p class="text-[10px] text-gray-400">
                                        terjual
                                    </p>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="flex min-h-[220px] flex-col items-center justify-center text-center">

                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#F5E6CA] text-[#8B6F5A]">

                            <svg
                                class="h-7 w-7"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M12 3v18m9-9H3"
                                />
                            </svg>

                        </div>

                        <p class="mt-4 text-sm font-semibold text-gray-600">
                            Belum ada data penjualan
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Data menu favorit akan muncul setelah transaksi.
                        </p>

                    </div>

                @endif

            </div>

        </div>



        {{-- =====================================================
            LOW STOCK PRODUCTS
        ====================================================== --}}
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">

                <div>
                    <h2 class="font-bold text-[#1F1F1F]">
                        Peringatan Stok
                    </h2>

                    <p class="mt-0.5 text-xs text-gray-400">
                        Produk yang perlu segera diperhatikan
                    </p>
                </div>


                @if(auth()->user()->role === 'admin')

                    <a
                        href="{{ route('stocks.index') }}"
                        class="text-xs font-bold text-[#5C3D2E] hover:underline"
                    >
                        Kelola stok
                    </a>

                @endif

            </div>


            <div class="p-5">

                @if(isset($lowStockProducts) && $lowStockProducts->count())

                    <div class="space-y-3">

                        @foreach($lowStockProducts as $product)

                            <div class="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-3">

                                {{-- ICON --}}
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-orange-600">

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M12 9v4m0 4h.01M10.3 3.8 2.9 17a2 2 0 0 0 1.75 3h14.7a2 2 0 0 0 1.75-3L13.7 3.8a2 2 0 0 0-3.4 0Z"
                                        />
                                    </svg>

                                </div>


                                {{-- INFO --}}
                                <div class="min-w-0 flex-1">

                                    <p class="truncate text-sm font-bold text-gray-700">
                                        {{ $product->name }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-gray-400">
                                        {{ $product->category?->name ?? 'Tanpa kategori' }}
                                    </p>

                                </div>


                                {{-- STOCK --}}
                                <div class="shrink-0 text-right">

                                    @if($product->stock <= 0)

                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-bold text-red-600">
                                            Habis
                                        </span>

                                    @elseif($product->stock <= 3)

                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-bold text-red-600">
                                            {{ $product->stock }} stok
                                        </span>

                                    @else

                                        <span class="rounded-full bg-orange-100 px-2.5 py-1 text-xs font-bold text-orange-600">
                                            {{ $product->stock }} stok
                                        </span>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="flex min-h-[220px] flex-col items-center justify-center text-center">

                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-green-50 text-green-600">

                            <svg
                                class="h-7 w-7"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="m5 12 4 4L19 6"
                                />
                            </svg>

                        </div>

                        <p class="mt-4 text-sm font-semibold text-gray-600">
                            Semua stok aman
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Tidak ada produk dengan stok menipis.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>



    {{-- =========================================================
        RECENT TRANSACTIONS
    ========================================================== --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="font-bold text-[#1F1F1F]">
                    Transaksi Terbaru
                </h2>

                <p class="mt-0.5 text-xs text-gray-400">
                    Aktivitas transaksi terbaru KOPI KITA
                </p>
            </div>


            <a
                href="{{ route('transactions.index') }}"
                class="inline-flex w-fit items-center gap-1 text-xs font-bold text-[#5C3D2E] hover:underline"
            >
                Lihat semua

                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m9 18 6-6-6-6"
                    />
                </svg>

            </a>

        </div>


        {{-- DESKTOP TABLE --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="w-full text-left">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-wider text-gray-400">
                            Invoice
                        </th>

                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-wider text-gray-400">
                            Kasir
                        </th>

                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-wider text-gray-400">
                            Total
                        </th>

                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-wider text-gray-400">
                            Pembayaran
                        </th>

                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-wider text-gray-400">
                            Waktu
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-400">
                            Detail
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @if(isset($recentTransactions) && $recentTransactions->count())

                        @foreach($recentTransactions as $transaction)

                            <tr class="transition hover:bg-gray-50">

                                <td class="px-5 py-4">

                                    <span class="text-sm font-bold text-[#5C3D2E]">
                                        {{ $transaction->invoice_number }}
                                    </span>

                                </td>


                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-2">

                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#F5E6CA] text-xs font-bold text-[#5C3D2E]">
                                            {{ strtoupper(substr($transaction->user?->name ?? 'K', 0, 1)) }}
                                        </div>

                                        <span class="text-sm text-gray-600">
                                            {{ $transaction->user?->name ?? '-' }}
                                        </span>

                                    </div>

                                </td>


                                <td class="px-5 py-4">

                                    <span class="text-sm font-bold text-gray-700">
                                        Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                    </span>

                                </td>


                                <td class="px-5 py-4">

                                    <span class="rounded-full bg-[#F5E6CA] px-2.5 py-1 text-xs font-bold uppercase text-[#5C3D2E]">
                                        {{ $transaction->payment_method }}
                                    </span>

                                </td>


                                <td class="px-5 py-4">

                                    <span class="text-sm text-gray-500">
                                        {{ $transaction->created_at?->format('d/m/Y H:i') }}
                                    </span>

                                </td>


                                <td class="px-5 py-4 text-right">

                                    <a
                                        href="{{ route('transactions.show', $transaction) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-400 transition hover:bg-[#F5E6CA] hover:text-[#5C3D2E]"
                                        title="Lihat detail"
                                    >

                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.7"
                                                d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"
                                            />

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="2.5"
                                                stroke-width="1.7"
                                            />
                                        </svg>

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    @else

                        <tr>

                            <td
                                colspan="6"
                                class="px-5 py-12 text-center"
                            >

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#F5E6CA] text-[#8B6F5A]">

                                    <svg
                                        class="h-6 w-6"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M6 2h12v20l-3-2-3 2-3-2-3 2V2Zm3 5h6M9 11h6M9 15h4"
                                        />
                                    </svg>

                                </div>

                                <p class="mt-3 text-sm font-semibold text-gray-600">
                                    Belum ada transaksi
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    Transaksi terbaru akan muncul di sini.
                                </p>

                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>

        </div>


        {{-- MOBILE CARDS --}}
        <div class="divide-y divide-gray-100 md:hidden">

            @if(isset($recentTransactions) && $recentTransactions->count())

                @foreach($recentTransactions as $transaction)

                    <a
                        href="{{ route('transactions.show', $transaction) }}"
                        class="block p-4 transition hover:bg-gray-50"
                    >

                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">

                                <p class="truncate text-sm font-bold text-[#5C3D2E]">
                                    {{ $transaction->invoice_number }}
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $transaction->user?->name ?? '-' }}
                                </p>

                            </div>


                            <span class="shrink-0 rounded-full bg-[#F5E6CA] px-2.5 py-1 text-[10px] font-bold uppercase text-[#5C3D2E]">
                                {{ $transaction->payment_method }}
                            </span>

                        </div>


                        <div class="mt-3 flex items-end justify-between">

                            <div>

                                <p class="text-[10px] text-gray-400">
                                    Total
                                </p>

                                <p class="mt-0.5 text-sm font-extrabold text-gray-700">
                                    Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                </p>

                            </div>


                            <div class="text-right">

                                <p class="text-[10px] text-gray-400">
                                    Waktu
                                </p>

                                <p class="mt-0.5 text-xs font-medium text-gray-500">
                                    {{ $transaction->created_at?->format('d/m/Y H:i') }}
                                </p>

                            </div>

                        </div>

                    </a>

                @endforeach

            @else

                <div class="px-5 py-12 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#F5E6CA] text-[#8B6F5A]">

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M6 2h12v20l-3-2-3 2-3-2-3 2V2Zm3 5h6M9 11h6M9 15h4"
                            />
                        </svg>

                    </div>

                    <p class="mt-3 text-sm font-semibold text-gray-600">
                        Belum ada transaksi
                    </p>

                    <p class="mt-1 text-xs text-gray-400">
                        Transaksi terbaru akan muncul di sini.
                    </p>

                </div>

            @endif

        </div>

    </div>



    {{-- =========================================================
        FOOTER INFO
    ========================================================== --}}
    <div class="flex flex-col items-center justify-between gap-2 rounded-2xl border border-gray-100 bg-white px-5 py-4 text-center shadow-sm sm:flex-row sm:text-left">

        <div>

            <p class="text-sm font-semibold text-gray-700">
                KOPI KITA
            </p>

            <p class="text-xs text-gray-400">
                Coffee Shop Point of Sale
            </p>

        </div>


        <div class="flex items-center gap-2 text-xs text-gray-400">

            <span class="h-2 w-2 rounded-full bg-green-500"></span>

            Sistem berjalan normal

        </div>

    </div>

</div>

@endsection