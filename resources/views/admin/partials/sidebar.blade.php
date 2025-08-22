<div class="fixed left-0 top-0 w-[325px] h-screen bg-white z-50 flex flex-col transform transition-transform duration-300 ease-in-out lg:translate-x-0" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <div class="lg:hidden flex justify-end p-4">
        <button @click="sidebarOpen = false" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" /></svg>
        </button>
    </div>

    <div class="flex flex-col items-center pt-[70px] lg:pt-[70px] pb-8">
        <div class="w-[74px] h-[74px] bg-green-500/20 rounded-full flex items-center justify-center mb-4">
            <span class="text-2xl font-bold text-success">K</span>
        </div>
        <h2 class="text-2xl font-bold text-foreground">Welcome, Kemi</h2>
    </div>

    <div class="flex-1 px-5 space-y-5 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center gap-6 px-6 py-3 rounded-[14px] text-left transition-colors bg-black text-white shadow-[0_6px_12px_rgba(253,199,72,0.29)]">
            <div class="w-6 h-6 flex items-center justify-center">
                <img src="{{ asset('images/icons/dashboard.svg') }}" alt="Logo" class="w-6 h-6 rounded-full">
            </div>
            <span class="font-bold text-base truncate">Dashboard</span>
        </a>
        <a href="{{ route('admin.purchases') }}" class="w-full flex items-center gap-6 px-6 py-3 rounded-[14px] text-left transition-colors bg-transparent text-muted-foreground hover:bg-muted">
            <div class="w-6 h-6 flex items-center justify-center">
                <img src="{{ asset('images/icons/purchase.svg') }}" alt="Logo" class="w-6 h-6 rounded-full">
            </div>
            <span class="font-bold text-base truncate">Purchase Management</span>
        </a>
        <a href="{{ route('admin.uploads') }}" class="w-full flex items-center gap-6 px-6 py-3 rounded-[14px] text-left transition-colors bg-transparent text-muted-foreground hover:bg-muted">
            <div class="w-6 h-6 flex items-center justify-center">
                <img src="{{ asset('images/icons/upload.svg') }}" alt="Logo" class="w-6 h-6 rounded-full">
            </div>
            <span class="font-bold text-base truncate">Uploads Management</span>
        </a>
        <a href="{{ route('admin.rewards') }}" class="w-full flex items-center gap-6 px-6 py-3 rounded-[14px] text-left transition-colors bg-transparent text-muted-foreground hover:bg-muted">
            <div class="w-6 h-6 flex items-center justify-center">
                <img src="{{ asset('images/icons/rewards.svg') }}" alt="Logo" class="w-6 h-6 rounded-full">
            </div>
            <span class="font-bold text-base truncate">Rewards Management</span>
        </a>
        <a href="{{ route('admin.users') }}" class="w-full flex items-center gap-6 px-6 py-3 rounded-[14px] text-left transition-colors bg-transparent text-muted-foreground hover:bg-muted">
            <div class="w-6 h-6 flex items-center justify-center">
                <img src="{{ asset('images/icons/rewards.svg') }}" alt="Logo" class="w-6 h-6 rounded-full">
            </div>
            <span class="font-bold text-base truncate">Users Management</span>
        </a>
        
        <a href="{{ route('admin.updates') }}" class="w-full flex items-center gap-6 px-6 py-3 rounded-[14px] text-left transition-colors bg-transparent text-muted-foreground hover:bg-muted">
            <div class="w-6 h-6 flex items-center justify-center">
                <img src="{{ asset('images/icons/rewards.svg') }}" alt="Logo" class="w-6 h-6 rounded-full">
            </div>
            <span class="font-bold text-base truncate">Campaign & Updates</span>
        </a>
        <a href="#" class="w-full flex items-center gap-6 px-6 py-3 rounded-[14px] text-left transition-colors bg-transparent text-muted-foreground hover:bg-muted">
            <div class="w-6 h-6 flex items-center justify-center">
                <img src="{{ asset('images/icons/rewards.svg') }}" alt="Logo" class="w-6 h-6 rounded-full">
            </div>
            <span class="font-bold text-base truncate">Analytics</span>
        </a>
        <a href="{{ route('admin.profile')}}" class="w-full flex items-center gap-6 px-6 py-3 rounded-[14px] text-left transition-colors bg-transparent text-muted-foreground hover:bg-muted">
            <div class="w-6 h-6 flex items-center justify-center">
                <img src="{{ asset('images/icons/User-alt.svg') }}" alt="Logo" class="w-6 h-6 rounded-full">
            </div>
            <span class="font-bold text-base truncate">Profile</span>
        </a>
        <a href="{{ route('admin.settings')}}" class="w-full flex items-center gap-6 px-6 py-3 rounded-[14px] text-left transition-colors bg-transparent text-muted-foreground hover:bg-muted">
            <div class="w-6 h-6 flex items-center justify-center">
                <img src="{{ asset('images/icons/settings.svg') }}" alt="Logo" class="w-6 h-6 rounded-full">
            </div>
            <span class="font-bold text-base truncate">Settings</span>
        </a>
        
        {{-- Add other sidebar links here in the same fashion --}}
    </div>

    <div class="p-5 border-t border-gray-100">
        <a href="#" class="flex items-center gap-3 text-foreground hover:text-gray-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
                <line x1="21" x2="9" y1="12" y2="12" /></svg>
            <span class="font-bold text-sm">Log out Account</span>
        </a>
    </div>
</div>
