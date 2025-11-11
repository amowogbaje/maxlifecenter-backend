@extends('admin.layouts.app')

@section('content')
<div class="p-4 lg:p-[32px] space-y-6 lg:space-y-8">
    <div class="flex flex-col">
        <h1 class="text-xl lg:text-2xl font-bold text-foreground">
            Hi, {{ $admin->full_name }}
        </h1>
        <p class="text-sm lg:text-base font-bold">
            <span class="text-muted-foreground">Take a look at your overview </span>
            <span class="text-foreground">Today {{ date('M d, Y') }}</span>
        </p>
    </div>

    <div class="space-y-4">
        <div class="w-full max-w-4xl bg-white rounded-[20px] shadow-lg p-8 md:p-12">

            <!-- Form fields -->
            <form id="profileForm">
                @csrf
                <input type="hidden" name="user_id" value="{{ $admin->id }}">
                <div class="grid gap-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="text-gray-700 text-sm font-bold">First Name</label>
                            <input type="text" name="first_name" value="{{ $admin->first_name }}" readonly
                                class="w-full h-12 px-4 rounded-[14px] border border-gray-300 text-gray-700 text-sm shadow-sm focus:outline-none">
                        </div>

                        <div class="space-y-2">
                            <label class="text-gray-700 text-sm font-bold">Last Name</label>
                            <input type="text" name="last_name" value="{{ $admin->last_name }}" readonly
                                class="w-full h-12 px-4 rounded-[14px] border border-gray-300 text-gray-700 text-sm shadow-sm focus:outline-none">
                        </div>

                        <div class="space-y-2">
                            <label class="text-gray-700 text-sm font-bold">Mobile Number</label>
                            <input type="tel" name="phone" value="{{ $admin->phone ?? '' }}" readonly
                                class="w-full h-12 px-4 rounded-[14px] border border-gray-300 text-gray-700 text-sm shadow-sm focus:outline-none">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-gray-700 text-sm font-bold">Email Address</label>
                        <input readonly type="email" readonly value="{{ $admin->email }}"
                            class="w-full h-12 px-4 rounded-[14px] border border-gray-300 text-gray-500 bg-gray-100 text-sm shadow-sm cursor-not-allowed">
                    </div>

                    <div class="space-y-2">
                        <label class="text-gray-700 text-sm font-bold">Bio</label>
                        <textarea name="bio" rows="4" readonly
                            class="w-full p-4 rounded-[14px] border border-gray-300 text-gray-700 text-sm shadow-sm resize-none focus:outline-none">{{ $admin->bio ?? '' }}</textarea>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- Toast Container -->
<div id="toast-container" class="fixed top-5 right-5 space-y-3 z-50"></div>

@endsection
@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Init Flatpickr
    flatpickr("#birthday", {
        dateFormat: "Y-m-d",
        maxDate: "today",
    });

    

    // Handle AJAX submission
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch("{{ route('user.profile.update') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast("success", "Profile updated successfully!");
            } else {
                showToast("error", data.message || "Something went wrong.");
            }
        })
        .catch(() => showToast("⚠️ Something went wrong.", "error"));
    });
</script>
<!-- Toast Container -->


<script>
    function showToast(type, message) {
        // Create wrapper
        const toast = document.createElement("div");
        toast.className = `
            max-w-[350px] bg-white rounded-[16px] shadow-lg p-4 flex items-start gap-3 animate-slideIn
        `;

        // Icon
        let icon = "";
        if (type === "success") {
            icon = `
            <div class="w-[48px] h-[48px] rounded-full flex items-center justify-center bg-green-100">
                <svg width="28" height="28" fill="none" stroke="green" stroke-width="3" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7"></path>
                </svg>
            </div>`;
        } else if (type === "error") {
            icon = `
            <div class="w-[48px] h-[48px] rounded-full flex items-center justify-center bg-red-100">
                <svg width="28" height="28" fill="none" stroke="red" stroke-width="3" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>`;
        }

        // Inner HTML
        toast.innerHTML = `
            ${icon}
            <div>
                <h1 class="font-bold text-gray-800">${type === "success" ? "Success" : "Error"}</h1>
                <p class="text-sm text-gray-600">${message}</p>
            </div>
        `;

        // Append to container
        const container = document.getElementById("toast-container");
        container.appendChild(toast);

        // Auto-remove after 2.5s
        setTimeout(() => {
            toast.classList.add("animate-fadeOut");
            setTimeout(() => toast.remove(), 500);
        }, 2500);
    }
</script>

<!-- Animations -->
<style>
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(100%); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(100%); }
    }
    .animate-slideIn { animation: slideIn 0.4s ease-out; }
    .animate-fadeOut { animation: fadeOut 0.4s ease-in forwards; }
</style>

@endpush
