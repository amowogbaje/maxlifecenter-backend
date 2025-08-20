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
                <div class="text-center mb-8">
                    <h2 class="text-lg font-semibold text-[#0A1629] mb-1">Join the royal experience</h2>
                    <p class="text-sm text-[#91929E]">Already an account yet? <a href="{{ route('login') }}" class="text-[#0A1629] font-semibold">Sign in Here</a></p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 mb-6">
                    <div class="flex-1">
                        <label class="block text-sm font-medium mb-1">First Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <img src="{{ asset('images/icons/User-alt.svg') }}" alt="User Icon" class="w-5 h-5" />

                            </div>
                            <input type="text" placeholder="First name" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg 
                        focus:outline-none focus:ring-2 focus:ring-[#FFBE00] text-gray-600" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium mb-1">Last Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <img src="{{ asset('images/icons/User-alt.svg') }}" alt="User Icon" class="w-5 h-5" />
                            </div>
                            <input type="text" placeholder="Last name" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg 
                        focus:outline-none focus:ring-2 focus:ring-[#FFBE00] text-gray-600" />
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-[#0A1629] mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <img src="{{ asset('images/icons/Message.svg') }}" alt="User Icon" class="w-5 h-5" />
                        </div>
                        <input type="email" placeholder="someone@youmail.com" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg 
                      focus:outline-none focus:ring-2 focus:ring-[#FFBE00] text-gray-600" />
                    </div>
                </div>

                <!-- Gender -->
            <div class="mb-5">
              <label class="block text-sm font-medium mb-1">Gender</label>
              <select class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300">
                <option value="">Select...</option>
                <option value="king">King</option>
                <option value="queen">Queen</option>
                <option value="prince">Prince</option>
                <option value="princess">Princess</option>
              </select>
            </div>

            <!-- Phone -->
            <div class="mb-5">
              <label class="block text-sm font-medium mb-1">Phone Number (Optional)</label>
              <input type="tel" placeholder="Enter your phone number" class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300">
            </div>

            <!-- Terms -->
            <div class="flex items-start gap-3 mb-5">
              <input type="checkbox" class="w-5 h-5 border rounded cursor-pointer">
              <label class="text-sm">
                <span class="text-gray-500">By clicking create an account, I agree to the </span>
                <a href="#" class="text-black hover:underline">Terms of Use</a>
                <span class="text-gray-500"> and </span>
                <a href="#" class="text-black hover:underline">Privacy Policy.</a>
              </label>
            </div>
                <!-- Submit -->
            <button type="submit" class="w-full h-12 bg-black text-white font-bold rounded-[14px] shadow-md hover:opacity-90 flex items-center justify-center gap-2">
              Create Account
              <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                <path d="M2.5 12L22 2L12.5 22L10.5 14.5L2.5 12Z"/>
              </svg>
            </button>
                
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
