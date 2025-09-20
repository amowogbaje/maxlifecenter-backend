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

        <div x-show="showInfoBanner" x-transition class="fixed top-24 right-4 z-50 max-w-[420px] lg:max-w-[549px]" style="display: none;">
            <div class="bg-light-blue rounded-[14px] p-4 lg:p-5 flex items-start gap-3 shadow-lg border border-blue-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                <span class="text-blue-500 font-semibold text-sm flex-1 leading-relaxed">
                    Info display for quick message prompt hint, other things that I don't know am typing here.
                </span>
                <button @click="showInfoBanner = false" class="w-5 h-5 text-black hover:text-gray-600 flex-shrink-0 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
        </div>
        
        @include('user.partials.sidebar')

        <div class="lg:ml-[325px] min-h-screen">
            @include('user.partials.header')

            <main>
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>