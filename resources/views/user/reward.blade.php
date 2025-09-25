@extends('user.layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Rewards</h1>
            <p class="text-gray-500">Take a look at your reward history</p>
        </div>

    </div>

    <!-- Banner -->
    <div class="rounded-2xl overflow-hidden mb-6">
        <img src="{{ asset('images/reward-banner.jpg')}}" class="w-full" />
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Search + Rewards List -->
        <div class="lg:col-span-2">

            <!-- Search + Filter -->
            <div class="flex flex-col sm:flex-row items-center gap-3 mb-6">
                <div class="flex items-center w-full sm:flex-1 bg-white border rounded-lg px-3 py-2">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" /></svg>
                    <input type="text" placeholder="Search" class="flex-1 outline-none text-gray-600">
                </div>
                <button class="bg-white border rounded-lg px-4 py-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1l-7 8v7l-4-2v-5L3 4z" /></svg>
                </button>
            </div>

            <!-- Rewards List -->
            <div class="space-y-4">
                <!-- Reward Item -->
                <!-- Rewards List -->
                @foreach ($rewards as $reward)
                <div class="flex flex-col md:flex-row md:items-center bg-white p-4 rounded-xl shadow-sm mb-4">
                    <!-- Icon -->
                    <div class="flex-shrink-0 mb-3 md:mb-0 md:mr-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center text-2xl">🎁</div>
                    </div>

                    <!-- Left Info -->
                    <div class="flex-1 mb-3 md:mb-0">
                        <p class="text-sm text-gray-400">{{ $reward->code }}</p>
                        <h3 class="text-base font-bold text-gray-900">{{ $reward->title }}</h3>
                        <p class="text-xs text-gray-500">Created {{ $reward->created_at->format('M d, Y') }}</p>
                    </div>

                    <!-- Description -->
                    <div class="flex-1 mb-3 md:mb-0">
                        <p class="font-semibold text-gray-700">Description</p>
                        <p class="text-xs text-gray-500">
                            {{ $reward->description }}
                        </p>
                    </div>

                    <!-- Button -->
                    <div class="md:ml-4">
                        @if ($reward->pivot->status === 'unclaimed')
                        <button type="button" class="claim-btn w-full md:w-auto bg-black text-white text-sm font-semibold px-4 py-2 rounded-lg" data-id="{{ $reward->pivot->id }}">
                            Claim Reward
                        </button>
                        @elseif ($reward->pivot->status === 'pending')
                        <button disabled class="w-full md:w-auto bg-yellow-500 text-white text-sm font-semibold px-4 py-2 rounded-lg opacity-70 cursor-not-allowed">
                            Pending Approval
                        </button>
                        @elseif ($reward->pivot->status === 'approved')
                        <button disabled class="w-full md:w-auto bg-green-600 text-white text-sm font-semibold px-4 py-2 rounded-lg opacity-70 cursor-not-allowed">
                            Approved
                        </button>
                        @endif
                    </div>

                </div>
                @endforeach

                @if ($rewards->isEmpty())
                <p class="text-center text-sm text-gray-500">No rewards available yet.</p>
                @endif

            </div>

        </div>

        <!-- Right Column: User Summary -->
        <div>
            <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col items-center">
                {{-- <img src="{{ asset('images/profile.jpg')}}" alt="User Avatar" class="w-16 h-16 rounded-full border-4 border-yellow-400 mb-4"> --}}
                <div class="w-full bg-yellow-50 rounded-lg p-4">
                    <div class="flex justify-between text-sm text-gray-500 mb-2">
                        <span>Bonus Point</span>
                        <span>Value Amount</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900">{{$user->bonus_point}}</span>
                        <span class="text-lg font-bold text-green-600">₦{{number_format($user->total_spent,2)}}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.claim-btn').forEach(button => {
            button.addEventListener('click', function() {
                let rewardId = this.dataset.id;
                let btn = this;

                btn.disabled = true;
                btn.textContent = 'Processing...';

                fetch(`/api/rewards/${rewardId}/claim`, {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            btn.classList.remove('bg-black');
                            btn.classList.add('bg-yellow-500', 'opacity-70', 'cursor-not-allowed');
                            btn.textContent = 'Pending Approval';
                        } else {
                            btn.disabled = false;
                            btn.textContent = 'Claim Reward';
                            alert(data.message);
                        }
                    })
                    .catch(err => {
                        btn.disabled = false;
                        btn.textContent = 'Claim Reward';
                        console.error(err);
                        alert('Something went wrong. Try again.');
                    });
            });
        });
    });

</script>

@endpush
