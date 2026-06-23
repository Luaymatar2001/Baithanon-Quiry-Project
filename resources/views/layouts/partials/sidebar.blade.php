<!-- Sidebar RTL -->
<aside x-data="{ open: true }" x-on:toggle-sidebar.window="open = !open" class="fixed right-0 h-screen w-64 bg-gray-800 text-blue-100
           transition-transform duration-300 ease-in-out z-40
           top-16 md:top-0
           md:translate-x-0" :class="open ? 'translate-x-0' : 'translate-x-full md:translate-x-0'">

    <!-- Sidebar header -->
    <header class="h-16 flex items-center px-4 shadow-md bg-gray-800 sticky top-0 z-30">
        <a href="#" class="text-white flex items-center space-x-reverse space-x-2">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745" />
            </svg>
            <div>
                <span class="text-l font-bold block">المنظومة الإلكترونية</span>
                <span class="text-xs text-gray-400">لتحديث بيانات أسر مدينة بيت حانون</span>
            </div>
        </a>
    </header>

    <!-- Navigation -->
    <nav class="h-[calc(100vh-64px)] overflow-y-auto px-4 py-4">
        <ul class="space-y-2 text-sm">
            <li>
                <a href="{{route('dashboard')}}"
                    class="flex items-center gap-2 px-2 py-2 rounded hover:bg-gray-700 hover:text-white">
                    لوحة التحكم
                </a>
            </li>
            <div class="border-b border-gray-700 my-4 text-xs text-gray-500">Management</div>
            <li x-data="{ open:false }">
                <button @click="open = !open"
                    class="flex items-center w-full px-2 py-2 rounded hover:bg-gray-700 hover:text-white">
                    <span class="flex-1 text-right">أرباب الأسر</span>
                    <svg class="h-4 w-4 transition-transform" :class="open && 'rotate-180'" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <ul x-show="open" x-collapse class="mt-2 mr-3 border-r border-gray-700 space-y-1 text-xs">
                    <li>
                        <a href="{{ route('headhousehold.index') }}"
                            class="block px-3 py-1 rounded hover:bg-gray-700">عرض البيانات</a>
                    </li>

                    @if(auth()->user()->role === 'supervisor')
                    <li>
                        <a href="{{ route('member-requests.pending') }}"
                            class="block px-3 py-1 rounded hover:bg-gray-700">طلبات إضافة الأفراد</a>
                    </li>

                    <li>
                        <a href="{{ route('marriage-requests.dashboard') }}"
                            class="block px-3 py-1 rounded hover:bg-gray-700">طلبات إضافة
                            حالات زواج</a>
                    </li>
                    @endif
                </ul>

            </li>

            <li x-data="{ open:false }">
                <button @click="open = !open"
                    class="flex items-center w-full px-2 py-2 rounded hover:bg-gray-700 hover:text-white">
                    <span class="flex-1 text-right">جداول الأبناء</span>
                    <svg class="h-4 w-4 transition-transform" :class="open && 'rotate-180'" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <ul x-show="open" x-collapse class="mt-2 mr-3 border-r border-gray-700 space-y-1 text-xs">
                    <li>
                        <a href="{{ route('children.index') }}" class="block px-3 py-1 rounded hover:bg-gray-700">عرض
                            البيانات</a>
                    </li>
                </ul>
            </li>

            <li x-data="{ open:false }">
                <button @click="open = !open"
                    class="flex items-center w-full px-2 py-2 rounded hover:bg-gray-700 hover:text-white">
                    <span class="flex-1 text-right">جداول الأزواج</span>
                    <svg class="h-4 w-4 transition-transform" :class="open && 'rotate-180'" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <ul x-show="open" x-collapse class="mt-2 mr-3 border-r border-gray-700 space-y-1 text-xs">
                    <li>
                        <a href="{{ route('partner.index') }}" class="block px-3 py-1 rounded hover:bg-gray-700">عرض
                            البيانات</a>
                    </li>
                </ul>
            </li>


            <li x-data="{ open:false }">
                <button @click="open = !open"
                    class="flex items-center w-full px-2 py-2 rounded hover:bg-gray-700 hover:text-white">
                    <span class="flex-1 text-right">جداول الأماكن</span>
                    <svg class="h-4 w-4 transition-transform" :class="open && 'rotate-180'" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <ul x-show="open" x-collapse class="mt-2 mr-3 border-r border-gray-700 space-y-1 text-xs">
                    <li>
                        <a href="{{ route('governorate.index') }}" class="block px-3 py-1 rounded hover:bg-gray-700">عرض
                            بيانات المحافظات</a>
                    </li>

                    <li>
                        <a href="{{ route('city.index') }}" class="block px-3 py-1 rounded hover:bg-gray-700">عرض
                            بيانات المدن</a>
                    </li>

                    <li>
                        <a href="{{ route('location.index') }}" class="block px-3 py-1 rounded hover:bg-gray-700">عرض
                            بيانات المناطق والمعالم</a>
                    </li>
                </ul>
            </li>
            @auth
            @if(auth()->user()->role === 'supervisor')

            {{-- <li>
                <a href="{{ route('member-requests.pending') }}"
            class="flex items-center gap-2 px-2 py-2 rounded hover:bg-gray-700 hover:text-white">
            طلبات الأعضاء
            </a>
            </li> --}}

            <div class="border-b border-gray-700 my-4 text-xs text-gray-500"> المستخدمين</div>

            <li>
                <a href="{{ route('users.index') }}"
                    class="flex items-center gap-2 px-2 py-2 rounded hover:bg-gray-700 hover:text-white">
                    إدارة بيانات المستخدمين
                </a>
            </li>
            @endif
            @endauth
        </ul>
    </nav>
</aside>