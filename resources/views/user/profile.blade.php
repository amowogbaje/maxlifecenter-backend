@extends('user.layouts.app')

@section('content')
<div class="p-4 lg:p-[32px] space-y-6 lg:space-y-8">
    <div class="flex flex-col">
        <h1 class="text-xl lg:text-2xl font-bold text-foreground">
            Hi, {{ Auth::user()->full_name }}
        </h1>
        <p class="text-sm lg:text-base font-bold">
            <span class="text-muted-foreground">Take a look at your overview </span>
            <span class="text-foreground">Today {{ date('M d, Y') }}</span>
        </p>
    </div>

    <div class="space-y-4">
        <div class="w-full max-w-4xl bg-white rounded-[20px] shadow-lg p-8 md:p-12">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-8">
                <div class="flex flex-col sm:flex-row items-start gap-6 mb-6 lg:mb-0">
                    <div class="flex items-center gap-4">
                        <div class="w-[50px] h-[50px] rounded-full border-2 border-white overflow-hidden bg-gray-200">
                            <img src="{{ Auth::user()->profile_picture 
                                ? asset('storage/' . Auth::user()->profile_picture) 
                                : asset('images/profile.jpg') }}" 
                                alt="{{ Auth::user()->first_name }}" 
                                class="w-full h-full object-cover" />
                        </div>
                        <div>
                            <h2 class="text-gray-800 font-bold text-base">
                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                            </h2>
                            <p class="text-gray-500 text-sm">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <!-- Example stats -->
                    <div class="bg-gray-100 rounded-[20px] px-6 py-4 flex items-center gap-8">
                        <div>
                            <p class="text-gray-500 text-sm font-normal">Point Allocated</p>
                            <p class="text-gray-800 font-bold text-base">{{ Auth::user()->bonus_points ?? 0 }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <img src="https://api.builder.io/api/v1/image/assets/TEMP/7389327a8088ce0d8fa92cbba294eb87ed31e921?width=72" 
                                 alt="Money icon" class="w-9 h-9" />
                            <div>
                                <p class="text-gray-500 text-sm font-normal">Value Amount</p>
                                <p class="text-gray-800 font-bold text-base">₦{{ number_format(Auth::user()->value_amount ?? 0) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 flex items-center gap-8">
                        <div class="flex items-center gap-3">
                            <div class="w-16 h-16 bg-green-400/20 rounded-full flex items-center justify-center mb-4">
                                <img src="{{ asset('images/eleniyan.png')}}" alt="Tier icon" class="w-10 h-10" />
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-normal">Current Tier</p>
                                <p class="text-gray-800 font-bold text-base">{{ Auth::user()->approvedTier->title ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form fields -->
            <div class="grid gap-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="text-gray-700 text-sm font-bold">First Name</label>
                        <input type="text" value="{{ Auth::user()->first_name }}" 
                               class="w-full h-12 px-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-gray-700 text-sm font-bold">Last Name</label>
                        <input type="text" value="{{ Auth::user()->last_name }}" 
                               class="w-full h-12 px-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-gray-700 text-sm font-bold">Mobile Number</label>
                        <input type="tel" value="{{ Auth::user()->phone ?? '' }}" 
                               class="w-full h-12 px-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-gray-700 text-sm font-bold">Email Address</label>
                    <input type="email" readonly value="{{ Auth::user()->email }}" 
                           class="w-full h-12 px-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="text-gray-700 text-sm font-bold">Location</label>
                        <input type="text" value="{{ Auth::user()->location ?? '' }}" 
                               class="w-full h-12 px-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-gray-700 text-sm font-bold">Birthday Date</label>
                        <input type="text" value="{{ Auth::user()->birthday ?? '' }}" 
                               class="w-full h-12 px-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-gray-700 text-sm font-bold">Mobile Number</label>
                        <input type="tel" value="{{ Auth::user()->phone ?? '' }}" 
                               class="w-full h-12 px-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-gray-700 text-sm font-bold">Bio</label>
                    <textarea rows="4" 
                              class="w-full p-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm resize-none focus:outline-none">{{ Auth::user()->bio ?? '' }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
