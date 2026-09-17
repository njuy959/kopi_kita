@extends('layouts.dashboard')

@section('title', 'Tambah Kategori')

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
                Tambah Kategori
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Tambahkan kategori baru untuk produk KOPI KITA.
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
          action="{{ route('categories.store') }}"
          class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        @csrf

        <div class="space-y-6 p-5 sm:p-7">

            {{-- Icon --}}
            <div class="flex justify-center">

                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-[#F5E6CA] text-[#5C3D2E]">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-9 w-9"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4 6h16M4 10h16M4 14h16M4 18h10"/>
                    </svg>

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
                       value="{{ old('name') }}"
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

                <p class="mt-2 text-xs text-gray-500">
                    Gunakan nama kategori yang singkat dan mudah dipahami.
                </p>

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
                          d="M12 4v16m8-8H4"/>
                </svg>

                Simpan Kategori

            </button>

        </div>

    </form>

</div>
@endsection
