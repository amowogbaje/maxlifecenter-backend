<div class="space-y-3">
    @foreach($users as $user)
    <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 overflow-hidden">
        <div class="flex items-center gap-4 lg:gap-6 min-w-0">
            <div class="flex-shrink-0">
                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                    class="user-checkbox w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                    {{ in_array($user->id, $selectedUserIds ?? []) ? 'checked' : '' }}>
            </div>
            <div class="flex-1 min-w-0">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div><span class="font-bold text-gray-800 truncate">{{ $user->full_name }}</span></div>
                    <div><span class="text-gray-700 truncate">{{ $user->email }}</span></div>
                    <div><span class="text-gray-700 truncate">{{ $user->approvedTier->title }}</span></div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
