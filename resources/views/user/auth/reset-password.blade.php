@extends('user.layouts.auth')
@section('content')
<!-- Header -->

<main class="flex items-center justify-center px-4 py-8 sm:py-12 min-h-[calc(100vh-92px)]">
    <div class="w-full max-w-[450px] mx-auto px-4">
        <div class="bg-white rounded-[20px] px-5 sm:px-8 py-9 shadow-sm">
            <div class="text-center mb-8 sm:mb-10">
                <h1 class="text-xl sm:text-2xl font-bold text-brand-black mb-2 font-['Nunito_Sans']">
                    Create New access code
                </h1>
                <p class="text-sm font-bold text-brand-gray-text leading-6 font-['Nunito_Sans'] px-2">
                    Please create your new access code,<br />
                    don't use your old access code
                </p>
            </div>

            <div class="mb-8 sm:mb-10">
                <div class="flex flex-col items-center gap-3 w-full">
                    <div class="flex gap-3 justify-center">
                        <input type="number" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" />
                        <input type="number" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" />
                        <input type="number" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" />
                        <input type="number" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" />
                    </div>
                    <p class="text-brand-gray text-sm sm:text-base font-medium tracking-tight text-center">
                        Please enter access code
                    </p>
                </div>
            </div>

            <div class="mb-6">
                <button class="flex items-center justify-center w-full h-12 px-6 bg-gray-600 text-white font-bold text-base rounded-[14px] shadow-lg hover:bg-black transition-colors">
                    <span class="flex-1 text-left">Reset and save access code</span>
                    <img src="{{ asset('images/icons/Arrow-right.svg') }}" alt="Arrow Right" class="w-6 h-6" />
                </button>
            </div>

            <div class="flex justify-center">
                <a href="{{ route('login')}}" class="flex items-center gap-2.5 text-brand-black font-bold text-sm hover:opacity-70 transition-opacity">
                    <img src="{{ asset('images/icons/Arrow-left.svg') }}" alt="Arrow Right" class="w-6 h-6" />
                    <span>Back to signin</span>
                </a>
            </div>
        </div>
    </div>
</main>

<script>
    document.querySelectorAll(".otp-input").forEach((input, index, inputs) => {
        input.addEventListener("input", (e) => {
            if (e.target.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });
        input.addEventListener("keydown", (e) => {
            if (e.key === "Backspace" && !e.target.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

</script>
@endsection
