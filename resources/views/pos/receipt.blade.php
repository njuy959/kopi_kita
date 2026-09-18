@extends('layouts.guest')

@section('title', 'Struk Transaksi')

@section('content')

<div class="mx-auto w-full max-w-md">

    {{-- RECEIPT --}}
    <div class="overflow-hidden rounded-3xl bg-white shadow-xl">

        {{-- HEADER --}}
        <div class="bg-[#5C3D2E] px-6 py-7 text-center text-white">

            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white/10">

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
                        d="M6 3h12v18l-3-2-3 2-3-2-3 2V3Zm3 5h6M9 12h6M9 15h4"
                    />
                </svg>

            </div>

            <h1 class="mt-3 text-xl font-extrabold">
                KOPI KITA
            </h1>

            <p class="mt-1 text-xs text-white/70">
                Coffee Shop POS
            </p>

        </div>


        {{-- SUCCESS --}}
        <div class="px-6 py-6 text-center">

            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-green-600">

                <svg
                    class="h-7 w-7"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m5 12 4 4L19 6"
                    />
                </svg>

            </div>

            <h2 class="mt-3 text-lg font-bold text-gray-800">
                Pembayaran Berhasil
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                Terima kasih telah berbelanja di KOPI KITA.
            </p>

        </div>


        {{-- TRANSACTION INFO --}}
        <div class="mx-6 border-y border-dashed border-gray-200 py-4">

            <div class="flex items-center justify-between text-sm">

                <span class="text-gray-400">
                    No. Transaksi
                </span>

                <span class="font-bold text-gray-700">
                    {{ $transaction->invoice_number }}
                </span>

            </div>

            <div class="mt-2 flex items-center justify-between text-sm">

                <span class="text-gray-400">
                    Kasir
                </span>

                <span class="font-semibold text-gray-700">
                    {{ $transaction->user?->name ?? '-' }}
                </span>

            </div>

            <div class="mt-2 flex items-center justify-between text-sm">

                <span class="text-gray-400">
                    Tanggal
                </span>

                <span class="font-semibold text-gray-700">
                    {{ $transaction->created_at?->format('d/m/Y H:i') }}
                </span>

            </div>

        </div>


        {{-- ITEMS --}}
        <div class="px-6 py-5">

            <h3 class="mb-3 text-sm font-bold text-gray-700">
                Detail Pesanan
            </h3>

            <div class="space-y-3">

                @foreach($transaction->items as $item)

                    <div class="flex items-start justify-between gap-4">

                        <div class="min-w-0">

                            <p class="text-sm font-semibold text-gray-700">
                                {{ $item->product_name }}
                            </p>

                            <p class="mt-0.5 text-xs text-gray-400">
                                {{ $item->quantity }} ×
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>

                        </div>

                        <span class="shrink-0 text-sm font-bold text-gray-700">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </span>

                    </div>

                @endforeach

            </div>

        </div>


        {{-- TOTAL --}}
        <div class="mx-6 rounded-2xl bg-[#F5E6CA] p-4">

            <div class="flex items-center justify-between">

                <span class="text-sm text-[#8B6F5A]">
                    Subtotal
                </span>

                <span class="text-sm font-semibold text-[#5C3D2E]">
                    Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}
                </span>

            </div>


            <div class="mt-2 flex items-center justify-between">

                <span class="text-sm text-[#8B6F5A]">
                    Diskon
                </span>

                <span class="text-sm font-semibold text-[#5C3D2E]">
                    Rp {{ number_format($transaction->discount ?? 0, 0, ',', '.') }}
                </span>

            </div>


            <div class="my-3 border-t border-[#8B6F5A]/20"></div>


            <div class="flex items-center justify-between">

                <span class="font-bold text-[#5C3D2E]">
                    Total
                </span>

                <span class="text-xl font-extrabold text-[#5C3D2E]">
                    Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                </span>

            </div>

        </div>


        {{-- PAYMENT --}}
        <div class="px-6 py-5">

            <div class="flex items-center justify-between text-sm">

                <span class="text-gray-400">
                    Metode Pembayaran
                </span>

                <span class="font-bold uppercase text-gray-700">
                    {{ $transaction->payment_method }}
                </span>

            </div>


            <div class="mt-2 flex items-center justify-between text-sm">

                <span class="text-gray-400">
                    Dibayar
                </span>

                <span class="font-semibold text-gray-700">
                    Rp {{ number_format($transaction->payment_amount, 0, ',', '.') }}
                </span>

            </div>


            <div class="mt-2 flex items-center justify-between text-sm">

                <span class="text-gray-400">
                    Kembalian
                </span>

                <span class="font-bold text-green-600">
                    Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}
                </span>

            </div>

        </div>


        {{-- FOOTER --}}
        <div class="border-t border-dashed border-gray-200 px-6 py-5 text-center">

            <p class="text-xs text-gray-400">
                Terima kasih 🙏
            </p>

            <p class="mt-1 text-xs font-semibold text-[#5C3D2E]">
                KOPI KITA
            </p>

        </div>

    </div>


    {{-- ACTION --}}
    <div class="mt-4 grid grid-cols-2 gap-3">

        <a
            href="{{ route('pos.index') }}"
            class="flex items-center justify-center rounded-xl bg-[#5C3D2E] px-4 py-3 text-sm font-bold text-white transition hover:bg-[#4a3024]"
        >
            Transaksi Baru
        </a>


        <button
            type="button"
            onclick="window.print()"
            class="flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
        >
            Cetak Struk
        </button>

    </div>

</div>


<style>
@media print {

    body {
        background: white !important;
    }

    body > * {
        visibility: hidden;
    }

    .max-w-md,
    .max-w-md * {
        visibility: visible;
    }

    .max-w-md {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        max-width: 420px;
    }

    .max-w-md > .mt-4 {
        display: none !important;
    }

}
</style>

@endsection
