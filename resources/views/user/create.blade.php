@extends('layouts.dashboard')

@section('title', 'Tambah User')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('users.index') }}"
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
                Tambah User
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Buat akun baru untuk admin atau kasir.
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
          action="{{ route('users.store') }}"
          class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        @csrf

        <div class="space-y-6 p-5 sm:p-7">

            {{-- Name --}}
            <div>
                <label for="name"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Nama Lengkap
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Contoh: Budi Santoso"
                       required
                       autofocus
                       class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10">

                @error('name')
                    <p class="mt-1.5 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Email
                </label>

                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="contoh@email.com"
                       required
                       class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10">

                @error('email')
                    <p class="mt-1.5 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label for="role"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Role
                </label>

                <select id="role"
                        name="role"
                        required
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10">

                    <option value="">Pilih Role</option>

                    <option value="admin"
                        {{ old('role') === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="cashier"
                        {{ old('role') === 'cashier' ? 'selected' : '' }}>
                        Kasir
                    </option>
                </select>

                <p class="mt-2 text-xs text-gray-500">
                    Admin dapat mengakses seluruh menu pengelolaan sistem.
                    Kasir fokus pada transaksi POS.
                </p>

                @error('role')
                    <p class="mt-1.5 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Password
                </label>

                <div class="relative">
                    <input type="password"
                           id="password"
                           name="password"
                           minlength="8"
                           required
                           placeholder="Minimal 8 karakter"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 pr-12 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10">

                    <button type="button"
                            onclick="togglePassword('password', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#5C3D2E]">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>

                @error('password')
                    <p class="mt-1.5 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Konfirmasi Password
                </label>

                <div class="relative">
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           minlength="8"
                           required
                           placeholder="Ulangi password"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 pr-12 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-[#5C3D2E] focus:ring-2 focus:ring-[#5C3D2E]/10">

                    <button type="button"
                            onclick="togglePassword('password_confirmation', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#5C3D2E]">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-7">

            <a href="{{ route('users.index') }}"
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

                Simpan User
            </button>

        </div>
    </form>
</div>

<script>
function togglePassword(id, button) {
    const input = document.getElementById(id);

    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}
</script>
@endsection