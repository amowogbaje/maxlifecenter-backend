@extends('user.layouts.auth')
@push('style')
<style>
    * {
        font-family: 'Nunito Sans', sans-serif;
    }

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
        /* Fixed height to prevent layout shift */
    }

</style>
@endpush
@section('content')
<div x-data="wizard()" class="flex items-center justify-center min-h-[calc(100vh-92px)]">
    <div class="relative w-full max-w-full bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">

        <div class="hidden md:block absolute inset-0 bg-cover bg-center" style="background-image: url(http://koc.test/images/african-illustration.jpg);"></div>

        <div class="relative w-full md:w-1/2 bg-white md:bg-white/95 md:backdrop-blur-sm p-6 md:p-10 flex flex-col justify-center order-2 md:order-2">
            <div class="w-full max-w-sm mx-auto bg-white form-container p-6 lg:p-8 rounded-xl shadow">

                <div class="flex items-center justify-center mb-8">
                    <div x-show="step === 1" class="flex items-center space-x-0">
                        <div class="w-8 h-8 border-2 border-amber-500 rounded-full flex items-center justify-center">
                            <div class="w-2.5 h-2.5 bg-amber-500 rounded-full"></div>
                        </div>
                        <div class="w-20 h-0.5 bg-gray-500"></div>
                        <div class="w-8 h-8 border-2 border-gray-500 rounded-full"></div>
                    </div>
                    <div x-show="step === 2" class="flex items-center space-x-0">
                        <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center">
                            <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 20 20">
                                <path d="M4.16675 10.8333L7.50008 14.1667L15.8334 5.83333"></path>
                            </svg>
                        </div>
                        <div class="w-20 h-0.5 bg-amber-500"></div>
                        <div class="w-8 h-8 border-2 border-amber-500 rounded-full flex items-center justify-center">
                            <div class="w-2.5 h-2.5 bg-amber-500 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <div x-show="step === 1" x-transition x-cloak>
                    <div class="text-center mb-8">
                        <h1 class="text-gray-800 text-xl font-bold mb-2">Enter Your Royal Access Code</h1>
                        <p class="text-sm text-gray-600">Create a 4-digit PIN for secure access</p>
                    </div>
                    <div class="flex justify-center space-x-3 mb-8">
                        <template x-for="(digit, index) in 4" :key="index">
                            <input type="password" maxlength="1" pattern="\d*" inputmode="numeric" class="otp-input w-10 h-10 md:w-12 md:h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" x-model="pin[index]" :id="'pin-input-' + index" @input="handleOtpInput($event, index, 'pin')" @keydown="handleOtpKeydown($event, index, 'pin')" @paste="handleOtpPaste($event, 'pin')">
                        </template>
                    </div>
                    <button @click="nextStep" class="w-full bg-black text-white font-bold py-3 px-6 rounded-2xl shadow-lg hover:bg-gray-800 transition-colors" :disabled="isPinIncomplete(pin)" :class="{'opacity-50 cursor-not-allowed': isPinIncomplete(pin)}">
                        Continue
                    </button>
                </div>

                <div x-show="step === 2" x-transition x-cloak>
                    <div class="text-center mb-8">
                        <h1 class="text-gray-800 text-xl font-bold mb-2">Confirm Your Access Code</h1>
                        <p class="text-sm text-gray-600">Re-enter your 4-digit PIN to confirm</p>
                    </div>
                    <div class="flex justify-center space-x-3 mb-8">
                        <template x-for="(digit, index) in 4" :key="index">
                            <input type="password" maxlength="1" pattern="\d*" inputmode="numeric" class="otp-input w-10 h-10 md:w-12 md:h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFBE00]" x-model="confirmPin[index]" :id="'confirm-pin-input-' + index" @input="handleOtpInput($event, index, 'confirmPin')" @keydown="handleOtpKeydown($event, index, 'confirmPin')" @paste="handleOtpPaste($event, 'confirmPin')">
                        </template>
                    </div>
                    <div class="flex gap-3">
                        <button @click="step = 1" class="w-1/3 bg-gray-200 text-gray-800 font-bold py-3 px-6 rounded-2xl shadow-lg hover:bg-gray-300 transition-colors">
                            Back
                        </button>
                        <button @click="submitForm" class="flex-1 bg-black text-white font-bold py-3 px-6 rounded-2xl shadow-lg hover:bg-gray-800 transition-colors" :disabled="isPinIncomplete(confirmPin)" :class="{'opacity-50 cursor-not-allowed': isPinIncomplete(confirmPin)}">
                            Confirm & Continue
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative w-full md:w-1/2 flex items-center justify-center p-6 md:p-10 order-1 md:order-1">
            <div class="bg-white md:bg-white/95 md:backdrop-blur-sm rounded-xl shadow-lg p-6 w-full max-w-xs text-center">
                <div class="flex flex-col items-center gap-2">
                    <div class="text-xs font-bold text-[#91929E] mb-2">Tier 1</div>
                    <div class="flex items-center justify-between w-full mb-3">
                        <h3 class="text-[15px] font-bold text-[#0A1629]">Eleniyan</h3>
                        <div class="w-[45px] h-[45px] rounded-full bg-[#E5F3DD] flex items-center justify-center">
                            <img src="{{asset('images/eleniyan.png')}}" alt="Eleniyan Icon" class="w-7 h-7">
                        </div>
                    </div>
                    <p class="text-[11px] text-[#0A1629] opacity-70 mb-4 leading-relaxed">
                        Describe your question and our specialists will answer you within 24 hours.
                    </p>
                    <button class="bg-[#FFBE00] text-white px-4 py-2 rounded-lg font-bold text-[11px] shadow-lg hover:bg-amber-500 transition-colors">
                        Learn More
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-show="showError" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.outside="showError = false" class="w-full max-w-[400px] bg-white rounded-[20px] shadow-lg overflow-hidden p-6 relative">
            <div class="flex justify-center mb-6">
                <div class="w-[90px] h-[90px] rounded-full flex items-center justify-center bg-red-100">
                    <svg width="48" height="48" fill="none" stroke="#E55D57" stroke-width="4" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-lg font-bold text-center text-[#E55D57]">Error</h1>
            <p class="text-sm text-center text-gray-600 mt-2" x-text="errorMessage"></p>
            <div class="flex justify-center gap-3 mt-6">
                <button @click="showError = false" class="px-5 py-2 rounded-lg border border-black bg-white hover:bg-gray-50 text-sm font-bold">
                    Cancel
                </button>
                <button @click="resetPins()" class="px-5 py-2 rounded-lg bg-black text-white hover:bg-gray-800 text-sm font-bold">
                    Try Again
                </button>
            </div>
        </div>
    </div>

    <div x-show="showSuccess" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.outside="showSuccess = false" class="w-full max-w-[400px] bg-white rounded-[20px] shadow-lg overflow-hidden p-6 relative">
            <button @click="showSuccess = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="flex justify-center mb-6">
                <div class="w-[90px] h-[90px] rounded-full flex items-center justify-center bg-green-100">
                    <svg width="48" height="48" fill="none" stroke="green" stroke-width="4" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-lg font-bold text-center text-green-600">Success</h1>
            <p class="text-sm text-center text-gray-600 mt-2" x-text="successMessage"></p>
            <div class="flex justify-center gap-3 mt-6">
                <button @click="redirectToLogin" class="px-5 py-2 rounded-lg bg-black text-white hover:bg-gray-800 text-sm font-bold">
                    Go to Login
                </button>
            </div>
        </div>
    </div>



</div>

@endsection
@push('script')
<script>
    function wizard() {
        return {
            step: 1,
            pin: ['', '', '', ''],
            confirmPin: ['', '', '', ''],
            email: '',           // added for API binding
            token: '',           // added for API binding
            errorMessage: '',    // added for modal binding
            successMessage: '',  // added for modal binding
            showError: false,
            showSuccess: false,

            init() {
                // Extract token + email from query params
                const params = new URLSearchParams(window.location.search);
                this.email = params.get('email') || '';
                const pathParts = window.location.pathname.split('/');
this.token =    pathParts[pathParts.length - 1]; 

                this.$watch('step', (newStep) => {
                    if (newStep === 2) {
                        this.$nextTick(() => {
                            document.getElementById('confirm-pin-input-0')?.focus();
                        });
                    }
                });
            },

            // Helper: check if pin is complete
            isPinIncomplete(pinArray) {
                return pinArray.join('').length !== 4;
            },

            nextStep() {
                if (this.isPinIncomplete(this.pin)) return;
                this.step = 2;
            },

            async submitForm() {
                if (this.isPinIncomplete(this.confirmPin)) return;

                if (this.pin.join('') !== this.confirmPin.join('')) {
                    this.errorMessage = "The codes do not match. Please try again.";
                    this.showError = true;
                    return;
                }

                try {
                    const res = await fetch("/api/password", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            email: this.email,
                            token: this.token,
                            password: this.pin.join(''),
                            password_confirmation: this.confirmPin.join('')
                        }),
                    });
                    console.log(JSON.stringify({
                            email: this.email,
                            token: this.token,
                            password: this.pin.join(''),
                            password_confirmation: this.confirmPin.join('')
                        }))

                    const data = await res.json();

                    if (res.ok && data.status === "success") {
                        this.successMessage = data.message || "Password reset successful!";
                        this.showSuccess = true;
                        setTimeout(() => {
                            window.location.href = "/login"; // change to your login route
                        }, 3000);
                    } else {
                        this.errorMessage = data.message || "Unable to reset password.";
                        this.showError = true;
                    }
                } catch (e) {
                    this.errorMessage = "Something went wrong. Please try again.";
                    this.showError = true;
                }
            },

            resetPins() {
                this.pin = ['', '', '', ''];
                this.confirmPin = ['', '', '', ''];
                this.showError = false;
                this.step = 1;
                this.$nextTick(() => {
                    document.getElementById('pin-input-0')?.focus();
                });
            },

            redirectToLogin() {
                window.location.href = "/login"; // relative for portability
            },

            handleOtpInput(event, index, field) {
                const value = event.target.value;

                // Only allow numbers
                if (!/^\d*$/.test(value)) {
                    this[field][index] = '';
                    return;
                }

                // Auto-focus next input
                if (value && index < 3) {
                    const nextInput = event.target.closest('.flex').querySelector(`#${field.replace('Pin', '-pin')}-input-${index + 1}`);
                    if (nextInput) nextInput.focus();
                }
            },

            handleOtpKeydown(event, index, field) {
                // Handle backspace
                if (event.key === 'Backspace' && !this[field][index] && index > 0) {
                    const prevInput = event.target.closest('.flex').querySelector(`#${field.replace('Pin', '-pin')}-input-${index - 1}`);
                    if (prevInput) prevInput.focus();
                }
            },

            handleOtpPaste(event, field) {
                event.preventDefault();
                const pasteData = event.clipboardData.getData('text').replace(/\D/g, '').slice(0, 4);

                for (let i = 0; i < pasteData.length; i++) {
                    if (i < 4) {
                        this[field][i] = pasteData[i];
                    }
                }

                const nextIndex = Math.min(pasteData.length, 3);
                const nextInput = event.target.closest('.flex').querySelector(`#${field.replace('Pin', '-pin')}-input-${nextIndex}`);
                if (nextInput) nextInput.focus();
            }

            
        }
    }
</script>

@endpush
