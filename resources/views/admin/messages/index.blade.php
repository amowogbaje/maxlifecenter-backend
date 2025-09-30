@extends('admin.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Message Templates</h1>
        <a href="{{ route('admin.messages.create') }}" 
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700">
            + New Template
        </a>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($messages as $message)
            <div class="bg-white shadow rounded-xl p-5 hover:shadow-lg transition">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">{{ $message->title }}</h2>
                <p class="text-sm text-gray-500 truncate">{{ $message->subject }}</p>
                <div class="mt-4 flex space-x-3">
                    <a href="{{ route('admin.messages.preview', $message) }}" 
                       class="text-indigo-600 hover:underline">Preview</a>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">No message templates yet.</p>
        @endforelse
    </div>
</div>
@endsection
