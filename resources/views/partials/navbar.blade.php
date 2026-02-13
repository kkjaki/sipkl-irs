<nav class="w-full px-10 py-3 bg-white shadow flex justify-between items-center relative">

    {{-- Menu Icon --}}
    <div>
        <x-heroicon-s-bars-3 class="w-6 h-6 text-stone-900 cursor-pointer" />
    </div>

    {{-- Profile Dropdown --}}
    <div>
        <x-dropdown align="right" width="48">

            {{-- Trigger --}}
            <x-slot name="trigger">
                <button class="flex items-center focus:outline-none">
                    <x-heroicon-o-user-circle 
                        class="w-9 h-9 text-stone-900 cursor-pointer" 
                        stroke-width="1.5" />
                </button>
            </x-slot>

            {{-- Content --}}
            <x-slot name="content">

                {{-- Email --}}
                <div class="px-4 py-2 text-xs text-gray-400 border-b">
                    {{ Auth::user()->email ?? 'example@gmail.com' }}
                </div>

                {{-- Profil --}}
                <a href="{{ route('student.profil.index') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    Profil
                </a>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition">
                        Logout
                    </button>
                </form>

            </x-slot>

        </x-dropdown>
    </div>

</nav>
