@extends('user.layouts.auth')
@push('style')
<style>
    .otp-input {
        transition: all 0.2s ease;
    }

    .otp-input:focus {
        outline: none;
        border-color: #FFBE00;
        box-shadow: 0 0 0 2px rgba(255, 190, 0, 0.2);
    }

    [x-cloak] {
        display: none !important;
    }

    .step-transition {
        transition: all 0.3s ease-out;
    }

    .form-container {
        min-height: 380px;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.3s ease;
    }

    .fade-enter-from, .fade-leave-to {
        opacity: 0;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #6b7280;
    }

    .password-toggle:hover {
        color: #374151;
    }

    .pin-section {
        margin-bottom: 2rem;
    }

    .pin-title {
        font-size: 0.875rem;
        font-weight: 500;
        color: #0A1629;
        margin-bottom: 0.5rem;
        text-align: center;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endpush

@section('content')
<div x-data="loginFlow()" class="flex items-center justify-center min-h-[calc(100vh-92px)] px-4 py-8">
    <div class="relative w-full max-w-[900px] bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">

        <!-- Background Image -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url({{ asset('images/african-illustration.jpg')}});"></div>

        <!-- Left Panel (Login Form) -->
        <div class="relative w-full md:w-1/2 bg-white/95 backdrop-blur-sm p-6 md:p-10 flex flex-col justify-center">
            <div class="w-full max-w-sm mx-auto form-container">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-[#0A1629] mb-2">Welcome Royalty!</h1>
                    <h2 class="text-lg font-semibold text-[#0A1629] mb-1">Sign In</h2>
                    <p class="text-sm text-[#91929E]" x-text="stepText"></p>
                </div>

                <!-- Step 1: Email/Phone Input -->
                <div x-show="step === 1" x-transition:enter="fade-enter-active" x-transition:leave="fade-leave-active" class="space-y-4">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-[#0A1629] mb-2">Email Address/Phone No.</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <img src="{{ asset('images/icons/User-alt.svg') }}" alt="User Icon" class="w-5 h-5" />
                            </div>
                            <input 
                                type="text" 
                                x-model="identifier" 
                                placeholder="email or phone" 
                                class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FFBE00] text-gray-600"
                                :class="identifierError ? 'border-red-500' : ''"
                                @keyup.enter="checkIdentifier"
                            />
                        </div>
                        <p x-show="identifierError" x-text="identifierError" class="text-red-500 text-sm mt-1"></p>
                    </div>
                    <button 
                        @click="checkIdentifier" 
                        class="w-full bg-yellow-500 text-white py-3 rounded-lg hover:bg-yellow-600 font-semibold"
                        :disabled="loading"
                    >
                        <span x-show="!loading">Next →</span>
                        <span x-show="loading">Checking...</span>
                    </button>
                </div>

                <!-- Step 2: OTP Input -->
                <div x-show="step === 2" x-transition:enter="fade-enter-active" x-transition:leave="fade-leave-active" class="space-y-4">
                    <div class="text-center mb-4">
                        <h2 class="text-xl font-bold text-gray-700">Enter OTP</h2>
                        <p class="text-gray-500 text-sm">We've sent a one-time passcode to your email/phone</p>
                    </div>
                    
                    <div class="flex gap-2 justify-center mb-6">
                        <template x-for="i in 6" :key="i">
                            <input 
                                type="text" 
                                maxlength="1" 
                                class="otp-input w-12 h-12 text-center text-xl border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400" 
                                inputmode="numeric" 
                                pattern="\d*" 
                                @input="handleOtpInput($event, i)" 
                                @keydown.backspace="handleOtpBackspace($event, i)"
                            >
                        </template>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <button @click="step = 1" class="text-gray-500 hover:underline">← Back</button>
                        <button @click="verifyOtp" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                            Verify OTP
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <button @click="resendOtp" class="text-sm text-yellow-600 hover:underline" :disabled="resendDisabled">
                            <span x-show="!resendDisabled">Resend OTP</span>
                            <span x-show="resendDisabled" x-text="'Resend in ' + countdown + 's'"></span>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Password Setup (4-digit PIN style) -->
                <div x-show="step === 3" x-transition:enter="fade-enter-active" x-transition:leave="fade-leave-active" class="space-y-4">
                    <div class="text-center mb-4">
                        <h2 class="text-xl font-bold text-gray-700">Set Your Access Code</h2>
                        <p class="text-gray-500 text-sm">Create a 4-digit PIN for secure access</p>
                    </div>

                    <div class="space-y-6">
                        <!-- New PIN -->
                        <div class="pin-section">
                            <div class="pin-title">Enter New PIN</div>
                            <div class="flex gap-2 justify-center">
                                <template x-for="i in 4" :key="i">
                                    <input 
                                        type="password" 
                                        maxlength="1" 
                                        class="otp-input w-12 h-12 text-center text-xl border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400" 
                                        inputmode="numeric" 
                                        pattern="\d*" 
                                        x-model="newPin[i-1]"
                                        @input="handleNewPinInput($event, i)" 
                                        @keydown.backspace="handleNewPinBackspace($event, i)"
                                    >
                                </template>
                            </div>
                            <p x-show="newPinError" x-text="newPinError" class="text-red-500 text-sm mt-2 text-center"></p>
                        </div>

                        <!-- Confirm PIN -->
                        <div class="pin-section">
                            <div class="pin-title">Confirm PIN</div>
                            <div class="flex gap-2 justify-center">
                                <template x-for="i in 4" :key="i">
                                    <input 
                                        type="password" 
                                        maxlength="1" 
                                        class="otp-input w-12 h-12 text-center text-xl border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400" 
                                        inputmode="numeric" 
                                        pattern="\d*" 
                                        x-model="confirmPin[i-1]"
                                        @input="handleConfirmPinInput($event, i)" 
                                        @keydown.backspace="handleConfirmPinBackspace($event, i)"
                                    >
                                </template>
                            </div>
                            <p x-show="confirmPinError" x-text="confirmPinError" class="text-red-500 text-sm mt-2 text-center"></p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <button @click="step = 2" class="text-gray-500 hover:underline">← Back</button>
                        <button @click="setupPassword" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                            Set PIN
                        </button>
                    </div>
                </div>

                <!-- Step 4: Password Login -->
                <div x-show="step === 4" x-transition:enter="fade-enter-active" x-transition:leave="fade-leave-active" class="space-y-4">
                    <div class="text-center mb-4">
                        <h2 class="text-xl font-bold text-gray-700">Enter Access Code</h2>
                        <p class="text-gray-500 text-sm">Enter your 4-digit PIN to continue</p>
                    </div>

                    <div class="flex gap-2 justify-center mb-6">
                        <template x-for="i in 4" :key="i">
                            <input 
                                type="password" 
                                maxlength="1" 
                                class="otp-input w-12 h-12 text-center text-xl border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400" 
                                inputmode="numeric" 
                                pattern="\d*" 
                                x-model="loginPin[i-1]"
                                @input="handleLoginPinInput($event, i)" 
                                @keydown.backspace="handleLoginPinBackspace($event, i)"
                            >
                        </template>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <button @click="step = 1" class="text-gray-500 hover:underline">← Back</button>
                        <button @click="loginWithPassword" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                            Login
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <a href="/forgot-password" class="text-sm text-yellow-600 hover:underline">Forgot PIN?</a>
                    </div>
                </div>

                <p class="text-center text-sm text-[#91929E] mt-4">Step into your treasure trove</p>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="relative w-full md:w-1/2 flex items-center justify-center p-6 md:p-10">
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
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    function showToast(message, type = 'error') {
        Toastify({
            text: message,
            duration: 3000,
            gravity: "top",
            position: "right",
            backgroundColor: type === 'success' ? "#4caf50" : "#f44336",
        }).showToast();
    }

    function loginFlow() {
        return {
            step: 1,
            identifier: '',
            identifierError: '',
            otpDigits: ['', '', '', '', '', ''],
            // Password setup PIN arrays
            newPin: ['', '', '', ''],
            confirmPin: ['', '', '', ''],
            newPinError: '',
            confirmPinError: '',
            // Login PIN array
            loginPin: ['', '', '', ''],
            loading: false,
            resendDisabled: false,
            countdown: 60,
            hasPassword: false,

            get stepText() {
                const texts = {
                    1: 'First visit? Unlock your royal royalty here!',
                    2: 'Enter the OTP sent to your email/phone',
                    3: 'Set up your secure 4-digit access code',
                    4: 'Enter your access code to continue'
                };
                return texts[this.step] || '';
            },

            init() {
                // Focus first input when step changes
                this.$watch('step', (value) => {
                    this.$nextTick(() => {
                        if (value === 1) {
                            document.querySelector('input[x-model="identifier"]')?.focus();
                        } else if (value === 2) {
                            document.querySelector('.otp-input')?.focus();
                        } else if (value === 3) {
                            // Focus first input of new PIN
                            document.querySelector('input[x-model="newPin[0]"]')?.focus();
                        } else if (value === 4) {
                            document.querySelector('input[x-model="loginPin[0]"]')?.focus();
                        }
                    });
                });
            },

            async checkIdentifier() {
                this.identifierError = '';
                this.loading = true;

                if (!this.identifier) {
                    this.identifierError = 'Please enter an email or phone number';
                    this.loading = false;
                    return;
                }

                try {
                    const response = await fetch('/api/check-identifier', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            identifier: this.identifier
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        showToast(data.message || 'Email or Phone not registered', 'error');
                        this.loading = false;
                        return;
                    }

                    this.hasPassword = data.hasPassword;

                    if (data.hasPassword) {
                        // User has password, go to password login
                        this.step = 4;
                    } else {
                        // User doesn't have password, send OTP
                        await this.sendOtp();
                        this.step = 2;
                        this.startResendTimer();
                    }

                } catch (error) {
                    console.error('Error:', error);
                    showToast('Something went wrong. Please try again.', 'error');
                } finally {
                    this.loading = false;
                }
            },

            async sendOtp() {
                try {
                    const response = await fetch('/api/send-otp', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            identifier: this.identifier
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to send OTP');
                    }

                } catch (error) {
                    console.error('Error sending OTP:', error);
                    showToast('Failed to send OTP. Please try again.', 'error');
                }
            },

            handleOtpInput(event, index) {
                const value = event.target.value.replace(/\D/g, '');
                this.otpDigits[index - 1] = value;
                
                if (value && index < 6) {
                    event.target.nextElementSibling?.focus();
                }
            },

            handleOtpBackspace(event, index) {
                if (!event.target.value && index > 1) {
                    event.target.previousElementSibling?.focus();
                }
            },

            async verifyOtp() {
                const otp = this.otpDigits.join('');
                
                if (otp.length !== 6) {
                    showToast('Please enter the complete 6-digit OTP', 'error');
                    return;
                }

                this.loading = true;

                try {
                    const response = await fetch('/api/verify-otp', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            identifier: this.identifier,
                            otp: otp
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        showToast(data.message || 'Invalid OTP', 'error');
                        this.loading = false;
                        return;
                    }

                    // OTP verified, proceed to password setup
                    this.step = 3;

                } catch (error) {
                    console.error('Error:', error);
                    showToast('Something went wrong. Please try again.', 'error');
                } finally {
                    this.loading = false;
                }
            },

            async resendOtp() {
                if (this.resendDisabled) return;

                this.resendDisabled = true;
                this.countdown = 60;

                await this.sendOtp();
                this.startResendTimer();
                showToast('OTP sent successfully!', 'success');
            },

            startResendTimer() {
                const timer = setInterval(() => {
                    this.countdown--;
                    
                    if (this.countdown <= 0) {
                        this.resendDisabled = false;
                        clearInterval(timer);
                    }
                }, 1000);
            },

            // New PIN input handlers
            handleNewPinInput(event, index) {
                const value = event.target.value.replace(/\D/g, '');
                this.newPin[index - 1] = value;
                
                if (value && index < 4) {
                    event.target.nextElementSibling?.focus();
                }
            },

            handleNewPinBackspace(event, index) {
                if (!event.target.value && index > 1) {
                    event.target.previousElementSibling?.focus();
                }
            },

            // Confirm PIN input handlers
            handleConfirmPinInput(event, index) {
                const value = event.target.value.replace(/\D/g, '');
                this.confirmPin[index - 1] = value;
                
                if (value && index < 4) {
                    event.target.nextElementSibling?.focus();
                }
            },

            handleConfirmPinBackspace(event, index) {
                if (!event.target.value && index > 1) {
                    event.target.previousElementSibling?.focus();
                }
            },

            // Login PIN input handlers
            handleLoginPinInput(event, index) {
                const value = event.target.value.replace(/\D/g, '');
                this.loginPin[index - 1] = value;
                
                if (value && index < 4) {
                    event.target.nextElementSibling?.focus();
                }
            },

            handleLoginPinBackspace(event, index) {
                if (!event.target.value && index > 1) {
                    event.target.previousElementSibling?.focus();
                }
            },

            validatePassword() {
                this.newPinError = '';
                this.confirmPinError = '';

                const newPin = this.newPin.join('');
                const confirmPin = this.confirmPin.join('');

                if (newPin.length !== 4) {
                    this.newPinError = 'Please enter a complete 4-digit PIN';
                    return false;
                }

                if (confirmPin.length !== 4) {
                    this.confirmPinError = 'Please confirm your 4-digit PIN';
                    return false;
                }

                if (newPin !== confirmPin) {
                    this.confirmPinError = 'PINs do not match';
                    return false;
                }

                return true;
            },

            async setupPassword() {
                if (!this.validatePassword()) {
                    return;
                }

                this.loading = true;

                try {
                    const response = await fetch('/api/setup-password', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            identifier: this.identifier,
                            password: this.newPin.join(''),
                            password_confirmation: this.confirmPin.join('')
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        showToast(data.message || 'Failed to set PIN', 'error');
                        this.loading = false;
                        return;
                    }

                    // PIN set successfully, login the user
                    await this.loginUser(this.newPin.join(''));

                } catch (error) {
                    console.error('Error:', error);
                    showToast('Something went wrong. Please try again.', 'error');
                } finally {
                    this.loading = false;
                }
            },

            async loginWithPassword() {
                const password = this.loginPin.join('');
                
                if (password.length !== 4) {
                    showToast('Please enter your 4-digit PIN', 'error');
                    return;
                }

                this.loading = true;

                try {
                    await this.loginUser(password);

                } catch (error) {
                    console.error('Error:', error);
                    showToast('Something went wrong. Please try again.', 'error');
                } finally {
                    this.loading = false;
                }
            },

            async loginUser(password) {
                try {
                    const response = await fetch('/login/new', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            identifier: this.identifier,
                            password: password
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        showToast(data.message || 'Login failed. Please check your credentials.', 'error');
                        return;
                    }

                    showToast('Login successful!', 'success');
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 1500);

                } catch (error) {
                    console.error('Login error:', error);
                    showToast('Something went wrong during login. Please try again.', 'error');
                }
            },

            resetFlow() {
                this.step = 1;
                this.identifier = '';
                this.otpDigits = ['', '', '', '', '', ''];
                this.newPin = ['', '', '', ''];
                this.confirmPin = ['', '', '', ''];
                this.loginPin = ['', '', '', ''];
                this.newPinError = '';
                this.confirmPinError = '';
            }
        }
    }
</script>
@endpush