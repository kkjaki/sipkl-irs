<aside :class="sidebarOpen ? 'w-64' : 'w-16'" class="py-2.5 h-screen fixed bg-white flex flex-col justify-start items-center shadow-lg transition-all duration-300 overflow-x-hidden">
    {{-- Logo Aplikasi --}}
    <div class="w-full px-7 py-9 flex justify-center items-center">
        <h1 x-show="sidebarOpen" class="text-neutral-800 text-3xl font-sans font-bold leading-10 whitespace-nowrap">PKL ONLINE</h1>
    </div>

    {{-- Navigasi --}}
    <nav class="w-full">
        <ul>
            {{-- Dashboard --}}
            <li onclick="window.location.href='{{ route('dashboard') }}'"
                :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('dashboard') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                <x-heroicon-m-home
                    class="w-5 h-5 transition-colors duration-100 {{ request()->routeIs('dashboard') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                <span
                    x-show="sidebarOpen"
                    class="text-lg font-normal font-sans transition {{ request()->routeIs('dashboard') ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                    Dashboard
                </span>
            </li>

            {{-- Pendamping Industri --}}
            <li onclick="window.location.href='{{ route('mentors.index') }}'"
                :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('mentors.*') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                <i class="w-5 h-5 fas fa-user-tie transition-colors duration-100 {{ request()->routeIs('mentors.*') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}"></i>
                <span
                    x-show="sidebarOpen"
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
                <span
                    x-show="sidebarOpen"
                    class="text-lg font-normal font-sans transition {{ request()->routeIs('internshipPrograms.*') ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                    Manajemen Program
                </span>
            </li>

            {{-- Sekolah Dropdown --}}
            <li>
                <div onclick="toggleDropdown(this, 'sekolahDropdown')"
                    :class="sidebarOpen ? 'px-4 justify-between' : 'px-0 justify-center'"
                    class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('schools.*') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                    <div class="flex items-center gap-3.5">
                        <i class="w-5 h-5 fas fa-school transition-colors duration-100 {{ request()->routeIs('schools.*') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}"></i>
                        <span
                            x-show="sidebarOpen"
                            class="text-lg font-normal font-sans transition {{ request()->routeIs('schools.*') ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                            Sekolah
                        </span>
                    </div>
                    <x-heroicon-m-chevron-left
                        x-show="sidebarOpen"
                        class="chevron-icon w-5 h-5 transition-transform duration-500 {{ request()->routeIs('schools.*') ? '-rotate-90 text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                </div>
                <ul id="sekolahDropdown" x-show="sidebarOpen" class="{{ request()->routeIs('schools.*') ? 'max-h-[500px]' : 'max-h-0' }} overflow-hidden transition-all duration-500 ease-in-out">
                    <li>
                        <a href="{{ route('schools.index') }}"
                            class="flex items-center px-12 py-4 text-lg font-normal font-sans transition {{ request()->routeIs('schools.index', 'schools.create', 'schools.edit') ? 'border-l-8 border-brand-primary bg-teal-50 text-brand-primary' : 'border-l-8 border-transparent text-gray-700 hover:border-teal-300 hover:bg-teal-50 hover:text-brand-primary' }}">
                            Data Sekolah
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('schools.management') }}"
                            class="flex items-center px-12 py-4 text-lg font-normal font-sans transition {{ request()->routeIs('schools.management') ? 'border-l-8 border-brand-primary bg-teal-50 text-brand-primary' : 'border-l-8 border-transparent text-gray-700 hover:border-teal-300 hover:bg-teal-50 hover:text-brand-primary' }}">
                            Manajemen Sekolah
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Presensi Dropdown --}}
            <li>
                <div onclick="toggleDropdown(this, 'presensiDropdown')"
                    :class="sidebarOpen ? 'px-4 justify-between' : 'px-0 justify-center'"
                    class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('presences.*', 'attendance.*') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                    <div class="flex items-center gap-3.5">
                        <i class="w-5 h-5 fas fa-list transition-colors duration-100 {{ request()->routeIs('presences.*', 'attendance.*') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}"></i>
                        <span
                            x-show="sidebarOpen"
                            class="text-lg font-normal font-sans transition {{ request()->routeIs('presences.*', 'attendance.*') ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                            Presensi
                        </span>
                    </div>
                    <x-heroicon-m-chevron-left
                        x-show="sidebarOpen"
                        class="chevron-icon w-5 h-5 transition-transform duration-500 {{ request()->routeIs('presences.*', 'attendance.*') ? '-rotate-90 text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                </div>
                <ul id="presensiDropdown" x-show="sidebarOpen" class="{{ request()->routeIs('presences.*', 'attendance.*') ? 'max-h-[500px]' : 'max-h-0' }} overflow-hidden transition-all duration-500 ease-in-out">
                    <li>
                        <a href="#"
                            class="flex items-center px-12 py-4 text-lg font-normal font-sans transition {{ request()->routeIs('attendance.sessions.*') ? 'border-l-8 border-brand-primary bg-teal-50 text-brand-primary' : 'border-l-8 border-transparent text-gray-700 hover:border-teal-300 hover:bg-teal-50 hover:text-brand-primary' }}">
                            Kelola Sesi Presensi
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center px-12 py-4 text-lg font-normal font-sans transition {{ request()->routeIs('attendance.validations.*') ? 'border-l-8 border-brand-primary bg-teal-50 text-brand-primary' : 'border-l-8 border-transparent text-gray-700 hover:border-teal-300 hover:bg-teal-50 hover:text-brand-primary' }}">
                            Validasi Presensi
                        </a>
                    </li>
                </ul>
            </li>


            {{-- Validasi Logbook --}}
            <li onclick="window.location.href='#'"
                :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('logbooks.*') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                <x-heroicon-s-book-open
                    class="w-5 h-5 transition-colors duration-100 {{ request()->routeIs('logbooks.*') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                <span
                    x-show="sidebarOpen"
                    class="text-lg font-normal font-sans transition {{ request()->routeIs('logbooks.*') ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                    Validasi Logbook
                </span>
            </li>

            {{-- Rekap --}}
            <li onclick="window.location.href='#'"
                :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('recap.*') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                <x-heroicon-s-clipboard-document-list
                    class="w-5 h-5 transition-colors duration-100 {{ request()->routeIs('recap.*') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                <span
                    x-show="sidebarOpen"
                    class="text-lg font-normal font-sans transition {{ request()->routeIs('recap.*') ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                    Rekap
                </span>
            </li>

            {{-- Nilai --}}
            <li onclick="window.location.href='#'"
                :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                class="py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 {{ request()->routeIs('grades.*') ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                <x-heroicon-s-academic-cap
                    class="w-5 h-5 transition-colors duration-100 {{ request()->routeIs('grades.*') ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                <span
                    x-show="sidebarOpen"
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