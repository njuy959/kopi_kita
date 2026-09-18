@extends('layouts.dashboard')

@section('title', 'Kasir POS')

@section('content')

<div class="space-y-5">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-[#1F1F1F]">
                Kasir POS
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Pilih produk untuk membuat transaksi.
            </p>
        </div>

        <div class="flex items-center gap-2 rounded-xl bg-[#F5E6CA] px-4 py-2.5">

            <svg
                class="h-5 w-5 text-[#5C3D2E]"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>

            <span
                id="currentTime"
                class="text-sm font-semibold text-[#5C3D2E]"
            >
                -
            </span>

        </div>

    </div>


    {{-- =========================================================
        MAIN
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-3">


        {{-- =====================================================
            PRODUK
        ====================================================== --}}
        <div class="xl:col-span-2">

            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">


                {{-- SEARCH --}}
                <div class="mb-4">

                    <div class="relative">

                        <svg
                            class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                            />
                        </svg>

                        <input
                            type="text"
                            id="searchProduct"
                            autocomplete="off"
                            placeholder="Cari nama produk..."
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-10 pr-4 text-sm outline-none transition focus:border-[#8B6F5A] focus:bg-white focus:ring-2 focus:ring-[#8B6F5A]/20"
                        >

                    </div>

                </div>


                {{-- KATEGORI --}}
                <div
                    id="categoryButtons"
                    class="mb-5 flex gap-2 overflow-x-auto pb-1"
                >

                    <button
                        type="button"
                        data-category="all"
                        class="category-button active-category whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium transition"
                    >
                        Semua
                    </button>


                    @foreach($categories as $category)

                        <button
                            type="button"
                            data-category="{{ $category->id }}"
                            class="category-button whitespace-nowrap rounded-xl bg-gray-100 px-4 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-200"
                        >
                            {{ $category->name }}
                        </button>

                    @endforeach

                </div>


                {{-- GRID PRODUK --}}
                <div
                    id="productGrid"
                    class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4"
                >

                    @forelse($products as $product)

                        <button
                            type="button"
                            class="product-card group overflow-hidden rounded-2xl border border-gray-200 bg-white text-left transition duration-200 hover:-translate-y-0.5 hover:border-[#8B6F5A] hover:shadow-md active:scale-[0.98]"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ (float) $product->price }}"
                            data-stock="{{ (int) $product->stock }}"
                            data-category="{{ $product->category_id ?? '' }}"
                            data-image="{{ $product->image ? asset('storage/' . $product->image) : '' }}"
                        >

                            {{-- GAMBAR --}}
                            <div class="relative flex h-28 items-center justify-center overflow-hidden bg-[#F5E6CA]/50 sm:h-32">

                                @if($product->image)

                                    <img
                                        src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                    >

                                @else

                                    <div class="flex h-full w-full items-center justify-center">

                                        <svg
                                            class="h-12 w-12 text-[#8B6F5A]"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M18 8a6 6 0 01-12 0m9 0a3 3 0 01-6 0m-1 8h8m-4-4v8"
                                            />
                                        </svg>

                                    </div>

                                @endif


                                {{-- STOK --}}
                                <span
                                    class="absolute right-2 top-2 rounded-lg bg-white/90 px-2 py-1 text-[10px] font-semibold shadow-sm {{ $product->stock <= 5 ? 'text-red-600' : 'text-gray-600' }}"
                                >
                                    Stok {{ $product->stock }}
                                </span>

                            </div>


                            {{-- INFORMASI --}}
                            <div class="p-3">

                                <div class="mb-1 min-h-[40px] text-sm font-semibold leading-5 text-[#1F1F1F]">
                                    {{ $product->name }}
                                </div>


                                <div class="mb-2 text-[11px] text-gray-400">

                                    @if($product->category)

                                        {{ $product->category->name }}

                                    @else

                                        Produk

                                    @endif

                                </div>


                                <div class="text-sm font-bold text-[#5C3D2E]">

                                    Rp {{ number_format((float) $product->price, 0, ',', '.') }}

                                </div>

                            </div>

                        </button>

                    @empty

                        <div class="col-span-full py-16 text-center">

                            <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">

                                <svg
                                    class="h-7 w-7 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M20 13V6a2 2 0 01-2-2H6a2 2 0 01-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"
                                    />
                                </svg>

                            </div>

                            <p class="font-semibold text-gray-600">
                                Belum ada produk
                            </p>

                            <p class="mt-1 text-sm text-gray-400">
                                Produk aktif akan muncul di sini.
                            </p>

                        </div>

                    @endforelse


                    {{-- TIDAK DITEMUKAN --}}
                    <div
                        id="noProductResult"
                        class="hidden col-span-full py-16 text-center"
                    >

                        <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">

                            <svg
                                class="h-7 w-7 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                                />
                            </svg>

                        </div>

                        <p class="font-semibold text-gray-600">
                            Produk tidak ditemukan
                        </p>

                        <p class="mt-1 text-sm text-gray-400">
                            Coba cari dengan nama lain.
                        </p>

                    </div>

                </div>

            </div>

        </div>



        {{-- =====================================================
            KERANJANG
        ====================================================== --}}
        <div class="xl:col-span-1">

            <div class="sticky top-5 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">


                {{-- HEADER CART --}}
                <div class="flex items-center justify-between border-b border-gray-100 px-4 py-4">

                    <div>

                        <h2 class="font-bold text-[#1F1F1F]">
                            Keranjang
                        </h2>

                        <p class="mt-0.5 text-xs text-gray-400">

                            <span id="totalItems">
                                0
                            </span>

                            item

                        </p>

                    </div>


                    <button
                        type="button"
                        id="clearCart"
                        class="hidden rounded-lg px-3 py-2 text-xs font-medium text-red-500 transition hover:bg-red-50"
                    >
                        Kosongkan
                    </button>

                </div>



                {{-- ISI CART --}}
                <div
                    id="cartContainer"
                    class="max-h-[420px] overflow-y-auto"
                >

                    {{-- CART KOSONG --}}
                    <div
                        id="emptyCart"
                        class="px-5 py-12 text-center"
                    >

                        <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-[#F5E6CA]">

                            <svg
                                class="h-7 w-7 text-[#5C3D2E]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 2.5A1 1 0 006 17h11m-8 4a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"
                                />
                            </svg>

                        </div>

                        <p class="font-semibold text-gray-600">
                            Keranjang kosong
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Klik produk untuk menambahkannya.
                        </p>

                    </div>


                    {{-- CART ITEMS --}}
                    <div
                        id="cartItems"
                        class="hidden divide-y divide-gray-100"
                    ></div>

                </div>



                {{-- SUMMARY --}}
                <div class="border-t border-gray-100 bg-gray-50 p-4">


                    {{-- SUBTOTAL --}}
                    <div class="space-y-2 text-sm">

                        <div class="flex justify-between text-gray-500">

                            <span>
                                Subtotal
                            </span>

                            <span>
                                Rp
                                <span id="subtotal">
                                    0
                                </span>
                            </span>

                        </div>


                        {{-- DISCOUNT --}}
                        <div class="flex justify-between text-gray-500">

                            <span>
                                Diskon
                            </span>

                            <span>
                                Rp
                                <span id="discount">
                                    0
                                </span>
                            </span>

                        </div>


                        <div class="my-3 border-t border-gray-200"></div>


                        {{-- GRAND TOTAL --}}
                        <div class="flex items-center justify-between">

                            <span class="font-bold text-[#1F1F1F]">
                                Total
                            </span>

                            <span class="text-xl font-bold text-[#5C3D2E]">

                                Rp
                                <span id="grandTotal">
                                    0
                                </span>

                            </span>

                        </div>

                    </div>



                    {{-- PAYMENT --}}
                    <div class="mt-4">

                        <label class="mb-2 block text-xs font-semibold text-gray-600">
                            Metode Pembayaran
                        </label>


                        <div class="grid grid-cols-2 gap-2">

                            <button
                                type="button"
                                id="cashButton"
                                data-method="cash"
                                class="payment-button rounded-xl border border-[#5C3D2E] bg-[#5C3D2E] px-3 py-2.5 text-sm font-medium text-white transition"
                            >
                                Cash
                            </button>


                            <button
                                type="button"
                                id="qrisButton"
                                data-method="qris"
                                class="payment-button rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm font-medium text-gray-600 transition"
                            >
                                QRIS
                            </button>

                        </div>

                    </div>



                    {{-- PAYMENT AMOUNT --}}
                    <div class="mt-3">

                        <label
                            for="paymentAmount"
                            class="mb-2 block text-xs font-semibold text-gray-600"
                        >
                            Jumlah Bayar
                        </label>

                        <input
                            type="number"
                            id="paymentAmount"
                            min="0"
                            value="0"
                            placeholder="Masukkan jumlah pembayaran"
                            class="w-full rounded-xl border border-gray-200 bg-white px-3 py-3 text-sm outline-none transition focus:border-[#8B6F5A] focus:ring-2 focus:ring-[#8B6F5A]/20 disabled:bg-gray-100"
                        >

                    </div>



                    {{-- CHANGE --}}
                    <div
                        id="changeBox"
                        class="mt-3 hidden rounded-xl bg-green-50 px-3 py-3"
                    >

                        <div class="flex justify-between text-sm">

                            <span class="font-medium text-green-700">
                                Kembalian
                            </span>

                            <span
                                id="changeAmount"
                                class="font-bold text-green-700"
                            >
                                Rp 0
                            </span>

                        </div>

                    </div>



                    {{-- CHECKOUT FORM --}}
                    <form
                        id="checkoutForm"
                        action="{{ route('pos.checkout') }}"
                        method="POST"
                        class="mt-4"
                    >

                        @csrf


                        {{-- PENTING:
                             CONTROLLER MEMBUTUHKAN "items"
                        --}}
                        <input
                            type="hidden"
                            name="items"
                            id="itemsInput"
                            value=""
                        >


                        <input
                            type="hidden"
                            name="payment_method"
                            id="paymentMethodInput"
                            value="cash"
                        >


                        <input
                            type="hidden"
                            name="payment_amount"
                            id="paymentAmountHidden"
                            value="0"
                        >


                        <button
                            type="submit"
                            id="checkoutButton"
                            disabled
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#5C3D2E] px-4 py-3.5 text-sm font-bold text-white transition hover:bg-[#4A3024] disabled:cursor-not-allowed disabled:opacity-50"
                        >

                            <svg
                                id="checkoutIcon"
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 12h14m-7-7 7 7-7 7"
                                />
                            </svg>

                            <span id="checkoutText">
                                Bayar Sekarang
                            </span>

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- =============================================================
    MODAL KOSONGKAN KERANJANG
============================================================= --}}
<div
    id="clearCartModal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 px-4 backdrop-blur-sm"
>

    <div
        id="clearCartBox"
        class="w-full max-w-sm scale-95 rounded-2xl bg-white p-5 opacity-0 shadow-2xl transition-all duration-200"
    >

        <div class="flex items-start gap-4">

            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-red-50">

                <svg
                    class="h-5 w-5 text-red-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18 18 6M6 6l12 12"
                    />
                </svg>

            </div>


            <div>

                <h3 class="text-base font-bold text-[#1F1F1F]">
                    Kosongkan keranjang?
                </h3>

                <p class="mt-1 text-sm leading-5 text-gray-500">
                    Semua produk yang ada di keranjang akan dihapus.
                </p>

            </div>

        </div>


        <div class="mt-5 flex gap-2">

            <button
                type="button"
                id="cancelClearCart"
                class="flex-1 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
            >
                Batal
            </button>


            <button
                type="button"
                id="confirmClearCart"
                class="flex-1 rounded-xl bg-red-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-600"
            >
                Kosongkan
            </button>

        </div>

    </div>

</div>



{{-- =============================================================
    SUCCESS / ERROR
============================================================= --}}
@if(session('success'))

    <div
        id="successNotification"
        class="fixed bottom-5 right-5 z-[90] w-[calc(100%-40px)] max-w-sm rounded-2xl border border-green-200 bg-white p-4 shadow-xl"
    >

        <div class="flex items-start gap-3">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-green-50">

                <svg
                    class="h-5 w-5 text-green-600"
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


            <div class="min-w-0">

                <p class="font-semibold text-green-700">
                    Berhasil
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    {{ session('success') }}
                </p>

            </div>

        </div>

    </div>

@endif



@if($errors->any())

    <div
        id="errorNotification"
        class="fixed bottom-5 right-5 z-[90] w-[calc(100%-40px)] max-w-sm rounded-2xl border border-red-200 bg-white p-4 shadow-xl"
    >

        <div class="flex items-start gap-3">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-50">

                <svg
                    class="h-5 w-5 text-red-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18 18 6M6 6l12-12"
                    />
                </svg>

            </div>


            <div class="min-w-0">

                <p class="font-semibold text-red-700">
                    Terjadi kesalahan
                </p>


                <ul class="mt-1 space-y-1 text-sm text-gray-500">

                    @foreach($errors->all() as $error)

                        <li class="flex gap-2">

                            <span>
                                •
                            </span>

                            <span>
                                {{ $error }}
                            </span>

                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    </div>

@endif



@push('styles')

<style>

    .active-category {
        background-color: #5C3D2E !important;
        color: #ffffff !important;
    }

    .hidden-product {
        display: none !important;
    }

    .product-card {
        -webkit-tap-highlight-color: transparent;
    }

</style>

@endpush



@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    let cart = [];

    let activeCategory = 'all';

    let paymentMethod = 'cash';

    let isProcessing = false;


    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const productCards =
        document.querySelectorAll('.product-card');

    const categoryButtons =
        document.querySelectorAll('.category-button');

    const searchProduct =
        document.getElementById('searchProduct');

    const noProductResult =
        document.getElementById('noProductResult');

    const cartItems =
        document.getElementById('cartItems');

    const emptyCart =
        document.getElementById('emptyCart');

    const clearCartButton =
        document.getElementById('clearCart');

    const totalItemsElement =
        document.getElementById('totalItems');

    const subtotalElement =
        document.getElementById('subtotal');

    const discountElement =
        document.getElementById('discount');

    const grandTotalElement =
        document.getElementById('grandTotal');

    const cashButton =
        document.getElementById('cashButton');

    const qrisButton =
        document.getElementById('qrisButton');

    const paymentAmount =
        document.getElementById('paymentAmount');

    const paymentMethodInput =
        document.getElementById('paymentMethodInput');

    const paymentAmountHidden =
        document.getElementById('paymentAmountHidden');

    const itemsInput =
        document.getElementById('itemsInput');

    const checkoutForm =
        document.getElementById('checkoutForm');

    const checkoutButton =
        document.getElementById('checkoutButton');

    const checkoutText =
        document.getElementById('checkoutText');

    const changeBox =
        document.getElementById('changeBox');

    const changeAmount =
        document.getElementById('changeAmount');

    const currentTime =
        document.getElementById('currentTime');


    /*
    |--------------------------------------------------------------------------
    | FORMAT
    |--------------------------------------------------------------------------
    */

    function formatRupiah(value) {

        return new Intl.NumberFormat('id-ID')
            .format(Number(value) || 0);

    }


    /*
    |--------------------------------------------------------------------------
    | CLOCK
    |--------------------------------------------------------------------------
    */

    function updateClock() {

        if (!currentTime) {
            return;
        }

        const now = new Date();

        currentTime.textContent =
            now.toLocaleString('id-ID', {
                weekday: 'short',
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

    }

    updateClock();

    setInterval(updateClock, 1000);


    /*
    |--------------------------------------------------------------------------
    | PRODUCT DATA
    |--------------------------------------------------------------------------
    */

    function getProductFromCard(card) {

        return {

            id:
                Number(card.dataset.id),

            name:
                card.dataset.name || '',

            price:
                Number(card.dataset.price) || 0,

            stock:
                Number(card.dataset.stock) || 0,

            category_id:
                card.dataset.category || '',

            image:
                card.dataset.image || ''

        };

    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCT CLICK
    |--------------------------------------------------------------------------
    */

    productCards.forEach(function (card) {

        card.addEventListener('click', function (event) {

            event.preventDefault();

            const product =
                getProductFromCard(this);

            addToCart(product);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | ADD CART
    |--------------------------------------------------------------------------
    */

    function addToCart(product) {

        if (!product) {
            return;
        }


        if (product.stock <= 0) {

            showMessage(
                'Produk ini sedang habis.'
            );

            return;

        }


        const existing =
            cart.find(function (item) {

                return Number(item.id) ===
                    Number(product.id);

            });


        if (existing) {

            if (
                Number(existing.quantity) >=
                Number(product.stock)
            ) {

                showMessage(
                    'Jumlah produk sudah mencapai stok tersedia.'
                );

                return;

            }


            existing.quantity += 1;

        } else {

            cart.push({

                id:
                    product.id,

                name:
                    product.name,

                price:
                    product.price,

                stock:
                    product.stock,

                category_id:
                    product.category_id,

                image:
                    product.image,

                quantity:
                    1

            });

        }


        renderCart();

    }


    /*
    |--------------------------------------------------------------------------
    | RENDER CART
    |--------------------------------------------------------------------------
    */

    function renderCart() {

        cartItems.innerHTML = '';


        if (cart.length === 0) {

            emptyCart.classList.remove(
                'hidden'
            );

            cartItems.classList.add(
                'hidden'
            );

            clearCartButton.classList.add(
                'hidden'
            );

            updateSummary();

            return;

        }


        emptyCart.classList.add(
            'hidden'
        );

        cartItems.classList.remove(
            'hidden'
        );

        clearCartButton.classList.remove(
            'hidden'
        );


        cart.forEach(function (item) {

            const row =
                document.createElement('div');

            row.className =
                'p-4';


            let imageHTML = '';


            if (item.image) {

                imageHTML = `
                    <img
                        src="${escapeHTML(item.image)}"
                        alt="${escapeHTML(item.name)}"
                        class="h-full w-full object-cover"
                    >
                `;

            } else {

                imageHTML = `
                    <div class="flex h-full w-full items-center justify-center">
                        <svg
                            class="h-6 w-6 text-[#8B6F5A]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M18 8a6 6 0 01-12 0m9 0a3 3 0 01-6 0m-1 8h8m-4-4v8"
                            />
                        </svg>
                    </div>
                `;

            }


            row.innerHTML = `

                <div class="flex gap-3">

                    <div class="h-14 w-14 shrink-0 overflow-hidden rounded-xl bg-[#F5E6CA]/60">

                        ${imageHTML}

                    </div>


                    <div class="min-w-0 flex-1">

                        <div class="truncate text-sm font-semibold text-[#1F1F1F]">
                            ${escapeHTML(item.name)}
                        </div>


                        <div class="mt-1 text-xs text-gray-500">
                            Rp ${formatRupiah(item.price)}
                        </div>


                        <div class="mt-2 flex items-center justify-between gap-2">


                            <div class="flex items-center overflow-hidden rounded-lg border border-gray-200">

                                <button
                                    type="button"
                                    class="decrease-button flex h-8 w-8 items-center justify-center text-gray-500 hover:bg-gray-100"
                                    data-id="${item.id}"
                                >
                                    −
                                </button>


                                <span class="flex h-8 min-w-8 items-center justify-center text-xs font-semibold">
                                    ${item.quantity}
                                </span>


                                <button
                                    type="button"
                                    class="increase-button flex h-8 w-8 items-center justify-center text-[#5C3D2E] hover:bg-[#F5E6CA]"
                                    data-id="${item.id}"
                                >
                                    +
                                </button>

                            </div>


                            <div class="flex items-center gap-2">

                                <span class="text-sm font-bold text-[#5C3D2E]">
                                    Rp ${formatRupiah(
                                        item.price *
                                        item.quantity
                                    )}
                                </span>


                                <button
                                    type="button"
                                    class="remove-button flex h-7 w-7 items-center justify-center rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-500"
                                    data-id="${item.id}"
                                    title="Hapus"
                                >
                                    ×
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            `;


            cartItems.appendChild(row);

        });


        attachCartEvents();

        updateSummary();

    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHTML(value) {

        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    /*
    |--------------------------------------------------------------------------
    | CART EVENTS
    |--------------------------------------------------------------------------
    */

    function attachCartEvents() {


        document
            .querySelectorAll('.increase-button')
            .forEach(function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        increaseQuantity(
                            Number(this.dataset.id)
                        );

                    }
                );

            });


        document
            .querySelectorAll('.decrease-button')
            .forEach(function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        decreaseQuantity(
                            Number(this.dataset.id)
                        );

                    }
                );

            });


        document
            .querySelectorAll('.remove-button')
            .forEach(function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        removeFromCart(
                            Number(this.dataset.id)
                        );

                    }
                );

            });

    }


    /*
    |--------------------------------------------------------------------------
    | INCREASE
    |--------------------------------------------------------------------------
    */

    function increaseQuantity(id) {

        const item =
            cart.find(function (product) {

                return Number(product.id) ===
                    Number(id);

            });


        if (!item) {
            return;
        }


        if (
            Number(item.quantity) >=
            Number(item.stock)
        ) {

            showMessage(
                'Jumlah melebihi stok tersedia.'
            );

            return;

        }


        item.quantity += 1;

        renderCart();

    }


    /*
    |--------------------------------------------------------------------------
    | DECREASE
    |--------------------------------------------------------------------------
    */

    function decreaseQuantity(id) {

        const item =
            cart.find(function (product) {

                return Number(product.id) ===
                    Number(id);

            });


        if (!item) {
            return;
        }


        if (Number(item.quantity) <= 1) {

            removeFromCart(id);

            return;

        }


        item.quantity -= 1;

        renderCart();

    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE
    |--------------------------------------------------------------------------
    */

    function removeFromCart(id) {

        cart =
            cart.filter(function (item) {

                return Number(item.id) !==
                    Number(id);

            });


        renderCart();

    }


    /*
    |--------------------------------------------------------------------------
    | MODAL CLEAR CART
    |--------------------------------------------------------------------------
    */

    const clearCartModal =
        document.getElementById('clearCartModal');

    const clearCartBox =
        document.getElementById('clearCartBox');

    const cancelClearCart =
        document.getElementById('cancelClearCart');

    const confirmClearCart =
        document.getElementById('confirmClearCart');


    function openClearCartModal() {

        if (cart.length === 0) {
            return;
        }


        clearCartModal.classList.remove(
            'hidden'
        );

        clearCartModal.classList.add(
            'flex'
        );


        setTimeout(function () {

            clearCartBox.classList.remove(
                'scale-95',
                'opacity-0'
            );

            clearCartBox.classList.add(
                'scale-100',
                'opacity-100'
            );

        }, 10);

    }


    function closeClearCartModal() {

        clearCartBox.classList.remove(
            'scale-100',
            'opacity-100'
        );

        clearCartBox.classList.add(
            'scale-95',
            'opacity-0'
        );


        setTimeout(function () {

            clearCartModal.classList.add(
                'hidden'
            );

            clearCartModal.classList.remove(
                'flex'
            );

        }, 200);

    }


    clearCartButton.addEventListener(
        'click',
        function () {

            openClearCartModal();

        }
    );


    cancelClearCart.addEventListener(
        'click',
        function () {

            closeClearCartModal();

        }
    );


    confirmClearCart.addEventListener(
        'click',
        function () {

            cart = [];

            paymentAmount.value = 0;

            paymentAmountHidden.value = 0;

            renderCart();

            closeClearCartModal();

        }
    );


    clearCartModal.addEventListener(
        'click',
        function (event) {

            if (
                event.target ===
                clearCartModal
            ) {

                closeClearCartModal();

            }

        }
    );


    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                !clearCartModal.classList.contains(
                    'hidden'
                )
            ) {

                closeClearCartModal();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CATEGORY
    |--------------------------------------------------------------------------
    */

    categoryButtons.forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                activeCategory =
                    this.dataset.category;


                categoryButtons.forEach(
                    function (btn) {

                        btn.classList.remove(
                            'active-category'
                        );

                    }
                );


                this.classList.add(
                    'active-category'
                );


                filterProducts();

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    searchProduct.addEventListener(
        'input',
        function () {

            filterProducts();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */

    function filterProducts() {

        const keyword =
            searchProduct.value
                .toLowerCase()
                .trim();


        let visibleCount = 0;


        productCards.forEach(
            function (card) {

                const name =
                    String(
                        card.dataset.name || ''
                    ).toLowerCase();


                const category =
                    String(
                        card.dataset.category || ''
                    );


                const stock =
                    Number(
                        card.dataset.stock || 0
                    );


                const categoryMatch =
                    activeCategory === 'all' ||
                    category ===
                    String(activeCategory);


                const searchMatch =
                    keyword === '' ||
                    name.includes(keyword);


                const stockMatch =
                    stock > 0;


                if (
                    categoryMatch &&
                    searchMatch &&
                    stockMatch
                ) {

                    card.classList.remove(
                        'hidden-product'
                    );

                    visibleCount++;

                } else {

                    card.classList.add(
                        'hidden-product'
                    );

                }

            }
        );


        if (visibleCount === 0) {

            noProductResult.classList.remove(
                'hidden'
            );

        } else {

            noProductResult.classList.add(
                'hidden'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */

    function calculateSubtotal() {

        return cart.reduce(
            function (total, item) {

                return total +
                    (
                        Number(item.price) *
                        Number(item.quantity)
                    );

            },
            0
        );

    }


    function calculateDiscount() {

        return 0;

    }


    function calculateGrandTotal() {

        return Math.max(
            0,
            calculateSubtotal() -
            calculateDiscount()
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SUMMARY
    |--------------------------------------------------------------------------
    */

    function updateSummary() {

        const totalItems =
            cart.reduce(
                function (total, item) {

                    return total +
                        Number(item.quantity);

                },
                0
            );


        const subtotal =
            calculateSubtotal();


        const discount =
            calculateDiscount();


        const grandTotal =
            calculateGrandTotal();


        totalItemsElement.textContent =
            totalItems;


        subtotalElement.textContent =
            formatRupiah(subtotal);


        discountElement.textContent =
            formatRupiah(discount);


        grandTotalElement.textContent =
            formatRupiah(grandTotal);


        updateChange();


        checkoutButton.disabled =
            cart.length === 0 ||
            grandTotal <= 0;

    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENT METHOD
    |--------------------------------------------------------------------------
    */

    cashButton.addEventListener(
        'click',
        function () {

            setPaymentMethod('cash');

        }
    );


    qrisButton.addEventListener(
        'click',
        function () {

            setPaymentMethod('qris');

        }
    );


    function setPaymentMethod(method) {

        paymentMethod =
            method;


        paymentMethodInput.value =
            method;


        if (method === 'cash') {

            cashButton.classList.add(
                'bg-[#5C3D2E]',
                'text-white',
                'border-[#5C3D2E]'
            );

            cashButton.classList.remove(
                'bg-white',
                'text-gray-600',
                'border-gray-200'
            );


            qrisButton.classList.remove(
                'bg-[#5C3D2E]',
                'text-white',
                'border-[#5C3D2E]'
            );

            qrisButton.classList.add(
                'bg-white',
                'text-gray-600',
                'border-gray-200'
            );


            paymentAmount.disabled =
                false;


            paymentAmount.value =
                0;


            paymentAmountHidden.value =
                0;

        } else {

            qrisButton.classList.add(
                'bg-[#5C3D2E]',
                'text-white',
                'border-[#5C3D2E]'
            );

            qrisButton.classList.remove(
                'bg-white',
                'text-gray-600',
                'border-gray-200'
            );


            cashButton.classList.remove(
                'bg-[#5C3D2E]',
                'text-white',
                'border-[#5C3D2E]'
            );

            cashButton.classList.add(
                'bg-white',
                'text-gray-600',
                'border-gray-200'
            );


            paymentAmount.disabled =
                true;


            const total =
                calculateGrandTotal();


            paymentAmount.value =
                total;


            paymentAmountHidden.value =
                total;

        }


        updateChange();

    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENT INPUT
    |--------------------------------------------------------------------------
    */

    paymentAmount.addEventListener(
        'input',
        function () {

            const value =
                Number(this.value) || 0;


            paymentAmountHidden.value =
                value;


            updateChange();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CHANGE
    |--------------------------------------------------------------------------
    */

    function updateChange() {

        const total =
            calculateGrandTotal();


        const payment =
            Number(paymentAmount.value) || 0;


        if (
            paymentMethod === 'cash' &&
            total > 0 &&
            payment >= total
        ) {

            const change =
                payment - total;


            changeBox.classList.remove(
                'hidden'
            );


            changeAmount.textContent =
                'Rp ' +
                formatRupiah(change);

        } else {

            changeBox.classList.add(
                'hidden'
            );


            changeAmount.textContent =
                'Rp 0';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    checkoutForm.addEventListener(
        'submit',
        function (event) {

            if (isProcessing) {

                event.preventDefault();

                return;

            }


            if (cart.length === 0) {

                event.preventDefault();

                showMessage(
                    'Keranjang masih kosong.'
                );

                return;

            }


            const total =
                calculateGrandTotal();


            if (total <= 0) {

                event.preventDefault();

                showMessage(
                    'Total transaksi tidak valid.'
                );

                return;

            }


            let payment =
                Number(
                    paymentAmount.value
                ) || 0;


            /*
            |--------------------------------------------------------------------------
            | CASH
            |--------------------------------------------------------------------------
            */

            if (paymentMethod === 'cash') {

                if (payment < total) {

                    event.preventDefault();

                    showMessage(
                        'Jumlah pembayaran masih kurang.'
                    );

                    return;

                }

            }


            /*
            |--------------------------------------------------------------------------
            | QRIS
            |--------------------------------------------------------------------------
            */

            if (paymentMethod === 'qris') {

                payment =
                    total;

                paymentAmount.value =
                    total;

            }


            /*
            |--------------------------------------------------------------------------
            | SIAPKAN ITEMS
            |--------------------------------------------------------------------------
            */

            const checkoutItems =
                cart.map(
                    function (item) {

                        return {

                            product_id:
                                Number(item.id),

                            quantity:
                                Number(item.quantity)

                        };

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | KIRIM FIELD "items"
            |--------------------------------------------------------------------------
            */

            itemsInput.value =
                JSON.stringify(
                    checkoutItems
                );


            paymentMethodInput.value =
                paymentMethod;


            paymentAmountHidden.value =
                payment;


            isProcessing =
                true;


            checkoutButton.disabled =
                true;


            checkoutText.textContent =
                'Memproses...';

        }
    );


    /*
    |--------------------------------------------------------------------------
    | MESSAGE
    |--------------------------------------------------------------------------
    */

    function showMessage(message) {

        const oldMessage =
            document.getElementById(
                'posTemporaryMessage'
            );


        if (oldMessage) {

            oldMessage.remove();

        }


        const messageBox =
            document.createElement('div');


        messageBox.id =
            'posTemporaryMessage';


        messageBox.className =
            'fixed bottom-5 right-5 z-[120] max-w-sm rounded-2xl border border-[#E7D7C5] bg-white px-4 py-3 text-sm font-medium text-[#5C3D2E] shadow-xl';


        messageBox.textContent =
            message;


        document.body.appendChild(
            messageBox
        );


        setTimeout(
            function () {

                messageBox.remove();

            },
            2500
        );

    }


    /*
    |--------------------------------------------------------------------------
    | AUTO HIDE NOTIFICATION
    |--------------------------------------------------------------------------
    */

    setTimeout(
        function () {

            const success =
                document.getElementById(
                    'successNotification'
                );


            const error =
                document.getElementById(
                    'errorNotification'
                );


            if (success) {

                success.remove();

            }


            if (error) {

                error.remove();

            }

        },
        5000
    );


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    filterProducts();

    renderCart();

    setPaymentMethod('cash');

});

</script>

@endpush

@endsection
