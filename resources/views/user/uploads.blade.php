@extends('user.layouts.app') {{-- Or your master layout file --}}

@section('content')
<main class="p-4 lg:p-8">
    <div class="mb-6 lg:mb-8">
        {{-- You can get the authenticated user's name dynamically --}}
        <h1 class="text-xl lg:text-2xl font-bold text-foreground">All Uploads</h1>
        <p class="text-sm lg:text-base font-bold">
            <span class="text-muted-foreground">Take a look your uploads </span>
            <span class="text-foreground">Today {{ date('M d, Y') }}</span>
        </p>
    </div>




    <div class="flex justify-between items-center gap-4 w-full lg:w-auto">
        <div class="relative my-3 flex lg:w-[412px]">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-5 top-1/2 transform -translate-y-1/2 w-5 h-5 text-text-dark">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <input type="text" placeholder="Search" class="w-full h-12 pl-14 pr-4 bg-white rounded-[14px] shadow-sm border-0 text-text-gray" />
        </div>
        <!-- Filter Dropdown -->
        <div class="flex gap-x-4">
            <div x-data="{ open: false }" class="relative inline-block text-left">
                <!-- Filter Button -->
                <button @click="open = !open" class="w-12 h-12 bg-white rounded-[14px] shadow-sm flex items-center justify-center 
               hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 transition" aria-label="Open filters">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                </button>

                <!-- Dropdown Panel -->
                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                    <div class="p-4 space-y-3">
                        <h3 class="text-sm font-semibold text-gray-700">Filters</h3>

                        <!-- Category Filter -->
                        <label class="block">
                            <span class="text-xs text-gray-500">Category</span>
                            <select class="w-full mt-1 border rounded-md p-2 text-sm">
                                <option>All</option>
                                <option>Active</option>
                                <option>Completed</option>
                            </select>
                        </label>

                        <!-- Date Filter -->
                        <label class="block">
                            <span class="text-xs text-gray-500">Date</span>
                            <input type="date" class="w-full mt-1 border rounded-md p-2 text-sm" />
                        </label>

                        <!-- Actions -->
                        <div class="flex justify-end space-x-2 pt-2">
                            <button @click="open = false" class="text-xs text-gray-600 hover:text-gray-900">Reset</button>
                            <button class="px-3 py-1 bg-blue-600 text-white text-xs rounded-md hover:bg-blue-700">Apply</button>
                        </div>
                    </div>
                </div>
            </div>

            <a href="http://koc.test/purchases" class="w-full flex items-center gap-6 px-6 py-3 rounded-[14px] text-left transition-colors  bg-black text-white shadow-[0_6px_12px_rgba(253,199,72,0.29)]">
                <div class="w-6 h-6 flex items-center justify-center">
                    <svg class="w-10 h-10 fill-current text-white" viewBox="0 0 23 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.68539 5.34736L5.34041 12.5194C5.38821 13.0714 5.87812 13.4854 6.47665 13.4854H6.481H18.3333H18.3355C18.9015 13.4854 19.3849 13.0974 19.4652 12.5824L20.4972 6.02336C20.5211 5.86736 20.4787 5.71136 20.3755 5.58536C20.2734 5.45836 20.1235 5.37636 19.9541 5.35436C19.727 5.36236 10.3058 5.35036 4.68539 5.34736ZM6.47448 14.9854C5.04386 14.9854 3.83266 13.9574 3.71643 12.6424L2.7214 1.74836L1.08439 1.48836C0.640099 1.41636 0.343546 1.02936 0.419585 0.620365C0.497797 0.211365 0.926875 -0.054635 1.36139 0.00936497L3.62084 0.369365C3.98474 0.428365 4.26174 0.706365 4.29324 1.04636L4.54851 3.84736C20.0562 3.85336 20.1061 3.86036 20.1811 3.86836C20.7861 3.94936 21.3184 4.24036 21.6812 4.68836C22.0441 5.13536 22.1961 5.68636 22.1092 6.23836L21.0784 12.7964C20.8839 14.0444 19.7064 14.9854 18.3377 14.9854H18.3323H6.48317H6.47448Z"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5908 9.0437H13.5797C13.1289 9.0437 12.765 8.7077 12.765 8.2937C12.765 7.8797 13.1289 7.5437 13.5797 7.5437H16.5908C17.0406 7.5437 17.4056 7.8797 17.4056 8.2937C17.4056 8.7077 17.0406 9.0437 16.5908 9.0437Z"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.00717 17.7019C6.33413 17.7019 6.5981 17.9449 6.5981 18.2459C6.5981 18.5469 6.33413 18.7909 6.00717 18.7909C5.67911 18.7909 5.41515 18.5469 5.41515 18.2459C5.41515 17.9449 5.67911 17.7019 6.00717 17.7019Z"></path>
                        <mask id="mask0_791_5223" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="5" y="17" width="2" height="2">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.4146 18.2454C5.4146 18.5474 5.67857 18.7914 6.00771 18.7914C6.33467 18.7914 6.59864 18.5474 6.59864 18.2454C6.59864 17.9444 6.33467 17.7014 6.00771 17.7014C5.67857 17.7014 5.4146 17.9444 5.4146 18.2454Z" fill="white"></path>
                        </mask>
                        <g mask="url(#mask0_791_5223)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M-0.015686 23.7904H12.03V12.7014H-0.015686V23.7904Z"></path>
                        </g>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.00608 18.0408C5.88333 18.0408 5.78339 18.1328 5.78339 18.2458C5.78339 18.4728 6.22985 18.4728 6.22985 18.2458C6.22985 18.1328 6.12883 18.0408 6.00608 18.0408ZM6.00608 19.5408C5.23048 19.5408 4.60044 18.9598 4.60044 18.2458C4.60044 17.5318 5.23048 16.9518 6.00608 16.9518C6.78168 16.9518 7.4128 17.5318 7.4128 18.2458C7.4128 18.9598 6.78168 19.5408 6.00608 19.5408Z"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.2607 17.7019C18.5876 17.7019 18.8527 17.9449 18.8527 18.2459C18.8527 18.5469 18.5876 18.7909 18.2607 18.7909C17.9326 18.7909 17.6686 18.5469 17.6686 18.2459C17.6686 17.9449 17.9326 17.7019 18.2607 17.7019Z"></path>
                        <mask id="mask1_791_5223" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="17" y="17" width="2" height="2">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6689 18.2454C17.6689 18.5474 17.9328 18.7914 18.2609 18.7914C18.5868 18.7914 18.8529 18.5474 18.8529 18.2454C18.8529 17.9444 18.5868 17.7014 18.2609 17.7014C17.9328 17.7014 17.6689 17.9444 17.6689 18.2454Z" fill="white"></path>
                        </mask>
                        <g mask="url(#mask1_791_5223)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2375 23.7904H24.2843V12.7014H12.2375V23.7904Z"></path>
                        </g>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.2596 18.0408C18.1379 18.0408 18.038 18.1328 18.038 18.2458C18.0391 18.4748 18.4844 18.4728 18.4834 18.2458C18.4834 18.1328 18.3823 18.0408 18.2596 18.0408ZM18.2596 19.5408C17.484 19.5408 16.8539 18.9598 16.8539 18.2458C16.8539 17.5318 17.484 16.9518 18.2596 16.9518C19.0363 16.9518 19.6674 17.5318 19.6674 18.2458C19.6674 18.9598 19.0363 19.5408 18.2596 19.5408Z"></path>
                    </svg>
                </div>
                <span class="font-bold text-base truncate">Purchase History</span>
            </a>
        </div>

    </div>

    <div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3 lg:gap-4">
            @foreach($uploadCards as $card)
            <div class="upload-card relative bg-white rounded-3xl p-4 lg:p-6">
                @include('user.partials.upload-card', ['card' => $card])
            </div>
            @endforeach
        </div>
    </div>
</main>
@endsection

@push('scripts')

@endpush
