<!-- Navbar -->
<nav
    class="sticky top-0 z-50 h-16 bg-gray-800 shadow-xl flex items-center justify-between px-4"
    x-data="{ mobileMenu: false }"
>
    <div class="flex items-center justify-between w-full">

        <!-- Toggle Sidebar Button (Always on top) -->
        <button class="cursor-pointer text-white z-50 hover:text-gray-300 transition-colors" @click="$dispatch('toggle-sidebar')">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Search (desktop only) -->
        <div class="hidden lg:block flex-1 px-4">
            <div class="relative">
                <input type="text"
                       class="bg-gray-700 text-sm text-gray-300 rounded-md pr-10 py-1.5 w-48 focus:w-60 transition-all focus:text-white focus:outline-none"
                       placeholder="Search...">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                </span>
            </div>
        </div>

        <!-- Profile -->
        <div class="flex items-center gap-4">
            <div class="relative" x-data="{ open:false }">
                <div class="flex items-center gap-2 cursor-pointer" @click="open = !open">
                    <div class="rounded-full text-xl text-white"><i class="fa-regular fa-user"></i></div>
                    <div class="text-sm text-gray-300 leading-tight">
                        <div>{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-400">{{ auth()->user()->role }}</div>
                    </div>
                </div>
             <div x-show="open"
     @click.away="open=false"
     class="absolute left-0 mt-2 w-40 bg-white rounded shadow text-sm">

    <form method="POST"
          action="{{ route('logout') }}"
          @click.stop>
        @csrf

        <button type="submit"
                class="block w-full text-right px-4 py-2 hover:bg-gray-100">
            Logout
        </button>
    </form>
</div>

            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenu" @click.away="mobileMenu=false"
         class="md:hidden bg-gray-800 border-t border-gray-700">
        <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">Dashboard</a>
        <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">Team</a>
    </div>
</nav>
