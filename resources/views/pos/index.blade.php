@extends('layouts.dashboard')

@section('title', 'POS Kasir')

@section('content')

<div
    x-data="posApp()"
    class="space-y-5"
>

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[#1F1F1F]">
                POS Kasir
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Pilih produk untuk membuat transaksi baru.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <div class="rounded-xl bg-white px-4 py-2.5 shadow-sm ring-1 ring-gray-100">
                <div class="text-xs text-gray-400">
                    Kasir
                </div>

                <div class="text-sm font-semibold text-[#5C3D2E]">
                    {{ auth()->user()->name }}
                </div>
            </div>

            <button
                type="button"
                @click="clearCart()"
                x-show="cart.length > 0"
                class="rounded-xl border border-red-200 bg-white px-4 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50"
            >
                Kosongkan
            </button>
        </div>
    </div>


    {{-- MAIN POS --}}
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-[minmax(0,1fr)_380px]">

        {{-- LEFT --}}
        <div class="min-w-0 space-y-5">

            {{-- SEARCH --}}
            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-100">
                <div class="relative">

                    <svg
                        class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                        />
                    </svg>

                    <input
                        type="text"
                        x-model="search"
                        placeholder="Cari nama produk..."
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-12 pr-4 text-sm outline-none transition focus:border-[#8B6F5A] focus:bg-white focus:ring-2 focus:ring-[#5C3D2E]/10"
                    >

                </div>
            </div>


            {{-- CATEGORY --}}
            <div class="overflow-x-auto pb-1">
                <div class="flex min-w-max gap-2">

                    <button
                        type="button"
                        @click="selectedCategory = 'all'"
                        :class="selectedCategory === 'all'
                            ? 'bg-[#5C3D2E] text-white shadow-sm'
                            : 'bg-white text-gray-600 hover:bg-[#F5E6CA]'"
                        class="rounded-xl px-5 py-2.5 text-sm font-semibold transition"
                    >
                        Semua
                    </button>

                    @foreach($categories as $category)

                        <button
                            type="button"
                            @click="selectedCategory = '{{ $category->id }}'"
                            :class="selectedCategory == '{{ $category->id }}'
                                ? 'bg-[#5C3D2E] text-white shadow-sm'
                                : 'bg-white text-gray-600 hover:bg-[#F5E6CA]'"
                            class="rounded-xl px-5 py-2.5 text-sm font-semibold transition"
                        >
                            {{ $category->name }}
                        </button>

                    @endforeach

                </div>
            </div>


            {{-- PRODUCT GRID --}}
            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-100">

                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-[#1F1F1F]">
                            Daftar Produk
                        </h2>

                        <p class="text-xs text-gray-400">
                            Klik produk untuk menambahkan ke keranjang
                        </p>
                    </div>

                    <span
                        class="rounded-full bg-[#F5E6CA] px-3 py-1 text-xs font-semibold text-[#5C3D2E]"
                        x-text="filteredProducts.length + ' produk'"
                    ></span>
                </div>


                <div
                    class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 2xl:grid-cols-5"
                >

                    @foreach($products as $product)

                        @include('pos.partials.product-card', [
                            'product' => $product
                        ])

                    @endforeach

                </div>


                {{-- EMPTY SEARCH --}}
                <div
                    x-show="filteredProducts.length === 0"
                    x-cloak
                    class="py-16 text-center"
                >
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#F5E6CA] text-[#5C3D2E]">
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
                                d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                            />
                        </svg>
                    </div>

                    <h3 class="mt-4 font-semibold text-gray-700">
                        Produk tidak ditemukan
                    </h3>

                    <p class="mt-1 text-sm text-gray-400">
                        Coba gunakan kata kunci lain.
                    </p>
                </div>

            </div>

        </div>


        {{-- RIGHT CART --}}
        <div class="min-w-0">

            <div class="sticky top-5">
                @include('pos.partials.cart')
            </div>

        </div>

    </div>


    {{-- PAYMENT MODAL --}}
    @include('pos.partials.payment')

</div>


@push('scripts')

<script>
function posApp() {

    return {

        search: '',

        selectedCategory: 'all',

        showPayment: false,

        paymentMethod: 'cash',

        paymentAmount: 0,

        cart: [],

        products: @json(
            $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => (float) $product->price,
                    'stock' => (int) $product->stock,
                    'category_id' => $product->category_id,
                    'image' => $product->image
                        ? asset('storage/' . $product->image)
                        : null,
                ];
            })->values()
        ),


        get filteredProducts() {

            return this.products.filter(product => {

                const keyword =
                    this.search.toLowerCase().trim();

                const matchesSearch =
                    product.name
                        .toLowerCase()
                        .includes(keyword);

                const matchesCategory =
                    this.selectedCategory === 'all' ||
                    String(product.category_id) === String(this.selectedCategory);

                return matchesSearch && matchesCategory;

            });

        },


        get subtotal() {

            return this.cart.reduce((total, item) => {

                return total + (item.price * item.quantity);

            }, 0);

        },


        get discount() {

            return 0;

        },


        get total() {

            return Math.max(
                0,
                this.subtotal - this.discount
            );

        },


        get totalItems() {

            return this.cart.reduce((total, item) => {

                return total + item.quantity;

            }, 0);

        },


        get change() {

            const payment =
                Number(this.paymentAmount) || 0;

            return Math.max(
                0,
                payment - this.total
            );

        },


        formatRupiah(value) {

            return new Intl.NumberFormat(
                'id-ID',
                {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }
            ).format(value);

        },


        addToCart(product) {

            if (product.stock <= 0) {

                this.showToast(
                    'Produk sedang habis.',
                    'error'
                );

                return;

            }


            const existing =
                this.cart.find(
                    item => item.id === product.id
                );


            if (existing) {

                if (existing.quantity >= product.stock) {

                    this.showToast(
                        'Jumlah melebihi stok tersedia.',
                        'error'
                    );

                    return;

                }

                existing.quantity++;

            } else {

                this.cart.push({

                    id: product.id,

                    name: product.name,

                    price: product.price,

                    stock: product.stock,

                    quantity: 1

                });

            }


            this.showToast(
                product.name + ' ditambahkan.',
                'success'
            );

        },


        increase(item) {

            const product =
                this.products.find(
                    product => product.id === item.id
                );


            if (!product) {
                return;
            }


            if (item.quantity >= product.stock) {

                this.showToast(
                    'Stok tidak mencukupi.',
                    'error'
                );

                return;

            }


            item.quantity++;

        },


        decrease(item) {

            if (item.quantity > 1) {

                item.quantity--;

            } else {

                this.removeFromCart(item.id);

            }

        },


        removeFromCart(id) {

            this.cart =
                this.cart.filter(
                    item => item.id !== id
                );

        },


        clearCart() {

            if (this.cart.length === 0) {
                return;
            }


            if (
                confirm(
                    'Yakin ingin mengosongkan keranjang?'
                )
            ) {

                this.cart = [];

            }

        },


        openPayment() {

            if (this.cart.length === 0) {

                this.showToast(
                    'Keranjang masih kosong.',
                    'error'
                );

                return;

            }


            this.paymentAmount = this.total;

            this.paymentMethod = 'cash';

            this.showPayment = true;

        },


        closePayment() {

            this.showPayment = false;

        },


        submitPayment() {

            if (this.cart.length === 0) {

                this.showToast(
                    'Keranjang masih kosong.',
                    'error'
                );

                return;

            }


            if (
                this.paymentMethod === 'cash' &&
                Number(this.paymentAmount) < this.total
            ) {

                this.showToast(
                    'Nominal pembayaran kurang.',
                    'error'
                );

                return;

            }


            document
                .getElementById('checkout-form')
                .submit();

        },


        showToast(message, type = 'success') {

            window.dispatchEvent(
                new CustomEvent('pos-toast', {
                    detail: {
                        message: message,
                        type: type
                    }
                })
            );

        }

    };

}
</script>


{{-- TOAST --}}
<script>

document.addEventListener(
    'alpine:init',
    () => {

        Alpine.data(
            'toastManager',
            () => ({

                show: false,

                message: '',

                type: 'success',

                timer: null,


                init() {

                    window.addEventListener(
                        'pos-toast',
                        event => {

                            this.message =
                                event.detail.message;

                            this.type =
                                event.detail.type;

                            this.show = true;


                            clearTimeout(
                                this.timer
                            );


                            this.timer =
                                setTimeout(
                                    () => {
                                        this.show = false;
                                    },
                                    2500
                                );

                        }
                    );

                }

            })
        );

    }
);

</script>


<div
    x-data="toastManager()"
    x-cloak
    x-show="show"
    class="fixed bottom-5 right-5 z-[100] max-w-sm"
>
    <div
        class="flex items-center gap-3 rounded-2xl bg-[#1F1F1F] px-4 py-3 text-white shadow-2xl"
    >

        <div
            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full"
            :class="type === 'success'
                ? 'bg-green-500'
                : 'bg-red-500'"
        >

            <svg
                x-show="type === 'success'"
                class="h-5 w-5"
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

            <svg
                x-show="type !== 'success'"
                class="h-5 w-5"
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

        <span
            class="text-sm font-medium"
            x-text="message"
        ></span>

    </div>
</div>


@endpush

@endsection