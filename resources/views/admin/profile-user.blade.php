@extends('admin.layouts.app')

@section('content')
<div class="p-4 lg:p-[32px] space-y-6 lg:space-y-8">
    <div class="flex flex-col">
        <h1 class="text-xl lg:text-2xl font-bold text-foreground">Hi, {{ auth('admin')->user()->full_name}}</h1>
        <p class="text-sm lg:text-base font-bold">
            <span class="text-muted-foreground">Take a look your overview </span>
            <span class="text-foreground">Today {{ date('M d, Y') }}</span>
        </p>
    </div>

    

    

    <div class="space-y-4">
        <div class="w-full max-w-4xl bg-white rounded-[20px] shadow-lg p-8 md:p-12">
        <!-- Header with stats and edit button -->
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-8">
            <!-- User info and stats -->
            <div class="flex flex-col sm:flex-row items-start gap-6 mb-6 lg:mb-0">
                <!-- Profile picture and basic info -->
                <div class="flex items-center gap-4">
                    <div class="w-[50px] h-[50px] rounded-full border-2 border-white overflow-hidden bg-gray-200">
                        <img 
                            src="{{ asset('images/profile.jpg') }}" 
                            alt="Kemi Wale" 
                            class="w-full h-full object-cover"
                        />
                    </div>
                    <div>
                        <h2 class="text-gray-800 font-bold text-base">{{ auth('admin')->user()->full_name}}</h2>
                        <p class="text-gray-500 text-sm">{{ auth('admin')->user()->email}}</p>
                    </div>
                </div>

                <!-- Stats card -->
                <div class="bg-gray-100 rounded-[20px] px-6 py-4 flex items-center gap-8">
                    <div>
                        <p class="text-gray-500 text-sm font-normal">Point Allocated</p>
                        <p class="text-gray-800 font-bold text-base">1920</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <img 
                            src="https://api.builder.io/api/v1/image/assets/TEMP/7389327a8088ce0d8fa92cbba294eb87ed31e921?width=72" 
                            alt="Money icon" 
                            class="w-9 h-9"
                        />
                        <div>
                            <p class="text-gray-500 text-sm font-normal">Value Amount</p>
                            <p class="text-gray-800 font-bold text-base">₦230,0032</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Form fields -->
        <div class="grid gap-6">
            <!-- First row: First Name, Last Name, Mobile Number -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-gray-700 text-sm font-bold">First Name</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                            <!-- User icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <input
                            type="text"
                            value="Cadabra"
                            class="w-full h-12 pl-12 pr-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none focus:border-blue-500"
                        />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-gray-700 text-sm font-bold">Last Name</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                            <!-- User icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <input
                            type="text"
                            value="Cadabra"
                            class="w-full h-12 pl-12 pr-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none focus:border-blue-500"
                        />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-gray-700 text-sm font-bold">Mobile Number</label>
                    <input
                        type="tel"
                        value="+1 675 346 23-10"
                        class="w-full h-12 px-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none focus:border-blue-500"
                    />
                </div>
            </div>

            <!-- Second row: Email Address -->
            <div class="space-y-2">
                <label class="text-gray-700 text-sm font-bold">Email Address</label>
                <div class="relative">
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                        <!-- Mail icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <input
                        type="email"
                        value="someone@yourmail.com"
                        class="w-full h-12 pl-12 pr-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none focus:border-blue-500"
                    />
                </div>
            </div>

            <!-- Third row: Location, Birthday Date, Mobile Number -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-gray-700 text-sm font-bold">Location</label>
                    <div class="relative">
                        <input
                            type="text"
                            value="NYC, New York, USA"
                            class="w-full h-12 pl-4 pr-12 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none focus:border-blue-500"
                        />
                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                            <!-- MapPin icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-gray-700 text-sm font-bold">Birthday Date</label>
                    <div class="relative">
                        <input
                            type="text"
                            value="May 19, 1996"
                            class="w-full h-12 pl-4 pr-12 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none focus:border-blue-500"
                        />
                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                            <!-- Calendar icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-gray-700 text-sm font-bold">Mobile Number</label>
                    <input
                        type="tel"
                        value="+1 675 346 23-10"
                        class="w-full h-12 px-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm shadow-sm focus:outline-none focus:border-blue-500"
                    />
                </div>
            </div>

            <!-- Bio field -->
            <div class="space-y-2">
                <label class="text-gray-700 text-sm font-bold">Bio</label>
                <textarea
                    placeholder="Add some description of the event"
                    rows="4"
                    class="w-full p-4 rounded-[14px] border border-gray-300 bg-white text-gray-700 text-sm placeholder-gray-500 shadow-sm resize-none focus:outline-none focus:border-blue-500"
                ></textarea>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
