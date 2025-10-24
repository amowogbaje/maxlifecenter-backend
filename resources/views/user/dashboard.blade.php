@extends('user.layouts.app')

@section('content')
<div class="mb-[32px] px-6">
    <h1 class="text-[#1D1F24] text-2xl font-bold font-nunito mb-[8px]">Hi, {{auth()->user()->full_name}}</h1>
    <p class="text-base font-nunito">
        <span class="text-[#6B6E75] font-bold">Take a look your overview </span>
        <span class="text-[#1D1F24] font-bold">Today {{ now()->format('M d, Y') }}</span>
    </p>
</div>



<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-12 px-6">
    <div class="bg-white rounded-2xl shadow p-5 relative flex flex-col justify-between hover:shadow-md transition">

        <!-- Icon -->
        <div class="flex items-center justify-center mb-3">
            <div class="w-8 h-8 rounded-full flex items-center justify-center bg-green-600">
                <svg width="15" height="14" viewBox="0 0 15 14" fill="white">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.95481 4.86937L4.33168 9.05303C4.35918 9.37503 4.64106 9.61653 4.98543 9.61653H11.8086C12.1342 9.61653 12.4123 9.3902 12.4586 9.08978L13.0523 5.2637C13.0661 5.1727 13.0417 5.0817 12.9823 5.0082L12.7398 4.87345L3.95481 4.86937Z" fill="white"></path>
                </svg>
            </div>
        </div>

        <!-- Text -->
        <div class="flex-1">
            <p class="text-sm text-gray-500 mb-1 break-words text-center">My Purchase</p>
            <h3 class="text-2xl font-bold text-gray-900 mb-3 break-words text-center">{{$purchaseCount}}</h3>
            <div class="bg-blue-50 rounded-lg px-3 py-1 flex justify-center">
                <span class="text-xs font-semibold text-gray-700 break-words">₦{{$purchaseTotal}}</span>
            </div>
        </div>

        <!-- Avatar -->
    </div>

    <div class="bg-white rounded-2xl shadow p-5 relative flex flex-col justify-between hover:shadow-md transition">

        <!-- Icon -->
        <div class="flex items-center justify-center mb-3">
            <div class="w-9 h-9 bg-green-100 rounded-full flex items-center justify-center">
                <img src="{{ asset('images/'. strtolower($currentTier) .'.png')}}" class="w-7 h-7" alt="{{$currentTier}}" />
            </div>
        </div>

        <!-- Text -->
        <div class="flex-1 text-center">
            <p class="text-xs text-gray-500 mb-1">Current Tier</p>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{$currentTier}}</h3>

        </div>


    </div>

    @if($nextTier)
    <div class="bg-white rounded-2xl shadow p-5 relative flex flex-col justify-between hover:shadow-md transition">

        <!-- Icon -->
        <div class="flex items-center justify-center mb-3">
            <div class="w-9 h-9 bg-green-100 rounded-full flex items-center justify-center">
                <img src="{{ asset('images/'. strtolower($nextTier) .'.png')}}" class="w-7 h-7" alt="{{$nextTier}}" />
            </div>
        </div>

        <!-- Text -->
        <div class="flex-1 text-center">
            <p class="text-xs text-gray-500 mb-1">Next Tier</p>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{$nextTier}}</h3>
        </div>


    </div>
    @endif



</div>

<!-- Bottom Grid -->
<div class="flex flex-col lg:flex-row gap-6">

    <!-- Updates Section -->
    <div class="bg-white rounded-2xl p-6 flex-1 max-w-full">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-gray-900 text-xl font-bold">Updates</h2>
            <div class="flex items-center text-blue-500 cursor-pointer">
                <span class="text-base font-bold mr-1">View all</span>
                <svg class="w-2 h-3" fill="currentColor" viewBox="0 0 6 10">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.293 0.293C0.653 -0.068 1.221 -0.095 1.613 0.21L5.707 4.293C6.068 4.653 6.095 5.221 5.79 5.613L1.707 9.707C1.317 10.098 0.683 10.098 0.293 9.707V1.707C-0.068 1.347 -0.095 0.779 0.21 0.387Z" />
                </svg>
            </div>
        </div>

        <!-- Update Items -->
        <div class="space-y-5">
            <div class="bg-white rounded-xl shadow p-4 flex items-center">
                <div class="w-1 h-10 bg-pink-400 rounded mr-6"></div>
                <div class="flex-1 ">
                    <div class="text-gray-900 flex text-xs font-bold mb-1">
                        <svg class="w-6 h-6 me-2 text-pink-400 fill-current" viewBox="0 0 27 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.2548 2.9636C15.653 1.67814 17.9189 1.67848 19.3163 2.96458C20.505 4.05885 20.6827 5.73188 19.8495 6.99973H21.4511C23.2508 6.9998 24.7097 8.34304 24.7099 9.99973V10.9997C24.7099 12.3056 23.8022 13.4128 22.537 13.8249V18.9997C22.537 20.5974 21.1803 21.9036 19.4697 21.9949L19.2783 21.9997H8.41595C6.68051 21.9997 5.26127 20.7512 5.16205 19.1765L5.15717 18.9997V13.8249C3.89197 13.4128 2.98431 12.3056 2.98431 10.9997V9.99973C2.98447 8.34301 4.44342 6.99975 6.2431 6.99973H7.84467C7.01167 5.73224 7.18923 4.05994 8.37787 2.96555C9.77531 1.6791 12.0407 1.6785 13.4394 2.96458C13.5893 3.10261 13.7251 3.2577 13.8476 3.42942C13.9702 3.25792 14.1048 3.10167 14.2548 2.9636ZM7.32904 18.9997C7.32904 19.5126 7.74878 19.9351 8.289 19.9929L8.41595 19.9997H12.7607V13.9997H7.32904V18.9997ZM14.9335 19.9997H19.2783C19.8352 19.9997 20.2945 19.6141 20.3574 19.1169L20.3652 18.9997V13.9997H14.9335V19.9997ZM6.2431 8.99973C5.64328 8.99975 5.15732 9.44758 5.15717 9.99973V10.9997C5.15717 11.552 5.64319 11.9997 6.2431 11.9997H12.7607V8.99973H6.2431ZM14.9335 11.9997H21.4511C22.051 11.9997 22.537 11.552 22.537 10.9997V9.99973C22.5369 9.44761 22.0509 8.9998 21.4511 8.99973H14.9335V11.9997ZM11.9042 4.37864C11.3545 3.87326 10.4634 3.8739 9.914 4.37962C9.36482 4.88534 9.36456 5.70508 9.91302 6.21067C10.1468 6.42587 10.7262 6.63959 11.5204 6.78587C11.7723 6.83223 12.0363 6.8701 12.3056 6.9011L12.6953 6.94016L12.6533 6.58079L12.5966 6.2136L12.5283 5.85911C12.3694 5.12787 12.1376 4.59355 11.9042 4.37864ZM17.666 4.28489C17.1136 3.87603 16.3035 3.90749 15.791 4.37864C15.5142 4.63342 15.2541 5.3085 15.0976 6.20872C15.0656 6.39279 15.0394 6.57657 15.0175 6.75559L14.996 6.94016L15.3886 6.9011L15.787 6.84934L16.1728 6.78587C16.9673 6.63959 17.5468 6.4255 17.7802 6.21067C18.329 5.70474 18.3292 4.88534 17.7802 4.37962L17.666 4.28489Z" />
                        </svg>
                        <span>Prompt Title</span>
                    </div>
                    <p class="text-gray-500 text-xs leading-4">
                        Some text form short call to action for the user to
                        read and take some actions.
                    </p>
                </div>
                <div class="flex items-center flex-shrink-0  justify-center gap-x-1">
                    <svg class="svg-main text-black w-4 h-4" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.00106 0.692383C1.10306 0.692383 1.20089 0.732905 1.27302 0.805034C1.34515 0.877163 1.38567 0.974992 1.38567 1.077C1.38567 3.86469 3.59798 6.077 6.38567 6.077H6.99567L6.11337 5.19546C6.07761 5.1597 6.04924 5.11725 6.02989 5.07052C6.01053 5.0238 6.00057 4.97372 6.00057 4.92315C6.00057 4.87258 6.01053 4.8225 6.02989 4.77578C6.04924 4.72906 6.07761 4.6866 6.11337 4.65084C6.18559 4.57862 6.28354 4.53805 6.38567 4.53805C6.43625 4.53805 6.48632 4.54801 6.53305 4.56736C6.57977 4.58672 6.62222 4.61508 6.65798 4.65084L8.19644 6.18931C8.23226 6.22503 8.26068 6.26748 8.28007 6.3142C8.29946 6.36093 8.30944 6.41102 8.30944 6.46161C8.30944 6.5122 8.29946 6.5623 8.28007 6.60902C8.26068 6.65575 8.23226 6.69819 8.19644 6.73392L6.65798 8.27238C6.62222 8.30814 6.57977 8.33651 6.53305 8.35586C6.48632 8.37522 6.43625 8.38518 6.38567 8.38518C6.3351 8.38518 6.28502 8.37522 6.2383 8.35586C6.19158 8.33651 6.14913 8.30814 6.11337 8.27238C6.07761 8.23662 6.04924 8.19417 6.02989 8.14745C6.01053 8.10072 6.00057 8.05065 6.00057 8.00008C6.00057 7.9495 6.01053 7.89943 6.02989 7.8527C6.04924 7.80598 6.07761 7.76353 6.11337 7.72777L6.99567 6.84623H6.38567C5.72784 6.84183 5.07568 6.96816 4.46707 7.21788C3.85845 7.4676 3.30551 7.83573 2.84034 8.3009C2.37517 8.76607 2.00704 9.31901 1.75732 9.92762C1.50761 10.5362 1.38128 11.1884 1.38567 11.8462C1.38567 11.9482 1.34515 12.0461 1.27302 12.1182C1.20089 12.1903 1.10306 12.2308 1.00106 12.2308C0.899051 12.2308 0.801223 12.1903 0.729094 12.1182C0.656964 12.0461 0.616442 11.9482 0.616442 11.8462C0.609254 10.6816 0.957058 9.54249 1.61353 8.58053C2.27 7.61857 3.20398 6.87945 4.29106 6.46161C3.20398 6.04378 2.27 5.30466 1.61353 4.3427C0.957058 3.38073 0.609254 2.24159 0.616442 1.077C0.616442 0.974992 0.656964 0.877163 0.729094 0.805034C0.801223 0.732905 0.899051 0.692383 1.00106 0.692383ZM5.25644 7.76392C4.31254 8.01695 3.48723 8.59292 2.92413 9.39161V9.92315C2.92413 10.3312 3.08622 10.7225 3.37474 11.011C3.66326 11.2995 4.05457 11.4616 4.46260 11.4616H9.07798C9.48601 11.4616 9.87732 11.2995 10.1658 11.011C10.4544 10.7225 10.6164 10.3312 10.6164 9.92315V3.00008C10.6164 2.59205 10.4544 2.20074 10.1658 1.91222C9.87732 极速.6237 9.48601 1.46161 9.07798 1.46161H4.46260C4.05457 1.46161 3.66326 1.6237 3.37474 1.91222C3.08622 2.20074 2.92413 2.59205 2.92413 3.00008V3.53161C3.48723 4.33031 4.31254 4.90628 5.25644 5.15931C5.20536 4.91609 5.23423 4.66287 5.33874 4.43739C5.44326 4.21191 5.61782 4.02624 5.83643 3.90802C6.05504 3.78981 6.306 3.74539 6.55190 3.78139C6.79780 3.81738 7.02550 3.93186 7.20106 4.10777L8.73952 5.64623C8.84674 5.75338 8.93180 5.88062 8.98983 6.02065C9.04786 6.16069 9.07773 6.31080 9.07773 6.46238C9.07773 6.61397 9.04786 6.76407 极速.98983 6.90411C8.93180 7.04415 8.84674 7.17138 8.73952 7.27854L7.20106 8.817C7.02540 8.99314 6.79752 9.10781 6.55138 9.14389C6.30525 9.17997 6.05405 9.13553 5.83522 9.01721C5.61640 8.89889 5.44168 8.71302 5.33710 8.48731C5.23252 8.26159 5.20369 8.00813 5.25490 7.76469" fill="currentColor"></path>
                    </svg>
                    <span class="text-gray-500 text-[10px] font-bold">View</span>
                </div>
            </div>

            <!-- Duplicate Item -->
            <div class="bg-white rounded-xl shadow p-4 flex items-center">
                <div class="w-1 h-10 bg-pink-400 rounded mr-6"></div>
                <div class="flex-1 ">
                    <div class="text-gray-900 flex text-xs font-bold mb-1">
                        <svg class="w-6 h-6 me-2 text-pink-400 fill-current" viewBox="0 0 27 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.2548 2.9636C15.653 1.67814 17.9189 1.67848 19.3163 2.96458C20.505 4.05885 20.6827 5.73188 19.8495 6.99973H21.4511C23.2508 6.9998 24.7097 8.34304 24.7099 9.99973V10.9997C24.7099 12.3056 23.8022 13.4128 22.537 13.8249V18.9997C22.537 20.5974 21.1803 21.9036 19.4697 21.9949L19.2783 21.9997H8.41595C6.68051 21.9997 5.26127 20.7512 5.16205 19.1765L5.15717 18.9997V13.8249C3.89197 13.4128 2.98431 12.3056 2.98431 10.9997V9.99973C2.98447 8.34301 4.44342 6.99975 6.2431 6.99973H7.84467C7.01167 5.73224 7.18923 4.05994 8.37787 2.96555C9.77531 1.6791 12.0407 1.6785 13.4394 2.96458C13.5893 3.10261 13.7251 3.2577 13.8476 3.42942C13.9702 3.25792 14.1048 3.10167 14.2548 2.9636ZM7.32904 18.9997C7.32904 19.5126 7.74878 19.9351 8.289 19.9929L8.41595 19.9997H12.7607V13.9997H7.32904V18.9997ZM14.9335 19.9997H19.2783C19.8352 19.9997 20.2945 19.6141 20.3574 19.1169L20.3652 18.9997V13.9997H14.9335V19.9997ZM6.2431 8.99973C5.64328 8.99975 5.15732 9.44758 5.15717 9.99973V10.9997C5.15717 11.552 5.64319 11.9997 6.2431 11.9997H12.7607V8.99973H6.2431ZM14.9335 11.9997H21.4511C22.051 11.9997 22.537 11.552 22.537 10.9997V9.99973C22.5369 9.44761 22.0509 8.9998 21.4511 8.99973H14.9335V11.9997ZM11.9042 4.37864C11.3545 3.87326 10.4634 3.8739 9.914 4.37962C9.36482 4.88534 9.36456 5.70508 9.91302 6.21067C10.1468 6.42587 10.7262 6.63959 11.5204 6.78587C11.7723 6.83223 12.0363 6.8701 12.3056 6.9011L12.6953 6.94016L12.6533 6.58079L12.5966 6.2136L12.5283 5.85911C12.3694 5.12787 12.1376 4.59355 11.9042 4.37864ZM17.666 4.28489C17.1136 3.87603 16.3035 3.90749 15.791 4.37864C15.5142 4.63342 15.2541 5.3085 15.0976 6.20872C15.0656 6.39279 15.0394 6.57657 15.0175 6.75559L14.996 6.94016L15.3886 6.9011L15.787 6.84934L16.1728 6.78587C16.9673 6.63959 17.5468 6.4255 17.7802 6.21067C18.329 5.70474 18.3292 4.88534 17.7802 4.37962L17.666 4.28489Z" />
                        </svg>
                        <span>Prompt Title</span>
                    </div>
                    <p class="text-gray-500 text-xs leading-4">
                        Some text form short call to action for the user to
                        read and take some actions.
                    </p>
                </div>
                <div class="flex items-center flex-shrink-0  justify-center gap-x-1">
                    <svg class="svg-main text-black w-4 h-4" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.00106 0.692383C1.10306 0.692383 1.20089 0.732905 1.27302 0.805034C1.34515 0.877163 1.38567 0.974992 1.38567 1.077C1.38567 3.86469 3.59798 6.077 6.38567 6.077H6.99567L6.11337 5.19546C6.07761 5.1597 6.04924 5.11725 6.02989 5.07052C6.01053 5.0238 6.00057 4.97372 6.00057 4.92315C6.00057 4.87258 6.01053 4.8225 6.02989 4.77578C6.04924 4.72906 6.07761 4.6866 6.11337 4.65084C6.18559 4.57862 6.28354 4.53805 6.38567 4.53805C6.43625 4.53805 6.48632 4.54801 6.53305 4.56736C6.57977 4.58672 6.62222 4.61508 6.65798 4.65084L8.19644 6.18931C8.23226 6.22503 8.26068 6.26748 8.28007 6.3142C8.29946 6.36093 8.30944 6.41102 8.30944 6.46161C8.30944 6.5122 8.29946 6.5623 8.28007 6.60902C8.26068 6.65575 8.23226 6.69819 8.19644 6.73392L6.65798 8.27238C6.62222 8.30814 6.57977 8.33651 6.53305 8.35586C6.48632 8.37522 6.43625 8.38518 6.38567 8.38518C6.3351 8.38518 6.28502 8.37522 6.2383 8.35586C6.19158 8.33651 6.14913 8.30814 6.11337 8.27238C6.07761 8.23662 6.04924 8.19417 6.02989 8.14745C6.01053 8.10072 6.00057 8.05065 6.00057 8.00008C6.00057 7.9495 6.01053 7.89943 6.02989 7.8527C6.04924 7.80598 6.07761 7.76353 6.11337 7.72777L6.99567 6.84623H6.38567C5.72784 6.84183 5.07568 6.96816 4.46707 7.21788C3.85845 7.4676 3.30551 7.83573 2.84034 8.3009C2.37517 8.76607 2.00704 9.31901 1.75732 9.92762C1.50761 10.5362 1.38128 11.1884 1.38567 11.8462C1.38567 11.9482 1.34515 12.0461 1.27302 12.1182C1.20089 12.1903 1.10306 12.2308 1.00106 12.2308C0.899051 12.2308 0.801223 12.1903 0.729094 12.1182C0.656964 12.0461 0.616442 11.9482 0.616442 11.8462C0.609254 10.6816 0.957058 9.54249 1.61353 8.58053C2.27 7.61857 3.20398 6.87945 4.29106 6.46161C3.20398 6.04378 2.27 5.30466 1.61353 4.3427C0.957058 3.38073 0.609254 2.24159 0.616442 1.077C0.616442 0.974992 0.656964 0.877163 0.729094 0.805034C0.801223 0.732905 0.899051 0.692383 1.00106 0.692383ZM5.25644 7.76392C4.31254 8.01695 3.48723 8.59292 2.92413 9.39161V9.92315C2.92413 10.3312 3.08622 10.7225 3.37474 11.011C3.66326 11.2995 4.05457 11.4616 4.46260 11.4616H9.07798C9.48601 11.4616 9.87732 11.2995 10.1658 11.011C10.4544 10.7225 10.6164 10.3312 10.6164 9.92315V3.00008C10.6164 2.59205 10.4544 2.20074 10.1658 1.91222C9.87732 极速.6237 9.48601 1.46161 9.07798 1.46161H4.46260C4.05457 1.46161 3.66326 1.6237 3.37474 1.91222C3.08622 2.20074 2.92413 2.59205 2.92413 3.00008V3.53161C3.48723 4.33031 4.31254 4.90628 5.25644 5.15931C5.20536 4.91609 5.23423 4.66287 5.33874 4.43739C5.44326 4.21191 5.61782 4.02624 5.83643 3.90802C6.05504 3.78981 6.306 3.74539 6.55190 3.78139C6.79780 3.81738 7.02550 3.93186 7.20106 4.10777L8.73952 5.64623C8.84674 5.75338 8.93180 5.88062 8.98983 6.02065C9.04786 6.16069 9.07773 6.31080 9.07773 6.46238C9.07773 6.61397 9.04786 6.76407 极速.98983 6.90411C8.93180 7.04415 8.84674 7.17138 8.73952 7.27854L7.20106 8.817C7.02540 8.99314 6.79752 9.10781 6.55138 9.14389C6.30525 9.17997 6.05405 9.13553 5.83522 9.01721C5.61640 8.89889 5.44168 8.71302 5.33710 8.48731C5.23252 8.26159 5.20369 8.00813 5.25490 7.76469" fill="currentColor"></path>
                    </svg>
                    <span class="text-gray-500 text-[10px] font-bold">View</span>
                </div>
            </div>
        </div>
    </div>

    <!-- TIMEX Banner -->
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl relative overflow-hidden flex-1 max-w-full">
        <img src="{{asset('images/timex.png')}}" alt="TIMEX banner" class="w-full h-full object-cover">
    </div>
</div>


<!-- Active Campaign Section -->
<div class="mt-5 flex flex-col lg:flex-row gap-6">

    <!-- Active Campaign -->
    <div class="bg-white rounded-2xl p-6 flex-1 max-w-full">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-[#0A1629] text-xl font-bold font-nunito">Active Campaign</h2>
            <div class="flex items-center text-[#3F8CFF] cursor-pointer">
                <span class="text-base font-bold font-nunito mr-1">View all</span>
                <svg class="w-2 h-3" fill="currentColor" viewBox="0 0 6 10">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.293 0.293C0.653 -0.068 1.221 -0.095 1.613 0.21L5.707 4.293C6.068 4.653 6.095 5.221 5.79 5.613L1.707 9.707C1.317 10.098 0.683 10.098 0.293 9.707V1.707C-0.068 1.347 -0.095 0.779 0.21 0.387Z" />
                </svg>
            </div>
        </div>

        <!-- Campaign Items -->
        <div class="space-y-4">
            <div class="bg-[#F4F6F9] rounded-xl p-4 flex items-center">
                <div class="w-12 h-12 bg-[#FFEBEA] rounded-lg flex items-center justify-center mr-4">
                    <div class="text-2xl text-[#F44336]">📢</div>
                </div>
                <div class="flex-1">
                    <h4 class="text-[#0A1629] text-sm font-bold mb-1">Campaign Title</h4>
                    <p class="text-[#91929E] text-xs">Some text form short call to action for the user to read and take some actions.</p>
                </div>
                <button class="bg-[#FFBE00] text-white rounded-lg px-3 py-1.5 text-xs font-bold shadow">
                    View
                </button>
            </div>

            <div class="bg-[#F4F6F9] rounded-xl p-4 flex items-center">
                <div class="w-12 h-12 bg-[#FFEBEA] rounded-lg flex items-center justify-center mr-4">
                    <div class="text-2xl text-[#F44336]">📢</div>
                </div>
                <div class="flex-1">
                    <h4 class="text-[#0A1629] text-sm font-bold mb-1">Campaign Title</h4>
                    <p class="text-[#91929E] text-xs">Some text form short call to action for the user to read and take some actions.</p>
                </div>
                <button class="bg-[#FFBE00] text-white rounded-lg px-3 py-1.5 text-xs font-bold shadow">
                    View
                </button>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="bg-white rounded-2xl p-6 flex-1 max-w-full">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-[#0A1629] text-xl font-bold font-nunito">Products just for</h2>
            <div class="flex items-center text-[#3F8CFF] cursor-pointer">
                <a href="{{ route('purchases') }}" class="inline-flex items-center text-base font-bold mr-1 text-blue-600 hover:underline">
                    View all
                </a>
                <svg class="w-2 h-3" fill="currentColor" viewBox="0 0 6 10">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.293 0.293C0.653 -0.068 1.221 -0.095 1.613 0.21L5.707 4.293C6.068 4.653 6.095 5.221 5.79 5.613L1.707 9.707C1.317 10.098 0.683 10.098 0.293 9.707V1.707C-0.068 1.347 -0.095 0.779 0.21 0.387Z" />
                </svg>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            @forelse($recentProducts as $product)
            <div class="bg-[#F4F9FD] rounded-xl shadow p-2">
                <!-- Product Image -->
                <div class="w-full h-28 bg-gray-200 rounded-lg mb-3 flex items-center justify-center overflow-hidden">
                    <img class="h-full object-contain" src="{{ $product->image_url ?? asset('/images/placeholder.jpg') }}" alt="{{ $product->name }}" />
                </div>

                <!-- Product Info -->
                <div class="px-2">
                    <p class="text-[#91929E] text-[10px] mb-1 truncate">
                        {{ $product->name }}
                    </p>
                    <p class="text-[#0A1629] text-sm font-bold">
                        ₦{{ number_format($product->price, 2) }}
                    </p>
                </div>
            </div>
            @empty
            <div class="col-span-2 sm:col-span-3 text-center text-gray-500 py-6">
                No recent purchases found.
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection
