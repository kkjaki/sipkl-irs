<nav class="w-full px-8 py-3 bg-white border-b border-gray-200 flex justify-between items-center sticky top-0 z-10">
    
    <div 
        @click="sidebarOpen = !sidebarOpen"
        class="p-2 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors duration-200 w-max"
    >
        <div class="transition-transform duration-300" :class="!sidebarOpen ? 'rotate-180' : ''">
             <x-heroicon-s-bars-3 class="w-6 h-6 text-stone-900 hover:text-teal-600 transition-colors" />
        </div>
    </div>

    <div class="flex items-center gap-2.5 relative" x-data="{ profileOpen: false }" @click.outside="profileOpen = false">
        <!-- Tombol Trigger -->
        <button @click="profileOpen = !profileOpen" type="button" class="flex items-center justify-center rounded-full hover:bg-gray-100 focus:outline-none transition-colors">
            <x-heroicon-o-user-circle class="w-9 h-9 text-stone-900 transition-colors" stroke-width="1.5" />
        </button>

        <!-- Kotak Dropdown (Modal) -->
        <div x-show="profileOpen" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 translate-y-1"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-1"
             class="absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden">
            
            <!-- Info Email (Header Dropdown) -->
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-medium text-gray-500 truncate">
                    {{ auth()->user()->email ?? 'example@gmail.com' }}
                </p>
            </div>

            <!-- Opsi / Menu -->
            <div class="p-2 space-y-1">
                
                <!-- Tombol Profil -->
                <a href="{{ route('profile.edit') }}" class="flex items-center w-full px-3 py-2 text-sm font-semibold text-teal-800 bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors">
                    <x-heroicon-s-user class="w-5 h-5 mr-3 text-teal-600" />
                    Profil
                </a>

                <!-- Tombol Logout -->
                <form method="POST" action="{{ route('logout') }}" class="w-full m-0">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-3 py-2 text-sm font-medium text-left text-gray-700 rounded-lg hover:bg-gray-50 transition-colors focus:outline-none">
                        <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 mr-3 text-gray-400" />
                        Logout
                    </button>
                </form>
                
            </div>
        </div>
    </div>

</nav>
