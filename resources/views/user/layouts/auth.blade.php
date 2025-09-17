<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito Sans">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('style')
    
</head>

<body style="font-family: 'Nunito Sans', sans-serif;" class="min-h-screen bg-[#f8f8f8]">
    <!-- component -->
    <!-- component -->
    <!-- Header -->
    <div class="w-full h-[92px] bg-black shadow-lg flex items-center justify-center px-4">
        <div class="flex items-center gap-[14px]">
            <img src="{{ asset('images/kclanco.png')}}" alt="Logo 1" class="w-[124px] h-[33px]" />
            <img src="{{ asset('images/watchlocker.png')}}" alt="Logo 2" class="w-[183px] h-[44px]" />
        </div>
    </div>
    @yield('content')
@stack('script')
</body>

</html>
