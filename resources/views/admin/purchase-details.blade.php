@extends('admin.layouts.app')

@section('content')
<div class="p-4 lg:p-[32px] space-y-6 lg:space-y-8">
    <div class="flex flex-col">
        <h1 class="text-xl lg:text-2xl font-bold text-foreground">Hi, {{auth()->user()->full_name}}</h1>
        <p class="text-sm lg:text-base font-bold">
            <span class="text-muted-foreground">Take a look your overview </span>
            <span class="text-foreground">Today {{ date('M d, Y') }}</span>
        </p>
    </div>



    <div class="space-y-4">
        <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 overflow-hidden">
            <div class="flex items-center gap-4 lg:gap-6 min-w-0">
                <div class="w-[50px] h-[50px] bg-gray-300 rounded-full border-2 border-white relative flex-shrink-0 flex items-center justify-center">
                    <div class="w-9 h-9 bg-success rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 23 22" fill="currentColor">
                            <path d="M15.6899 5.71106C16.0368 5.71106 16.3234 5.95161 16.3688 6.26372L16.375 6.35048V17.9605C16.375 18.3137 16.0683 18.5999 15.6899 18.5999C15.3431 18.5999 15.0565 18.3594 15.0111 18.0473L15.0049 17.9605V6.35048C15.0049 5.99734 15.3116 5.71106 15.6899 5.71106Z" />
                            <path d="M18.9292 14.0172C19.1961 13.7669 19.6299 13.766 19.8981 14.0151C20.1419 14.2416 20.1649 14.5968 19.9665 14.8475L19.9003 14.9194L16.1754 18.412C15.932 18.6403 15.5499 18.6611 15.2813 18.4743L15.2043 18.412L11.4794 14.9194C11.2125 14.6691 11.2135 14.2642 11.4817 14.0151C11.7254 13.7886 12.1061 13.7688 12.3738 13.9551L12.4505 14.0172L15.6895 17.054L18.9292 14.0172Z" />
                            <path d="M6.6207 3.39758C6.96754 3.39758 7.25418 3.63814 7.29955 3.95024L7.3058 4.03701V15.647C7.3058 16.0002 6.99907 16.2865 6.6207 16.2865C6.27387 16.2865 5.98723 16.0459 5.94186 15.7338L5.93561 15.647V4.03701C5.93561 3.68386 6.24234 3.39758 6.6207 3.39758Z" />
                            <path d="M6.13525 3.58542C6.37871 3.35715 6.76076 3.33639 7.02942 3.52317L7.10636 3.58542L10.8313 7.07809C11.0982 7.32838 11.0972 7.73324 10.829 7.98237C10.5852 8.20886 10.2046 8.22867 9.93683 8.04236L9.86014 7.98028L6.6206 4.94251L3.38147 7.98028C3.1388 8.20782 2.75825 8.22927 2.48959 8.04412L2.4126 7.98237C2.16881 7.75589 2.14582 7.4007 2.3442 7.14995L2.41036 7.07809L6.13525 3.58542Z" /></svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-6">
                        <div class="flex flex-col gap-1 min-w-0">
                            <span class="text-sm text-text-light">Purchase ID</span>
                            <span class="text-base text-text-dark truncate" title="{{ $purchase->woo_id }}">{{ $purchase->woo_id }}</span>
                        </div>
                        <div class="flex flex-col gap-1 min-w-0">
                            <span class="text-sm text-text-light truncate">Amount</span>
                            <span class="text-base font-bold text-text-dark truncate" title="{{ $purchase->total }}">{{ '₦' . number_format($purchase->total, 2) }}</span>
                        </div>

                        <div class="flex flex-col gap-1 min-w-0 sm:col-span-2 lg:col-span-1">
                            <span class="text-sm text-text-light">Date</span>
                            <span class="text-xs lg:text-base text-text-dark truncate" title="{{ $purchase->date }}">{{ \Carbon\Carbon::parse($purchase['date'])->format('M d, Y H:i a') }}</span>
                        </div>
                        <div class="flex flex-col gap-1 min-w-0">
                            <span class="text-sm text-text-light truncate">Bonus Points</span>
                            <span class="text-base font-bold text-text-dark truncate" title="{{ $purchase->bonus_point }}"><img src="{{ asset('images/icons/diamond.svg') }}" alt="Bonus Points" class="inline-block w-4 h-4 mr-1">{{ $purchase->bonus_point }}</span>
                        </div>
                        @if(!empty($purchase->reward_status))
                        <div class="flex flex-col min-w-0 col-span-2 sm:col-span-1">
                            <span class="text-[11px] sm:text-sm text-text-light">Status</span>
                            @php
                            $statusColors = [
                            'pending' => 'bg-warning',
                            'completed' => 'bg-success',
                            'rejected' => 'bg-danger',
                            ];
                            $statusColor = $statusColors[$purchase->status] ?? 'bg-gray-500';
                            @endphp

                            <div class="rounded-md px-2 py-[2px] sm:px-3 sm:py-1 w-fit {{ $statusColor }}">
                                <span class="text-[10px] sm:text-xs font-bold text-white truncate block">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Purchase Items -->
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">Purchase Items</h2>
                    <div class="relative w-64">
                        <input type="text" placeholder="Search" class="w-full h-10 pl-10 pr-4 rounded-xl border border-gray-200 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-sm" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                        </svg>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                    <!-- Item Card -->
                    @foreach($purchase->items as $purchaseItem)
                    <div class="bg-gray-50 rounded-2xl p-3 flex flex-col items-center text-center hover:shadow transition">
                        <img src="{{ asset($purchaseItem->product->image_url)}}" alt="Watch" class="w-24 h-24 object-contain my-2">
                        <p class="text-xs my-2 text-gray-500 break-words w-24">{{$purchaseItem->product->name}} {{ $purchaseItem->product->woo_id }}</p>
                        <p class="font-semibold my-2 text-gray-800">{{ '₦' . number_format($purchaseItem->product->price, 2) }}</p>
                    </div>
                    @endforeach

                </div>
            </div>

            <!-- Right: User Detail -->
            <!-- Right: User Detail (corrected) -->
            <div class="relative lg:pl-8 lg:border-l lg:border-gray-200 lg:col-span-1">
                <!-- Top action -->
                {{-- <button class="absolute -top-4 right-0 px-4 py-2 rounded-xl bg-black text-white text-sm font-semibold
                    shadow-[0_10px_20px_rgba(0,0,0,0.18)] flex items-center gap-2">
                    Change Status
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white">
                        <path d="m22 2-7 20-4-9-9-4Z"></path>
                        <path d="M22 2 11 13"></path>
                    </svg>
                </button> --}}

                <!-- Dotted card -->
                <div class="bg-white rounded-3xl border-2 border-dashed border-gray-300 p-6">
                    <!-- Profile -->
                    <div class="flex justify-center items-center gap-3 mb-6">
                        <img src="https://i.pravatar.cc/80?img=5" alt="avatar" class="w-12 h-12 rounded-full">
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="font-semibold text-gray-900">{{$user->full_name}}</p>
                                <span class="inline-flex w-5 h-5 rounded-full bg-green-100 items-center justify-center">
                                    <img src="{{asset('images/icons/check.svg')}}" class="h-5 h-5" />
                                </span>
                            </div>
                            <p class="text-sm text-gray-500">{{$user->email}}</p>
                        </div>
                    </div>

                    <!-- Bonus & Value -->
                    <div class="rounded-2xl bg-[#F6FBEF] p-4 mb-6 flex flex-wrap items-center justify-between gap-4">
                        <!-- Bonus Point -->
                        <div class="flex items-center gap-3 flex-1 min-w-[150px]">
                            <img class="w-9 h-9 rounded-full" src="{{asset('images/icons/bonus_cocoa.png')}}"/>
                            <div>
                                <p class="text-xs text-gray-600">Bonus Point</p>
                                <p class="font-semibold text-gray-800">{{ $user->bonus_point }}</p>
                            </div>
                        </div>

                        <!-- Divider (hidden on wrap) -->
                        <div class="hidden sm:block h-10 w-px bg-gray-200 rounded"></div>

                        <!-- Value Amount -->
                        <div class="flex items-center gap-3 flex-1 min-w-[150px]">
                            <img class="w-9 h-9 rounded-full" src="{{asset('images/icons/money.png')}}"/>
                            <div>
                                <p class="text-xs text-gray-600">Value Amount</p>
                                <p class="font-semibold text-emerald-700">₦{{ number_format($user->total_spent, 2) }}</p>
                            </div>
                        </div>
                    </div>


                    <!-- Details -->
                    <div class="px-4 flex-1">
                        <div class="grid grid-cols-2 gap-x-4 gap-y-3">
                            <div>
                                <p class="text-sm text-brand-light-gray mb-1">Type</p>
                                <p class="text-base text-brand-dark">Purchase</p>
                            </div>
                            <div>
                                <p class="text-sm text-brand-light-gray mb-1">Amount</p>
                                <p class="text-base font-bold text-brand-dark">₦{{number_format($purchase->total,2)}}</p>
                            </div>
                            <div>
                                <p class="text-sm text-brand-light-gray mb-1">Date</p>
                                <p class="text-base text-brand-dark">{{ \Carbon\Carbon::parse($purchase->date_created)->format('M d, Y H:i a') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-brand-light-gray mb-1">Status</p>
                                <div class="inline-flex items-center justify-center w-[75px] h-[30px] bg-success rounded-[10px]"><span class="text-xs font-bold text-white">Completed</span></div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="p-4 mt-auto">
                        <button class="w-full flex items-center justify-center h-12 px-6 bg-black rounded-[14px] shadow-lg hover:bg-gray-800 transition-colors">
                            <span class="text-white font-bold text-base mr-3">Assign Point</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white">
                                <path d="m22 2-7 20-4-9-9-4Z"></path>
                                <path d="M22 2 11 13"></path>
                            </svg>
                        </button>
                    </div> --}}
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
