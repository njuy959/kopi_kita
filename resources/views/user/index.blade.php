@extends('layouts.dashboard')

@section('title', 'Manajemen User')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[#1F1F1F]">
                Manajemen User
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Kelola akun admin dan kasir KOPI KITA.
            </p>
        </div>

        <a href="{{ route('users.create') }}"
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
            Tambah User
        </a>
    </div>

    {{-- Alert Success --}}
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
                    class="text-green-600 hover:text-green-800">
                &times;
            </button>
        </div>
    @endif

    {{-- Alert Error --}}
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
                    class="text-red-600 hover:text-red-800">
                &times;
            </button>
        </div>
    @endif

    {{-- Filter --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
        <form method="GET"
              action="{{ route('users.index') }}"
              class="grid grid-cols-1 gap-3 md:grid-cols-4">

            {{-- Search --}}
            <div class="md:col-span-2">
                <label for="search"
                       class="mb-1.5 block text-sm font-medium text-gray-700">
                    Cari User
                </label>

                <div class="relative">
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
                           id="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama atau email..."
                           class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-10 pr-4 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10">
                </div>
            </div>

            {{-- Role --}}
            <div>
                <label for="role"
                       class="mb-1.5 block text-sm font-medium text-gray-700">
                    Role
                </label>

                <select id="role"
                        name="role"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10">

                    <option value="">Semua Role</option>

                    <option value="admin"
                        {{ request('role') === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="cashier"
                        {{ request('role') === 'cashier' ? 'selected' : '' }}>
                        Kasir
                    </option>
                </select>
            </div>

            {{-- Button --}}
            <div class="flex items-end gap-2">
                <button type="submit"
                        class="flex-1 rounded-xl bg-[#5C3D2E] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#4b3024]">
                    Filter
                </button>

                @if(request('search') || request('role'))
                    <a href="{{ route('users.index') }}"
                       class="rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Desktop Table --}}
    <div class="hidden overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm md:block">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead class="bg-[#F5E6CA]/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                            User
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                            Role
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
                    @forelse($users as $user)
                        <tr class="transition hover:bg-gray-50">

                            {{-- User --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-[#F5E6CA] text-sm font-bold text-[#5C3D2E]">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <div class="font-semibold text-[#1F1F1F]">
                                            {{ $user->name }}
                                        </div>

                                        @if($user->id === auth()->id())
                                            <span class="text-xs text-[#8B6F5A]">
                                                Akun Anda
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $user->email }}
                            </td>

                            {{-- Role --}}
                            <td class="px-6 py-4">
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center rounded-full bg-[#F5E6CA] px-3 py-1 text-xs font-bold text-[#5C3D2E]">
                                        Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                                        Kasir
                                    </span>
                                @endif
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $user->created_at?->format('d M Y H:i') ?? '-' }}
                            </td>

                            {{-- Action --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    <a href="{{ route('users.edit', $user) }}"
                                       class="rounded-lg border border-gray-200 p-2 text-gray-600 transition hover:border-[#5C3D2E] hover:bg-[#F5E6CA]/40 hover:text-[#5C3D2E]"
                                       title="Edit">

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

                                    @if($user->id !== auth()->id())
                                        <form method="POST"
                                              action="{{ route('users.destroy', $user) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus user {{ addslashes($user->name) }}?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-lg border border-red-200 p-2 text-red-500 transition hover:bg-red-50 hover:text-red-700"
                                                    title="Hapus">

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
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-7 w-7 text-gray-400"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>

                                <h3 class="mt-4 font-semibold text-gray-700">
                                    Tidak ada user
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Belum ada user yang sesuai dengan pencarian.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Mobile Cards --}}
    <div class="space-y-3 md:hidden">
        @forelse($users as $user)
            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">

                <div class="flex items-start justify-between gap-3">

                    <div class="flex min-w-0 items-center gap-3">

                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-[#F5E6CA] font-bold text-[#5C3D2E]">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div class="min-w-0">
                            <h3 class="truncate font-bold text-[#1F1F1F]">
                                {{ $user->name }}
                            </h3>

                            <p class="truncate text-sm text-gray-500">
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>

                    @if($user->role === 'admin')
                        <span class="flex-shrink-0 rounded-full bg-[#F5E6CA] px-2.5 py-1 text-xs font-bold text-[#5C3D2E]">
                            Admin
                        </span>
                    @else
                        <span class="flex-shrink-0 rounded-full bg-blue-100 px-2.5 py-1 text-xs font-bold text-blue-700">
                            Kasir
                        </span>
                    @endif
                </div>

                <div class="mt-4 border-t border-gray-100 pt-3">
                    <div class="flex items-center justify-between">

                        <span class="text-xs text-gray-500">
                            {{ $user->created_at?->format('d M Y H:i') ?? '-' }}
                        </span>

                        <div class="flex gap-2">

                            <a href="{{ route('users.edit', $user) }}"
                               class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Edit
                            </a>

                            @if($user->id !== auth()->id())
                                <form method="POST"
                                      action="{{ route('users.destroy', $user) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            @endif

                        </div>
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
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>

                <p class="mt-4 font-semibold text-gray-700">
                    Tidak ada user
                </p>
            </div>

        @endforelse
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
        <div class="rounded-2xl border border-gray-200 bg-white px-4 py-4 shadow-sm">
            {{ $users->links() }}
        </div>
    @endif

</div>
@endsection