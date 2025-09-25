@extends('user.layouts.auth')
@section('content')
<!-- Header -->

<div class="flex items-center justify-center min-h-[calc(100vh-92px)] px-4 py-8">
    <div class="relative w-full max-w-[900px] bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">

        <!-- Background Image -->
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

                <!-- Login Form -->
                <div x-data="loginWizard()" class="max-w-md mx-auto p-6 bg-white rounded-2xl shadow">

                    <!-- Step 1: Enter Email -->
                    <div x-show="step === 1" x-transition class="space-y-4">
                        <h2 class="text-xl font-bold text-gray-700">Welcome back 👋</h2>
                        <input type="email" id="email" x-model="email" class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-yellow-400" placeholder="Enter your email" required>

                        <button @click="checkEmail()" class="w-full bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600">
                            Next →
                        </button>
                    </div>

                    <!-- Step 2: Password / OTP -->
                    <div x-show="step === 2" x-transition class="space-y-4">
                        <template x-if="hasPassword">
                            <div>
                                <h2 class="text-xl font-bold text-gray-700">Enter Password</h2>
                                <div class="flex gap-2 justify-center mt-3">
                                    <template x-for="i in 4" :key="i">
                                        <input type="password" maxlength="1" class="w-12 h-12 text-center text-xl border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400" inputmode="numeric" pattern="\d*">
                                    </template>
                                </div>
                            </div>
                        </template>

                        <template x-if="!hasPassword">
                            <div>
                                <h2 class="text-xl font-bold text-gray-700">Check your email 📩</h2>
                                <p class="text-gray-500 text-sm">We’ve sent you a one-time passcode to login.</p>
                            </div>
                        </template>

                        <div class="flex justify-between mt-3">
                            <button @click="step = 1" class="text-gray-500 hover:underline">← Back</button>
                            <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                                Login
                            </button>
                        </div>
                    </div>

                </div>

                <script>
                    function loginWizard() {
                        return {
                            step: 1
                            , email: ''
                            , hasPassword: false,

                            async checkEmail() {
                                if (!this.email) {
                                    alert("Please enter an email");
                                    return;
                                }

                                try {
                                    let response = await fetch('/check-email', {
                                        method: 'POST'
                                        , headers: {
                                            'Content-Type': 'application/json'
                                            , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                        , body: JSON.stringify({
                                            email: this.email
                                        })
                                    });

                                    let data = await response.json();

                                    if (data.exists) {
                                        this.hasPassword = data.hasPassword;
                                        this.step = 2;
                                    } else {
                                        alert("Email not registered");
                                    }
                                } catch (e) {
                                    console.error(e);
                                    alert("Something went wrong. Please try again.");
                                }
                            }
                        }
                    }

                </script>


                <p class="text-center text-sm text-[#91929E] mt-4">Step into your treasure trove</p>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="relative w-full md:w-1/2 flex items-center justify-center p-6 md:p-10 
            md:order-2 order-1">
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
    const inputs = document.querySelectorAll(".otp-input");
    const passwordField = document.getElementById("passwordField");
    const form = document.getElementById("loginForm");

    inputs.forEach((input, index) => {
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

    form.addEventListener("submit", () => {
        let code = "";
        inputs.forEach(input => code += input.value);
        passwordField.value = code;
    });

</script>
@endsection
