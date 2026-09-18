@php
    $productImage = $product->image
        ? asset('storage/' . $product->image)
        : null;
@endphp

<div
    x-data
    x-show="
        filteredProducts.some(
            item => item.id === {{ $product->id }}
        )
    "
    x-cloak
    class="group"
>
    <button
        type="button"
        @click="addToCart(products.find(item => item.id === {{ $product->id }}))"
        @disabled($product->stock <= 0)
        class="w-full overflow-hidden rounded-2xl border border-gray-100 bg-white text-left shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#8B6F5A] hover:shadow-md disabled:cursor-not-allowed disabled:opacity-60"
    >

        {{-- IMAGE --}}
        <div class="relative aspect-[4/3] overflow-hidden bg-[#F5E6CA]">

            @if($productImage)

                <img
                    src="{{ $productImage }}"
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
                            d="M8 10h.01M16 10h.01M9 16c1.5 1 4.5 1 6 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>

                </div>

            @endif


            {{-- STOCK --}}
            <div class="absolute right-2 top-2">

                @if($product->stock > 5)

                    <span class="rounded-full bg-white/90 px-2 py-1 text-[10px] font-bold text-green-700 shadow-sm backdrop-blur">
                        Stok {{ $product->stock }}
                    </span>

                @elseif($product->stock > 0)

                    <span class="rounded-full bg-white/90 px-2 py-1 text-[10px] font-bold text-orange-600 shadow-sm backdrop-blur">
                        Sisa {{ $product->stock }}
                    </span>

                @else

                    <span class="rounded-full bg-red-500 px-2 py-1 text-[10px] font-bold text-white shadow-sm">
                        Habis
                    </span>

                @endif

            </div>

        </div>


        {{-- CONTENT --}}
        <div class="p-3">

            <h3 class="truncate text-sm font-bold text-[#1F1F1F]">
                {{ $product->name }}
            </h3>

            <p class="mt-1 truncate text-xs text-gray-400">
                {{ $product->category?->name ?? 'Tanpa kategori' }}
            </p>

            <div class="mt-3 flex items-center justify-between gap-2">

                <span class="text-sm font-bold text-[#5C3D2E]">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>

                <span
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#5C3D2E] text-white transition group-hover:bg-[#8B6F5A]"
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
                            d="M12 5v14M5 12h14"
                        />
                    </svg>
                </span>

            </div>

        </div>

    </button>
</div>