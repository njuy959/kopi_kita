@extends('layouts.dashboard')

@section('title', 'Tambah Produk')

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
            Tambah Produk
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Tambahkan produk baru ke menu KOPI KITA.
        </p>

    </div>


    {{-- VALIDATION ERROR --}}
    @if($errors->any())

        <div class="rounded-xl border border-red-200 bg-red-50 p-4">

            <div class="flex gap-3">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0 text-red-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v2m0 4h.01M10.29 3.86l-8.82 15a2 2 0 001.71 3h17.64a2 2 0 001.71-3l-8.82-15a2 2 0 00-3.42 0z"
                    />
                </svg>

                <div>

                    <p class="font-semibold text-red-800">
                        Periksa kembali data yang dimasukkan.
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- FORM --}}
    <form
        action="{{ route('products.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf


        {{-- BASIC INFO --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

            <div class="mb-6">

                <h2 class="text-lg font-bold text-gray-900">
                    Informasi Produk
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Isi informasi dasar produk.
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
                        value="{{ old('name') }}"
                        required
                        maxlength="255"
                        placeholder="Contoh: Cappuccino"
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
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10 @error('category_id') border-red-400 @enderror"
                    >

                        <option value="">
                            Pilih kategori
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)
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
                            value="{{ old('price') }}"
                            required
                            min="0"
                            step="0.01"
                            placeholder="25000"
                            class="w-full rounded-xl border border-gray-300 py-3 pl-12 pr-4 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10 @error('price') border-red-400 @enderror"
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
                        Stok Awal
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="stock"
                        type="number"
                        name="stock"
                        value="{{ old('stock', 0) }}"
                        required
                        min="0"
                        step="1"
                        placeholder="50"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10 @error('stock') border-red-400 @enderror"
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
                        Status Produk
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
                            @selected(old('is_active', '1') == '1')
                        >
                            Aktif
                        </option>

                        <option
                            value="0"
                            @selected(old('is_active') === '0')
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
                        placeholder="Masukkan deskripsi produk..."
                        class="w-full resize-none rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10 @error('description') border-red-400 @enderror"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- IMAGE --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

            <div class="mb-5">

                <h2 class="text-lg font-bold text-gray-900">
                    Foto Produk
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Upload foto produk agar tampil menarik di POS.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                <div>

                    <label
                        for="image"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Pilih Gambar
                    </label>

                    <input
                        id="image"
                        type="file"
                        name="image"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="block w-full rounded-xl border border-gray-300 bg-white text-sm file:mr-4 file:border-0 file:bg-[#F5E6CA] file:px-4 file:py-3 file:font-semibold file:text-[#5C3D2E] hover:file:bg-[#ead5b1]"
                    >

                    <p class="mt-2 text-xs text-gray-500">
                        JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                    </p>

                    @error('image')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>


                <div>

                    <div
                        id="imagePreview"
                        class="hidden overflow-hidden rounded-2xl border border-gray-200 bg-gray-50"
                    >
                        <img
                            id="previewImage"
                            src=""
                            alt="Preview"
                            class="h-48 w-full object-cover"
                        >
                    </div>

                    <div
                        id="emptyPreview"
                        class="flex h-48 items-center justify-center rounded-2xl border border-dashed border-gray-300 bg-gray-50"
                    >
                        <div class="text-center">

                            <div class="text-3xl">
                                ☕
                            </div>

                            <p class="mt-2 text-xs text-gray-500">
                                Preview gambar
                            </p>

                        </div>
                    </div>

                </div>

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a
                href="{{ route('products.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
            >
                Batal
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#5C3D2E] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#4b3024]"
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

                Simpan Produk

            </button>

        </div>

    </form>

</div>


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.getElementById('image');
    const previewImage = document.getElementById('previewImage');
    const imagePreview = document.getElementById('imagePreview');
    const emptyPreview = document.getElementById('emptyPreview');

    if (!imageInput) {
        return;
    }

    imageInput.addEventListener('change', function (event) {

        const file = event.target.files[0];

        if (!file) {
            imagePreview.classList.add('hidden');
            emptyPreview.classList.remove('hidden');
            previewImage.src = '';
            return;
        }

        if (!file.type.startsWith('image/')) {
            imageInput.value = '';
            alert('File yang dipilih harus berupa gambar.');
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {

            previewImage.src = e.target.result;

            imagePreview.classList.remove('hidden');
            emptyPreview.classList.add('hidden');

        };

        reader.readAsDataURL(file);

    });

});

</script>

@endpush

@endsection