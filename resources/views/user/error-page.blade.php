<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Dialog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito Sans', -apple-system, Roboto, Helvetica, sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50 p-4">
    <!-- Error Dialog -->
    <div class="w-full max-w-[450px] bg-white rounded-[20px] shadow-lg overflow-hidden">
        <!-- Dialog Content -->
        <div class="relative h-[377px] flex flex-col">
            <!-- Error Icon Circle -->
            <div class="absolute left-1/2 top-[68px] transform -translate-x-1/2">
                <div class="w-[116px] h-[116px] rounded-full flex items-center justify-center bg-[rgba(255,235,234,1)]">
                    <div class="w-[72px] h-[72px] flex items-center justify-center">
                        <svg
                            width="48"
                            height="48"
                            viewBox="0 0 48 48"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="text-[#E55D57]"
                        >
                            <path
                                d="M36 12L12 36M12 12l24 24"
                                stroke="currentColor"
                                stroke-width="4"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Text Content -->
            <div class="absolute left-1/2 top-[197px] transform -translate-x-1/2 text-center">
                <div class="flex flex-col items-center gap-[3px]">
                    <!-- Error Title -->
                    <h1 class="text-[24px] font-bold leading-[24px] text-center text-[#E55D57]">
                        Error
                    </h1>
                    <!-- Error Subtitle -->
                    <p class="text-[14px] font-normal leading-6 text-center mt-[6px] max-w-[360px] sm:max-w-[403px] text-[#7D8592]">
                        {{ $message ?? 'Something went wrong.' }}
                    </p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="absolute left-1/2 top-[286px] transform -translate-x-1/2 flex items-center gap-[15px]">
                <!-- Cancel Button -->
                <a href="{{ route('login')}}" 
                   class="flex h-[48px] px-[28px] py-[12px] justify-center items-center rounded-[14px] border border-black bg-white hover:bg-gray-50 transition-colors shadow-[0_6px_12px_0_rgba(63,140,255,0.26)]">
                    <div class="flex items-center gap-[24px]">
                        <span class="text-[16px] font-bold leading-normal whitespace-nowrap text-black">
                            Go Home
                        </span>
                        
                    </div>
                </a>

                <!-- Try Again Button (dynamic) -->
                @if(!empty($link) && !empty($linkTitle))
                    <a href="{{ $link }}" 
                       class="flex h-[48px] px-[28px] py-[12px] justify-center items-center rounded-[14px] bg-black hover:bg-gray-800 transition-colors shadow-[0_6px_12px_0_rgba(63,140,255,0.26)]">
                        <div class="flex items-center gap-[24px]">
                            <span class="text-[16px] font-bold leading-normal text-white whitespace-nowrap">
                                {{ $linkTitle }}
                            </span>
                            <svg
                                width="17"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M3 20V4L22 12L3 20ZM5 17L17 12L5 7V10.5L11 12L5 13.5V17Z"
                                    fill="white"
                                />
                            </svg>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
