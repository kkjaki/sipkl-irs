<aside :class="sidebarOpen ? 'w-64' : 'w-16'"
    class="py-2.5 h-screen fixed bg-white flex flex-col justify-start items-center shadow-lg transition-all duration-300 overflow-x-hidden">
    {{-- Logo Aplikasi --}}
    <div class="w-full px-7 py-9 flex justify-center items-center">
        <h1 x-show="sidebarOpen" class="text-neutral-800 text-3xl font-sans font-bold leading-10 whitespace-nowrap">PKL
            ONLINE</h1>
    </div>

    {{-- Navigasi --}}
    <nav class="w-full">
        <ul>
            {{-- Dashboard --}}
            @if (auth()->check() && auth()->user()->role === 'owner')
                <li onclick="window.location.href='{{ route('dashboard') }}'"
                    :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                    class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('dashboard') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                    <x-heroicon-m-home
                        class="w-5 h-5 transition-colors duration-100 {{ request()->routeIs('dashboard') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                    <span x-show="sidebarOpen"
                        class="text-lg font-normal font-sans transition {{ request()->routeIs('dashboard') ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                        Dashboard
                    </span>
                </li>
            @endif

            {{-- Pendamping Industri --}}
            <li onclick="window.location.href='{{ route('mentors.index') }}'"
                :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('mentors.*') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                <i
                    class="w-5 h-5 fas fa-user-tie transition-colors duration-100 {{ request()->routeIs('mentors.*') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}"></i>
                <span x-show="sidebarOpen"
                    class="text-lg font-normal font-sans transition {{ request()->routeIs('mentors.*') ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                    Pendamping Industri
                </span>
            </li>

            {{-- Manajemen Program PKL --}}
            <li onclick="window.location.href='{{ route('internship-programs.index') }}'"
                :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('internship-programs.*') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                <x-heroicon-s-briefcase
                    class="w-5 h-5 transition-colors duration-100 {{ request()->routeIs('internship-programs.*') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                <span x-show="sidebarOpen"
                    class="text-lg font-normal font-sans transition {{ request()->routeIs('internship-programs.*') ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                    Manajemen Program
                </span>
            </li>

            {{-- Sekolah Dropdown --}}
            @php
                $isSekolahActive = request()->routeIs('schools.*', 'supervisors.*', 'criteria.*');
            @endphp
            <!-- Karena kita butuh state sekolahOpen, dan jika belum ada di parent x-data, kita inject di sini atau asumsikan ada. Saya akan tambahkan x-data local jika diperlukan, tapi sepertinya state dropdown harus independen. -->
            <li x-data="{ sekolahOpen: {{ $isSekolahActive ? 'true' : 'false' }} }">
                <a href="{{ route('schools.index') }}"
                    @click.prevent="sidebarOpen ? (sekolahOpen = !sekolahOpen) : (window.location.href = '{{ route('schools.index') }}')"
                    :class="sidebarOpen ? 'px-4 justify-between' : 'px-0 justify-center'"
                    class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ $isSekolahActive ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                    <div class="flex items-center gap-3.5">
                        <i
                            class="w-5 h-5 fas fa-school transition-colors duration-100 {{ $isSekolahActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}"></i>
                        <span x-show="sidebarOpen"
                            class="text-lg font-normal font-sans transition {{ $isSekolahActive ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                            Sekolah
                        </span>
                    </div>
                    <x-heroicon-m-chevron-left x-show="sidebarOpen" :class="sekolahOpen
                        ? '-rotate-90 text-brand-primary'
                        : '{{ $isSekolahActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}'"
                        class="chevron-icon w-5 h-5 transition-transform duration-500" />
                </a>
                <ul x-show="sidebarOpen" :class="sekolahOpen ? 'max-h-[500px]' : 'max-h-0'"
                    class="overflow-hidden transition-all duration-500 ease-in-out">
                    <li>
                        <a href="{{ route('schools.index') }}"
                            class="flex items-center px-12 py-4 text-lg font-normal font-sans transition {{ request()->routeIs('schools.index', 'schools.create', 'schools.edit') ? 'border-l-8 border-brand-primary bg-teal-50 text-brand-primary' : 'border-l-8 border-transparent text-gray-700 hover:border-teal-300 hover:bg-teal-50 hover:text-brand-primary' }}">
                            Data Sekolah
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('schools.management') }}"
                            class="flex items-center px-12 py-4 text-lg font-normal font-sans transition {{ request()->routeIs(['schools.management', 'schools.supervisors.*', 'supervisors.*', 'schools.criteria.*', 'criteria.*']) ? 'border-l-8 border-brand-primary bg-teal-50 text-brand-primary' : 'border-l-8 border-transparent text-gray-700 hover:border-teal-300 hover:bg-teal-50 hover:text-brand-primary' }}">
                            Manajemen Sekolah
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Presensi Dropdown --}}
            @php
                $isPresensiActive =
                    request()->routeIs('attendance-sessions.*') || request()->routeIs('attendance.validate.*');
            @endphp
            <li x-data="{ presensiOpen: {{ $isPresensiActive ? 'true' : 'false' }} }">
                <a href="{{ route('attendance-sessions.index') }}"
                    @click.prevent="sidebarOpen ? (presensiOpen = !presensiOpen) : (window.location.href = '{{ route('attendance-sessions.index') }}')"
                    :class="sidebarOpen ? 'px-4 justify-between' : 'px-0 justify-center'"
                    class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ $isPresensiActive ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                    <div class="flex items-center gap-3.5">
                        <i
                            class="w-5 h-5 fas fa-list transition-colors duration-100 {{ $isPresensiActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}"></i>
                        <span x-show="sidebarOpen"
                            class="text-lg font-normal font-sans transition {{ $isPresensiActive ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                            Presensi
                        </span>
                    </div>
                    <x-heroicon-m-chevron-left x-show="sidebarOpen" :class="presensiOpen
                        ? '-rotate-90 text-brand-primary'
                        : '{{ $isPresensiActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}'"
                        class="chevron-icon w-5 h-5 transition-transform duration-500" />
                </a>
                <ul x-show="sidebarOpen" :class="presensiOpen ? 'max-h-[500px]' : 'max-h-0'"
                    class="overflow-hidden transition-all duration-500 ease-in-out">
                    <li>
                        <a href="{{ route('attendance-sessions.index') }}"
                            class="flex items-center px-12 py-4 text-lg font-normal font-sans transition {{ request()->routeIs('attendance-sessions.*') ? 'border-l-8 border-brand-primary bg-teal-50 text-brand-primary' : 'border-l-8 border-transparent text-gray-700 hover:border-teal-300 hover:bg-teal-50 hover:text-brand-primary' }}">
                            Kelola Sesi Presensi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('attendance.validate.schools.index') }}"
                            class="flex items-center px-12 py-4 text-lg font-normal font-sans transition {{ request()->routeIs('attendance.validate.schools.*') ? 'border-l-8 border-brand-primary bg-teal-50 text-brand-primary' : 'border-l-8 border-transparent text-gray-700 hover:border-teal-300 hover:bg-teal-50 hover:text-brand-primary' }}">
                            Validasi Presensi
                        </a>
                    </li>
                </ul>
            </li>


            {{-- Validasi Logbook --}}
            <li onclick="window.location.href='{{ route('industry.logbooks.index') }}'" :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('logbooks.*') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                <x-heroicon-s-book-open
                    class="w-5 h-5 transition-colors duration-100 {{ request()->routeIs('logbooks.*') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                <span x-show="sidebarOpen"
                    class="text-lg font-normal font-sans transition {{ request()->routeIs('logbooks.*') ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                    Validasi Logbook
                </span>
            </li>

            {{-- Rekap --}}
            <li onclick="window.location.href='{{ route('industry.recap.index') }}'" :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('industry.recap.index') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                <x-heroicon-s-clipboard-document-list
                    class="w-5 h-5 transition-colors duration-100 {{ request()->routeIs('industry.recap.index') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                <span x-show="sidebarOpen"
                    class="text-lg font-normal font-sans transition {{ request()->routeIs('industry.recap.index') ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                    Rekap
                </span>
            </li>

            {{-- Nilai --}}
            <li onclick="window.location.href='{{ route('grades.schools.index') }}'" :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('grades.*') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                <x-heroicon-s-academic-cap
                    class="w-5 h-5 transition-colors duration-100 {{ request()->routeIs('grades.*') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                <span x-show="sidebarOpen"
                    class="text-lg font-normal font-sans transition {{ request()->routeIs('grades.*') ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                    Nilai
                </span>
            </li>
        </ul>
    </nav>
</aside>

<script>
    function toggleDropdown(el, dropdownId) {
        document.querySelectorAll('ul[id$="Dropdown"]').forEach(ul => {
            if (ul.id !== dropdownId) {
                ul.classList.remove('max-h-[500px]');
                ul.classList.add('max-h-0');

                const parentDiv = ul.previousElementSibling;
                const chevronIcon = parentDiv.querySelector('.chevron-icon');
                const mainIcon = parentDiv.querySelector('i, svg:not(.chevron-icon)');

                parentDiv.classList.remove('border-teal-300');
                parentDiv.classList.add('border-transparent');
                chevronIcon?.classList.remove('-rotate-90', 'text-brand-primary');
                mainIcon?.classList.remove('text-brand-primary');
                parentDiv.querySelector('span')?.classList.remove('text-brand-primary');

                ul.querySelectorAll('a').forEach(a => {
                    a.classList.remove('border-teal-300');
                    a.classList.add('border-transparent');
                });
            }
        });

        const dropdown = document.getElementById(dropdownId);
        const isHidden = dropdown.classList.contains('max-h-0');
        const chevronIcon = el.querySelector('.chevron-icon');
        const mainIcon = el.querySelector('i, svg:not(.chevron-icon)');

        dropdown.classList.toggle('max-h-0');
        dropdown.classList.toggle('max-h-[500px]');

        if (isHidden) {
            el.classList.remove('border-transparent');
            el.classList.add('border-teal-300');
            chevronIcon?.classList.add('-rotate-90', 'text-brand-primary');
            mainIcon?.classList.add('text-brand-primary');
            el.querySelector('span')?.classList.add('text-brand-primary');

            dropdown.querySelectorAll('a').forEach(a => {
                a.classList.remove('border-transparent');
                a.classList.add('border-teal-300');
            });
        } else {
            el.classList.remove('border-teal-300');
            el.classList.add('border-transparent');
            chevronIcon?.classList.remove('-rotate-90', 'text-brand-primary');
            mainIcon?.classList.remove('text-brand-primary');
            el.querySelector('span')?.classList.remove('text-brand-primary');

            dropdown.querySelectorAll('a').forEach(a => {
                a.classList.remove('border-teal-300');
                a.classList.add('border-transparent');
            });
        }
    }
</script>
