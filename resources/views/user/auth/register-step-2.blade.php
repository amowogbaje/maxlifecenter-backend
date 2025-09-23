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
            md:order-2 order-2">
            <div class="w-full max-w-sm mx-auto">
                <div class="w-full bg-white p-6 lg:p-8">

                    <!-- Progress Stepper -->
                    <div class="flex items-center justify-center mb-8">
                        <div class="flex items-center space-x-0">
                            <!-- Step 1 -->
                            <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center">
                                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 20 20">
                                    <path d="M4.16675 10.8333L7.50008 14.1667L15.8334 5.83333"></path>
                                </svg>
                            </div>
                            <div class="w-20 h-0.5 bg-amber-500"></div>
                            <!-- Step 2 -->
                            <div class="w-8 h-8 border-2 border-amber-500 rounded-full flex items-center justify-center">
                                <div class="w-2.5 h-2.5 bg-amber-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Header Text -->
                    <div class="text-center mb-8">
                        <h1 class="text-gray-800 text-xl font-bold mb-2">
                            Almost there!<br>Let's Setup your access code
                        </h1>
                        <p class="text-sm font-bold">
                            <span class="text-gray-400">Already an account yet? </span>
                            <span class="text-black cursor-pointer hover:underline">Sign in Here</span>
                        </p>
                    </div>

                    <!-- PIN Input Section -->
                    <div class="mb-8">
                        <div class="text-center mb-4">
                            <p class="text-gray-400 font-medium">Confirm your royal access code here</p>
                        </div>
                        <!-- PIN Stars -->
                        <div class="flex justify-center space-x-4 mb-8">
                            <input type="number" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" />
                            <input type="number" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" />
                            <input type="number" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" />
                            <input type="number" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" />
                        </div>
                    </div>

                    <!-- Continue Button -->
                    <button class="w-full bg-black text-white font-bold py-3 px-6 rounded-2xl flex items-center justify-center space-x-3 shadow-lg hover:bg-gray-800 transition-colors">
                        <span>Continue</span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 12L3 20L7 12L3 4L21 12Z"></path>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Right Panel (Eleniyan Card) -->
        <div class="relative w-full md:w-1/2 flex items-center justify-center p-6 md:p-10 
            md:order-1 order-1">
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-lg p-6 w-full max-w-xs">
                <div class="flex flex-col items-center gap-2">
                    <div class="text-xs font-bold text-[#91929E] mb-2">Tier 1</div>
                    <div class="flex items-center justify-between w-full mb-3">
                        <h3 class="text-[15px] font-bold text-[#0A1629]">Eleniyan</h3>
                        <div class="w-[45px] h-[45px] rounded-full bg-[#E5F3DD] flex items-center justify-center">
                            <img src="{{asset('images/eleniyan.png')}}" alt="Eleniyan Icon" class="w-7 h-7" />
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
