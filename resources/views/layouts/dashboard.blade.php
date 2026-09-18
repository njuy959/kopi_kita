<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') - KOPI KITA
        @else
            KOPI KITA
        @endif
    </title>

    {{-- Google Font --}}
    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        coffee: '#5C3D2E',
                        cream: '#F5E6CA',
                        lightbrown: '#8B6F5A',
                        darkcoffee: '#4B3024',
                        blackcoffee: '#1F1F1F'
                    },

                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f7f7f7;
            color: #1F1F1F;
        }

        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c4b6ac;
            border-radius: 999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #8B6F5A;
        }

        /* Sidebar */
        .sidebar-transition {
            transition:
                transform 0.25s ease,
                width 0.25s ease;
        }

        /* Overlay */
        .mobile-overlay {
            transition: opacity 0.2s ease;
        }

        /* Navigation */
        .nav-link {
            transition:
                background-color 0.2s ease,
                color 0.2s ease,
                transform 0.2s ease;
        }

        .nav-link:hover {
            transform: translateX(2px);
        }

        /* Toast */
        .toast {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Page animation */
        .page-content {
            animation: pageFade 0.25s ease-out;
        }

        @keyframes pageFade {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Focus */
        button:focus-visible,
        a:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 2px solid #5C3D2E;
            outline-offset: 2px;
        }
    </style>

    @stack('styles')
</head>

<body>

@php
    $currentUser = auth()->user();

    $isAdmin = $currentUser && $currentUser->role === 'admin';

    $currentRoute = request()->route()?->getName();

    $navItems = [
        [
            'name' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'dashboard',
            'roles' => ['admin', 'cashier'],
        ],
        [
            'name' => 'POS Kasir',
            'route' => 'pos.index',
            'icon' => 'cart',
            'roles' => ['admin', 'cashier'],
        ],
        [
            'name' => 'Transaksi',
            'route' => 'transactions.index',
            'icon' => 'receipt',
            'roles' => ['admin', 'cashier'],
        ],
        [
            'name' => 'Produk',
            'route' => 'products.index',
            'icon' => 'product',
            'roles' => ['admin'],
        ],
        [
            'name' => 'Kategori',
            'route' => 'categories.index',
            'icon' => 'category',
            'roles' => ['admin'],
        ],
        [
            'name' => 'Stok',
            'route' => 'stocks.index',
            'icon' => 'stock',
            'roles' => ['admin'],
        ],
        [
            'name' => 'Laporan',
            'route' => 'reports.index',
            'icon' => 'report',
            'roles' => ['admin'],
        ],
        [
            'name' => 'User',
            'route' => 'users.index',
            'icon' => 'users',
            'roles' => ['admin'],
        ],
    ];
@endphp


{{-- ========================================================= --}}
{{-- MOBILE OVERLAY --}}
{{-- ========================================================= --}}

<div id="sidebarOverlay"
     class="mobile-overlay fixed inset-0 z-40 hidden bg-black/50 opacity-0 lg:hidden"
     onclick="closeSidebar()">
</div>


{{-- ========================================================= --}}
{{-- SIDEBAR --}}
{{-- ========================================================= --}}

<aside id="sidebar"
       class="sidebar-transition fixed inset-y-0 left-0 z-50 flex w-[270px] -translate-x-full flex-col border-r border-[#E8DED6] bg-white lg:translate-x-0">

    {{-- Logo --}}
    <div class="flex h-[76px] flex-shrink-0 items-center border-b border-[#EEE7E2] px-5">

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#5C3D2E] shadow-sm">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6 text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M4 8h12v7a4 4 0 01-4 4H8a4 4 0 01-4-4V8z"/>

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M16 10h2a3 3 0 010 6h-2"/>

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M7 4c0 1-1 1-1 2m5-2c0 1-1 1-1 2"/>
                </svg>

            </div>

            <div>
                <h1 class="font-poppins text-lg font-extrabold tracking-tight text-[#5C3D2E]">
                    KOPI KITA
                </h1>

                <p class="text-[10px] font-medium uppercase tracking-[0.18em] text-[#8B6F5A]">
                    Coffee Shop POS
                </p>
            </div>

        </a>


        {{-- Close mobile --}}
        <button type="button"
                onclick="closeSidebar()"
                class="ml-auto flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 lg:hidden">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12"/>

            </svg>

        </button>

    </div>


    {{-- User Profile --}}
    <div class="border-b border-[#EEE7E2] p-4">

        <div class="flex items-center gap-3 rounded-xl bg-[#F9F5F1] p-3">

            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-[#5C3D2E] text-sm font-bold text-white">
                {{ strtoupper(substr($currentUser?->name ?? 'U', 0, 1)) }}
            </div>

            <div class="min-w-0">

                <p class="truncate text-sm font-bold text-[#1F1F1F]">
                    {{ $currentUser?->name ?? 'User' }}
                </p>

                <p class="mt-0.5 text-xs text-[#8B6F5A]">
                    {{ $isAdmin ? 'Administrator' : 'Kasir' }}
                </p>

            </div>

        </div>

    </div>


    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4">

        <p class="mb-3 px-3 text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400">
            Menu Utama
        </p>


        <div class="space-y-1">

            @foreach($navItems as $item)

                @if($currentUser && in_array($currentUser->role, $item['roles'], true))

                    @php
                        $isActive = $currentRoute === $item['route'];

                        if ($item['route'] === 'products.index') {
                            $isActive = request()->routeIs('products.*');
                        }

                        if ($item['route'] === 'categories.index') {
                            $isActive = request()->routeIs('categories.*');
                        }

                        if ($item['route'] === 'transactions.index') {
                            $isActive = request()->routeIs('transactions.*');
                        }

                        if ($item['route'] === 'stocks.index') {
                            $isActive = request()->routeIs('stocks.*');
                        }

                        if ($item['route'] === 'reports.index') {
                            $isActive = request()->routeIs('reports.*');
                        }

                        if ($item['route'] === 'users.index') {
                            $isActive = request()->routeIs('users.*');
                        }

                        if ($item['route'] === 'pos.index') {
                            $isActive = request()->routeIs('pos.*');
                        }
                    @endphp

                    <a href="{{ route($item['route']) }}"
                       class="nav-link flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold
                       {{ $isActive
                            ? 'bg-[#5C3D2E] text-white shadow-sm'
                            : 'text-gray-600 hover:bg-[#F5E6CA]/50 hover:text-[#5C3D2E]' }}">

                        {{-- Dashboard Icon --}}
                        @if($item['icon'] === 'dashboard')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 flex-shrink-0"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M4 13h6V4H4v9zm0 7h6v-4H4v4zm10 0h6v-9h-6v9zm0-16v4h6V4h-6z"/>

                            </svg>

                        {{-- Cart --}}
                        @elseif($item['icon'] === 'cart')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 flex-shrink-0"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M3 3h2l2.4 11.2a2 2 0 002 1.6h7.9a2 2 0 001.9-1.4L21 7H6"/>

                                <circle cx="10"
                                        cy="19"
                                        r="1.5"
                                        fill="currentColor"/>

                                <circle cx="18"
                                        cy="19"
                                        r="1.5"
                                        fill="currentColor"/>

                            </svg>

                        {{-- Receipt --}}
                        @elseif($item['icon'] === 'receipt')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 flex-shrink-0"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M6 3h12v18l-2.5-1.5L13 21l-2.5-1.5L8 21l-2-1.5L4 21V5a2 2 0 012-2z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8 8h8M8 12h8M8 16h5"/>

                            </svg>

                        {{-- Product --}}
                        @elseif($item['icon'] === 'product')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 flex-shrink-0"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M4 7.5L12 3l8 4.5v9L12 21l-8-4.5v-9z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M4 7.5l8 4.5 8-4.5M12 12v9"/>

                            </svg>

                        {{-- Category --}}
                        @elseif($item['icon'] === 'category')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 flex-shrink-0"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M4 6h16M4 10h16M4 14h16M4 18h10"/>

                            </svg>

                        {{-- Stock --}}
                        @elseif($item['icon'] === 'stock')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 flex-shrink-0"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M3 3h18v18H3z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M7 16v-5m5 5V7m5 9v-3"/>

                            </svg>

                        {{-- Report --}}
                        @elseif($item['icon'] === 'report')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 flex-shrink-0"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M4 19V5a2 2 0 012-2h12a2 2 0 012 2v14"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8 16v-4m4 4V8m4 8v-6"/>

                            </svg>

                        {{-- Users --}}
                        @elseif($item['icon'] === 'users')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 flex-shrink-0"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>

                                <circle cx="9"
                                        cy="7"
                                        r="4"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>

                            </svg>

                        @endif


                        <span class="flex-1">
                            {{ $item['name'] }}
                        </span>

                    </a>

                @endif

            @endforeach

        </div>

    </nav>


    {{-- Sidebar Bottom --}}
    <div class="border-t border-[#EEE7E2] p-3">

        <div class="mb-3 rounded-xl bg-[#F9F5F1] px-3 py-2.5">

            <div class="flex items-center gap-2">

                <span class="flex h-2 w-2 rounded-full bg-green-500"></span>

                <span class="text-xs font-medium text-gray-600">
                    Sistem Online
                </span>

            </div>

        </div>


        {{-- Logout --}}
        <form method="POST"
              action="{{ route('logout') }}">

            @csrf

            <button type="submit"
                    class="nav-link flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-red-600 hover:bg-red-50">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M10 17l5-5-5-5"/>

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15 12H3"/>

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M21 19V5a2 2 0 00-2-2h-5"/>

                </svg>

                <span>
                    Logout
                </span>

            </button>

        </form>

    </div>

</aside>


{{-- ========================================================= --}}
{{-- MAIN WRAPPER --}}
{{-- ========================================================= --}}

<div class="min-h-screen lg:pl-[270px]">

    {{-- ===================================================== --}}
    {{-- TOPBAR --}}
    {{-- ===================================================== --}}

    <header class="sticky top-0 z-30 border-b border-[#E8DED6] bg-white/95 backdrop-blur">

        <div class="flex h-[76px] items-center justify-between px-4 sm:px-6 lg:px-8">

            {{-- Left --}}
            <div class="flex items-center gap-3">

                {{-- Mobile Menu --}}
                <button type="button"
                        onclick="openSidebar()"
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 lg:hidden">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>

                    </svg>

                </button>


                <div class="hidden sm:block">

                    <p class="text-xs font-medium text-gray-400">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>

                    <p class="mt-0.5 text-sm font-semibold text-[#5C3D2E]">
                        Selamat datang di KOPI KITA
                    </p>

                </div>

            </div>


            {{-- Right --}}
            <div class="flex items-center gap-2 sm:gap-4">

                {{-- Clock --}}
                <div class="hidden items-center gap-2 rounded-xl bg-[#F9F5F1] px-3 py-2 sm:flex">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4 text-[#8B6F5A]"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">

                        <circle cx="12"
                                cy="12"
                                r="9"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 7v5l3 2"/>

                    </svg>

                    <span id="liveClock"
                          class="text-xs font-bold text-[#5C3D2E]">
                        --:--:--
                    </span>

                </div>


                {{-- User --}}
                <div class="flex items-center gap-2">

                    <div class="hidden text-right sm:block">

                        <p class="text-sm font-semibold text-[#1F1F1F]">
                            {{ $currentUser?->name ?? 'User' }}
                        </p>

                        <p class="text-[11px] text-gray-400">
                            {{ $isAdmin ? 'Administrator' : 'Kasir' }}
                        </p>

                    </div>


                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#5C3D2E] text-sm font-bold text-white">
                        {{ strtoupper(substr($currentUser?->name ?? 'U', 0, 1)) }}
                    </div>

                </div>

            </div>

        </div>

    </header>


    {{-- ===================================================== --}}
    {{-- CONTENT --}}
    {{-- ===================================================== --}}

    <main class="page-content min-h-[calc(100vh-76px)] bg-[#F7F7F7] px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8">

        {{-- Flash Messages --}}
        <div class="mb-5 space-y-3">

            @if(session('success'))

                <div class="toast flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3.5 text-green-700 shadow-sm">

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

                    <p class="flex-1 text-sm font-medium">
                        {{ session('success') }}
                    </p>

                    <button type="button"
                            onclick="this.parentElement.remove()"
                            class="text-lg leading-none text-green-600 hover:text-green-800">
                        &times;
                    </button>

                </div>

            @endif


            @if(session('error'))

                <div class="toast flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3.5 text-red-700 shadow-sm">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="mt-0.5 h-5 w-5 flex-shrink-0"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 8v4m0 4h.01"/>

                        <circle cx="12"
                                cy="12"
                                r="9"/>

                    </svg>

                    <p class="flex-1 text-sm font-medium">
                        {{ session('error') }}
                    </p>

                    <button type="button"
                            onclick="this.parentElement.remove()"
                            class="text-lg leading-none text-red-600 hover:text-red-800">
                        &times;
                    </button>

                </div>

            @endif

        </div>


        @yield('content')

    </main>

</div>


{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>
    function openSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        sidebar.classList.remove('-translate-x-full');

        overlay.classList.remove('hidden');

        setTimeout(() => {
            overlay.classList.remove('opacity-0');
        }, 10);

        document.body.classList.add('overflow-hidden');
    }


    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        sidebar.classList.add('-translate-x-full');

        overlay.classList.add('opacity-0');

        setTimeout(() => {
            overlay.classList.add('hidden');
        }, 200);

        document.body.classList.remove('overflow-hidden');
    }


    // Tutup sidebar saat klik link pada mobile
    document.querySelectorAll('#sidebar a').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        });
    });


    // Tutup sidebar jika layar berubah ke desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            document.getElementById('sidebar').classList.remove('-translate-x-full');

            document.getElementById('sidebarOverlay').classList.add('hidden');

            document.body.classList.remove('overflow-hidden');
        } else {
            document.getElementById('sidebar').classList.add('-translate-x-full');
        }
    });


    // Jam realtime
    function updateClock() {
        const clock = document.getElementById('liveClock');

        if (!clock) {
            return;
        }

        const now = new Date();

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        clock.textContent = `${hours}:${minutes}:${seconds}`;
    }

    updateClock();

    setInterval(updateClock, 1000);


    // Auto hide flash message
    setTimeout(function() {

        document.querySelectorAll('.toast').forEach(function(toast) {

            toast.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

            toast.style.opacity = '0';

            toast.style.transform = 'translateY(-5px)';

            setTimeout(function() {
                toast.remove();
            }, 300);

        });

    }, 5000);
</script>


@stack('scripts')

</body>
</html>
