@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white shadow-xl rounded-2xl p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">
            Edit Contact List
        </h1>

        <form method="GET" action="{{ route('admin.messages.contacts.edit', $contactList->id) }}" id="filterForm">
            <!-- Filters -->
            @foreach ($selectedUserIds as $id)
                <input type="hidden" name="user_ids[]" value="{{ $id }}">
            @endforeach
            
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <div class="flex flex-col md:flex-wrap md:flex-row gap-4 md:items-center">
                    <!-- Search -->
                    <div class="flex-1 min-w-[250px]">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="w-full h-11 px-4 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 focus:ring-2 focus:ring-indigo-500" />
                    </div>

                    <!-- Reward Filter -->
                    <div class="min-w-[200px]">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Reward</label>
                        <select name="reward_id" class="w-full h-11 px-4 rounded-xl border border-gray-200 shadow-sm text-gray-700 focus:ring-2 focus:ring-indigo-500">
                            <option value="">All Rewards</option>
                            @foreach($rewards as $reward)
                            <option value="{{ $reward->id }}" {{ request('reward_id') == $reward->id ? 'selected' : '' }}>
                                {{ $reward->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div class="flex flex-col sm:flex-row items-center gap-2 min-w-[260px]">
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Start Date</label>
                            <input type="text" name="start_date" id="start_date" value="{{ request('start_date') }}" placeholder="Start Date" class="w-full h-11 px-4 rounded-xl border border-gray-200 shadow-sm text-gray-700 flatpickr" />
                        </div>
                        <div class="hidden sm:block text-gray-500 mt-6">to</div>
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">End Date</label>
                            <input type="text" name="end_date" id="end_date" value="{{ request('end_date') }}" placeholder="End Date" class="w-full h-11 px-4 rounded-xl border border-gray-200 shadow-sm text-gray-700 flatpickr" />
                        </div>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="h-11 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm transition">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <form action="{{ route('admin.messages.contacts.update', $contactList->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            @foreach ($selectedUserIds as $id)
                <input type="hidden" name="user_ids[]" value="{{ $id }}">
            @endforeach

            <!-- Users Section -->
            <div class="space-y-4">
                <h2 class="text-xl lg:text-2xl font-bold text-foreground">User List</h2>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="select-all" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="select-all" class="text-sm text-gray-700 cursor-pointer select-none">Select All</label>
                </div>



                <!-- User Checkboxes -->
                <div class="space-y-3 user-list-checkboxes">
                    @foreach($users as $user)
                    <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 overflow-hidden">
                        <div class="flex items-center gap-4 lg:gap-6 min-w-0">
                            <div class="flex-shrink-0">
                            @php
                                $selectedUserIds = old('user_ids', $selectedUserIds ?? []);
                            @endphp
                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" {{ in_array($user->id, old('user_ids', $selectedUserIds)) ? 'checked' : '' }}>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-4 lg:gap-6">
                                    <div class="flex flex-col gap-1 min-w-0">
                                        <span class="text-base font-bold text-text-dark truncate">{{ $user->full_name }}</span>
                                    </div>
                                    <div class="flex flex-col gap-1 min-w-0 sm:col-span-2 lg:col-span-1">
                                        <span class="text-xs lg:text-base text-text-dark truncate">{{ $user->email }}</span>
                                    </div>
                                    <div class="flex flex-col gap-1 min-w-0">
                                        <span class="text-base text-text-dark truncate">{{ $user->approvedTier->title }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{-- <x-pagination :paginator="$users" /> --}}

                @php
                    $query = http_build_query([
                        'user_ids' => $selectedUserIds,
                        'search' => request('search'),
                        'reward_id' => request('reward_id'),
                        'start_date' => request('start_date'),
                        'end_date' => request('end_date'),
                    ]);
                @endphp

                <div class="flex justify-center lg:justify-end mt-4" id="paginationContainer">
                    <div class="bg-white rounded-[14px] shadow-sm px-5 py-3 flex items-center gap-4">
                        <span class="text-base text-text-dark">
                            {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }}
                        </span>
                        @if($users->onFirstPage())
                        <svg class="w-6 h-6 text-gray-300">
                            <path d="m15 18-6-6 6-6" /></svg>
                        @else
                        <a href="{{ $users->previousPageUrl()  . '&' . $query }}">
                            <svg class="w-6 h-6 text-blue-500">
                                <path d="m15 18-6-6 6-6" /></svg>
                        </a>
                        @endif

                        @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() . '&' . $query }}">
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

            <!-- Title -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Title</label>
                <input type="text" name="title" value="{{ old('title', $contactList->title) }}" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm px-4 py-2" placeholder="Contact List Title here" required>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Description</label>
                <input type="text" name="description" value="{{ old('description', $contactList->description) }}" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm px-4 py-2" placeholder="Enter description" required>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                <a href="{{ route('admin.messages.contacts.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg shadow-md transition">
                    Update Contact List
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr
    flatpickr(".flatpickr", {
        dateFormat: "Y-m-d"
        , allowInput: true
    });

    // Select All Functionality (Edit mode aware)
    document.addEventListener("DOMContentLoaded", () => {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.user-checkbox');

        // Set select all checkbox if all are already checked
        selectAll.checked = Array.from(checkboxes).every(cb => cb.checked);

        selectAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                selectAll.checked = Array.from(checkboxes).every(c => c.checked);
            });
        });
    });

</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector('form[action*="update"]');
    const checkboxes = document.querySelectorAll('.user-checkbox');

    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            if (cb.checked) {
                // add hidden input if not already exists
                if (!form.querySelector(`input[type="hidden"][value="${cb.value}"]`)) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'user_ids[]';
                    hidden.value = cb.value;
                    form.prepend(hidden);
                }
            } else {
                // remove hidden input if unchecked
                const hidden = form.querySelector(`input[type="hidden"][value="${cb.value}"]`);
                if (hidden) hidden.remove();
            }
        });
    });
});
</script>


{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {

        const filterForm = document.getElementById('filterForm'); // or your actual form ID
        const userListContainer = document.getElementById('userListContainer');
        const paginationContainer = document.getElementById('paginationContainer');

        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData).toString();
            const url = "{{ route('admin.messages.contacts.edit', $contactList->id) }}?" + params;

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    userListContainer.innerHTML = data.html;
                    paginationContainer.innerHTML = data.pagination;
                })
                .catch(err => console.error('Error:', err));
        });
    });

</script> --}}

@endpush
