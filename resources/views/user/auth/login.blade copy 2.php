@extends('user.layouts.auth')
@section('content')
<!-- Header -->


<div class="flex items-center justify-center min-h-[calc(100vh-92px)] px-4 py-8">
    <div class="relative w-full max-w-[900px] bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">

        <!-- Background Image (for desktop split view) -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url({{ asset('images/african-illustration.jpg')}});">
        </div>

        <!-- Left Panel (Login Form) -->
        <div class="relative w-full md:w-1/2 bg-white/95 backdrop-blur-sm p-6 md:p-10 flex flex-col justify-center 
            md:order-1 order-2">
            <div class="w-full max-w-sm mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-[#0A1629] mb-2">Welcome Royalty!</h1>
                    <h2 class="text-lg font-semibold text-[#0A1629] mb-1">Sign In</h2>
                    <p class="text-sm text-[#91929E]">First visit? Unlock your royal royalty here!</p>
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-[#0A1629] mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="email" placeholder="someone@youmail.com" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg 
                      focus:outline-none focus:ring-2 focus:ring-[#FFBE00] text-gray-600" />
                    </div>
                </div>

                <!-- Access Code -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-[#0A1629] mb-2">Enter your royal access code
                        here</label>
                    <div class="flex gap-3 justify-center">
                        <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" />
                        <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" />
                        <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" />
                        <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" />
                    </div>
                    <div class="text-center mt-2">
                        <button class="text-sm text-[#91929E] hover:text-[#0A1629] transition-colors">Forgot Access
                            Code?</button>
                    </div>
                </div>

                <!-- Login Button -->
                <button class="w-full bg-black text-white py-3 rounded-lg font-semibold hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                    Login
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </button>

                <p class="text-center text-sm text-[#91929E] mt-4">Step into your treasure trove</p>
            </div>
        </div>

        <!-- Right Panel (Eleniyan Card) -->
        <div class="relative w-full md:w-1/2 flex items-center justify-center p-6 md:p-10 
            md:order-2 order-1">
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-lg p-6 w-full max-w-xs">
                <div class="flex flex-col items-center gap-2">
                    <div class="text-xs font-bold text-[#91929E] mb-2">Tier 1</div>
                    <div class="flex items-center justify-between w-full mb-3">
                        <h3 class="text-[15px] font-bold text-[#0A1629]">Eleniyan</h3>
                        <div class="w-[45px] h-[45px] rounded-full bg-[#E5F3DD] flex items-center justify-center">
                            <img src="{{asset('images/icons/eleniyan.png')}}" alt="Eleniyan Icon" class="w-7 h-7" />
                        </div>
                    </div>
                    <p class="text-[10px] text-[#0A1629] opacity-70 text-center mb-4 leading-relaxed">
                        Describe your question and our specialists will answer you within 24 hours.
                    </p>
                    <button class="bg-[#FFBE00] text-white px-4 py-2 rounded-lg font-bold text-[10px] flex items-center gap-2 shadow-lg">
                        Learn More
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>


    </div>
</div>
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
