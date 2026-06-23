<nav x-data="{ open: false }" class="bg-white border-b border-tr-border sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14">

            <!-- Logo + Nav links -->
            <div class="flex items-center gap-6">
                <a href="{{ route('projects.index') }}" class="flex items-center gap-2 shrink-0">
                    <span class="w-7 h-7 rounded-lg bg-tr-accent flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </span>
                    <span class="font-bold text-base text-tr-text tracking-tight">PriTech</span>
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')">
                        Projects
                    </x-nav-link>
                    <x-nav-link :href="route('tags.index')" :active="request()->routeIs('tags.*')">
                        Tags
                    </x-nav-link>
                </div>
            </div>

            <!-- User dropdown -->
            <div class="hidden sm:flex items-center">
                <x-dropdown align="right" width="48" contentClasses="py-1 bg-white border border-tr-border rounded-xl shadow-lg overflow-hidden">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm text-tr-muted hover:text-tr-text hover:bg-tr-raised transition-all duration-150 focus:outline-none">
                            <span class="w-7 h-7 rounded-full bg-tr-accent/15 border border-tr-accent/30 flex items-center justify-center text-xs font-bold text-tr-accent-d shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="font-medium text-tr-text">{{ Auth::user()->name }}</span>
                            <svg class="w-3 h-3 fill-current opacity-50" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-3 py-2.5 border-b border-tr-border mb-1">
                            <p class="text-xs font-semibold text-tr-text truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-tr-dim truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profile
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-lg text-tr-muted hover:text-tr-text hover:bg-tr-raised transition-colors">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-tr-border bg-white">
        <div class="pt-2 pb-3 px-4 space-y-1">
            <x-responsive-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')">Projects</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tags.index')" :active="request()->routeIs('tags.*')">Tags</x-responsive-nav-link>
        </div>
        <div class="pt-3 pb-3 border-t border-tr-border px-4">
            <div class="flex items-center gap-3 mb-3">
                <span class="w-8 h-8 rounded-full bg-tr-accent/15 border border-tr-accent/30 flex items-center justify-center text-sm font-bold text-tr-accent-d">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                <div>
                    <p class="text-sm font-medium text-tr-text">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-tr-muted">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
