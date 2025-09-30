```blade
@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Preview Message</h1>
        <a href="{{ route('admin.messages.index') }}" 
           class="text-sm text-blue-600 hover:underline">
            ← Back to Messages
        </a>
    </div>

    <!-- Message Card -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-700">{{ $message->subject }}</h2>
        </div>
        <div class="px-6 py-6 prose max-w-none text-gray-700">
            {!! nl2br(e($message->body)) !!}
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-8 bg-white shadow rounded-xl p-6 space-y-6">
        <!-- Send to Reward Level -->
        <form method="POST" action="{{ route('admin.messages.send', $message) }}" class="space-y-4">
            @csrf
            <div>
                <label for="reward_level" class="block text-sm font-medium text-gray-700 mb-1">
                    Select Reward Level
                </label>
                <select name="reward_level" id="reward_level" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                        required>
                    <option value="">-- Select Reward Level --</option>
                    @foreach($rewardLevels as $level)
                        <option value="{{ $level->id }}">{{ $level->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center space-x-3">
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow font-medium">
                    🚀 Send to Users
                </button>
            </div>
        </form>

        <!-- Divider -->
        <div class="flex items-center space-x-2 text-gray-400">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs">OR</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <!-- Send Test Message -->
        <form method="POST" action="{{ route('admin.messages.test', $message) }}">
            @csrf
            <input type="hidden" name="test_email" value="hello@watchlocker.biz">
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow font-medium">
                ✉️ Send Test Message to hello@watchlocker.biz
            </button>
        </form>
    </div>
</div>
@endsection
```
