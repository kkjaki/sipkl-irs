{{-- SIDEBAR --}}
<aside id="sidebar"
class="w-64 min-h-screen py-2.5 bg-white flex flex-col shadow-lg shrink-0
transition-all duration-300 overflow-hidden">

    {{-- Logo --}}
    <div class="w-full px-7 py-9 flex justify-center items-center">
        <h1 class="text-neutral-800 text-3xl font-extrabold leading-10">
            PKL ONLINE
        </h1>
    </div>

    <nav class="w-full">
        <ul>

            {{-- DASHBOARD --}}
            <li>
                <a href="{{ route('student.dashboard') }}"
                   class="px-4 py-4 flex items-center gap-3.5 border-l-8 transition
                   {{ request()->routeIs('student.dashboard') 
                        ? 'border-teal-400 bg-gray-50 text-brand-primary' 
                        : 'border-transparent hover:border-teal-300' }}">
                    
                    <x-lucide-home class="w-5 h-5" />
                    <span class="text-lg">Dashboard</span>
                </a>
            </li>


            {{-- PRESENSI --}}
            @php
                $presensiActive = request()->routeIs('student.kehadiran.*');
            @endphp

            <li>
                <div onclick="toggleDropdown(this, 'presensiDropdown')"
                    class="px-4 py-4 flex items-center justify-between cursor-pointer border-l-8 transition
                    {{ $presensiActive ? 'border-teal-400 bg-gray-50' : 'border-transparent hover:border-teal-300' }}">
                    
                    <div class="flex items-center gap-3.5">
                        <x-lucide-clipboard-list class="w-5 h-5" />
                        <span class="text-lg">Presensi</span>
                    </div>

                    <x-lucide-chevron-left
                        class="chevron-icon w-5 h-5 transition-transform duration-300
                        {{ $presensiActive ? '-rotate-90' : '' }}" />
                </div>

                <ul id="presensiDropdown"
                    class="overflow-hidden transition-all duration-300 ease-in-out
                    {{ $presensiActive ? 'max-h-40' : 'max-h-0' }}">

                    <li>
                        <a href="{{ route('student.kehadiran.create') }}"
                           class="block px-12 py-4 border-l-8 transition
                           {{ request()->routeIs('student.kehadiran.create') 
                                ? 'border-teal-400 text-brand-primary' 
                                : 'border-transparent hover:border-teal-300' }}">
                            Presensi Harian
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student.kehadiran.index') }}"
                           class="block px-12 py-4 border-l-8 transition
                           {{ request()->routeIs('student.kehadiran.index') 
                                ? 'border-teal-400 text-brand-primary' 
                                : 'border-transparent hover:border-teal-300' }}">
                            Daftar Kehadiran
                        </a>
                    </li>

                </ul>
            </li>


            {{-- LOGBOOK --}}
            @php
                $logbookActive = request()->routeIs('student.logbook.*');
            @endphp

            <li>
                <div onclick="toggleDropdown(this, 'logbookDropdown')"
                    class="px-4 py-4 flex items-center justify-between cursor-pointer border-l-8 transition
                    {{ $logbookActive ? 'border-teal-400 bg-gray-50' : 'border-transparent hover:border-teal-300' }}">
                    
                    <div class="flex items-center gap-3.5">
                        <x-lucide-book-open class="w-5 h-5" />
                        <span class="text-lg">Logbook</span>
                    </div>

                    <x-lucide-chevron-left
                        class="chevron-icon w-5 h-5 transition-transform duration-300
                        {{ $logbookActive ? '-rotate-90' : '' }}" />
                </div>

                <ul id="logbookDropdown"
                    class="overflow-hidden transition-all duration-300 ease-in-out
                    {{ $logbookActive ? 'max-h-40' : 'max-h-0' }}">

                    <li>
                        <a href="{{ route('student.logbook.create') }}"
                           class="block px-12 py-4 border-l-8 transition
                           {{ request()->routeIs('student.logbook.create') 
                                ? 'border-teal-400 text-brand-primary' 
                                : 'border-transparent hover:border-teal-300' }}">
                            Logbook Harian
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student.logbook.index') }}"
                           class="block px-12 py-4 border-l-8 transition
                           {{ request()->routeIs('student.logbook.index') 
                                ? 'border-teal-400 text-brand-primary' 
                                : 'border-transparent hover:border-teal-300' }}">
                            Daftar Logbook
                        </a>
                    </li>

                </ul>
            </li>


            {{-- NILAI --}}
            <li>
                <a href="{{ route('student.nilai.index') }}"
                class="px-4 py-4 flex items-center gap-3.5 border-l-8 transition
                {{ request()->routeIs('student.nilai.*') 
                        ? 'border-teal-400 bg-gray-50 text-brand-primary' 
                        : 'border-transparent hover:border-teal-300' }}">
                    
                    <x-lucide-graduation-cap class="w-5 h-5" />
                    <span class="text-lg">Nilai</span>
                </a>
            </li>

        </ul>
    </nav>

</aside>


{{-- SIDEBAR SCRIPT --}}
<script>

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
}

function toggleDropdown(el, dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const icon = el.querySelector('.chevron-icon');

    dropdown.classList.toggle('max-h-0');
    dropdown.classList.toggle('max-h-40');
    icon.classList.toggle('-rotate-90');
}

</script>