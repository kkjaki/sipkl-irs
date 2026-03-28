<aside :class="sidebarOpen ? 'w-64' : 'w-16'"
    class="py-2.5 h-screen fixed bg-white flex flex-col justify-start items-center shadow-lg transition-all duration-300 overflow-x-hidden z-50">
    {{-- Logo Aplikasi --}}
    <div class="w-full px-7 py-9 flex justify-center items-center">
        <h1 x-show="sidebarOpen" class="text-neutral-800 text-3xl font-sans font-bold leading-10 whitespace-nowrap">PKL
            ONLINE</h1>
    </div>

    {{-- Navigasi --}}
    <nav class="w-full">
        <ul>
            {{-- Dashboard Khusus Owner --}}
            @if (auth()->user()->role === 'owner')
                @php $isActive = request()->routeIs('dashboard'); @endphp
                <li>
                    <a href="{{ route('dashboard') }}" :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                        class="py-4 flex items-center gap-3.5 group transition duration-100 {{ $isActive ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                        <x-heroicon-m-home
                            class="w-5 h-5 transition-colors duration-100 {{ $isActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                        <span x-show="sidebarOpen"
                            class="text-lg font-normal font-sans transition {{ $isActive ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                            Dashboard
                        </span>
                    </a>
                </li>

                {{-- Pendamping Industri Khusus Owner --}}
                @php $isActive = request()->routeIs('mentors.*'); @endphp
                <li>
                    <a href="{{ route('mentors.index') }}" :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                        class="py-4 flex items-center gap-3.5 group transition duration-100 {{ $isActive ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                        <i
                            class="w-5 h-5 fas fa-user-tie transition-colors duration-100 {{ $isActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}"></i>
                        <span x-show="sidebarOpen"
                            class="text-lg font-normal font-sans transition {{ $isActive ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                            Pendamping Industri
                        </span>
                    </a>
                </li>

                {{-- Manajemen Program PKL Khusus Owner --}}
                @php $isActive = request()->routeIs('internship-programs.*'); @endphp
                <li>
                    <a href="{{ route('internship-programs.index') }}" :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                        class="py-4 flex items-center gap-3.5 group transition duration-100 {{ $isActive ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                        <x-heroicon-s-briefcase
                            class="w-5 h-5 transition-colors duration-100 {{ $isActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                        <span x-show="sidebarOpen"
                            class="text-lg font-normal font-sans transition {{ $isActive ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                            Manajemen Program
                        </span>
                    </a>
                </li>
            @endif

            {{-- Sekolah (Dropdown Owner, Link Mentor) --}}
            @if (auth()->user()->role === 'owner')
                @php
                    $isSekolahActive = request()->routeIs('schools.*', 'supervisors.*', 'criteria.*');
                @endphp
                <li x-data="{ open: {{ $isSekolahActive ? 'true' : 'false' }} }">
                    <a href="#"
                        @click.prevent="sidebarOpen ? open = !open : window.location.href='{{ route('schools.index') }}'"
                        :class="sidebarOpen ? 'px-4 justify-between' : 'px-0 justify-center'"
                        class="py-4 flex items-center gap-3.5 group transition duration-100 {{ $isSekolahActive ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                        <div class="flex items-center gap-3.5">
                            <i
                                class="w-5 h-5 fas fa-school transition-colors duration-100 {{ $isSekolahActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}"></i>
                            <span x-show="sidebarOpen"
                                class="text-lg font-normal font-sans transition {{ $isSekolahActive ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                                Sekolah
                            </span>
                        </div>
                        <x-heroicon-m-chevron-down x-show="sidebarOpen" :class="open ? 'rotate-180' : 'rotate-0'"
                            class="w-5 h-5 transition-transform duration-300 {{ $isSekolahActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                    </a>
                    <ul x-show="sidebarOpen" :class="open ? 'max-h-[500px] opacity-100 py-2' : 'max-h-0 opacity-0 py-0'"
                        class="overflow-hidden transition-all duration-300 ease-in-out">
                        @php $isChildActive = request()->routeIs('schools.index', 'schools.create', 'schools.edit'); @endphp
                        <li>
                            <a href="{{ route('schools.index') }}"
                                class="flex items-center px-12 py-2.5 text-lg font-normal font-sans transition {{ $isChildActive ? 'text-brand-primary' : 'text-gray-700 hover:text-brand-primary' }}">
                                <span
                                    class="w-1.5 h-1.5 rounded-full mr-3 transition-colors {{ $isChildActive ? 'bg-teal-500' : 'bg-gray-400' }}"></span>
                                Data Sekolah
                            </a>
                        </li>
                        @php $isChildActive = request()->routeIs(['schools.management', 'schools.supervisors.*', 'supervisors.*', 'schools.criteria.*', 'criteria.*']); @endphp
                        <li>
                            <a href="{{ route('schools.management') }}"
                                class="flex items-center px-12 py-2.5 text-lg font-normal font-sans transition {{ $isChildActive ? 'text-brand-primary' : 'text-gray-700 hover:text-brand-primary' }}">
                                <span
                                    class="w-1.5 h-1.5 rounded-full mr-3 transition-colors {{ $isChildActive ? 'bg-teal-500' : 'bg-gray-400' }}"></span>
                                Manajemen Sekolah
                            </a>
                        </li>
                    </ul>
                </li>
            @elseif(auth()->user()->role === 'mentor')
                @php $isSekolahActive = request()->routeIs('schools.management'); @endphp
                <li>
                    <a href="{{ route('schools.management') }}" :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                        class="py-4 flex items-center gap-3.5 group transition duration-100 {{ $isSekolahActive ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                        <i
                            class="w-5 h-5 fas fa-school transition-colors duration-100 {{ $isSekolahActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}"></i>
                        <span x-show="sidebarOpen"
                            class="text-lg font-normal font-sans transition {{ $isSekolahActive ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                            Manajemen Sekolah
                        </span>
                    </a>
                </li>
            @endif

            {{-- Presensi Dropdown Global (Owner & Mentor) --}}
            @php
                $isPresensiActive = request()->routeIs('attendance-sessions.*', 'attendance.validate.*');
            @endphp
            <li x-data="{ open: {{ $isPresensiActive ? 'true' : 'false' }} }">
                <a href="#"
                    @click.prevent="sidebarOpen ? open = !open : window.location.href='{{ route('attendance-sessions.index') }}'"
                    :class="sidebarOpen ? 'px-4 justify-between' : 'px-0 justify-center'"
                    class="py-4 flex items-center gap-3.5 group transition duration-100 {{ $isPresensiActive ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                    <div class="flex items-center gap-3.5">
                        <i
                            class="w-5 h-5 fas fa-list transition-colors duration-100 {{ $isPresensiActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}"></i>
                        <span x-show="sidebarOpen"
                            class="text-lg font-normal font-sans transition {{ $isPresensiActive ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                            Presensi
                        </span>
                    </div>
                    {{-- Smooth Chevron Animation (rotate-180) --}}
                    <x-heroicon-m-chevron-down x-show="sidebarOpen" :class="open ? 'rotate-180' : 'rotate-0'"
                        class="w-5 h-5 transition-transform duration-300 {{ $isPresensiActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                </a>
                <ul x-show="sidebarOpen" :class="open ? 'max-h-[500px] opacity-100 py-2' : 'max-h-0 opacity-0 py-0'"
                    class="overflow-hidden transition-all duration-300 ease-in-out">
                    @php $isChildActive = request()->routeIs('attendance-sessions.*'); @endphp
                    <li>
                        <a href="{{ route('attendance-sessions.index') }}"
                            class="flex items-center px-12 py-2.5 text-lg font-normal font-sans transition {{ $isChildActive ? 'text-brand-primary' : 'text-gray-700 hover:text-brand-primary' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full mr-3 transition-colors {{ $isChildActive ? 'bg-teal-500' : 'bg-gray-400' }}"></span>
                            Kelola Sesi
                        </a>
                    </li>
                    @php $isChildActive = request()->routeIs('attendance.validate.*'); @endphp
                    <li>
                        <a href="{{ route('attendance.validate.schools.index') }}"
                            class="flex items-center px-12 py-2.5 text-lg font-normal font-sans transition {{ $isChildActive ? 'text-brand-primary' : 'text-gray-700 hover:text-brand-primary' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full mr-3 transition-colors {{ $isChildActive ? 'bg-teal-500' : 'bg-gray-400' }}"></span>
                            Validasi Presensi
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Validasi Logbook Global (Owner & Mentor) --}}
            @php $isActive = request()->routeIs('logbooks.*', 'industry.logbooks.*'); @endphp
            <li>
                <a href="{{ route('industry.logbooks.index') }}" :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                    class="py-4 flex items-center gap-3.5 group transition duration-100 {{ $isActive ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                    <x-heroicon-s-book-open
                        class="w-5 h-5 transition-colors duration-100 {{ $isActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                    <span x-show="sidebarOpen"
                        class="text-lg font-normal font-sans transition {{ $isActive ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                        Validasi Logbook
                    </span>
                </a>
            </li>

            {{-- Rekap Global (Owner & Mentor) --}}
            @php $isActive = request()->routeIs('industry.recap.index'); @endphp
            <li>
                <a href="{{ route('industry.recap.index') }}" :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                    class="py-4 flex items-center gap-3.5 group transition duration-100 {{ $isActive ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                    <x-heroicon-s-clipboard-document-list
                        class="w-5 h-5 transition-colors duration-100 {{ $isActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                    <span x-show="sidebarOpen"
                        class="text-lg font-normal font-sans transition {{ $isActive ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                        Rekap
                    </span>
                </a>
            </li>

            {{-- Nilai Global (Owner & Mentor) --}}
            @php $isActive = request()->routeIs('grades.*'); @endphp
            <li>
                <a href="{{ route('grades.schools.index') }}" :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'"
                    class="py-4 flex items-center gap-3.5 group transition duration-100 {{ $isActive ? 'border-l-8 border-brand-primary bg-teal-50' : 'border-l-8 border-transparent hover:border-teal-300 hover:bg-teal-50' }}">
                    <x-heroicon-s-academic-cap
                        class="w-5 h-5 transition-colors duration-100 {{ $isActive ? 'text-brand-primary' : 'text-stone-900 group-hover:text-brand-primary' }}" />
                    <span x-show="sidebarOpen"
                        class="text-lg font-normal font-sans transition {{ $isActive ? 'text-brand-primary' : 'text-neutral-800 group-hover:text-brand-primary' }}">
                        Nilai
                    </span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
