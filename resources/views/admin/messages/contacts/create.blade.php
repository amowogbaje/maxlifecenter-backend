@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white shadow-xl rounded-2xl p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">
            Create Contact List
        </h1>

        <form action="{{ route('admin.messages.contacts.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Title -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Title</label>
                <input type="text" name="title" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm px-4 py-2" placeholder="Contact List Title here" required>
            </div>

            <!-- Subject -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Description</label>
                <input type="text" name="description" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm px-4 py-2" placeholder="Enter description" required>
            </div>

            


            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                <a href="{{ route('admin.messages.contacts.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg shadow-md transition">
                    Save Contact List
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
        dateFormat: "Y-m-d",
        allowInput: true
    });

    // Select All Functionality
    document.addEventListener("DOMContentLoaded", () => {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('input[name="user_ids[]"]');

        selectAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                if (!cb.checked) selectAll.checked = false;
                else if (Array.from(checkboxes).every(c => c.checked)) selectAll.checked = true;
            });
        });
    });
</script>

@endpush