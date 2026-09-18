<div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100">

    {{-- HEADER --}}
    <div class="border-b border-gray-100 p-4">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="font-bold text-[#1F1F1F]">
                    Keranjang
                </h2>

                <p class="mt-0.5 text-xs text-gray-400">
                    <span x-text="totalItems"></span> item dipilih
                </p>
            </div>

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F5E6CA] text-[#5C3D2E]">

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

            </div>

        </div>

    </div>


    {{-- CART ITEMS --}}
    <div class="max-h-[420px] overflow-y-auto p-4">

        {{-- EMPTY --}}
        <div
            x-show="cart.length === 0"
            class="flex min-h-[280px] flex-col items-center justify-center text-center"
        >

            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-[#F5E6CA]">

                <svg
                    class="h-9 w-9 text-[#8B6F5A]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13 5 5m2 8 1 5h10m-8 0a1 1 0 1 1-2 0m10 0a1 1 0 1 1-2 0"
                    />
                </svg>

            </div>

            <h3 class="mt-4 font-semibold text-gray-700">
                Keranjang masih kosong
            </h3>

            <p class="mt-1 max-w-[220px] text-xs leading-5 text-gray-400">
                Pilih produk dari daftar untuk menambahkannya ke transaksi.
            </p>

        </div>


        {{-- ITEMS --}}
        <div
            x-show="cart.length > 0"
            class="space-y-3"
        >

            <template x-for="item in cart" :key="item.id">

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-3">

                    <div class="flex gap-3">

                        {{-- INFO --}}
                        <div class="min-w-0 flex-1">

                            <h3
                                class="truncate text-sm font-bold text-[#1F1F1F]"
                                x-text="item.name"
                            ></h3>

                            <p
                                class="mt-1 text-xs text-gray-500"
                                x-text="formatRupiah(item.price)"
                            ></p>

                        </div>


                        {{-- REMOVE --}}
                        <button
                            type="button"
                            @click="removeFromCart(item.id)"
                            class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-gray-400 transition hover:bg-red-50 hover:text-red-500"
                        >
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
                                    d="M6 18 18 6M6 6l12 12"
                                />
                            </svg>
                        </button>

                    </div>


                    {{-- QUANTITY --}}
                    <div class="mt-3 flex items-center justify-between">

                        <div class="flex items-center rounded-lg border border-gray-200 bg-white">

                            <button
                                type="button"
                                @click="decrease(item)"
                                class="flex h-8 w-8 items-center justify-center text-gray-500 transition hover:bg-gray-100"
                            >
                                −
                            </button>

                            <span
                                class="w-8 text-center text-sm font-bold text-[#1F1F1F]"
                                x-text="item.quantity"
                            ></span>

                            <button
                                type="button"
                                @click="increase(item)"
                                class="flex h-8 w-8 items-center justify-center text-[#5C3D2E] transition hover:bg-[#F5E6CA]"
                            >
                                +
                            </button>

                        </div>


                        <span
                            class="text-sm font-bold text-[#5C3D2E]"
                            x-text="formatRupiah(item.price * item.quantity)"
                        ></span>

                    </div>

                </div>

            </template>

        </div>

    </div>


    {{-- SUMMARY --}}
    <div
        x-show="cart.length > 0"
        class="border-t border-gray-100 p-4"
    >

        <div class="space-y-3 text-sm">

            <div class="flex items-center justify-between">
                <span class="text-gray-500">
                    Subtotal
                </span>

                <span
                    class="font-semibold text-gray-700"
                    x-text="formatRupiah(subtotal)"
                ></span>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-gray-500">
                    Diskon
                </span>

                <span
                    class="font-semibold text-gray-700"
                    x-text="formatRupiah(discount)"
                ></span>
            </div>

        </div>


        <div class="my-4 border-t border-dashed border-gray-200"></div>


        <div class="flex items-end justify-between">

            <div>
                <p class="text-xs text-gray-400">
                    Total Pembayaran
                </p>

                <p
                    class="mt-1 text-2xl font-extrabold text-[#5C3D2E]"
                    x-text="formatRupiah(total)"
                ></p>
            </div>

            <span class="rounded-full bg-[#F5E6CA] px-3 py-1 text-xs font-bold text-[#5C3D2E]">
                <span x-text="totalItems"></span> item
            </span>

        </div>


        <button
            type="button"
            @click="openPayment()"
            class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-[#5C3D2E] px-4 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#4a3024] active:scale-[0.98]"
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
                    stroke-width="2"
                    d="M17 9V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-2m0-6h4v6h-4a3 3 0 0 1 0-6Zm0 3h.01"
                />
            </svg>

            Bayar Sekarang

        </button>

    </div>

</div>