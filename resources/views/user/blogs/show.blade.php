@extends('user.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 md:p-8">
    <div class="w-full max-w-[850px] bg-white rounded-[24px] p-8 md:p-12 flex flex-col gap-12 shadow-sm">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-[22px] font-bold text-[#0A1629] font-nunito">
                View Update
            </h1>
            <a href="{{ route('admin.updates.index') }}" class="flex items-center gap-3 h-12 px-4 rounded-[14px] bg-blue-500 text-white 
                      shadow-[0_6px_12px_0_rgba(63,140,255,0.26)] hover:bg-blue-600 transition-colors">
                <span class="text-base font-bold">Back to Updates</span>
            </a>
        </div>

        <!-- Image Banner -->
        <div class="flex flex-col gap-[10px]">
            {{-- <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">
                Image Banner
            </label> --}}
            <div class="w-full rounded-[14px] overflow-hidden shadow-md">
                @if($update->image)
                <div class="relative h-[300px] md:h-[400px] w-full bg-gray-100">
                    <img src="{{ asset($update->image) }}" alt="Blog Cover" class="w-full h-full object-cover object-center transition-transform duration-500 hover:scale-105" />
                </div>
                @else
                <div class="flex flex-col items-center justify-center h-[300px] md:h-[400px] w-full bg-gray-100 text-gray-400">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" class="mb-2">
                        <path d="M19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 
                        3.89543 21 5 21H19C20.1046 21 21 20.1046 21 
                        19V5C21 3.89543 20.1046 3 19 3Z" stroke="currentColor" stroke-width="2" />
                        <path d="M8.5 10C9.32843 10 10 9.32843 10 
                        8.5C10 7.67157 9.32843 7 8.5 7C7.67157 7 
                        7 7.67157 7 8.5C7 9.32843 7.67157 10 8.5 
                        10Z" stroke="currentColor" stroke-width="2" />
                        <path d="M21 15L16 10L5 21" stroke="currentColor" stroke-width="2" />
                    </svg>
                    <p class="text-lg font-semibold">No image uploaded</p>
                </div>
                @endif
            </div>

        </div>

        <!-- Title -->
        <div class="flex flex-col gap-[6px]">
            {{-- <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">Title</label> --}}
            <p class="text-[#0A1629] text-center text-lg font-semibold">
                {{ $update->title }}
            </p>
        </div>

        <!-- Body -->
        <div class="flex flex-col gap-[6px]">
            {{-- <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">Details</label> --}}
            <div class="prose max-w-full text-gray-700">
                {!! $update->body_html !!}
            </div>
        </div>

        {{-- <!-- Created & Updated Info -->
        <div class="gap-3 sm:gap-8 text-sm text-[#7D8592]">
            <p class="text-right">Written: {{ $update->created_at->format('M d, Y h:i A') }}</p>
    </div> --}}
</div>
</div>
@endsection
