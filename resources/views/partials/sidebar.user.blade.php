<aside class="w-64 h-screen py-2.5 bg-white flex flex-col justify-start items-center shadow-lg">
    {{-- Logo Aplikasi --}}
    <div class="w-full px-7 py-9 flex justify-center items-center">
        <h1 class="text-neutral-800 text-3xl font-['SF_Pro'] font-bold leading-10">PKL ONLINE</h1>
    </div>

    {{-- Navigasi --}}
    <nav class="w-full">
        <ul>
            {{-- Dashboard --}}
            <li onclick="window.location.href='{{ route('dashboard') }}'"
                class="px-4 py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 border-l-8 border-transparent hover:border-teal-300">
                <x-heroicon-m-home
                    class="w-5 h-5 text-stone-900 transition-colors duration-100 group-hover:text-brand-primary" />
                <span
                    class="text-neutral-800 text-lg font-normal font-['SF_Pro'] group-hover:text-brand-primary transition">
                    Dashboard
                </span>
            </li>

            {{-- Presensi Dropdown --}}
            <li>
                <div onclick="toggleDropdown(this, 'presensiDropdown')"
                    class="px-4 py-4 flex items-center justify-between gap-3.5 cursor-pointer group transition duration-100 border-l-8 border-transparent hover:border-teal-300">
                    <div class="flex items-center gap-3.5">
                        <i class="w-5 h-5 fas fa-list text-stone-900 group-hover:text-brand-primary"></i>
                        <span
                            class="text-neutral-800 text-lg font-normal font-['SF_Pro'] group-hover:text-brand-primary transition">
                            Presensi
                        </span>
                    </div>
                    <x-heroicon-m-chevron-left
                        class="chevron-icon w-5 h-5 text-stone-900 transition-transform duration-500 group-hover:text-brand-primary" />
                </div>
                <ul id="presensiDropdown" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                    <li>
                        <a href="#"
                            class="flex items-center border-l-8 border-transparent hover:border-teal-300 px-12 py-4 text-lg font-normal font-['SF_Pro'] text-gray-700 hover:text-brand-primary transition">
                            Presensi Harian
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center border-l-8 border-transparent hover:border-teal-300 px-12 py-4 text-lg font-normal font-['SF_Pro'] text-gray-700 hover:text-brand-primary transition">
                            Daftar Kehadiran
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Logbook Dropdown --}}
            <li>
                <div onclick="toggleDropdown(this, 'logbookDropdown')"
                    class="px-4 py-4 flex items-center justify-between gap-3.5 cursor-pointer group transition duration-100 border-l-8 border-transparent hover:border-teal-300">
                    <div class="flex items-center gap-3.5">
                        <x-heroicon-s-book-open
                            class="w-5 h-5 text-stone-900 transition-colors duration-100 group-hover:text-brand-primary" />
                        <span
                            class="text-neutral-800 text-lg font-normal font-['SF_Pro'] group-hover:text-brand-primary transition">
                            Logbook
                        </span>
                    </div>
                    <x-heroicon-m-chevron-left
                        class="chevron-icon w-5 h-5 text-stone-900 transition-transform duration-500 group-hover:text-brand-primary" />
                </div>
                <ul id="logbookDropdown" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                    <li>
                        <a href="#"
                            class="flex items-center border-l-8 border-transparent hover:border-teal-300 px-12 py-4 text-lg font-normal font-['SF_Pro'] text-gray-700 hover:text-brand-primary transition">
                            Logbook Harian
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center border-l-8 border-transparent hover:border-teal-300 px-12 py-4 text-lg font-normal font-['SF_Pro'] text-gray-700 hover:text-brand-primary transition">
                            Daftar Logbook
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Nilai --}}
            <li onclick="window.location.href='#'"
                class="px-4 py-4 flex items-center gap-3.5 cursor-pointer group transition duration-100 border-l-8 border-transparent hover:border-teal-300">
                <x-heroicon-s-academic-cap
                    class="w-5 h-5 text-stone-900 transition-colors duration-100 group-hover:text-brand-primary" />
                <span
                    class="text-neutral-800 text-lg font-normal font-['SF_Pro'] group-hover:text-brand-primary transition">
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
