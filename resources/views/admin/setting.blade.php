@extends('admin.layouts.app')

@section('content')
<div class="p-4 lg:p-[32px] space-y-6 lg:space-y-8">
    <div class="flex flex-col">
        <h1 class="text-xl lg:text-2xl font-bold text-foreground">Hi, Kemi Wale</h1>
        <p class="text-sm lg:text-base font-bold">
            <span class="text-muted-foreground">Take a look your overview </span>
            <span class="text-foreground">Today {{ date('M d, Y') }}</span>
        </p>
    </div>





    <div class="space-y-4">
        <div x-data="{
        activeTab: 'notifications',
        tabTitles: {
            account: 'Account',
            notifications: 'Notifications',
            confidentiality: 'Confidentiality',
            safety: 'Safety',
        },
        account: {
            name: 'John Doe',
            email: 'john.doe@example.com',
            emailNotifications: true,
        },
        notifications: {
            issueActivity: true,
            trackingActivity: false,
            newComments: false,
            quietHours: true,
        },
        confidentiality: {
            profileVisibility: true,
            dataSharing: false,
            twoFactorAuth: true,
            loginAlerts: true,
        },
        safety: {
            blockUsers: true,
            contentFiltering: true,
            reportSharing: false,
            autoLogout: true,
        }
    }" class="min-h-screen lg:flex">

        <div class="hidden lg:block lg:w-[265px] lg:flex-shrink-0">
            <div class="h-screen bg-white shadow-[0_6px_58px_0_rgba(196,203,214,0.10)] lg:rounded-r-[24px]">
                <div class="p-4 sm:p-6 lg:p-8">
                    <div class="space-y-2">
                        <div class="relative">
                            <div x-show="activeTab === 'account'" class="absolute -right-4 sm:-right-6 lg:-right-8 top-1/2 -translate-y-1/2 w-1 h-[52px] bg-black rounded-l-sm" style="display: none;"></div>
                            <button @click="activeTab = 'account'" :class="{
                                'bg-card-light text-text-primary': activeTab === 'account',
                                'text-text-secondary hover:bg-card-light hover:text-text-primary': activeTab !== 'account'
                            }" class="w-full flex items-center gap-3 sm:gap-4 px-3 sm:px-4 lg:px-5 py-3 sm:py-[15px] rounded-[14px] cursor-pointer transition-colors">
                                <div :class="{ 'text-black': activeTab === 'account', 'text-text-secondary': activeTab !== 'account' }">
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <svg width="18" height="20" viewBox="0 0 18 20" fill="currentColor"><path d="M9 10C11.7614 10 14 7.76142 14 5C14 2.23858 11.7614 0 9 0C6.23858 0 4 2.23858 4 5C4 7.76142 6.23858 10 9 10ZM9 12C4.02944 12 0 16.0294 0 21H18C18 16.0294 13.9706 12 9 12Z" /></svg>
                                    </div>
                                </div>
                                <span class="text-sm sm:text-base font-semibold">Account</span>
                            </button>
                        </div>
                        <div class="relative">
                            <div x-show="activeTab === 'notifications'" class="absolute -right-4 sm:-right-6 lg:-right-8 top-1/2 -translate-y-1/2 w-1 h-[52px] bg-black rounded-l-sm" style="display: none;"></div>
                            <button @click="activeTab = 'notifications'" :class="{
                                'bg-card-light text-text-primary': activeTab === 'notifications',
                                'text-text-secondary hover:bg-card-light hover:text-text-primary': activeTab !== 'notifications'
                            }" class="w-full flex items-center gap-3 sm:gap-4 px-3 sm:px-4 lg:px-5 py-3 sm:py-[15px] rounded-[14px] cursor-pointer transition-colors">
                                <div :class="{ 'text-black': activeTab === 'notifications', 'text-text-secondary': activeTab !== 'notifications' }">
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.557 17.103C12.3277 17.103 12.8087 17.9381 12.422 18.6047C11.9211 19.4684 10.9983 20 10 20C9.00166 20 8.07886 19.4684 7.57796 18.6047C7.21064 17.9714 7.62639 17.1861 8.32964 17.1092L8.443 17.103H11.557ZM10 0C13.9511 0 17.169 3.13941 17.2961 7.06012L17.3 7.30112V11.8019C17.3 12.6917 17.9831 13.4218 18.8533 13.4962L19.1332 13.5094C20.2445 13.6286 20.2872 15.2401 19.2614 15.4741L19.1332 15.4954L19 15.5024H1L0.866825 15.4954C-0.288942 15.3714 -0.288942 13.6334 0.866825 13.5094L1.14668 13.4962C1.96851 13.4259 2.62352 12.7708 2.69376 11.9486L2.7 11.8019V7.30112C2.7 3.26886 5.96828 0 10 0ZM10 2C7.14611 2 4.81899 4.25617 4.70442 7.0826L4.7 7.30112V11.8019C4.7 12.3105 4.59742 12.7951 4.41182 13.2362L4.3122 13.453L4.285 13.502H15.714L15.6878 13.453C15.504 13.0848 15.3797 12.6817 15.3276 12.2563L15.3051 11.9984L15.3 11.8019V7.30112C15.3 4.37335 12.9271 2 10 2Z"/></svg>
                                    </div>
                                </div>
                                <span class="text-sm sm:text-base font-semibold">Notifications</span>
                            </button>
                        </div>
                        <div class="relative">
                            <div x-show="activeTab === 'confidentiality'" class="absolute -right-4 sm:-right-6 lg:-right-8 top-1/2 -translate-y-1/2 w-1 h-[52px] bg-black rounded-l-sm" style="display: none;"></div>
                            <button @click="activeTab = 'confidentiality'" :class="{
                                'bg-card-light text-text-primary': activeTab === 'confidentiality',
                                'text-text-secondary hover:bg-card-light hover:text-text-primary': activeTab !== 'confidentiality'
                            }" class="w-full flex items-center gap-3 sm:gap-4 px-3 sm:px-4 lg:px-5 py-3 sm:py-[15px] rounded-[14px] cursor-pointer transition-colors">
                                <div :class="{ 'text-black': activeTab === 'confidentiality', 'text-text-secondary': activeTab !== 'confidentiality' }">
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <svg width="20" height="21" viewBox="0 0 20 21" fill="currentColor"><path d="M16 8V6C16 2.68629 13.3137 0 10 0C6.68629 0 4 2.68629 4 6V8C1.79086 8 0 9.79086 0 12V17C0 19.2091 1.79086 21 4 21H16C18.2091 21 20 19.2091 20 17V12C20 9.79086 18.2091 8 16 8ZM6 6C6 3.79086 7.79086 2 10 2C12.2091 2 14 3.79086 14 6V8H6V6Z" /></svg>
                                    </div>
                                </div>
                                <span class="text-sm sm:text-base font-semibold">Confidentiality</span>
                            </button>
                        </div>
                        <div class="relative">
                            <div x-show="activeTab === 'safety'" class="absolute -right-4 sm:-right-6 lg:-right-8 top-1/2 -translate-y-1/2 w-1 h-[52px] bg-black rounded-l-sm" style="display: none;"></div>
                            <button @click="activeTab = 'safety'" :class="{
                                'bg-card-light text-text-primary': activeTab === 'safety',
                                'text-text-secondary hover:bg-card-light hover:text-text-primary': activeTab !== 'safety'
                            }" class="w-full flex items-center gap-3 sm:gap-4 px-3 sm:px-4 lg:px-5 py-3 sm:py-[15px] rounded-[14px] cursor-pointer transition-colors">
                                <div :class="{ 'text-black': activeTab === 'safety', 'text-text-secondary': activeTab !== 'safety' }">
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <svg width="22" height="21" viewBox="0 0 22 21" fill="currentColor"><path d="M11 0L21 4V12C21 18.075 16.425 20.19 11 21C5.575 20.19 1 18.075 1 12V4L11 0ZM11 2.236L3 5.236V12C3 16.575 6.575 18.19 11 18.905C15.425 18.19 19 16.575 19 12V5.236L11 2.236Z" /></svg>
                                    </div>
                                </div>
                                <span class="text-sm sm:text-base font-semibold">Safety</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:hidden bg-white border-b border-gray-200 px-4 py-3 sticky top-0 z-10">
            <h1 class="text-lg font-bold text-text-primary">
                Settings - <span x-text="tabTitles[activeTab]"></span>
            </h1>
        </div>

        <div class="lg:hidden bg-white border-b border-gray-200 px-4 py-2 sticky top-[57px] z-10">
            <div class="flex gap-2 overflow-x-auto mobile-nav">
                <template x-for="[tabId, title] in Object.entries(tabTitles)" :key="tabId">
                    <button @click="activeTab = tabId" 
                        :class="{
                            'bg-card-light text-text-primary': activeTab === tabId,
                            'text-text-secondary hover:bg-card-light hover:text-text-primary': activeTab !== tabId
                        }"
                        class="px-3 py-2 rounded-lg text-sm font-semibold whitespace-nowrap transition-colors">
                        <span x-text="title"></span>
                    </button>
                </template>
            </div>
        </div>


        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            <div class="max-w-none lg:max-w-[560px] mx-auto lg:mx-0">
                
                <div x-show="activeTab === 'account'" style="display: none;">
                    <div class="bg-white rounded-[14px] sm:rounded-[20px] lg:rounded-[24px] shadow-[0_6px_58px_0_rgba(196,203,214,0.10)] p-4 sm:p-6 lg:p-8">
                        <h1 class="text-base sm:text-lg font-bold text-text-primary mb-4 sm:mb-6">Account</h1>
                        
                        <div class="space-y-4 sm:space-y-6">
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <h3 class="text-sm sm:text-base font-bold text-text-primary mb-3">Profile Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-text-secondary mb-2">Full Name</label>
                                        <input type="text" x-model="account.name" class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-black focus:border-black text-sm sm:text-base" />
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-text-secondary mb-2">Email Address</label>
                                        <input type="email" x-model="account.email" class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-black focus:border-black text-sm sm:text-base" />
                                    </div>
                                </div>
                            </div>

                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <h3 class="text-sm sm:text-base font-bold text-text-primary mb-3">Account Preferences</h3>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm sm:text-base font-bold text-text-primary">Email Notifications</p>
                                        <p class="text-xs sm:text-sm text-text-secondary">Receive account-related emails</p>
                                    </div>
                                    <button @click="account.emailNotifications = !account.emailNotifications" :class="account.emailNotifications ? 'bg-black' : 'bg-switch-inactive'" class="relative inline-flex h-[31px] w-[51px] items-center rounded-[18px] transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                        <div :class="account.emailNotifications ? 'translate-x-[24px]' : 'translate-x-1'" class="inline-block h-[23px] w-[23px] transform rounded-full bg-white transition-transform"></div>
                                    </button>
                                </div>
                            </div>

                            <div class="bg-red-50 rounded-[12px] sm:rounded-[14px] p-4 sm:p-5 border border-red-200">
                                <h3 class="text-sm sm:text-base font-bold text-red-800 mb-3">Danger Zone</h3>
                                <div class="space-y-3">
                                    <button class="w-full sm:w-auto px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-semibold">Delete Account</button>
                                    <p class="text-xs sm:text-sm text-red-600">Once you delete your account, there is no going back. Please be certain.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'notifications'" style="display: none;">
                    <div class="bg-white rounded-[14px] sm:rounded-[20px] lg:rounded-[24px] shadow-[0_6px_58px_0_rgba(196,203,214,0.10)] p-4 sm:p-6 lg:p-8">
                        <h1 class="text-base sm:text-lg font-bold text-text-primary mb-4 sm:mb-6">Notifications</h1>
                        <div class="space-y-3 sm:space-y-4">
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <div class="flex items-start sm:items-center justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm sm:text-base font-bold text-text-primary mb-1">Issue Activity</h3>
                                        <p class="text-xs sm:text-sm font-semibold text-text-secondary leading-relaxed">Send me email notifications for issue activity</p>
                                    </div>
                                    <div class="flex-shrink-0 mt-1 sm:mt-0">
                                        <button @click="notifications.issueActivity = !notifications.issueActivity" :class="notifications.issueActivity ? 'bg-black' : 'bg-switch-inactive'" class="relative inline-flex h-[31px] w-[51px] items-center rounded-[18px] transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                            <div :class="notifications.issueActivity ? 'translate-x-[24px]' : 'translate-x-1'" class="inline-block h-[23px] w-[23px] transform rounded-full bg-white transition-transform"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <div class="flex items-start sm:items-center justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm sm:text-base font-bold text-text-primary mb-1">Tracking Activity</h3>
                                        <p class="text-xs sm:text-sm font-semibold text-text-secondary leading-relaxed">Send me notifications when someone've tracked time in tasks</p>
                                    </div>
                                    <div class="flex-shrink-0 mt-1 sm:mt-0">
                                        <button @click="notifications.trackingActivity = !notifications.trackingActivity" :class="notifications.trackingActivity ? 'bg-black' : 'bg-switch-inactive'" class="relative inline-flex h-[31px] w-[51px] items-center rounded-[18px] transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                            <div :class="notifications.trackingActivity ? 'translate-x-[24px]' : 'translate-x-1'" class="inline-block h-[23px] w-[23px] transform rounded-full bg-white transition-transform"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <div class="flex items-start sm:items-center justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm sm:text-base font-bold text-text-primary mb-1">New Comments</h3>
                                        <p class="text-xs sm:text-sm font-semibold text-text-secondary leading-relaxed">Send me notifications when someone've sent the comment</p>
                                    </div>
                                    <div class="flex-shrink-0 mt-1 sm:mt-0">
                                        <button @click="notifications.newComments = !notifications.newComments" :class="notifications.newComments ? 'bg-black' : 'bg-switch-inactive'" class="relative inline-flex h-[31px] w-[51px] items-center rounded-[18px] transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                            <div :class="notifications.newComments ? 'translate-x-[24px]' : 'translate-x-1'" class="inline-block h-[23px] w-[23px] transform rounded-full bg-white transition-transform"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 sm:mt-8 flex items-start sm:items-center gap-3 sm:gap-4">
                                <div class="flex-shrink-0 mt-0.5 sm:mt-0">
                                    <button @click="notifications.quietHours = !notifications.quietHours" class="w-6 h-6 flex items-center justify-center touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 rounded">
                                        <div :class="notifications.quietHours ? 'bg-text-primary border-text-primary' : 'border-text-secondary bg-white hover:border-text-primary'" class="w-5 h-5 rounded border-2 flex items-center justify-center transition-colors">
                                            <svg x-show="notifications.quietHours" width="14" height="10" viewBox="0 0 14 10" fill="none" class="w-3.5 h-2.5">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.3639 0.879435C13.7266 1.24206 13.7525 1.81391 13.4416 2.20643L13.3639 2.29365L6.29286 9.36472C5.93023 9.72735 5.35839 9.75325 4.96587 9.44242L4.87865 9.36472L0.63601 5.12208C0.245486 4.73155 0.245486 4.09839 0.63601 3.70786C0.99864 3.34523 1.57048 3.31933 1.963 3.63016L2.05022 3.70786L5.58598 7.24254L11.9497 0.879435C12.3123 0.516805 12.8842 0.490903 13.2767 0.801729L13.3639 0.879435Z" fill="white" />
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                                <span class="text-sm sm:text-base text-text-primary leading-relaxed">Don't send me notifications after 9:00 PM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'confidentiality'" style="display: none;">
                    <div class="bg-white rounded-[14px] sm:rounded-[20px] lg:rounded-[24px] shadow-[0_6px_58px_0_rgba(196,203,214,0.10)] p-4 sm:p-6 lg:p-8">
                        <h1 class="text-base sm:text-lg font-bold text-text-primary mb-4 sm:mb-6">Confidentiality</h1>
                        <div class="space-y-3 sm:space-y-4">
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <div class="flex items-start sm:items-center justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm sm:text-base font-bold text-text-primary mb-1">Public Profile</h3>
                                        <p class="text-xs sm:text-sm font-semibold text-text-secondary leading-relaxed">Make your profile visible to other users</p>
                                    </div>
                                    <div class="flex-shrink-0 mt-1 sm:mt-0">
                                        <button @click="confidentiality.profileVisibility = !confidentiality.profileVisibility" :class="confidentiality.profileVisibility ? 'bg-black' : 'bg-switch-inactive'" class="relative inline-flex h-[31px] w-[51px] items-center rounded-[18px] transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                            <div :class="confidentiality.profileVisibility ? 'translate-x-[24px]' : 'translate-x-1'" class="inline-block h-[23px] w-[23px] transform rounded-full bg-white transition-transform"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <div class="flex items-start sm:items-center justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm sm:text-base font-bold text-text-primary mb-1">Data Sharing</h3>
                                        <p class="text-xs sm:text-sm font-semibold text-text-secondary leading-relaxed">Allow sharing anonymized data for analytics</p>
                                    </div>
                                    <div class="flex-shrink-0 mt-1 sm:mt-0">
                                        <button @click="confidentiality.dataSharing = !confidentiality.dataSharing" :class="confidentiality.dataSharing ? 'bg-black' : 'bg-switch-inactive'" class="relative inline-flex h-[31px] w-[51px] items-center rounded-[18px] transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                            <div :class="confidentiality.dataSharing ? 'translate-x-[24px]' : 'translate-x-1'" class="inline-block h-[23px] w-[23px] transform rounded-full bg-white transition-transform"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <div class="flex items-start sm:items-center justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm sm:text-base font-bold text-text-primary mb-1">Two-Factor Authentication</h3>
                                        <p class="text-xs sm:text-sm font-semibold text-text-secondary leading-relaxed">Add an extra layer of security to your account</p>
                                    </div>
                                    <div class="flex-shrink-0 mt-1 sm:mt-0">
                                        <button @click="confidentiality.twoFactorAuth = !confidentiality.twoFactorAuth" :class="confidentiality.twoFactorAuth ? 'bg-black' : 'bg-switch-inactive'" class="relative inline-flex h-[31px] w-[51px] items-center rounded-[18px] transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                            <div :class="confidentiality.twoFactorAuth ? 'translate-x-[24px]' : 'translate-x-1'" class="inline-block h-[23px] w-[23px] transform rounded-full bg-white transition-transform"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <div class="flex items-start sm:items-center justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm sm:text-base font-bold text-text-primary mb-1">Login Alerts</h3>
                                        <p class="text-xs sm:text-sm font-semibold text-text-secondary leading-relaxed">Get notified when someone logs into your account</p>
                                    </div>
                                    <div class="flex-shrink-0 mt-1 sm:mt-0">
                                        <button @click="confidentiality.loginAlerts = !confidentiality.loginAlerts" :class="confidentiality.loginAlerts ? 'bg-black' : 'bg-switch-inactive'" class="relative inline-flex h-[31px] w-[51px] items-center rounded-[18px] transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                            <div :class="confidentiality.loginAlerts ? 'translate-x-[24px]' : 'translate-x-1'" class="inline-block h-[23px] w-[23px] transform rounded-full bg-white transition-transform"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 sm:mt-8 p-4 bg-blue-50 border border-blue-200 rounded-[12px] sm:rounded-[14px]">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 mt-0.5">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-blue-800 mb-1">Privacy Notice</p>
                                        <p class="text-xs text-blue-700 leading-relaxed">We take your privacy seriously. Your data is encrypted and stored securely. You can download or delete your data at any time.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'safety'" style="display: none;">
                    <div class="bg-white rounded-[14px] sm:rounded-[20px] lg:rounded-[24px] shadow-[0_6px_58px_0_rgba(196,203,214,0.10)] p-4 sm:p-6 lg:p-8">
                        <h1 class="text-base sm:text-lg font-bold text-text-primary mb-4 sm:mb-6">Safety</h1>
                        <div class="space-y-3 sm:space-y-4">
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <div class="flex items-start sm:items-center justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm sm:text-base font-bold text-text-primary mb-1">Block Unwanted Users</h3>
                                        <p class="text-xs sm:text-sm font-semibold text-text-secondary leading-relaxed">Automatically block users who send inappropriate content</p>
                                    </div>
                                    <div class="flex-shrink-0 mt-1 sm:mt-0">
                                        <button @click="safety.blockUsers = !safety.blockUsers" :class="safety.blockUsers ? 'bg-black' : 'bg-switch-inactive'" class="relative inline-flex h-[31px] w-[51px] items-center rounded-[18px] transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                            <div :class="safety.blockUsers ? 'translate-x-[24px]' : 'translate-x-1'" class="inline-block h-[23px] w-[23px] transform rounded-full bg-white transition-transform"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <div class="flex items-start sm:items-center justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm sm:text-base font-bold text-text-primary mb-1">Content Filtering</h3>
                                        <p class="text-xs sm:text-sm font-semibold text-text-secondary leading-relaxed">Filter out potentially harmful or offensive content</p>
                                    </div>
                                    <div class="flex-shrink-0 mt-1 sm:mt-0">
                                        <button @click="safety.contentFiltering = !safety.contentFiltering" :class="safety.contentFiltering ? 'bg-black' : 'bg-switch-inactive'" class="relative inline-flex h-[31px] w-[51px] items-center rounded-[18px] transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                            <div :class="safety.contentFiltering ? 'translate-x-[24px]' : 'translate-x-1'" class="inline-block h-[23px] w-[23px] transform rounded-full bg-white transition-transform"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <div class="flex items-start sm:items-center justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm sm:text-base font-bold text-text-primary mb-1">Safety Report Sharing</h3>
                                        <p class="text-xs sm:text-sm font-semibold text-text-secondary leading-relaxed">Share safety reports with platform moderators</p>
                                    </div>
                                    <div class="flex-shrink-0 mt-1 sm:mt-0">
                                        <button @click="safety.reportSharing = !safety.reportSharing" :class="safety.reportSharing ? 'bg-black' : 'bg-switch-inactive'" class="relative inline-flex h-[31px] w-[51px] items-center rounded-[18px] transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                            <div :class="safety.reportSharing ? 'translate-x-[24px]' : 'translate-x-1'" class="inline-block h-[23px] w-[23px] transform rounded-full bg-white transition-transform"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <div class="flex items-start sm:items-center justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm sm:text-base font-bold text-text-primary mb-1">Auto Logout</h3>
                                        <p class="text-xs sm:text-sm font-semibold text-text-secondary leading-relaxed">Automatically log out after 30 minutes of inactivity</p>
                                    </div>
                                    <div class="flex-shrink-0 mt-1 sm:mt-0">
                                        <button @click="safety.autoLogout = !safety.autoLogout" :class="safety.autoLogout ? 'bg-black' : 'bg-switch-inactive'" class="relative inline-flex h-[31px] w-[51px] items-center rounded-[18px] transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                            <div :class="safety.autoLogout ? 'translate-x-[24px]' : 'translate-x-1'" class="inline-block h-[23px] w-[23px] transform rounded-full bg-white transition-transform"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-card-light rounded-[12px] sm:rounded-[14px] p-4 sm:p-5">
                                <h3 class="text-sm sm:text-base font-bold text-text-primary mb-3">Emergency Contacts</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-border">
                                        <div>
                                            <p class="text-sm font-semibold text-text-primary">Emergency Contact 1</p>
                                            <p class="text-xs text-text-secondary">+1 (555) 123-4567</p>
                                        </div>
                                        <button class="text-xs text-blue-600 hover:text-blue-800 font-semibold">Edit</button>
                                    </div>
                                    <button class="w-full p-3 border-2 border-dashed border-border rounded-lg text-sm text-text-secondary hover:border-text-primary hover:text-text-primary transition-colors">+ Add Emergency Contact</button>
                                </div>
                            </div>
                            <div class="mt-6 sm:mt-8 p-4 bg-green-50 border border-green-200 rounded-[12px] sm:rounded-[14px]">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 mt-0.5">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-green-800 mb-1">Safety Resources</p>
                                        <p class="text-xs text-green-700 leading-relaxed mb-2">Need help? Our safety team is available 24/7 to assist you.</p>
                                        <button class="text-xs text-green-800 hover:text-green-900 font-semibold underline">Contact Safety Team</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
    </div>
</div>
@endsection
