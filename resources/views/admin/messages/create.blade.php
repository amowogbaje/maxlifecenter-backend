@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white shadow-xl rounded-2xl p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">
            Create Message Template
        </h1>

        <form action="{{ route('admin.messages.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Title -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Title</label>
                <input type="text" name="title" 
                       class="mt-2 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm px-4 py-2" 
                       placeholder="Enter template title" required>
            </div>

            <!-- Subject -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Subject</label>
                <input type="text" name="subject" 
                       class="mt-2 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm px-4 py-2" 
                       placeholder="Enter email subject" required>
            </div>

            <!-- Body -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Body</label>
                <textarea name="body" rows="7"
                          class="mt-2 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm px-4 py-3 resize-none" 
                          placeholder="Write your message body here..." required></textarea>
                <p class="text-xs text-gray-500 mt-2">
                    You can use placeholders like <code class="bg-gray-100 px-1 py-0.5 rounded">{{ '{name}' }}</code>.
                </p>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                <a href="{{ route('admin.messages.index') }}" 
                   class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg shadow-md transition">
                    Save Template
                </button>
            </div>
        </form>
    </div>
</div>
@endsection