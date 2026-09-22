@extends('layouts.dashboard')

@section('title', 'Produk')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-[#1F1F1F]">
                Produk
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola semua produk KOPI KITA
            </p>
        </div>

        <a
            href="{{ route('products.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#5C3D2E] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#4b3024]"
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
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Tambah Produk
        </a>

    </div>


    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div
            class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="mt-0.5 h-5 w-5 shrink-0"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 13l4 4L19 7"
                />
            </svg>

            <p class="text-sm font-medium">
                {{ session('success') }}
            </p>
        </div>
    @endif


    {{-- ALERT ERROR --}}
    @if(session('error'))
        <div
            class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="mt-0.5 h-5 w-5 shrink-0"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>

            <p class="text-sm font-medium">
                {{ session('error') }}
            </p>
        </div>
    @endif


    {{-- SEARCH & FILTER --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">

        <form
            method="GET"
            action="{{ route('products.index') }}"
            class="grid grid-cols-1 gap-3 md:grid-cols-12"
        >

            {{-- SEARCH --}}
            <div class="md:col-span-6">

                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Cari Produk
                </label>

                <div class="relative">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
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

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama produk..."
                        class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-10 pr-4 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10"
                    >

                </div>

            </div>


            {{-- CATEGORY --}}
            <div class="md:col-span-3">

                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Kategori
                </label>

                <select
                    name="category_id"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10"
                >

                    <option value="">
                        Semua Kategori
                    </option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            @selected(request('category_id') == $category->id)
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- STATUS --}}
            <div class="md:col-span-2">

                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Status
                </label>

                <select
                    name="is_active"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10"
                >

                    <option value="">
                        Semua
                    </option>

                    <option
                        value="1"
                        @selected(request('is_active') === '1')
                    >
                        Aktif
                    </option>

                    <option
                        value="0"
                        @selected(request('is_active') === '0')
                    >
                        Nonaktif
                    </option>

                </select>

            </div>


            {{-- BUTTON --}}
            <div class="flex items-end md:col-span-1">

                <button
                    type="submit"
                    class="w-full rounded-xl bg-[#5C3D2E] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#4b3024]"
                >
                    Cari
                </button>

            </div>

        </form>


        @if(request()->hasAny(['search', 'category_id', 'is_active']))

            <div class="mt-3">

                <a
                    href="{{ route('products.index') }}"
                    class="text-sm font-medium text-[#5C3D2E] hover:underline"
                >
                    Reset filter
                </a>

            </div>

        @endif

    </div>


    {{-- PRODUCT TABLE --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 px-5 py-4">

            <div class="flex items-center justify-between">

                <div>
                    <h2 class="font-bold text-[#1F1F1F]">
                        Daftar Produk
                    </h2>

                    <p class="mt-1 text-xs text-gray-500">
                        {{ $products->total() }} produk ditemukan
                    </p>
                </div>

            </div>

        </div>


        @if($products->count() > 0)

            {{-- DESKTOP --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full text-left">

                    <thead class="bg-[#F5E6CA]/50">

                        <tr>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-600">
                                Produk
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-600">
                                Kategori
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-600">
                                Harga
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-600">
                                Stok
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-600">
                                Status
                            </th>

                            <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-600">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach($products as $product)

                            <tr class="transition hover:bg-gray-50">

                                {{-- PRODUK --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="h-14 w-14 shrink-0 overflow-hidden rounded-xl bg-[#F5E6CA]">

                                            @if($product->image)

                                                <img
                                                    src="{{ asset('storage/' . $product->image) }}"
                                                    alt="{{ $product->name }}"
                                                    class="h-full w-full object-cover"
                                                >

                                            @else

                                                <div class="flex h-full w-full items-center justify-center text-[#5C3D2E]">

                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-7 w-7"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M12 3v18m9-9H3"
                                                        />
                                                    </svg>

                                                </div>

                                            @endif

                                        </div>


                                        <div class="min-w-0">

                                            <p class="truncate font-semibold text-gray-900">
                                                {{ $product->name }}
                                            </p>

                                            @if($product->description)

                                                <p class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                                    {{ $product->description }}
                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- CATEGORY --}}
                                <td class="px-5 py-4">

                                    <span class="rounded-full bg-[#F5E6CA] px-3 py-1 text-xs font-semibold text-[#5C3D2E]">
                                        {{ $product->category?->name ?? '-' }}
                                    </span>

                                </td>


                                {{-- PRICE --}}
                                <td class="px-5 py-4">

                                    <span class="font-semibold text-gray-900">
                                        Rp {{ number_format((float)$product->price, 0, ',', '.') }}
                                    </span>

                                </td>


                                {{-- STOCK --}}
                                <td class="px-5 py-4">

                                    @if($product->stock <= 0)

                                        <span class="font-bold text-red-600">
                                            Habis
                                        </span>

                                    @elseif($product->stock <= 5)

                                        <span class="font-bold text-orange-500">
                                            {{ $product->stock }}
                                        </span>

                                    @else

                                        <span class="font-semibold text-gray-700">
                                            {{ $product->stock }}
                                        </span>

                                    @endif

                                </td>


                                {{-- STATUS --}}
                                <td class="px-5 py-4">

                                    @if($product->is_active)

                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Aktif
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                            Nonaktif
                                        </span>

                                    @endif

                                </td>


                                {{-- ACTION --}}
                                <td class="px-5 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('products.show', $product) }}"
                                            title="Detail"
                                            class="rounded-lg border border-gray-200 p-2 text-gray-600 transition hover:border-[#5C3D2E] hover:bg-[#F5E6CA] hover:text-[#5C3D2E]"
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
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                />
                                            </svg>

                                        </a>


                                        <a
                                            href="{{ route('products.edit', $product) }}"
                                            title="Edit"
                                            class="rounded-lg border border-gray-200 p-2 text-gray-600 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600"
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

                                        </a>


                                        <form
                                            action="{{ route('products.destroy', $product) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus produk {{ addslashes($product->name) }}?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Hapus"
                                                class="rounded-lg border border-gray-200 p-2 text-gray-600 transition hover:border-red-300 hover:bg-red-50 hover:text-red-600"
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

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- MOBILE --}}
            <div class="divide-y divide-gray-100 md:hidden">

                @foreach($products as $product)

                    <div class="p-4">

                        <div class="flex gap-3">

                            <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl bg-[#F5E6CA]">

                                @if($product->image)

                                    <img
                                        src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="h-full w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-full w-full items-center justify-center text-[#5C3D2E]">
                                        <span class="text-xl">☕</span>
                                    </div>

                                @endif

                            </div>


                            <div class="min-w-0 flex-1">

                                <div class="flex items-start justify-between gap-2">

                                    <div>

                                        <h3 class="font-bold text-gray-900">
                                            {{ $product->name }}
                                        </h3>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $product->category?->name ?? '-' }}
                                        </p>

                                    </div>


                                    @if($product->is_active)

                                        <span class="shrink-0 rounded-full bg-green-100 px-2 py-1 text-[10px] font-semibold text-green-700">
                                            Aktif
                                        </span>

                                    @else

                                        <span class="shrink-0 rounded-full bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600">
                                            Nonaktif
                                        </span>

                                    @endif

                                </div>


                                <div class="mt-3 flex items-center justify-between">

                                    <div>

                                        <p class="font-bold text-[#5C3D2E]">
                                            Rp {{ number_format((float)$product->price, 0, ',', '.') }}
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            Stok:
                                            <span class="font-semibold">
                                                {{ $product->stock }}
                                            </span>
                                        </p>

                                    </div>


                                    <div class="flex gap-1">

                                        <a
                                            href="{{ route('products.show', $product) }}"
                                            class="rounded-lg p-2 text-gray-500 hover:bg-gray-100"
                                        >
                                            Detail
                                        </a>

                                        <a
                                            href="{{ route('products.edit', $product) }}"
                                            class="rounded-lg p-2 text-blue-600 hover:bg-blue-50"
                                        >
                                            Edit
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            {{-- EMPTY --}}
            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#F5E6CA]">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-8 w-8 text-[#5C3D2E]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                        />
                    </svg>

                </div>

                <h3 class="mt-4 font-bold text-gray-900">
                    Belum ada produk
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Tambahkan produk pertama untuk mulai menggunakan POS.
                </p>

                <a
                    href="{{ route('products.create') }}"
                    class="mt-5 inline-flex rounded-xl bg-[#5C3D2E] px-5 py-3 text-sm font-semibold text-white hover:bg-[#4b3024]"
                >
                    + Tambah Produk
                </a>

            </div>

        @endif


        {{-- PAGINATION --}}
        @if($products->hasPages())

            <div class="border-t border-gray-200 px-5 py-4">
                {{ $products->links() }}
            </div>

        @endif

    </div>

</div>

@endsection