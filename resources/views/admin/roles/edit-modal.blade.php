<!-- ✅ Edit Role Modal -->
<div 
    x-show="showEditModal" 
    x-cloak 
    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40"
    x-transition
>
    <div 
        class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6"
        @click.outside="showEditModal = false"
    >
        <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Role</h2>

        <form 
            method="POST" 
            :action="`/admin/roles/${selectedRole.id}`" 
            class="space-y-4"
        >
            @csrf
            @method('PUT')

            <!-- Role Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
                <input 
                    type="text" 
                    name="name" 
                    x-model="selectedRole.name" 
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required
                >
            </div>

            <!-- Permissions -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                <div class="grid grid-cols-2 gap-2 max-h-56 overflow-y-auto border rounded-lg p-3">
                    @foreach ($permissions as $permission)
                        <label class="flex items-center justify-between p-2 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="text-sm text-gray-800">{{ ucfirst($permission->name) }}</span>
                            <label class="inline-flex relative items-center cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="permissions[]" 
                                    value="{{ $permission->id }}" 
                                    class="sr-only peer"
                                    :checked="selectedRole.permissions.some(p => p.id === {{ $permission->id }})"
                                >
                                <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:bg-blue-500 transition-all"></div>
                                <div class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition-transform"></div>
                            </label>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 mt-6">
                <button 
                    type="button" 
                    @click="showEditModal = false" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                >
                    Update Role
                </button>
            </div>
        </form>
    </div>
</div>
