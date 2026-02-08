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

    <div class="space-y-4">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-foreground">Admin List</h2>
            <div x-data="{ openCreateModal: {{ $errors->any() ? 'true' : 'false' }} }" x-cloak>
                <!-- Create Button -->
                <button @click="openCreateModal = true" class="h-12 px-6 flex items-center justify-center bg-blue-500 text-white rounded-[14px] font-semibold shadow hover:bg-blue-600 transition">
                    + Create
                </button>

                <!-- Modal Overlay -->
                <div x-show="openCreateModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">

                    <!-- Modal -->
                    <div @click.outside="openCreateModal = false" class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 relative">

                        <button @click="openCreateModal = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-2xl">&times;
                        </button>

                        <h2 class="text-lg font-bold mb-4 text-gray-800">Create New Admin</h2>

                        <!-- Create Admin Form -->
                        <form method="POST" action="{{ route('admin.list.store') }}" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border rounded-lg p-2.5 focus:ring focus:ring-blue-200" required>
                                @error('first_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border rounded-lg p-2.5 focus:ring focus:ring-blue-200" required>
                                @error('last_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg p-2.5 focus:ring focus:ring-blue-200" required>
                                @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                                <input type="password" name="password" class="w-full border rounded-lg p-2.5 focus:ring focus:ring-blue-200" required>
                                @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
                                <select name="role_id" class="w-full border rounded-lg p-2.5 focus:ring focus:ring-blue-200" required>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ ucwords($role->name) }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end gap-3 pt-4">
                                <button type="button" @click="openCreateModal = false" class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-100">
                                    Cancel
                                </button>

                                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600 shadow">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>






        </div>

        <div class="space-y-3">
            @if($admins->count() > 0)
            @foreach($admins as $admin)
            <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 overflow-hidden">
                <div class="flex items-center gap-4 lg:gap-6 min-w-0">
                    <div class="w-[50px] h-[50px] bg-gray-300 rounded-full border-2 border-white relative flex-shrink-0 flex items-center justify-center">
                        <div class="w-9 h-9 bg-success rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 23 22" fill="currentColor">
                                <path d="M15.6899 5.71106C16.0368 5.71106 16.3234 5.95161 16.3688 6.26372L16.375 6.35048V17.9605C16.375 18.3137 16.0683 18.5999 15.6899 18.5999C15.3431 18.5999 15.0565 18.3594 15.0111 18.0473L15.0049 17.9605V6.35048C15.0049 5.99734 15.3116 5.71106 15.6899 5.71106Z" />
                                <path d="M18.9292 14.0172C19.1961 13.7669 19.6299 13.766 19.8981 14.0151C20.1419 14.2416 20.1649 14.5968 19.9665 14.8475L19.9003 14.9194L16.1754 18.412C15.932 18.6403 15.5499 18.6611 15.2813 18.4743L15.2043 18.412L11.4794 14.9194C11.2125 14.6691 11.2135 14.2642 11.4817 14.0151C11.7254 13.7886 12.1061 13.7688 12.3738 13.9551L12.4505 14.0172L15.6895 17.054L18.9292 14.0172Z" />
                                <path d="M6.6207 3.39758C6.96754 3.39758 7.25418 3.63814 7.29955 3.95024L7.3058 4.03701V15.647C7.3058 16.0002 6.99907 16.2865 6.6207 16.2865C6.27387 16.2865 5.98723 16.0459 5.94186 15.7338L5.93561 15.647V4.03701C5.93561 3.68386 6.24234 3.39758 6.6207 3.39758Z" />
                                <path d="M6.13525 3.58542C6.37871 3.35715 6.76076 3.33639 7.02942 3.52317L7.10636 3.58542L10.8313 7.07809C11.0982 7.32838 11.0972 7.73324 10.829 7.98237C10.5852 8.20886 10.2046 8.22867 9.93683 8.04236L9.86014 7.98028L6.6206 4.94251L3.38147 7.98028C3.1388 8.20782 2.75825 8.22927 2.48959 8.04412L2.4126 7.98237C2.16881 7.75589 2.14582 7.4007 2.3442 7.14995L2.41036 7.07809L6.13525 3.58542Z" /></svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-4 lg:gap-6">
                            <div class="flex flex-col gap-1 min-w-0">
                                <span class="text-sm text-text-light truncate">Name</span>
                                <span class="text-base font-bold text-text-dark truncate" title="{{ $admin->full_name }}">{{ $admin->full_name }}</span>
                            </div>
                            <div class="flex flex-col gap-1 min-w-0 sm:col-span-2 lg:col-span-1">
                                <span class="text-sm text-text-light">Email</span>
                                <span class="text-xs lg:text-base text-text-dark truncate" title="{{ $admin->email }}">{{ $admin->email }}</span>
                            </div>
                            <div class="flex flex-col gap-1 min-w-0 sm:col-span-2 lg:col-span-1">
                                <span class="text-sm text-text-light">Role</span>
                                <span class="text-xs lg:text-base text-text-dark truncate" title="{{ $admin->role->name }}">{{ ucwords($admin->role->name) }}</span>
                            </div>

                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.list.show', ['id' => $admin->id])}}" class="hidden sm:flex w-9 h-9 lg:w-11 lg:h-11 bg-light-blue rounded-[10px] lg:rounded-[14px] items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-black" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a> --}}
                </div>
            </div>
            @endforeach
            @else
            <div class="bg-white rounded-[24px] shadow-sm p-6 text-center">
                <svg class="mx-auto w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75h4.5m-2.25-2.25v4.5M12 3v1.5m0 15V21m9-9h-1.5M4.5 12H3m16.364 7.364l-1.061-1.061M6.697 6.697L5.636 5.636m12.728 0l-1.061 1.061M6.697 17.303l-1.061 1.061" />
                </svg>
                <p class="text-gray-500 text-sm lg:text-base">No admins found.</p>
            </div>
            @endif
        </div>

        <div class="flex justify-center lg:justify-end mt-4">
            <div class="bg-white rounded-[14px] shadow-sm px-5 py-3 flex items-center gap-4">
                <span class="text-base text-text-dark">
                    {{ $admins->firstItem() }}-{{ $admins->lastItem() }} of {{ $admins->total() }}
                </span>

                @if($admins->onFirstPage())
                <svg class="w-6 h-6 text-gray-300">
                    <path d="m15 18-6-6 6-6" /></svg>
                @else
                <a href="{{ $admins->previousPageUrl() }}">
                    <svg class="w-6 h-6 text-blue-500">
                        <path d="m15 18-6-6 6-6" /></svg>
                </a>
                @endif

                @if($admins->hasMorePages())
                <a href="{{ $admins->nextPageUrl() }}">
                    <svg class="w-6 h-6 text-blue-500">
                        <path d="m9 18 6-6-6-6" /></svg>
                </a>
                @else
                <svg class="w-6 h-6 text-gray-300">
                    <path d="m9 18 6-6-6-6" /></svg>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
