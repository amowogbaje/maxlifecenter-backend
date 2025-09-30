<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>

    <script>
        tailwind.config = {
          theme: { extend: { colors: { background: '#F9F9F9', foreground: '#1C1C1C', 'light-blue': '#E9F0FD', purple: '#7E57C2', success: '#00D097', warning: '#FDC748', 'text-dark': '#333333', 'text-light': '#888888', 'text-gray': '#A0AEC0', 'gray-border': '#E2E8F0', muted: '#F1F5F9', 'muted-foreground': '#64748B' } } }
        };
    </script>
    @stack('style')
</head>
<body 
  class="bg-background"
  x-data="{ showInfoBanner: false, sidebarOpen: false, profileDropdownOpen: false }"
>
    <div class="min-h-screen relative">
        <div 
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"
        ></div>

        @if(session('success') || session('error') || session('warning')) <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition class="fixed top-24 right-4 z-50 max-w-[420px] lg:max-w-[549px]">
            <div class=" rounded-[14px] p-4 lg:p-5 flex items-start gap-3 shadow-lg border @if(session('success')) bg-green-100 border-green-200 @endif @if(session('error')) bg-red-100 border-red-200 @endif @if(session('warning')) bg-yellow-100 border-yellow-200 @endif "> <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0 mt-0.5 @if(session('success')) text-green-600 @endif @if(session('error')) text-red-600 @endif @if(session('warning')) text-yellow-600 @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> @if(session('success'))
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /> @elseif(session('error'))
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12" y2="16" /> @elseif(session('warning'))
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0z" /> @endif </svg> <span class="font-semibold text-sm flex-1 leading-relaxed @if(session('success')) text-green-700 @endif @if(session('error')) text-red-700 @endif @if(session('warning')) text-yellow-700 @endif "> {{ session('success') ?? session('error') ?? session('warning') }} </span> <button @click="show = false" class="w-5 h-5 text-black hover:text-gray-600 flex-shrink-0 transition-colors"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" /> </svg> </button> </div>
        </div>
        @endif
        
        @include('user.partials.sidebar')

        <div class="lg:ml-[325px] min-h-screen">
            @include('user.partials.header')

            <main>
                @yield('content')
            </main>
        </div>
    </div>
    @stack('script')
</body>
</html>