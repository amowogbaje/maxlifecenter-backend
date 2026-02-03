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

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($metricCards as $card)
        <div class="bg-white rounded-2xl shadow p-5 relative flex flex-col justify-between hover:shadow-md transition">

            @if($card['hasAvatar'])
            <div class="flex items-center justify-start mb-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $card['bgColor'] }}">
                    <img src="{{asset($card['avatarIcon'])}}" alt="Eleniyan Icon" class="w-8 h-8" />
                </div>
            </div>
            @else
            <!-- Icon -->
            <div class="flex items-center justify-start mb-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $card['bgColor'] }}">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 12 12" fill="currentColor">
                        <path d="M2.25 1C1.56 1 1 1.56 1 2.25V3.412C1.00027 3.67934 1.07198 3.94175 1.20771 4.17207C1.34344 4.40239 1.53826 4.59225 1.772 4.722L4.648 6.321C4.0456 6.62512 3.56332 7.12345 3.27909 7.73549C2.99486 8.34752 2.92528 9.03751 3.08159 9.69398C3.2379 10.3504 3.61097 10.935 4.14052 11.3533C4.67008 11.7716 5.32518 11.9991 6 11.9991C6.67482 11.9991 7.32992 11.7716 7.85948 11.3533C8.38903 10.935 8.7621 10.3504 8.91841 9.69398C9.07472 9.03751 9.00514 8.34752 8.72091 7.73549C8.43668 7.12345 7.9544 6.62512 7.352 6.321L10.229 4.723C10.4627 4.59304 10.6574 4.40297 10.793 4.17246C10.9285 3.94196 11 3.67941 11 3.412V2.25C11 1.56 10.44 1 9.75 1H2.25ZM5 5.372V2H7V5.372L6 5.928L5 5.372ZM8 9C8 9.53043 7.78929 10.0391 7.41421 10.4142C7.03914 10.7893 6.53043 11 6 11C5.46957 11 4.96086 10.7893 4.58579 10.4142C4.21071 10.0391 4 9.53043 4 9C4 8.46957 4.21071 7.96086 4.58579 7.58579C4.96086 7.21071 5.46957 7 6 7C6.53043 7 7.03914 7.21071 7.41421 7.58579C7.78929 7.96086 8 8.46957 8 9Z" />
                    </svg>
                </div>
            </div>
            @endif

            <!-- Text -->
            <div class="flex-1">
                <p class="text-sm text-gray-500 mb-1 break-words">{{ $card['subtitle'] }}</p>
                <h3 class="text-2xl font-bold text-gray-900 mb-3 break-words">{{ $card['title'] }}</h3>
                @if(isset($card['value']))
                <div class="bg-blue-50 rounded-lg px-3 py-1 inline-block">
                    <span class="text-xs font-semibold text-gray-700 break-words">{{ $card['value'] }}</span>
                </div>
                @endif
            </div>

            <!-- Avatar -->

        </div>
        @endforeach
    </div>


</div>
@endsection
