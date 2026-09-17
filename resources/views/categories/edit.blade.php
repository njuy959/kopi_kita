@extends('layouts.dashboard')

@section('title', 'Edit Kategori')

@section('content')
<div class="mx-auto max-w-2xl space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">

        <a href="{{ route('categories.index') }}"
           class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-600 transition hover:bg-gray-50">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15 19l-7-7 7-7"/>
            </svg>

        </a>

        <div>

            <h1 class="text-2xl font-bold text-[#1F1F1F]">
                Edit Kategori
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Perbarui nama kategori produk.
            </p>

        </div>

    </div>


    {{-- Validation --}}
    @if($errors->any())

        <div class="rounded-xl border border-red-200 bg-red-50 p-4">

            <div class="flex gap-3">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 flex-shrink-0 text-red-600"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 8v4m0 4h.01M10.29 3.86l-7.82 14A2 2 0 004.2 21h15.6a2 2 0 001.73-3.14l-7.82-14a2 2 0 00-3.46 0z"/>
                </svg>

                <div>

                    <p class="font-semibold text-red-700">
                        Periksa kembali data:
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- Form --}}
    <form method="POST"
          action="{{ route('categories.update', $category) }}"
          class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        @csrf
        @method('PUT')

        <div class="space-y-6 p-5 sm:p-7">

            {{-- Current Category --}}
            <div class="flex items-center gap-4 rounded-2xl bg-[#F5E6CA]/40 p-4">

                <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl bg-[#5C3D2E] text-white">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4 6h16M4 10h16M4 14h16M4 18h10"/>
                    </svg>

                </div>

                <div class="min-w-0">

                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                        Kategori saat ini
                    </p>

                    <p class="truncate text-lg font-bold text-[#1F1F1F]">
                        {{ $category->name }}
                    </p>

                    <p class="text-xs text-gray-400">
                        ID #{{ $category->id }}
                    </p>

                </div>

            </div>


            {{-- Name --}}
            <div>

                <label for="name"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Nama Kategori
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $category->name) }}"
                       placeholder="Contoh: Coffee"
                       maxlength="255"
                       required
                       autofocus
                       class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10">

                @error('name')

                    <p class="mt-1.5 text-sm text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Product Info --}}
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                <div class="flex items-start gap-3">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="mt-0.5 h-5 w-5 flex-shrink-0 text-[#8B6F5A]"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>

                    <div>

                        <p class="text-sm font-semibold text-gray-700">
                            Informasi kategori
                        </p>

                        @php
                            $productCount = method_exists($category, 'products')
                                ? $category->products()->count()
                                : 0;
                        @endphp

                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            Kategori ini memiliki
                            <strong>{{ $productCount }}</strong>
                            produk.
                            Mengubah nama kategori tidak akan menghapus produk.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- Footer --}}
        <div class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-7">

            <a href="{{ route('categories.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                Batal
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#5C3D2E] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#4b3024]">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M5 13l4 4L19 7"/>
                </svg>

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>
@endsection