@extends('layouts.dashboard')

@section('title', 'Detail Produk')

@section('content')

<div class="mx-auto max-w-5xl space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <a
                href="{{ route('products.index') }}"
                class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-[#5C3D2E] hover:underline"
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
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Kembali ke Produk

            </a>

            <h1 class="text-2xl font-bold text-[#1F1F1F]">
                Detail Produk
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Informasi lengkap produk.
            </p>

        </div>


        <div class="flex gap-2">

            <a
                href="{{ route('products.edit', $product) }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#5C3D2E] px-5 py-3 text-sm font-semibold text-white hover:bg-[#4b3024]"
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
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                    />
                </svg>

                Edit

            </a>

        </div>

    </div>


    {{-- PRODUCT --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="grid grid-cols-1 lg:grid-cols-2">

            {{-- IMAGE --}}
            <div class="bg-[#F5E6CA]/40 p-6 sm:p-8">

                <div class="overflow-hidden rounded-2xl bg-white shadow-sm">

                    @if($product->image)

                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="aspect-square w-full object-cover"
                        >

                    @else

                        <div class="flex aspect-square w-full items-center justify-center">

                            <div class="text-center">

                                <div class="text-7xl">
                                    ☕
                                </div>

                                <p class="mt-4 text-sm text-gray-500">
                                    Tidak ada foto produk
                                </p>

                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- INFO --}}
            <div class="p-6 sm:p-8">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <span class="inline-flex rounded-full bg-[#F5E6CA] px-3 py-1 text-xs font-semibold text-[#5C3D2E]">
                            {{ $product->category?->name ?? 'Tanpa Kategori' }}
                        </span>

                        <h2 class="mt-4 text-3xl font-bold text-gray-900">
                            {{ $product->name }}
                        </h2>

                    </div>


                    @if($product->is_active)

                        <span class="shrink-0 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                            Aktif
                        </span>

                    @else

                        <span class="shrink-0 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                            Nonaktif
                        </span>

                    @endif

                </div>


                {{-- PRICE --}}
                <div class="mt-8">

                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Harga
                    </p>

                    <p class="mt-1 text-3xl font-bold text-[#5C3D2E]">
                        Rp {{ number_format((float)$product->price, 0, ',', '.') }}
                    </p>

                </div>


                {{-- STOCK --}}
                <div class="mt-6 rounded-2xl bg-gray-50 p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Stok Tersedia
                            </p>

                            <p class="mt-1 text-2xl font-bold text-gray-900">
                                {{ $product->stock }}
                            </p>

                        </div>


                        @if($product->stock <= 0)

                            <div class="rounded-xl bg-red-100 px-4 py-3 text-center">

                                <p class="text-xs font-semibold text-red-600">
                                    STATUS
                                </p>

                                <p class="font-bold text-red-700">
                                    Habis
                                </p>

                            </div>

                        @elseif($product->stock <= 5)

                            <div class="rounded-xl bg-orange-100 px-4 py-3 text-center">

                                <p class="text-xs font-semibold text-orange-600">
                                    STATUS
                                </p>

                                <p class="font-bold text-orange-700">
                                    Stok Menipis
                                </p>

                            </div>

                        @else

                            <div class="rounded-xl bg-green-100 px-4 py-3 text-center">

                                <p class="text-xs font-semibold text-green-600">
                                    STATUS
                                </p>

                                <p class="font-bold text-green-700">
                                    Tersedia
                                </p>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- DESCRIPTION --}}
                <div class="mt-7">

                    <h3 class="font-bold text-gray-900">
                        Deskripsi
                    </h3>

                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-600">
                        {{ $product->description ?: 'Tidak ada deskripsi produk.' }}
                    </p>

                </div>


                {{-- DATE --}}
                <div class="mt-7 grid grid-cols-2 gap-4 border-t border-gray-200 pt-6">

                    <div>

                        <p class="text-xs text-gray-500">
                            Dibuat
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-800">
                            {{ $product->created_at?->format('d M Y, H:i') ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-gray-500">
                            Diperbarui
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-800">
                            {{ $product->updated_at?->format('d M Y, H:i') ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- DELETE --}}
    <div class="rounded-2xl border border-red-200 bg-red-50 p-5">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h3 class="font-bold text-red-800">
                    Hapus Produk
                </h3>

                <p class="mt-1 text-sm text-red-700">
                    Tindakan ini akan menghapus produk dari database.
                </p>

            </div>


            <form
                action="{{ route('products.destroy', $product) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus produk {{ addslashes($product->name) }}?')"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700 sm:w-auto"
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
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h12"
                        />
                    </svg>

                    Hapus Produk

                </button>

            </form>

        </div>

    </div>

</div>

@endsection