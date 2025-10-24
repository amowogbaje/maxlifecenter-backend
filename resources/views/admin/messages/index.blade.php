@extends('admin.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex flex-col mb-8">
        <h1 class="text-xl lg:text-2xl font-bold text-foreground">Hi, {{ auth('admin')->user()->full_name}}</h1>
        <p class="text-sm lg:text-base font-bold">
            <span class="text-muted-foreground">Take a look your overview </span>
            <span class="text-foreground">Today {{ date('M d, Y') }}</span>
        </p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($metricCards as $card)
        <a href = "{{route($card['routeName'])}}">
            <div class="bg-white rounded-2xl shadow p-5 relative flex flex-col justify-between hover:shadow-md transition">

                <!-- Icon -->
                <div class="flex items-center justify-start mb-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center {{ $card['bgColor'] }}">
                        {!! $card['svgIcon'] !!}
                    </div>
                </div>

                <!-- Text -->
                <div class="flex-1">
                    <p class="text-sm text-gray-500 mb-1 break-words">{{ $card['subtitle'] }}</p>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 break-words">{{ $card['title'] }}</h3>
                </div>

            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
@push('style')
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
@endpush