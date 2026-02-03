@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white shadow-xl rounded-2xl p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">
            Edit Subscription List
        </h1>

        <form action="{{ route('admin.messages.subscriptions.update', $subscription->id) }}" method="POST" class="space-y-8" x-data="subscriptionTable()" x-init="init()">
            @csrf
            @method('PUT')

            {{-- FILTER SECTION --}}
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 border-b pb-6">
                <div class="flex flex-col md:flex-wrap md:flex-row gap-4 md:items-center w-full">
                    <div class="flex-1 min-w-[250px]">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Search Users</label>
                        <input type="text" x-model="clientSearch" placeholder="Type to filter users..." class="w-full h-11 px-4 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 focus:ring-2 focus:ring-indigo-500" @input="onSearchChange()">
                    </div>


                    <div class="flex flex-col sm:flex-row items-center gap-2 min-w-[260px]">
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Start Date</label>
                            <input type="text" x-model="startDate" class="w-full h-11 px-4 rounded-xl border border-gray-200 shadow-sm text-gray-700 flatpickr" placeholder="Start Date" @change="onFilterChange()" x-flatpickr="startDate" />
                        </div>
                        <div class="hidden sm:block text-gray-500 mt-6">to</div>
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">End Date</label>
                            <input type="text" x-model="endDate" class="w-full h-11 px-4 rounded-xl border border-gray-200 shadow-sm text-gray-700 flatpickr" placeholder="End Date" @change="onFilterChange()" x-flatpickr="endDate" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- USERS TABLE --}}
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl lg:text-2xl font-bold text-foreground">User List</h2>
                    <div x-show="loading" class="text-sm text-indigo-600 animate-pulse font-medium">
                        Loading users...
                    </div>
                </div>

                {{-- <div class="text-xs text-gray-500 p-2 bg-gray-100 rounded" x-show="showDebug">
                    <div>Selected users: <span x-text="selected.size"></span></div>
                    <div>Total users loaded: <span x-text="data.length"></span></div>
                    <div>Filtered users: <span x-text="filteredUsers.length"></span></div>
                    <div>Current page: <span x-text="page"></span></div>
                    <div>Showing: <span x-text="startIndex()"></span>-<span x-text="endIndex()"></span></div>
                </div> --}}

                <div class="flex items-center gap-4 flex-wrap">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="select-all" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" :checked="selectAllState" @change="toggleSelectAll($event.target.checked)">
                        <label for="select-all" class="text-sm text-gray-700 cursor-pointer select-none">Select Page</label>
                    </div>

                    <div>
                        <select x-model.number="perPage" class="border rounded-lg px-2 py-1 text-sm" @change="onPerPageChange()">
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                            <option value="500">500 per page</option>
                            <option value="1000">1000 per page</option>
                        </select>
                    </div>
                </div>

                {{-- User list --}}
                <div class="space-y-3 user-list-checkboxes mt-3">
                    <template x-for="user in paginatedUsers" :key="user.id">
                        <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 overflow-hidden border border-transparent hover:border-indigo-100 transition">
                            <div class="flex items-center gap-4 lg:gap-6 min-w-0">
                                <div class="flex-shrink-0">
                                    <input type="checkbox" :value="user.id" :checked="isSelected(user.id)" class="user-checkbox w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" @change="toggleUser($event, user.id)">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                        <div class="font-bold text-gray-800 truncate" x-text="user.full_name"></div>
                                        <div class="text-sm text-gray-600 truncate" x-text="user.email"></div>
                                        <div class="text-sm text-gray-500 truncate">
                                            <span class="bg-gray-100 px-2 py-1 rounded" x-text="user.tier_level || 'No Tier'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div x-show="paginatedUsers.length === 0 && !loading" class="text-center py-8 text-gray-500">
                        No users found matching your search.
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="flex justify-center lg:justify-end mt-4" x-show="filteredUsers.length > 0">
                    <div class="bg-white rounded-[14px] shadow-sm px-5 py-3 flex items-center gap-4 border">
                        <span class="text-sm text-gray-600">
                            <span x-text="startIndex()"></span>-<span x-text="endIndex()"></span> of <span x-text="filteredUsers.length"></span>
                        </span>

                        <button type="button" @click="prevPage()" :disabled="page === 1" class="p-1 hover:bg-gray-100 rounded disabled:opacity-50" :class="{'cursor-not-allowed': page === 1}">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m15 18-6-6 6-6" /></svg>
                        </button>

                        <button type="button" @click="nextPage()" :disabled="endIndex() >= filteredUsers.length" class="p-1 hover:bg-gray-100 rounded disabled:opacity-50" :class="{'cursor-not-allowed': endIndex() >= filteredUsers.length}">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m9 18 6-6-6-6" /></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Hidden inputs for selected users --}}
            <template x-for="userId in Array.from(selected)" :key="userId">
                <input type="hidden" name="user_ids[]" :value="userId" />
            </template>

            {{-- Details Section --}}
            <div class="grid gap-6 border-t pt-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Subscription List Title</label>
                    <input type="text" name="title" value="{{ old('title', $subscription->title) }}" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500 shadow-sm px-4 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Description</label>
                    <input type="text" name="description" value="{{ old('description', $subscription->description) }}" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500 shadow-sm px-4 py-2" required>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                <a href="{{ route('admin.messages.subscriptions.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg shadow-md transition">
                    Update Subscription List
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
    document.addEventListener('alpine:init', () => {
        Alpine.directive('flatpickr', (el, {
            expression
        }, {
            evaluateLater
        }) => {
            let set = evaluateLater(expression);

            flatpickr(el, {
                dateFormat: "Y-m-d"
                , allowInput: true
                , onChange: function(selectedDates, dateStr) {
                    set(() => dateStr);
                    el.dispatchEvent(new Event('input')); // notify Alpine instantly
                }
            });
        });
    });

</script>

<script>
    function subscriptionTable() {
        let debounceTimer;

        function debounce(fn, delay = 400) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fn, delay);
        }

        return {
            // State
            data: []
            , selected: new Set()
            , clientSearch: ''
            , startDate: '{{ request('
            start_date ') }}'
            , endDate: '{{ request('
            end_date ') }}'
            , loading: true
            , perPage: 10
            , page: 1
            , selectAllState: false
            , showDebug: true,

            // Computed
            get filteredUsers() {
                const term = this.clientSearch.trim().toLowerCase();
                return this.data.filter(u => !term || u.full_name.toLowerCase().includes(term) || u.email.toLowerCase().includes(term));
            },

            get paginatedUsers() {
                const start = (this.page - 1) * this.perPage;
                return this.filteredUsers.slice(start, start + this.perPage);
            },

            // Init
            async init() {
                this.initializeSelection();
                await this.loadAllUsers();
            },

            initializeSelection() {
                const saved = @json($selectedUserIds ?? []);
                saved.forEach(id => this.selected.add(Number(id)));
            },

            // Load all users from backend
            async loadAllUsers() {
                this.loading = true;

                const params = new URLSearchParams({
                    start_date: this.startDate || ''
                    , end_date: this.endDate || ''
                    , search: this.clientSearch || ''
                });

                const url = `{{ route('admin.users.fetch.all') }}?${params}`;
                const resp = await fetch(url);
                const users = await resp.json();

                const seen = new Set();
                this.data = users
                    .map(u => ({
                        id: Number(u.user_id)
                        , full_name: u.full_name
                        , email: u.email
                        , tier_level: u.tier_level || ''
                    }))
                    .filter(u => {
                        if (seen.has(u.id)) return false;
                        seen.add(u.id);
                        return true;
                    });

                this.loading = false;
                this.updateSelectAllState();
            },

            // Search / Filters
            async onFilterChange() {
                this.page = 1;
                await this.loadAllUsers();
            }
            , onSearchChange() {
                this.page = 1;
                this.updateSelectAllState();
            }
            , onPerPageChange() {
                this.page = 1;
                this.updateSelectAllState();
            },

            // Selection
            isSelected(id) {
                return this.selected.has(Number(id));
            }
            , toggleUser(e, id) {
                e.target.checked ? this.selected.add(id) : this.selected.delete(id);
                this.updateSelectAllState();
            }
            , toggleSelectAll(checked) {
                this.paginatedUsers.forEach(u => checked ? this.selected.add(u.id) : this.selected.delete(u.id));
                this.updateSelectAllState();
            }
            , updateSelectAllState() {
                this.selectAllState = this.paginatedUsers.length > 0 && this.paginatedUsers.every(u => this.selected.has(u.id));
            },

            // Pagination
            startIndex() {
                return (this.page - 1) * this.perPage + 1;
            }
            , endIndex() {
                return Math.min(this.page * this.perPage, this.filteredUsers.length);
            }
            , prevPage() {
                if (this.page > 1) this.page--;
                this.updateSelectAllState();
            }
            , nextPage() {
                if (this.endIndex() < this.filteredUsers.length) this.page++;
                this.updateSelectAllState();
            }
        };
    }

</script>
@endpush
