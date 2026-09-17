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


    {{-- Tailwind --}}
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
            background: #F5E6CA;
            color: #1F1F1F;
        }


        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }


        /* Background */
        .guest-background {
            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(92, 61, 46, 0.08),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 90% 90%,
                    rgba(139, 111, 90, 0.10),
                    transparent 28%
                ),
                #F5E6CA;
        }


        /* Coffee decoration */
        .coffee-circle {
            position: absolute;
            border-radius: 9999px;
            background: rgba(92, 61, 46, 0.05);
            pointer-events: none;
        }


        /* Card */
        .guest-card {
            animation: guestFade 0.4s ease-out;
        }


        @keyframes guestFade {

            from {
                opacity: 0;
                transform: translateY(12px);
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


        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
        }


        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }


        ::-webkit-scrollbar-thumb {
            background: #c4b6ac;
            border-radius: 999px;
        }

    </style>


    @stack('styles')

</head>


<body class="guest-background min-h-screen">


    {{-- Decorative Circles --}}

    <div class="coffee-circle -left-24 -top-24 h-72 w-72"></div>

    <div class="coffee-circle -bottom-32 -right-20 h-96 w-96"></div>


    {{-- Main --}}
    <main class="relative flex min-h-screen items-center justify-center px-4 py-8 sm:px-6">

        <div class="w-full max-w-md">

            {{-- Logo --}}
            <div class="mb-6 text-center">

                <a href="{{ route('login') }}"
                   class="inline-flex flex-col items-center">

                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#5C3D2E] shadow-lg">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-8 w-8 text-white"
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


                    <h1 class="mt-4 font-poppins text-2xl font-extrabold tracking-tight text-[#5C3D2E]">
                        KOPI KITA
                    </h1>


                    <p class="mt-1 text-xs font-medium uppercase tracking-[0.2em] text-[#8B6F5A]">
                        Coffee Shop POS
                    </p>

                </a>

            </div>


            {{-- Page Content --}}
            <div class="guest-card">

                @yield('content')

            </div>


            {{-- Footer --}}
            <p class="mt-6 text-center text-xs text-[#8B6F5A]">
                &copy; {{ date('Y') }} KOPI KITA.
                All rights reserved.
            </p>

        </div>

    </main>


    @stack('scripts')

</body>

</html>
