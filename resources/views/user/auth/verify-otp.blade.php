@extends('user.layouts.auth')
@section('content')

<main class="flex items-center justify-center px-4 py-8 sm:py-12 min-h-[calc(100vh-92px)]">
    <div class="w-full max-w-[450px] mx-auto px-4">
        <div class="bg-white rounded-[20px] px-5 sm:px-8 py-9 shadow-sm">
            
            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-xl sm:text-2xl font-bold text-brand-black mb-2 font-['Nunito_Sans']">
                    Verify OTP
                </h1>
                <p class="text-sm text-gray-600 leading-6 font-['Nunito_Sans'] px-2">
                    Please enter the one-time code sent to your email.
                </p>
            </div>

            <!-- Status message -->
            @if (session('status'))
                <div class="mb-4 p-3 text-sm text-green-700 bg-green-100 rounded-lg">
                    {!! session('status') !!}
                </div>
            @endif

            <!-- OTP -->
            <form action="{{ route('otp.verify.submit') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-[#0A1629] mb-2">One-Time Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <img src="{{ asset('images/icons/Password.svg') }}" alt="OTP Icon" class="w-5 h-5" />
                        </div>
                        <input type="text" name="otp" placeholder="Enter your code" 
                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg 
                               focus:outline-none focus:ring-2 focus:ring-[#FFBE00] text-gray-600" />
                    </div>
                    @error('otp')
                        <p class="mt-2 text-sm text-red-600">{!! $message !!}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <button type="submit"
                        class="flex items-center justify-center w-full h-12 px-6 bg-gray-600 text-white font-bold text-base rounded-[14px] shadow-lg hover:bg-black transition-colors">
                        <span class="flex-1 text-left">Verify OTP</span>
                        <img src="{{ asset('images/icons/Arrow-right.svg') }}" alt="Arrow Right" class="w-6 h-6" />
                    </button>
                </div>
            </form>

            <div class="flex justify-center">
                <a href="{{ route('login') }}" 
                   class="flex items-center gap-2.5 text-brand-black font-bold text-sm hover:opacity-70 transition-opacity">
                    <img src="{{ asset('images/icons/Arrow-left.svg') }}" alt="Arrow Left" class="w-6 h-6" />
                    <span>Back to signin</span>
                </a>
            </div>
        </div>
    </div>
</main>

@endsection
