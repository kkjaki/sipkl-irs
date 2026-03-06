<nav class="w-full px-8 py-3 bg-white border-b border-gray-200 flex justify-between items-center sticky top-0 z-10">
    
    <div 
        @click="sidebarOpen = !sidebarOpen"
        class="p-2 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors duration-200 w-max"
    >
        <div class="transition-transform duration-300" :class="!sidebarOpen ? 'rotate-180' : ''">
             <x-heroicon-s-bars-3 class="w-6 h-6 text-stone-900 hover:text-teal-600 transition-colors" />
        </div>
    </div>

    <div class="flex items-center gap-2.5">
        <x-heroicon-o-user-circle class="w-9 h-9 text-stone-900" stroke-width="1.5" />
    </div>

</nav>