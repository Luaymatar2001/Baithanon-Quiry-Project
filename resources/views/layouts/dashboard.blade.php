@extends('layouts.app')

@section('body')

<div class="bg-[#f3f3f9]" x-data="{ open: true }">

    <!-- Sidebar RTL -->
    @include('layouts.partials.sidebar')

    <!-- Main Wrapper -->
    <div class="md:mr-64 min-h-screen flex flex-col relative">

        <!-- Navbar -->
        <nav class="sticky top-0 z-[9999] h-16 bg-gray-800 shadow-xl flex items-center justify-between px-4">
            <!-- Toggle Button (Mobile only) -->
            <div class="md:hidden cursor-pointer text-white z-60" @click="$dispatch('toggle-sidebar')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>

            <!-- Search (Desktop) -->
            <div class="hidden lg:block flex-1 px-4">
                <div class="relative">
                    <input type="text"
                        class="bg-gray-700 text-sm text-gray-300 rounded-md pr-10 py-1.5 w-48 focus:w-60 transition-all focus:text-white focus:outline-none"
                        placeholder="Search...">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Profile Menu -->
            <div class="flex items-center gap-4">
                <div class="relative" x-data="{ open:false }">
                    <div class="flex items-center gap-2 cursor-pointer" @click="open = !open">
                        <div class="rounded-full text-xl text-white"><i class="fa-regular fa-user"></i></div>
                        <div class="text-sm text-gray-300 leading-tight">
                            <div>{{ auth()->user()->name }}</div>
                            <div class="text-xs text-gray-400">{{ auth()->user()->role }}</div>
                        </div>
                    </div>

                    <div x-show="open" @click.away="open=false"
                        class="absolute left-0 mt-2 w-40 bg-white rounded shadow text-sm">

                        <form method="POST" action="{{ route('admin.logout') }}" @click.stop>
                            @csrf

                            <button type="submit" class="block w-full text-right px-4 py-2 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <div class="border-b bg-white border-gray-300 pl-6 py-2 shadow-sm text-xl font-bold">
            @yield('page-title')
            <span class="block text-xs font-normal text-gray-400 mt-2">
                @yield('breadcrumb')
            </span>
        </div>
        <!-- Page Content -->
        <main class="flex-1 p-6 bg-[#f3f3f9]">
            @yield('content')

        </main>

        <!-- Footer -->
        <footer class="mt-auto">
            @include('layouts.partials.footer')
        </footer>

    </div>
</div>
@endsection