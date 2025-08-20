@extends('admin.layouts.auth')
@section('content')


<!-- Main Content -->
<div class="flex-1 flex items-center justify-center pt-[92px] px-5 py-10">
    <div class="w-full max-w-[900px] bg-white rounded-2xl overflow-hidden shadow-xl flex flex-col lg:flex-row">

        <!-- Left Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-5 py-10 bg-white">
            <div class="w-full max-w-[450px]">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl sm:text-[28px] font-semibold text-gray-900 mb-2">Welcome Royalty!</h1>
                    <h2 class="text-xl sm:text-2xl font-medium text-gray-900 mb-2">Sign In</h2>
                    <p class="text-sm text-gray-500">
                        Don't have an account yet?
                        <span class="text-gray-900 font-medium cursor-pointer hover:underline">
                            Sign Up Here
                        </span>
                    </p>
                </div>

                <!-- Form -->
                <form action="#" method="POST" class="space-y-6">
                    <!-- Email Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <img src="{{ asset('images/icons/User.svg') }}" alt="Login Icon" class="w-6 h-6" />
                            </div>
                            <input type="email" placeholder="someone@yourmail.com" class="w-full pl-12 pr-3 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 bg-white outline-none transition-colors focus:border-gray-400 focus:ring-0" required />
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <img src="{{ asset('images/icons/Password.svg') }}" alt="Login Icon" class="w-6 h-6" />
                            </div>
                            <input type="password" placeholder="••••••••" class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 bg-white outline-none transition-colors focus:border-gray-400 focus:ring-0" required />
                            <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="ti ti-eye text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="w-full bg-black text-white border-none rounded-lg py-[14px] px-4 text-base font-medium cursor-pointer flex items-center justify-center gap-2 transition-all hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <span>Login</span>
                        <img src="{{ asset('images/icons/Login.svg') }}" alt="Login Icon" class="w-6 h-6" />
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Side - Illustration -->
        <div class="hidden lg:block lg:w-1/2 bg-cover bg-center" 
            style="background-image: url('{{ asset('images/african-illustration.jpg') }}');">
        </div>
    </div>
</div>

<script>
    // simple toggle password visibility
    function togglePassword(button) {
        const input = button.parentElement.querySelector('input');
        const icon = button.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("ti-eye");
            icon.classList.add("ti-eye-off");
        } else {
            input.type = "password";
            icon.classList.remove("ti-eye-off");
            icon.classList.add("ti-eye");
        }
    }

</script>
@endsection
