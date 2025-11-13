@extends('admin.layouts.app')

@section('content')
<div x-data="dashboard()" x-cloak class="p-[50px] pt-[23px]">
    <!-- Greeting -->
    <div class="mb-[38px]">
        <h1 class="text-2xl font-bold text-gray-900 mb-1">Hi, Kemi Wale</h1>
        <p class="text-base">
            <span class="font-bold text-gray-700">Take a look your overview </span>
            <span class="font-extrabold text-gray-900" x-text="currentDate"></span>
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-3 gap-[23px] mb-[26px]">
        <template x-for="(card, index) in statsCards" :key="index">
            <div class="bg-white rounded-[24px] shadow-[0_6px_58px_0_rgba(196,203,214,0.10)] p-5 h-[146px] flex flex-col">
                <div :class="card.bgColor" class="w-[26px] h-[26px] rounded-full flex items-center justify-center mb-[8px]">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-html="card.icon"></path>
                    </svg>
                </div>
                <span class="text-[10px] text-gray-500 mb-[7px]" x-text="card.title"></span>
                <span class="text-2xl font-bold text-gray-900 mb-auto" x-text="card.value"></span>
                <div class="flex justify-end">
                    <span :class="card.changeColor" class="text-xs font-bold px-2.5 py-1 rounded-[18px]" x-text="card.change"></span>
                </div>
            </div>
        </template>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_365px] gap-[30px]">
        <!-- Left Column -->
        <div class="space-y-[31px]">
            <!-- Sales Chart -->
            <div class="bg-white rounded-[18px] p-[26px]">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Products Sales Over time</h2>
                    <button class="flex items-center gap-2 px-[6px] py-[6px] rounded-[2.5px] border border-gray-400 bg-gray-50">
                        <span class="text-[9px] text-black" x-text="selectedYear"></span>
                        <svg class="w-[11px] h-[11px] text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Chart Area -->
                <div class="relative h-[372px]">
                    <!-- Y-axis labels -->
                    <div class="absolute left-0 top-0 h-[328px] flex flex-col justify-between items-end text-xs font-medium text-black w-[28px]">
                        <template x-for="label in yAxisLabels" :key="label">
                            <span x-text="label"></span>
                        </template>
                    </div>

                    <!-- Chart area -->
                    <div class="absolute left-[37px] top-0 right-0 h-[349px]">
                        <!-- Grid lines -->
                        <div class="absolute inset-0 flex flex-col justify-between">
                            <template x-for="i in 8" :key="i">
                                <div class="h-[0.85px] bg-gray-300"></div>
                            </template>
                        </div>

                        <!-- Line chart with gradient -->
                        <svg class="absolute inset-0 w-full h-[328px]" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="salesGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#00E096" stop-opacity="0.33"></stop>
                                    <stop offset="100%" stop-color="#00E096" stop-opacity="0.02"></stop>
                                </linearGradient>
                            </defs>

                            <!-- Area fill -->
                            <path :d="salesAreaPath" fill="url(#salesGradient)"></path>

                            <!-- Line -->
                            <path :d="salesLinePath" stroke="#05C283" stroke-width="1.7" fill="none" stroke-linecap="round"></path>

                            <!-- Data points -->
                            <template x-for="(point, i) in salesData" :key="i">
                                <circle :cx="getXPosition(i)" :cy="getYPosition(point.value)" r="5" fill="#05C283"></circle>
                            </template>
                        </svg>

                        <!-- X-axis labels -->
                        <div class="absolute bottom-[-28px] left-0 right-0 flex justify-between px-[12px] text-xs font-medium text-black">
                            <template x-for="point in salesData" :key="point.month">
                                <span x-text="point.month"></span>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Download link -->
                <div class="flex justify-end mt-4">
                    <button @click="downloadChart('sales')" class="flex items-center gap-1 text-sm text-blue-500 hover:text-blue-700">
                        <span>Download</span>
                        <svg class="w-[14px] h-[14px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Top Selling Products -->
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-[14px]">Top Selling Product</h2>
                <div class="space-y-[15px]">
                    <template x-for="(product, index) in topProducts" :key="index">
                        <div class="bg-white rounded-[18px] p-[14px_18px] flex items-center justify-between hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-[18px]">
                                <div class="w-11 h-11 rounded-full bg-gray-100 border-2 border-white"></div>
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 mb-0.5" x-text="product.name"></h3>
                                    <div class="flex items-center gap-[30px]">
                                        <span class="text-sm text-gray-500" x-text="product.price"></span>
                                        <div class="flex items-center gap-2">
                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div>
                                            <span class="text-sm text-gray-500" x-text="product.sales"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span :class="product.changeColor" class="text-xs font-bold px-2.5 py-1 rounded-lg" x-text="product.change"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-[24px]">
            <!-- Pie Chart -->
            <div class="bg-white rounded-[24px] p-[14px_14px_0]">
                <h2 class="text-lg font-semibold text-gray-900 mb-[25px]">Sales by category</h2>

                <div class="flex items-center gap-[15px] mb-[25px]">
                    <!-- Pie Chart SVG -->
                    <svg width="229" height="179" viewBox="0 0 229 179" class="flex-shrink-0">
                        <path d="M114.5 178.615C97.8771 178.615 81.5841 173.976 67.4546 165.219C53.3251 156.462 41.92 143.936 34.5227 129.05C27.1254 114.164 24.0296 97.5083 25.5836 80.9582C27.1377 64.4081 33.2799 48.6202 43.3191 35.3713C53.3583 22.1223 66.896 11.9382 82.4086 5.965C97.9212 -0.00819969 114.793 -1.53337 131.125 1.56112C147.458 4.65562 162.602 12.247 174.854 23.4808C187.107 34.7147 195.981 49.1451 200.478 65.1482L114.5 89.3074L114.5 178.615Z" fill="#FF0408" />
                        <path d="M195.643 52.004C201.9 65.613 204.633 80.5769 203.591 95.5188C202.549 110.461 197.766 124.901 189.682 137.51C181.598 150.119 170.472 160.492 157.328 167.675C144.185 174.858 129.446 178.62 114.468 178.615L114.5 89.3073L195.643 52.004Z" fill="#222683" />
                        <path d="M187.933 38.481C194.967 48.6441 199.815 60.1567 202.171 72.2904C204.526 84.424 204.337 96.9145 201.615 108.971L114.5 89.308L187.933 38.481Z" fill="#FFBE00" />
                        <path d="M124.818 0.598537C137.478 2.07108 149.676 6.23614 160.592 12.8138C171.508 19.3915 180.89 28.2295 188.107 38.7339L114.5 89.3079L124.818 0.598537Z" fill="#D377F3" />
                        <path d="M59.4768 18.9633C69.2124 11.3481 80.4227 5.83666 92.3983 2.77779C104.374 -0.281071 116.854 -0.820789 129.049 1.19279L114.5 89.3072L59.4768 18.9633Z" fill="#4A86E4" />
                        <path d="M25.2711 93.0523C24.55 75.8745 28.8026 58.8536 37.5183 44.0335C46.234 29.2135 59.0423 17.2242 74.4052 9.50537L114.5 89.3065L25.2711 93.0523Z" fill="#5D923D" />
                    </svg>

                    <!-- Legend -->
                    <div class="flex-1 space-y-[4px]">
                        <template x-for="(item, index) in pieChartData" :key="index">
                            <div class="flex items-center gap-[4px]">
                                <div class="w-[5.5px] h-[5.5px]" :style="`background-color: ${item.color}`"></div>
                                <span class="text-[11px] text-gray-900" x-text="item.label"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex justify-end pb-[14px] pr-[14px]">
                    <button @click="downloadChart('pie')" class="flex items-center gap-1 text-sm text-blue-500 hover:text-blue-700">
                        <span>Download</span>
                        <svg class="w-[14px] h-[14px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="bg-white rounded-[18px] p-[14px]">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Sales by category</h2>
                    <button class="flex items-center gap-2 px-[6px] py-[6px] rounded-[2.5px] border border-gray-400 bg-gray-50">
                        <span class="text-[9px] text-black" x-text="selectedYear"></span>
                        <svg class="w-[11px] h-[11px] text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Bar Chart -->
                <div class="relative h-[285px]">
                    <!-- Y-axis labels -->
                    <div class="absolute left-0 top-[4px] h-[252px] flex flex-col justify-between text-[8px] font-medium text-black">
                        <template x-for="item in [...categoryData].reverse()" :key="item.month">
                            <span x-text="item.month"></span>
                        </template>
                    </div>

                    <!-- Bars -->
                    <div class="absolute left-[23px] top-[4px] right-0 h-[252px] flex flex-col justify-between">
                        <template x-for="(item, index) in [...categoryData].reverse()" :key="index">
                            <div class="h-[14px] bg-blue-500 rounded-r transition-all duration-500 hover:bg-blue-600" :style="`width: ${(item.percentage / 100) * 302}px`" x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                <div x-show="tooltip" class="absolute -top-8 left-0 bg-black text-white text-xs px-2 py-1 rounded whitespace-nowrap" x-text="`${item.percentage}%`"></div>
                            </div>
                        </template>
                    </div>

                    <!-- X-axis labels -->
                    <div class="absolute bottom-0 left-[30px] right-0 flex justify-between text-[8px] font-medium text-black">
                        <span>20%</span>
                        <span>40%</span>
                        <span>60%</span>
                        <span>80%</span>
                        <span>100%</span>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button @click="downloadChart('bar')" class="flex items-center gap-1 text-sm text-blue-500 hover:text-blue-700">
                        <span>Download</span>
                        <svg class="w-[14px] h-[14px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboard', () => ({
                // State
                searchQuery: '',
                selectedYear: '2025',
                currentDate: new Date().toLocaleDateString('en-US', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                }),

              
                // Stats Cards
                statsCards: [
                    {
                        title: "Total Sales",
                        value: "₦120,000",
                        change: "+5.4%",
                        icon: 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
                        bgColor: "bg-red-500",
                        changeColor: "text-gray-500 bg-gray-50",
                    },
                    {
                        title: "Total Order",
                        value: "146",
                        change: "+5.4%",
                        icon: 'M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5.5M7 13l2.5 5.5m5.5-5.5h.01M17 13h.01',
                        bgColor: "bg-blue-500",
                        changeColor: "text-gray-500 bg-gray-50",
                    },
                    {
                        title: "Total Sold Product",
                        value: "106",
                        change: "+5.4%",
                        icon: 'M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5.5M7 13l2.5 5.5m5.5-5.5h.01M17 13h.01',
                        bgColor: "bg-blue-500",
                        changeColor: "text-gray-500 bg-gray-50",
                    },
                ],

                // Chart Data
                salesData: [
                    { month: "Jan", value: 47 },
                    { month: "Feb", value: 73 },
                    { month: "Mar", value: 76 },
                    { month: "Apr", value: 55 },
                    { month: "May", value: 73 },
                    { month: "Jun", value: 101 },
                    { month: "Jul", value: 77 },
                    { month: "Aug", value: 48 },
                    { month: "Sep", value: 70 },
                    { month: "Oct", value: 115 },
                    { month: "Nov", value: 125 },
                    { month: "Dec", value: 48 },
                ],

                categoryData: [
                    { month: "Jan", percentage: 74 },
                    { month: "Feb", percentage: 27 },
                    { month: "Mar", percentage: 54 },
                    { month: "Apr", percentage: 59 },
                    { month: "May", percentage: 82 },
                    { month: "Jun", percentage: 67 },
                    { month: "Jul", percentage: 51 },
                    { month: "Aug", percentage: 92 },
                    { month: "Sep", percentage: 67 },
                    { month: "Oct", percentage: 54 },
                    { month: "Nov", percentage: 27 },
                    { month: "Dec", percentage: 74 },
                ],

                pieChartData: [
                    { label: "Name", color: "#FFBE00", percentage: 16 },
                    { label: "Name", color: "#D377F3", percentage: 5 },
                    { label: "Name", color: "#222683", percentage: 20 },
                    { label: "Name", color: "#4A86E4", percentage: 22 },
                    { label: "Name", color: "#EF746D", percentage: 19 },
                    { label: "Name", color: "#5D923D", percentage: 18 },
                ],

                topProducts: [
                    {
                        name: "Product Name",
                        price: "₦100,000",
                        sales: "247+ sales",
                        change: "+5.4%",
                        changeColor: "text-gray-500 bg-gray-50",
                    },
                    {
                        name: "Product Name",
                        price: "₦100,000",
                        sales: "247+ sales",
                        change: "-5.4%",
                        changeColor: "text-red-500 bg-red-50",
                    },
                ],

                // Y-axis labels for chart
                yAxisLabels: ['800k', '700k', '600k', '500k', '400k', '300k', '200k', '100k'],

                

                getXPosition(index) {
                    return (index * 531) / 11;
                },

                getYPosition(value) {
                    return 328 - (value / 125) * 273;
                },

                downloadChart(type) {
                    alert(`Downloading ${type} chart data...`);
                    // In a real app, this would trigger actual download
                },

                // Computed properties
                get salesLinePath() {
                    return `M 0,${this.getYPosition(this.salesData[0].value)} ${this.salesData
                        .map((point, i) => `L ${this.getXPosition(i)},${this.getYPosition(point.value)}`)
                        .join(' ')}`;
                },

                get salesAreaPath() {
                    return `${this.salesLinePath} L 531,273 L 0,273 Z`;
                }
            }));
        });
    </script>
@endpush