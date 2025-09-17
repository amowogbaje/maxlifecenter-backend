@extends('user.layouts.auth')
@section('content')

<main class="flex items-center justify-center px-4 py-8 sm:py-12 min-h-[calc(100vh-92px)]">
    <div class="w-full max-w-[450px] mx-auto px-4">
        <div class="bg-white rounded-[20px] px-5 sm:px-8 py-9 shadow-sm">
            <div class="text-center mb-6">
                <h1 class="text-xl sm:text-2xl font-bold text-brand-black mb-2 font-['Nunito_Sans']">
                    Forgot access code?
                </h1>
                <p class="text-sm text-gray-600 leading-6 font-['Nunito_Sans'] px-2">
                    Enter the email address you used when you joined and we'll send you instructions to reset your access code.
                </p>
            </div>

            <!-- Form -->
            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-[#0A1629] mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <img src="{{ asset('images/icons/Message.svg') }}" alt="User Icon" class="w-5 h-5" />
                        </div>
                        <input 
                            type="email" 
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="someone@youmail.com" 
                            class="w-full pl-10 pr-3 py-3 border rounded-lg 
                                   focus:outline-none focus:ring-2 focus:ring-[#FFBE00] 
                                   text-gray-600 @error('email') border-red-500 @enderror" 
                            required
                        />
                    </div>
                    @error('email')
                        <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Success Message -->
                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600 font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Submit -->
                <div class="mb-6">
                    <button type="submit" 
                        class="flex items-center justify-center w-full h-12 px-6 bg-gray-600 
                               text-white font-bold text-base rounded-[14px] shadow-lg 
                               hover:bg-black transition-colors">
                        <span class="flex-1 text-left">Send Recovery code</span>
                        <img src="{{ asset('images/icons/Arrow-right.svg') }}" alt="Arrow Right" class="w-6 h-6" />
                    </button>
                </div>
            </form>

            <!-- Back -->
            <div class="flex justify-center">
                <a href="{{route('login')}}" class="flex items-center gap-2.5 text-brand-black font-bold text-sm hover:opacity-70 transition-opacity">
                    <img src="{{ asset('images/icons/Arrow-left.svg') }}" alt="Arrow Left" class="w-6 h-6" />
                    <span>Back to signin</span>
                </a>
            </div>
        </div>
    </div>
</main>

@endsection
