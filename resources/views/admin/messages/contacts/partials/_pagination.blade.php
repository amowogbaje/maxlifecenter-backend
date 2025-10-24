<div class="flex justify-center lg:justify-end mt-4">
    <div class="bg-white rounded-[14px] shadow-sm px-5 py-3 flex items-center gap-4">
        <span class="text-base text-text-dark">
            {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }}
        </span>

        @if($users->onFirstPage())
        <svg class="w-6 h-6 text-gray-300">
            <path d="m15 18-6-6 6-6" /></svg>
        @else
        <a href="{{ $users->previousPageUrl() }}">
            <svg class="w-6 h-6 text-blue-500">
                <path d="m15 18-6-6 6-6" /></svg>
        </a>
        @endif

        @if($users->hasMorePages())
        <a href="{{ $users->nextPageUrl() }}">
            <svg class="w-6 h-6 text-blue-500">
                <path d="m9 18 6-6-6-6" /></svg>
        </a>
        @else
        <svg class="w-6 h-6 text-gray-300">
            <path d="m9 18 6-6-6-6" /></svg>
        @endif
    </div>
</div>
