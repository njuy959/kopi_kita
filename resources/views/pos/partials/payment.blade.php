<div
    x-show="showPayment"
    x-cloak
    class="fixed inset-0 z-[90] flex items-center justify-center p-4"
>

    {{-- OVERLAY --}}
    <div
        class="absolute inset-0 bg-black/50 backdrop-blur-sm"
        @click="closePayment()"
    ></div>


    {{-- MODAL --}}
    <div
        x-show="showPayment"
        x-transition
        class="relative w-full max-w-md overflow-hidden rounded-3xl bg-white shadow-2xl"
    >

        {{-- HEADER --}}
        <div class="border-b border-gray-100 px-5 py-4">

            <div class="flex items-center justify-between">

                <div>
                    <h2 class="text-lg font-bold text-[#1F1F1F]">
                        Pembayaran
                    </h2>

                    <p class="mt-0.5 text-xs text-gray-400">
                        Selesaikan transaksi pelanggan
                    </p>
                </div>

                <button
                    type="button"
                    @click="closePayment()"
                    class="flex h-9 w-9 items-center justify-center rounded-xl text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
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
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>
                </button>

            </div>

        </div>


        {{-- FORM --}}
        <form
            id="checkout-form"
            method="POST"
            action="{{ route('pos.checkout') }}"
            class="p-5"
        >

            @csrf


            {{-- TOTAL --}}
            <div class="rounded-2xl bg-[#F5E6CA] p-5 text-center">

                <p class="text-xs font-medium text-[#8B6F5A]">
                    Total yang harus dibayar
                </p>

                <p
                    class="mt-2 text-3xl font-extrabold text-[#5C3D2E]"
                    x-text="formatRupiah(total)"
                ></p>

            </div>


            {{-- PAYMENT METHOD --}}
            <div class="mt-5">

                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Metode Pembayaran
                </label>

                <div class="grid grid-cols-2 gap-2">

                    <label
                        class="cursor-pointer"
                        @click="paymentMethod = 'cash'"
                    >

                        <input
                            type="radio"
                            name="payment_method"
                            value="cash"
                            x-model="paymentMethod"
                            class="peer sr-only"
                        >

                        <div class="rounded-xl border border-gray-200 p-3 text-center transition peer-checked:border-[#5C3D2E] peer-checked:bg-[#F5E6CA]">

                            <svg
                                class="mx-auto h-6 w-6 text-[#5C3D2E]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M3 7h18v10H3V7Zm0 3h18M7 14h3"
                                />
                            </svg>

                            <span class="mt-1 block text-sm font-semibold">
                                Cash
                            </span>

                        </div>

                    </label>


                    <label
                        class="cursor-pointer"
                        @click="paymentMethod = 'qris'"
                    >

                        <input
                            type="radio"
                            name="payment_method"
                            value="qris"
                            x-model="paymentMethod"
                            class="peer sr-only"
                        >

                        <div class="rounded-xl border border-gray-200 p-3 text-center transition peer-checked:border-[#5C3D2E] peer-checked:bg-[#F5E6CA]">

                            <svg
                                class="mx-auto h-6 w-6 text-[#5C3D2E]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M4 4h6v6H4V4Zm10 0h6v6h-6V4ZM4 14h6v6H4v-6Zm10 0h2v2h-2v-2Zm4 0h2v2h-2v-2Zm-4 4h2v2h-2v-2Zm4 0h2v2h-2v-2Z"
                                />
                            </svg>

                            <span class="mt-1 block text-sm font-semibold">
                                QRIS
                            </span>

                        </div>

                    </label>

                </div>

            </div>


            {{-- PAYMENT INPUT --}}
            <div
                x-show="paymentMethod === 'cash'"
                x-transition
                class="mt-5"
            >

                <label
                    for="payment_amount"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Uang Dibayar
                </label>


                <div class="relative">

                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400">
                        Rp
                    </span>

                    <input
                        id="payment_amount"
                        name="payment_amount"
                        type="number"
                        min="0"
                        step="1"
                        x-model="paymentAmount"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3.5 pl-11 pr-4 text-lg font-bold outline-none transition focus:border-[#8B6F5A] focus:bg-white focus:ring-2 focus:ring-[#5C3D2E]/10"
                        placeholder="0"
                    >

                </div>


                {{-- CHANGE --}}
                <div class="mt-3 flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">

                    <span class="text-sm text-gray-500">
                        Kembalian
                    </span>

                    <span
                        class="text-sm font-bold text-green-600"
                        x-text="formatRupiah(change)"
                    ></span>

                </div>

            </div>


            {{-- HIDDEN CART DATA --}}
            <input
                type="hidden"
                name="cart"
                :value="JSON.stringify(
                    cart.map(item => ({
                        product_id: item.id,
                        quantity: item.quantity
                    }))
                )"
            >


            {{-- BUTTON --}}
            <div class="mt-5 grid grid-cols-2 gap-3">

                <button
                    type="button"
                    @click="closePayment()"
                    class="rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                >
                    Batal
                </button>


                <button
                    type="button"
                    @click="submitPayment()"
                    class="rounded-xl bg-[#5C3D2E] px-4 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#4a3024] active:scale-[0.98]"
                >
                    Proses Pembayaran
                </button>

            </div>

        </form>

    </div>

</div>