@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white shadow-xl rounded-2xl p-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b pb-4 mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Edit Subscription List
            </h1>

            @can('view subscription-links')
            <div x-data="{ copied: false }" class="flex items-center gap-2">

                <input type="text" readonly id="subscribe-link" value="{{ config('app.url') }}/api/subscriptions/{{ $subscription->id }}/subscribe">

                <button type="button" @click="
                    const input = document.getElementById('subscribe-link');
                    input.type = 'text';
                    input.select();
                    input.setSelectionRange(0, 99999);
                    document.execCommand('copy');
                    input.type = 'hidden';
                    copied = true;
                    setTimeout(() => copied = false, 2000);" 
                    class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm hover:bg-indigo-700 transition">
                    <span x-show="!copied">Copy Subscribe API</span>
                    <span x-show="copied">Copied ✓</span>
                </button>
            </div>
            @endcan


        </div>


        <form action="{{ route('admin.messages.subscriptions.update', $subscription->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Details Section --}}
            <div class="grid gap-6">
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
            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('admin.messages.subscriptions.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg shadow-md transition">
                    Update Subscription List
                </button>
            </div>



        </form>
        <div class="mt-12">
            {{-- FILTER SECTION --}}
            {{-- <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 border-b pb-6">
                <div class="flex flex-col md:flex-wrap md:flex-row gap-4 md:items-center w-full">
                    <div class="flex-1 min-w-[250px]">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Search Contacts</label>
                        <input type="text" x-model="clientSearch" placeholder="Type to filter contacts..." class="w-full h-11 px-4 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 focus:ring-2 focus:ring-indigo-500" @input="onSearchChange()">
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
            </div> --}}

            {{-- CONTACTS TABLE --}}
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl lg:text-2xl font-bold text-foreground"> Contact List </h2>
                    <span class="text-sm text-gray-500"> {{ $contacts->total() }} contacts </span>
                </div>



                {{-- <div class="flex items-center gap-4 flex-wrap">
                    <div>
                        <select name="perPage" class="border rounded-lg px-2 py-1 text-sm">
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                            <option value="500">500 per page</option>
                            <option value="1000">1000 per page</option>
                        </select>
                    </div>
                </div> --}}

                {{-- Contact list --}}
                <div class="space-y-3 mt-3">
                    @forelse ($contacts as $contact)
                    <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 border hover:border-indigo-100 transition">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <div class="font-bold text-gray-800 truncate">
                                {{ $contact->full_name }}
                            </div>

                            <div class="text-sm text-gray-600 truncate">
                                {{ $contact->email }}
                            </div>

                            <div class="text-sm text-gray-500">
                                Subscribed on {{ $contact->pivot->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        No contacts found for this subscription.
                    </div>
                    @endforelse
                </div>


                {{-- Pagination --}}
                {{-- <div class="flex justify-center lg:justify-end mt-4" x-show="filteredContacts.length > 0">
                    <div class="bg-white rounded-[14px] shadow-sm px-5 py-3 flex items-center gap-4 border">
                        <span class="text-sm text-gray-600">
                            <span x-text="startIndex()"></span>-<span x-text="endIndex()"></span> of <span x-text="filteredContacts.length"></span>
                        </span>

                        <button type="button" @click="prevPage()" :disabled="page === 1" class="p-1 hover:bg-gray-100 rounded disabled:opacity-50" :class="{'cursor-not-allowed': page === 1}">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m15 18-6-6 6-6" /></svg>
                        </button>

                        <button type="button" @click="nextPage()" :disabled="endIndex() >= filteredContacts.length" class="p-1 hover:bg-gray-100 rounded disabled:opacity-50" :class="{'cursor-not-allowed': endIndex() >= filteredContacts.length}">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m9 18 6-6-6-6" /></svg>
                        </button>
                    </div>
                </div> --}}
            </div>
        </div>
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

@endpush
