@extends('layouts.dashboard')

@section('title', 'Edit Produk')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- HEADER --}}
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
            Edit Produk
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Perbarui informasi produk {{ $product->name }}.
        </p>

    </div>


    {{-- ALERT --}}
    @if(session('error'))

        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
            {{ session('error') }}
        </div>

    @endif


    {{-- VALIDATION --}}
    @if($errors->any())

        <div class="rounded-xl border border-red-200 bg-red-50 p-4">

            <p class="font-semibold text-red-800">
                Periksa kembali data yang dimasukkan.
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORM --}}
    <form
        action="{{ route('products.update', $product) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


        {{-- INFORMASI --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

            <div class="mb-6">

                <h2 class="text-lg font-bold text-gray-900">
                    Informasi Produk
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Perbarui data produk.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- NAME --}}
                <div class="md:col-span-2">

                    <label
                        for="name"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Nama Produk
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $product->name) }}"
                        required
                        maxlength="255"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10 @error('name') border-red-400 @enderror"
                    >

                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>


                {{-- CATEGORY --}}
                <div>

                    <label
                        for="category_id"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Kategori
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        required
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10"
                    >

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id', $product->category_id) == $category->id)
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('category_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>


                {{-- PRICE --}}
                <div>

                    <label
                        for="price"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Harga
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">

                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">
                            Rp
                        </span>

                        <input
                            id="price"
                            type="number"
                            name="price"
                            value="{{ old('price', $product->price) }}"
                            required
                            min="0"
                            step="0.01"
                            class="w-full rounded-xl border border-gray-300 py-3 pl-12 pr-4 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10"
                        >

                    </div>

                    @error('price')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>


                {{-- STOCK --}}
                <div>

                    <label
                        for="stock"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Stok
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="stock"
                        type="number"
                        name="stock"
                        value="{{ old('stock', $product->stock) }}"
                        required
                        min="0"
                        step="1"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10"
                    >

                    @error('stock')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>


                {{-- STATUS --}}
                <div>

                    <label
                        for="is_active"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Status
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="is_active"
                        name="is_active"
                        required
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10"
                    >

                        <option
                            value="1"
                            @selected(old('is_active', $product->is_active ? '1' : '0') == '1')
                        >
                            Aktif
                        </option>

                        <option
                            value="0"
                            @selected(old('is_active', $product->is_active ? '1' : '0') == '0')
                        >
                            Nonaktif
                        </option>

                    </select>

                </div>


                {{-- DESCRIPTION --}}
                <div class="md:col-span-2">

                    <label
                        for="description"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Deskripsi
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        maxlength="1000"
                        class="w-full resize-none rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10"
                    >{{ old('description', $product->description) }}</textarea>

                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- GAMBAR --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

            <div class="mb-5">

                <h2 class="text-lg font-bold text-gray-900">
                    Foto Produk
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Ganti foto produk jika diperlukan.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- CURRENT IMAGE --}}
                <div>

                    <p class="mb-2 text-sm font-semibold text-gray-700">
                        Foto Saat Ini
                    </p>

                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-gray-50">

                        @if($product->image)

                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="h-56 w-full object-cover"
                            >

                        @else

                            <div class="flex h-56 items-center justify-center">

                                <div class="text-center">

                                    <div class="text-4xl">
                                        ☕
                                    </div>

                                    <p class="mt-2 text-sm text-gray-500">
                                        Belum ada gambar
                                    </p>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- NEW IMAGE --}}
                <div>

                    <label
                        for="image"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Ganti Foto
                    </label>

                    <input
                        id="image"
                        type="file"
                        name="image"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="block w-full rounded-xl border border-gray-300 bg-white text-sm file:mr-4 file:border-0 file:bg-[#F5E6CA] file:px-4 file:py-3 file:font-semibold file:text-[#5C3D2E]"
                    >

                    <p class="mt-2 text-xs text-gray-500">
                        JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                    </p>

                    @error('image')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror


                    {{-- PREVIEW --}}
                    <div
                        id="newImagePreview"
                        class="mt-4 hidden overflow-hidden rounded-2xl border border-gray-200"
                    >

                        <img
                            id="newPreviewImage"
                            src=""
                            alt="Preview gambar baru"
                            class="h-48 w-full object-cover"
                        >

                    </div>

                </div>

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a
                href="{{ route('products.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50"
            >
                Batal
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#5C3D2E] px-6 py-3 text-sm font-semibold text-white hover:bg-[#4b3024]"
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
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('image');
    const preview = document.getElementById('newImagePreview');
    const image = document.getElementById('newPreviewImage');

    if (!input) {
        return;
    }

    input.addEventListener('change', function (event) {

        const file = event.target.files[0];

        if (!file) {
            preview.classList.add('hidden');
            image.src = '';
            return;
        }

        if (!file.type.startsWith('image/')) {
            input.value = '';
            preview.classList.add('hidden');
            alert('File yang dipilih harus berupa gambar.');
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {

            image.src = e.target.result;
            preview.classList.remove('hidden');

        };

        reader.readAsDataURL(file);

    });

});

</script>

@endpush

@endsection