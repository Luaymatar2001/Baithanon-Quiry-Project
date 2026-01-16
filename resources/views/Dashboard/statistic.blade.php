@extends('layouts.dashboard')

@section('title', 'صفحة الإحصائيات')

@section('page-title')
الإحصائيات
@endsection

@section('breadcrumb')
<a href="#">الرئيسية</a> &raquo;
<a href="#">الإحصائيات</a> &raquo;
إضافة
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">

            <!-- Total Heads of Households -->
            <div
                class="animate-[fadeIn_0.6s_ease-in-out] relative overflow-hidden rounded-2xl bg-gradient-to-br from-green-500 to-green-700 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 opacity-20 text-white text-8xl p-4">
                    <i class="fa-solid fa-house-user"></i>
                </div>
                <div class="p-6 text-white">
                    <p class="text-sm opacity-80">العدد الكلي لأرباب الأسر</p>
                    <p class="mt-2 text-3xl font-bold">{{ $totalHeads }}</p>
                    <div class="mt-4 h-1 w-16 bg-white/40 rounded-full"></div>
                </div>
            </div>

            <!-- Children + Wives -->
            <div
                class="animate-[fadeIn_0.6s_ease-in-out] relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 opacity-20 text-white text-8xl p-4">
                    <i class="fa-solid fa-people-group"></i>
                </div>
                <div class="p-6 text-white">
                    <p class="text-sm opacity-80">الأبناء والأزواج</p>
                    <p class="mt-2 text-3xl font-bold">{{ $totalChildren + $totalWives }}</p>
                    <div class="mt-4 h-1 w-16 bg-white/40 rounded-full"></div>
                </div>
            </div>

            <!-- Homepage Visits -->
            <div
                class="animate-[fadeIn_0.6s_ease-in-out] relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 opacity-20 text-white text-8xl p-4">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div class="p-6 text-white">
                    <p class="text-sm opacity-80">زيارات الصفحة الرئيسية</p>
                    <p class="mt-2 text-3xl font-bold">{{ $homepageVisits }}</p>
                    <div class="mt-4 h-1 w-16 bg-white/40 rounded-full"></div>
                </div>
            </div>

            <!-- Data Updates -->
            <div
                class="animate-[fadeIn_0.6s_ease-in-out] relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-500 to-purple-700 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 opacity-20 text-white text-8xl p-4">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div class="p-6 text-white">
                    <p class="text-sm opacity-80">تحديثات البيانات</p>
                    <p class="mt-2 text-3xl font-bold">{{ $dataUpdates }}</p>
                    <div class="mt-4 h-1 w-16 bg-white/40 rounded-full"></div>
                </div>
            </div>

            <!-- Submitted Declarations -->
            <div
                class="animate-[fadeIn_0.6s_ease-in-out] relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-500 to-orange-700 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 opacity-20 text-white text-8xl p-4">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <div class="p-6 text-white">
                    <p class="text-sm opacity-80">الإقرارات المقدمة</p>
                    <p class="mt-2 text-3xl font-bold">{{ $submittedDeclarations }}</p>
                    <div class="mt-4 h-1 w-16 bg-white/40 rounded-full"></div>
                </div>
            </div>

            <!-- Total Cities -->
            <div
                class="animate-[fadeIn_0.6s_ease-in-out] relative overflow-hidden rounded-2xl bg-gradient-to-br from-red-500 to-red-700 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 opacity-20 text-white text-8xl p-4">
                    <i class="fa-solid fa-city"></i>
                </div>
                <div class="p-6 text-white">
                    <p class="text-sm opacity-80">عدد المدن</p>
                    <p class="mt-2 text-3xl font-bold">{{ $totalCities }}</p>
                    <div class="mt-4 h-1 w-16 bg-white/40 rounded-full"></div>
                </div>
            </div>

            <!-- Total Governorates -->
            <div
                class="animate-[fadeIn_0.6s_ease-in-out] relative overflow-hidden rounded-2xl bg-gradient-to-br from-teal-500 to-teal-700 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 opacity-20 text-white text-8xl p-4">
                    <i class="fa-solid fa-earth-asia"></i>
                </div>
                <div class="p-6 text-white">
                    <p class="text-sm opacity-80">عدد المحافظات</p>
                    <p class="mt-2 text-3xl font-bold">{{ $totalGovernorates }}</p>
                    <div class="mt-4 h-1 w-16 bg-white/40 rounded-full"></div>
                </div>
            </div>

            <!-- Total Regions -->
            <div
                class="animate-[fadeIn_0.6s_ease-in-out] relative overflow-hidden rounded-2xl bg-gradient-to-br from-yellow-500 to-yellow-700 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 opacity-20 text-white text-8xl p-4">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <div class="p-6 text-white">
                    <p class="text-sm opacity-80">عدد المناطق</p>
                    <p class="mt-2 text-3xl font-bold">{{ $totalRegions }}</p>
                    <div class="mt-4 h-1 w-16 bg-white/40 rounded-full"></div>
                </div>
            </div>

            <!-- Admin Users -->
            <div
                class="animate-[fadeIn_0.6s_ease-in-out] relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-500 to-pink-700 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 opacity-20 text-white text-8xl p-4">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="p-6 text-white">
                    <p class="text-sm opacity-80">مستخدمي لوحة التحكم</p>
                    <p class="mt-2 text-3xl font-bold">{{ $totalAdmins }}</p>
                    <div class="mt-4 h-1 w-16 bg-white/40 rounded-full"></div>
                </div>
            </div>

        </div>
    </div>

    <!-- Distribution Table -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl p-6">
        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">
            Distribution of Heads of Households by Governorate and Region
        </h3>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 dark:border-gray-700 text-sm">
                <thead
                    class="bg-gradient-to-r from-green-200 to-green-400 dark:from-gray-700 dark:to-gray-600 sticky top-0 z-10">
                    <tr>
                        <th
                            class="px-6 py-3 text-right font-semibold text-gray-800 dark:text-gray-200 uppercase tracking-wider">
                            Governorate
                        </th>
                        <th
                            class="px-6 py-3 text-right font-semibold text-gray-800 dark:text-gray-200 uppercase tracking-wider">
                            Region
                        </th>
                        <th
                            class="px-6 py-3 text-center font-semibold text-gray-800 dark:text-gray-200 uppercase tracking-wider">
                            Count
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($distribution as $item)
                    <tr class="hover:bg-green-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                            {{ $item->governorate }}
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                            {{ $item->region }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span
                                class="inline-flex items-center justify-center px-4 py-1 text-sm font-semibold rounded-full bg-gradient-to-r from-blue-300 to-blue-500 text-white shadow">
                                {{ $item->count }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                            No data available
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@endsection