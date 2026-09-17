@extends('layouts.dashboard')

@section('title', 'Kategori Produk')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[#1F1F1F]">
                Kategori Produk
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola kategori produk KOPI KITA.
            </p>
        </div>

        <a href="{{ route('categories.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#5C3D2E] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#4b3024]">

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

            Tambah Kategori
        </a>
    </div>


    {{-- Success Alert --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-4 text-green-700">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="mt-0.5 h-5 w-5 flex-shrink-0"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M5 13l4 4L19 7"/>
            </svg>

            <div class="flex-1 text-sm font-medium">
                {{ session('success') }}
            </div>

            <button type="button"
                    onclick="this.parentElement.remove()"
                    class="text-lg leading-none text-green-600 hover:text-green-800">
                &times;
            </button>
        </div>
    @endif


    {{-- Error Alert --}}
    @if(session('error'))
        <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-red-700">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="mt-0.5 h-5 w-5 flex-shrink-0"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 8v4m0 4h.01M10.29 3.86l-7.82 14A2 2 0 004.2 21h15.6a2 2 0 001.73-3.14l-7.82-14a2 2 0 00-3.46 0z"/>
            </svg>

            <div class="flex-1 text-sm font-medium">
                {{ session('error') }}
            </div>

            <button type="button"
                    onclick="this.parentElement.remove()"
                    class="text-lg leading-none text-red-600 hover:text-red-800">
                &times;
            </button>
        </div>
    @endif


    {{-- Validation Error --}}
    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">

            <p class="font-semibold text-red-700">
                Terjadi kesalahan:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- Search --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">

        <form method="GET"
              action="{{ route('categories.index') }}"
              class="flex flex-col gap-3 sm:flex-row">

            <div class="relative flex-1">

                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-gray-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"/>
                    </svg>

                </div>

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari kategori..."
                       class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-10 pr-4 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10">

            </div>

            <button type="submit"
                    class="rounded-xl bg-[#5C3D2E] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#4b3024]">
                Cari
            </button>

            @if(request('search'))
                <a href="{{ route('categories.index') }}"
                   class="rounded-xl border border-gray-300 bg-white px-6 py-3 text-center text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Reset
                </a>
            @endif

        </form>
    </div>


    {{-- Desktop Table --}}
    <div class="hidden overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm md:block">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-[#F5E6CA]/50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                            #
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                            Nama Kategori
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-600">
                            Jumlah Produk
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                            Dibuat
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-600">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($categories as $category)

                        <tr class="transition hover:bg-gray-50">

                            {{-- Number --}}
                            <td class="px-6 py-4 text-sm font-medium text-gray-500">
                                {{ $categories->firstItem() + $loop->index }}
                            </td>


                            {{-- Category --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F5E6CA] text-[#5C3D2E]">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-5 w-5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M4 6h16M4 10h16M4 14h16M4 18h10"/>
                                        </svg>

                                    </div>

                                    <div>
                                        <p class="font-semibold text-[#1F1F1F]">
                                            {{ $category->name }}
                                        </p>

                                        <p class="text-xs text-gray-400">
                                            ID #{{ $category->id }}
                                        </p>
                                    </div>

                                </div>

                            </td>


                            {{-- Products Count --}}
                            <td class="px-6 py-4 text-center">

                                @php
                                    $productCount = $category->products_count ?? $category->products()->count();
                                @endphp

                                <span class="inline-flex min-w-[40px] items-center justify-center rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-700">
                                    {{ $productCount }}
                                </span>

                            </td>


                            {{-- Date --}}
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $category->created_at?->format('d M Y H:i') ?? '-' }}
                            </td>


                            {{-- Action --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('categories.edit', $category) }}"
                                       title="Edit kategori"
                                       class="rounded-lg border border-gray-200 p-2 text-gray-600 transition hover:border-[#5C3D2E] hover:bg-[#F5E6CA]/40 hover:text-[#5C3D2E]">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-5 w-5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-8.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 8.5-8.5z"/>
                                        </svg>

                                    </a>


                                    {{-- Delete --}}
                                    <form method="POST"
                                          action="{{ route('categories.destroy', $category) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori {{ addslashes($category->name) }}?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                title="Hapus kategori"
                                                class="rounded-lg border border-red-200 p-2 text-red-500 transition hover:bg-red-50 hover:text-red-700">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-5 w-5"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 stroke-width="2">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"/>
                                            </svg>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-14 text-center">

                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-8 w-8 text-gray-400"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M4 6h16M4 10h16M4 14h16M4 18h10"/>
                                    </svg>

                                </div>

                                <h3 class="mt-4 font-semibold text-gray-700">
                                    Belum ada kategori
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan kategori untuk mengelompokkan produk.
                                </p>

                                <a href="{{ route('categories.create') }}"
                                   class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#5C3D2E] px-5 py-3 text-sm font-semibold text-white hover:bg-[#4b3024]">
                                    Tambah Kategori
                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- Mobile Cards --}}
    <div class="space-y-3 md:hidden">

        @forelse($categories as $category)

            @php
                $productCount = $category->products_count ?? $category->products()->count();
            @endphp

            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">

                <div class="flex items-center justify-between gap-3">

                    <div class="flex min-w-0 items-center gap-3">

                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-[#F5E6CA] text-[#5C3D2E]">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
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

                            <h3 class="truncate font-bold text-[#1F1F1F]">
                                {{ $category->name }}
                            </h3>

                            <p class="text-xs text-gray-400">
                                ID #{{ $category->id }}
                            </p>

                        </div>

                    </div>


                    <span class="flex-shrink-0 rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-700">
                        {{ $productCount }} produk
                    </span>

                </div>


                <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-3">

                    <span class="text-xs text-gray-500">
                        {{ $category->created_at?->format('d M Y') ?? '-' }}
                    </span>


                    <div class="flex gap-2">

                        <a href="{{ route('categories.edit', $category) }}"
                           class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            Edit
                        </a>


                        <form method="POST"
                              action="{{ route('categories.destroy', $category) }}"
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                                Hapus
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @empty

            <div class="rounded-2xl border border-gray-200 bg-white px-6 py-12 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-7 w-7 text-gray-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4 6h16M4 10h16M4 14h16M4 18h10"/>
                    </svg>

                </div>

                <p class="mt-4 font-semibold text-gray-700">
                    Belum ada kategori
                </p>

                <a href="{{ route('categories.create') }}"
                   class="mt-4 inline-flex rounded-xl bg-[#5C3D2E] px-5 py-3 text-sm font-semibold text-white">
                    Tambah Kategori
                </a>

            </div>

        @endforelse

    </div>


    {{-- Pagination --}}
    @if(method_exists($categories, 'hasPages') && $categories->hasPages())

        <div class="rounded-2xl border border-gray-200 bg-white px-4 py-4 shadow-sm">

            {{ $categories->links() }}

        </div>

    @endif

</div>
@endsection