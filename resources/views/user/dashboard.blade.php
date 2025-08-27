@extends('user.layouts.app')

@section('content')
    <div class="mb-[32px]">
        <h1 class="text-[#1D1F24] text-2xl font-bold font-nunito mb-[8px]">Hi, Evan Yates</h1>
        <p class="text-base font-nunito">
            <span class="text-[#6B6E75] font-bold">Take a look your overview </span>
            <span class="text-[#1D1F24] font-bold">Today Oct 12, 2024</span>
        </p>
    </div>

    <!-- Stats Cards Row -->
    <div class="flex items-center gap-[46px] mb-[38px]">
        <!-- Points Earn -->
        <div class="w-[191px] flex flex-col items-center justify-center  bg-white rounded-[24px] shadow-card p-[20px] relative">
            <div class="w-[26px] h-[26px] bg-[#D377F3] rounded-full flex items-center justify-center mb-[10px]">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="white">
                    <path d="M2.25 1C1.56 1 1 1.56 1 2.25V3.412C1.00027 3.67934 1.07198 3.94175 1.20771 4.17207L4.648 6.321C4.0456 6.62512 3.56332 7.12345 3.27909 7.73549L6 11.9991C6.67482 11.9991 7.32992 11.7716 7.85948 11.3533L10.229 4.723C10.4627 4.59304 11 3.67941 11 3.412V2.25C11 1.56 10.44 1 9.75 1H2.25Z" fill="white"></path>
                </svg>
            </div>
            <div class="text-[#91929E] text-xs font-nunito mb-[2px]">Points Earn</div>
            <div class="text-[#0A1629] text-2xl font-bold font-nunito mb-[12px]">120</div>
            <div class="w-[160px] mb-6 h-[28px] bg-[#F4F9FD] rounded-[8px] flex items-center justify-center">
                <span class="text-[#7D8592] text-xs font-bold font-nunito">₦3,6000</span>
            </div>
        </div>

        <!-- My Uploads -->
        <div class="w-[191px] flex flex-col items-center justify-center  bg-white rounded-[24px] shadow-card p-[20px] relative">
            <div class="w-[26px] h-[26px] bg-[#222683] rounded-full flex items-center justify-center mb-[10px]">
                <svg width="14" height="13" viewBox="0 0 15 13" fill="white">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.65346 7.8786L9.24384 11.8339C9.35717 12.0073 9.53425 12.0053 9.6058 11.9959L13.151 1.45193C13.2077 1.26993 13.1035 1.14593 13.0568 1.10193L1.74613 4.03126C1.53859 4.0886 1.49325 4.2526 1.48334 4.31993L5.90475 7.16926L9.66034 3.59726C9.86646 3.40126 10.4161 4.3006L6.65346 7.8786Z" fill="white"></path>
                </svg>
            </div>
            <div class="text-[#91929E] text-xs font-nunito mb-[2px]">My Uploads</div>
            <div class="text-[#0A1629] text-2xl font-bold font-nunito mb-[12px]">120</div>
            <div class="w-[160px] h-[28px] bg-[#F4F9FD] rounded-[8px] flex items-center justify-center">
                <span class="text-[#7D8592] text-xs font-nunito">13% Impressions</span>
            </div>
        </div>

        <!-- My Purchase -->
        <div class="w-[191px] flex flex-col items-center justify-center  bg-white rounded-[24px] shadow-card p-[20px] relative">
            <div class="w-[26px] h-[26px] bg-[#5D923D] rounded-full flex items-center justify-center mb-[10px]">
                <svg width="15" height="14" viewBox="0 0 15 14" fill="white">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.95481 4.86937L4.33168 9.05303C4.35918 9.37503 4.64106 9.61653 4.98543 9.61653H11.8086C12.1342 9.61653 12.4123 9.3902 12.4586 9.08978L13.0523 5.2637C13.0661 5.1727 13.0417 5.0817 12.9823 5.0082L12.7398 4.87345L3.95481 4.86937Z" fill="white"></path>
                </svg>
            </div>
            <div class="text-[#91929E] text-xs font-nunito mb-[2px]">My Purchase</div>
            <div class="text-[#0A1629] text-2xl font-bold font-nunito mb-[12px]">4</div>
            <div class="w-[160px] h-[28px] bg-[#F4F9FD] rounded-[8px] flex items-center justify-center">
                <span class="text-[#7D8592] text-xs font-bold font-nunito">₦523,6000</span>
            </div>
        </div>

        <!-- Current Tier -->
        <div class="w-[304px] bg-white rounded-[24px] shadow-card p-[20px] relative">
            <div class="w-[26px] h-[26px] bg-[#FFBE00] rounded-full flex items-center justify-center mb-[10px]">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="white">
                    <path d="M2.25 1C1.56 1 1 1.56 1 2.25V3.412C1.00027 3.67934 1.07198 3.94175 1.20771 4.17207L4.648 6.321C4.0456 6.62512 3.56332 7.12345 3.27909 7.73549L6 11.9991C6.67482 11.9991 7.32992 11.7716 7.85948 11.3533L10.229 4.723C10.4627 4.59304 11 3.67941 11 3.412V2.25C11 1.56 10.44 1 9.75 1H2.25Z" fill="white"></path>
                </svg>
            </div>
            <div class="text-[#91929E] text-xs font-nunito mb-[2px]">Current Tier</div>
            <div class="text-[#0A1629] text-2xl font-bold font-nunito mb-[12px]">Eleniyan</div>
            <div class="w-[160px] h-[28px] bg-[#F4F9FD] rounded-[8px] flex items-center justify-center mb-[12px]">
                <span class="text-[#7D8592] text-xs font-bold font-nunito">Next Level Oloye</span>
            </div>

            <!-- Tier Icons -->
            <div class="absolute right-[20px] bottom-[36px] flex items-center">
                <div class="w-[37px] h-[37px] bg-[#E5F3DD] rounded-full flex items-center justify-center mr-[10px]">
                    <div class="w-[23px] h-[23px] bg-[#5D923D] rounded-full flex items-center justify-center">
                        <span class="text-white text-xs font-bold">O</span>
                    </div>
                </div>
                <div class="w-[74px] h-[74px] bg-[#E5F3DD] rounded-full flex items-center justify-center">
                    <div class="w-[47px] h-[47px] bg-[#5D923D] rounded-full flex items-center justify-center">
                        <span class="text-white text-lg font-bold">E</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Grid -->
    <div class="flex gap-[23px]">
        <!-- Updates Section -->
        <div class="w-[431px] h-[226px] bg-white rounded-[20px] p-[24px]">
            <div class="flex items-center justify-between mb-[30px]">
                <h2 class="text-[#0A1629] text-xl font-bold font-nunito">Updates</h2>
                <div class="flex items-center text-[#3F8CFF]">
                    <span class="text-base font-bold font-nunito mr-[2px]">View all</span>
                    <svg class="w-[6px] h-[10px]" fill="currentColor" viewBox="0 0 6 10">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.653377 -0.0675907 1.22061 -0.0953203 1.6129 0.209705L5.70711 4.29289C6.06759 4.65338 6.09532 5.22061 5.7903 5.6129L1.70711 9.70711C1.31658 10.0976 0.683418 10.0976 0.292893 9.70711L0.292893 1.70711C-0.0675907 1.34662 -0.0953203 0.779392 0.209705 0.387101Z" fill="#3F8CFF"></path>
                    </svg>
                </div>
            </div>

            <!-- Update Items -->
            <div class="space-y-[26px]">
                <div class="w-[373px] h-[72px] bg-white rounded-[18px] shadow-update p-[18px] flex items-center">
                    <div class="w-[3px] h-[38px] bg-[#DE92EB] rounded-[2px] mr-[23px]"></div>
                    <div class="w-[21px] h-[18px] mr-[29px] flex items-center justify-center">
                        <div class="w-[17px] h-[15px] bg-[#DE92EB]"></div>
                    </div>
                    <div class="flex-1">
                        <div class="text-[#0A1629] text-xs font-bold font-nunito mb-[6px]">Prompt Title</div>
                        <p class="text-[#91929E] text-[11px] font-nunito leading-[14px]">
                            Some text form short call to action for the user to<br>
                            read and take some actions.
                        </p>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-[10px] h-[12px] mr-[8px]" fill="black" viewBox="0 0 11 13">
                            <path d="M1.00106 0.692383C1.10306 0.692383 1.20089 0.732905 1.27302 0.805034L6.38567 6.077H6.99567L6.11337 5.19546C6.07761 5.1597 6.04924 5.11725 6.02989 5.07052L8.19644 6.18931C8.23226 6.22503 8.26068 6.26748 8.28007 6.3142L6.65798 8.27238C6.62222 8.30814 6.57977 8.33651 6.53305 8.35586Z" fill="black"></path>
                        </svg>
                        <span class="text-[#7D8592] text-[9px] font-bold font-nunito">View</span>
                    </div>
                </div>
                <div class="w-[373px] h-[72px] bg-white rounded-[18px] shadow-update p-[18px] flex items-center">
                    <div class="w-[3px] h-[38px] bg-[#DE92EB] rounded-[2px] mr-[23px]"></div>
                    <div class="w-[21px] h-[18px] mr-[29px] flex items-center justify-center">
                        <div class="w-[17px] h-[15px] bg-[#DE92EB]"></div>
                    </div>
                    <div class="flex-1">
                        <div class="text-[#0A1629] text-xs font-bold font-nunito mb-[6px]">Prompt Title</div>
                        <p class="text-[#91929E] text-[11px] font-nunito leading-[14px]">
                            Some text form short call to action for the user to<br>
                            read and take some actions.
                        </p>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-[10px] h-[12px] mr-[8px]" fill="black" viewBox="0 0 11 13">
                            <path d="M1.00106 0.692383C1.10306 0.692383 1.20089 0.732905 1.27302 0.805034L6.38567 6.077H6.99567L6.11337 5.19546C6.07761 5.1597 6.04924 5.11725 6.02989 5.07052L8.19644 6.18931C8.23226 6.22503 8.26068 6.26748 8.28007 6.3142L6.65798 8.27238C6.62222 8.30814 6.57977 8.33651 6.53305 8.35586Z" fill="black"></path>
                        </svg>
                        <span class="text-[#7D8592] text-[9px] font-bold font-nunito">View</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- TIMEX Banner -->
        <div class="w-[563px] h-[226px] bg-gradient-to-r from-gray-800 to-gray-900 rounded-[20px] relative overflow-hidden">
            <img src="{{ asset('images/timex.png')}}" alt="TIMEX banner" class="w-full h-full object-cover">
        </div>
    </div>

    <!-- Active Campaign Section -->
    <div class="mt-[20px] flex gap-[23px]">
        <div class="w-[431px] h-[346px] bg-white rounded-[20px] p-[27px]">
            <div class="flex items-center justify-between mb-[30px]">
                <h2 class="text-[#0A1629] text-xl font-bold font-nunito">Active Campaign</h2>
                <div class="flex items-center text-[#3F8CFF]">
                    <span class="text-base font-bold font-nunito mr-[2px]">View all</span>
                    <svg class="w-[6px] h-[10px]" fill="currentColor" viewBox="0 0 6 10">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.653377 -0.0675907 1.22061 -0.0953203 1.6129 0.209705L5.70711 4.29289C6.06759 4.65338 6.09532 5.22061 5.7903 5.6129L1.70711 9.70711C1.31658 10.0976 0.683418 10.0976 0.292893 9.70711Z" fill="#3F8CFF"></path>
                    </svg>
                </div>
            </div>

            <!-- Campaign Items -->
            <div class="space-y-[20px]">
                <div class="w-[373px] h-[89px] bg-[#F4F6F9] rounded-[18px] p-[20px] flex items-center">
                    <div class="w-[47px] h-[47px] bg-[#FFEBEA] rounded-[10px] flex items-center justify-center mr-[14px]">
                        <div class="w-[29px] h-[29px] text-[#F44336]">📢</div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-[#0A1629] text-xs font-bold font-nunito mb-[4px]">Campaign Title</h4>
                        <p class="text-[#91929E] text-[10px] font-nunito">Some text form short call to action for the user to read and take some actions.</p>
                    </div>
                    <button class="w-[78px] h-[33px] bg-[#FFBE00] text-white rounded-[10px] text-[11px] font-bold font-nunito shadow-button">
                        View
                    </button>
                </div>
                <div class="w-[373px] h-[89px] bg-[#F4F6F9] rounded-[18px] p-[20px] flex items-center">
                    <div class="w-[47px] h-[47px] bg-[#FFEBEA] rounded-[10px] flex items-center justify-center mr-[14px]">
                        <div class="w-[29px] h-[29px] text-[#F44336]">📢</div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-[#0A1629] text-xs font-bold font-nunito mb-[4px]">Campaign Title</h4>
                        <p class="text-[#91929E] text-[10px] font-nunito">Some text form short call to action for the user to read and take some actions.</p>
                    </div>
                    <button class="w-[78px] h-[33px] bg-[#FFBE00] text-white rounded-[10px] text-[11px] font-bold font-nunito shadow-button">
                        View
                    </button>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="w-[565px] h-[346px] bg-white rounded-[20px] p-[41px]">
            <div class="flex items-center justify-between mb-[30px]">
                <h2 class="text-[#0A1629] text-xl font-bold font-nunito">Products just for</h2>
                <div class="flex items-center text-[#3F8CFF]">
                    <span class="text-base font-bold font-nunito mr-[2px]">View all</span>
                    <svg class="w-[6px] h-[10px]" fill="currentColor" viewBox="0 0 6 10">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.653377 -0.0675907 1.22061 -0.0953203 1.6129 0.209705L5.70711 4.29289C6.06759 4.65338 6.09532 5.22061 5.7903 5.6129L1.70711 9.70711C1.31658 10.0976 0.683418 10.0976 0.292893 9.70711Z" fill="#3F8CFF"></path>
                    </svg>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="flex gap-[23px]">
                <div class="w-[160px] h-[193px] bg-[#F4F9FD] rounded-[15px] shadow-[0_4px_35px_rgba(196,203,214,0.10)] p-[5px]">
                    <div class="w-[150px] h-[112px] bg-gray-200 rounded-[14px] mb-[12px] flex items-center justify-center">
                        <span class="text-4xl">⌚</span>
                    </div>
                    <div class="px-[10px]">
                        <p class="text-[#91929E] text-[8px] font-nunito mb-[8px]">Rotary Regent GB05450/65...</p>
                        <p class="text-[#0A1629] text-base font-bold font-nunito">₦523,6004</p>
                    </div>
                </div>
                <div class="w-[160px] h-[193px] bg-[#F4F9FD] rounded-[15px] shadow-[0_4px_35px_rgba(196,203,214,0.10)] p-[5px]">
                    <div class="w-[150px] h-[112px] bg-gray-200 rounded-[14px] mb-[12px] flex items-center justify-center">
                        <span class="text-4xl">⌚</span>
                    </div>
                    <div class="px-[10px]">
                        <p class="text-[#91929E] text-[8px] font-nunito mb-[8px]">Rotary Regent GB05450/65...</p>
                        <p class="text-[#0A1629] text-base font-bold font-nunito">₦523,6004</p>
                    </div>
                </div>
                <div class="w-[160px] h-[193px] bg-[#F4F9FD] rounded-[15px] shadow-[0_4px_35px_rgba(196,203,214,0.10)] p-[5px]">
                    <div class="w-[150px] h-[112px] bg-gray-200 rounded-[14px] mb-[12px] flex items-center justify-center">
                        <span class="text-4xl">⌚</span>
                    </div>
                    <div class="px-[10px]">
                        <p class="text-[#91929E] text-[8px] font-nunito mb-[8px]">Rotary Regent GB05450/65...</p>
                        <p class="text-[#0A1629] text-base font-bold font-nunito">₦523,6004</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Banner -->
    <div class="mt-[24px] w-[549px] h-[55px] bg-[#F4F9FD] rounded-[14px] flex items-center px-[20px]">
        <div class="w-[24px] h-[24px] mr-[10px] flex items-center justify-center">
            <svg class="w-[20px] h-[20px]" fill="#3F8CFF" viewBox="0 0 20 20">
                <path d="M10 0C15.5228 0 20 4.47715 20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0ZM10 9C9.44771 9 9 9.44771 9 10V14C9 14.5523 9.44771 15 10 15C10.5523 15 11 14.5523 11 14V10C11 9.44771 10.5523 9 10 9ZM10 5C9.44772 5 9 5.44772 9 6C9 6.55228 9.44772 7 10 7C10.5621 7 11.0098 6.55228 11.0098 6C11.0098 5.44772 10.5621 5 10.0098 5Z" fill="#3F8CFF"></path>
            </svg>
        </div>
        <p class="text-[#3F8CFF] text-sm font-semibold font-nunito flex-1">
            Info display for quick message prompt hint, other things that client know are typing here.
        </p>
        <button class="w-[20px] h-[20px] bg-black rounded-full flex items-center justify-center">
            <span class="text-white text-xs">×</span>
        </button>
    </div>
@endsection
