<header class="bg-white h-auto lg:h-[97px] flex flex-col lg:flex-row items-start lg:items-center justify-between p-4 lg:px-[76px] gap-4 lg:gap-0">
    <div class="flex items-center gap-4 w-full lg:w-auto">
        <button @click="sidebarOpen = true" class="lg:hidden w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
        </button>
        <div class="relative flex-1 lg:w-[403px]">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-text-gray"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" placeholder="Search" class="w-full h-12 pl-12 pr-4 border border-gray-border rounded-[14px] text-text-gray"/>
        </div>
    </div>

    <div class="relative" @click.outside="profileDropdownOpen = false">
        <button @click="profileDropdownOpen = !profileDropdownOpen" class="flex items-center gap-3 lg:gap-5 w-full lg:w-auto justify-between lg:justify-end hover:bg-gray-50 p-2 rounded-lg transition-colors">
            <div class="w-[50px] h-[50px] bg-gray-300 rounded-full border-2 border-white"></div>
            <div class="flex flex-col flex-1 lg:flex-initial min-w-0 text-left">
                <span class="font-bold text-base text-text-dark truncate">{{ auth('admin')->user()->full_name}}</span>
                <span class="text-sm text-text-light truncate">{{ auth('admin')->user()->email}}</span>
            </div>
            <div class="w-7 h-7 bg-purple/20 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 transition-transform duration-200" :class="profileDropdownOpen ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
            </div>
        </button>

        <div 
            x-show="profileDropdownOpen"
            x-transition
            class="absolute right-0 top-full mt-2 w-56 bg-white rounded-[14px] shadow-lg border border-gray-200 py-2 z-50"
            style="display: none;"
        >
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-medium text-text-dark">{{ auth('admin')->user()->full_name}}</p>
                <p class="text-xs text-text-light truncate">{{ auth('admin')->user()->email}}</p>
            </div>
            <div class="py-1">
                <a href="{{ route('admin.profile')}}" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-text-dark hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" /></svg>
                    <span>View Profile</span>
                </a>
                <a href="{{ route('admin.settings')}}" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-text-dark hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 0 2l-.15.08a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.38a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1 0-2l.15-.08a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                        <circle cx="12" cy="12" r="3" /></svg>
                    <span>Settings</span>
                </a>
            </div>
            <div class="border-t border-gray-100 py-1">
                <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" x2="9" y1="12" y2="12" />
                        </svg>
                        <span>Log out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>