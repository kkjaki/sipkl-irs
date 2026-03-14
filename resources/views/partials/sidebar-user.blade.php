<div class="flex">

    {{-- ================= SIDEBAR ================= --}}
    <aside id="sidebar"
        class="w-64 h-screen py-2.5 bg-white flex flex-col items-center shadow-lg transition-all duration-300">

        {{-- ================= LOGO ================= --}}
        <div class="w-full px-7 py-9 flex justify-center items-center">
            <h1 class="text-neutral-800 text-3xl font-bold">
                PKL ONLINE
            </h1>
        </div>


        {{-- ================= NAVIGATION ================= --}}
        <nav class="w-full">
            <ul>

                {{-- ================= DASHBOARD ================= --}}
                <li onclick="window.location.href='{{ route('student.dashboard') }}'"
                    class="menu-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">

                    <x-heroicon-m-home class="menu-icon"/>
                    <span>Dashboard</span>

                </li>


                {{-- ================= PRESENSI ================= --}}
                @php
                    $presensiActive = request()->routeIs('student.presensi.*');
                @endphp

                <li>

                    <div onclick="toggleDropdown(this,'presensiDropdown')"
                        class="menu-item dropdown {{ $presensiActive ? 'active' : '' }}">

                        <div class="flex items-center gap-3">
                            <i class="fas fa-list menu-icon"></i>
                            <span>Presensi</span>
                        </div>

                        <x-heroicon-m-chevron-down
                            class="chevron-icon w-5 h-5 {{ $presensiActive ? 'text-teal-400 rotate-180' : '' }}"/>

                    </div>


                    <ul id="presensiDropdown"
                        class="dropdown-menu {{ $presensiActive ? 'open' : '' }}">

                        <li>
                            <a href="{{ route('student.presensi.create') }}"
                               class="submenu {{ request()->routeIs('student.presensi.create') ? 'active' : '' }}">
                                Presensi Harian
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('student.presensi.index') }}"
                               class="submenu {{ request()->routeIs('student.presensi.index') ? 'active' : '' }}">
                                Daftar Kehadiran
                            </a>
                        </li>

                    </ul>

                </li>


                {{-- ================= LOGBOOK ================= --}}
                @php
                    $logbookActive = request()->routeIs('student.logbook.*');
                @endphp

                <li>

                    <div onclick="toggleDropdown(this,'logbookDropdown')"
                        class="menu-item dropdown {{ $logbookActive ? 'active' : '' }}">

                        <div class="flex items-center gap-3">
                            <x-heroicon-s-book-open class="menu-icon"/>
                            <span>Logbook</span>
                        </div>

                        <x-heroicon-m-chevron-left
                            class="chevron-icon w-5 h-5 {{ $logbookActive ? 'rotate-180 text-teal-400' : '' }}"/>

                    </div>


                    <ul id="logbookDropdown"
                        class="dropdown-menu {{ $logbookActive ? 'open' : '' }}">

                        <li>
                            <a href="{{ route('student.logbook.create') }}"
                               class="submenu {{ request()->routeIs('student.logbook.create') ? 'active' : '' }}">
                                Logbook Harian
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('student.logbook.index') }}"
                               class="submenu {{ request()->routeIs('student.logbook.index') ? 'active' : '' }}">
                                Daftar Logbook
                            </a>
                        </li>

                    </ul>

                </li>


                {{-- ================= NILAI ================= --}}
                <li onclick="window.location.href='{{ route('student.nilai.index') }}'"
                    class="menu-item {{ request()->routeIs('student.nilai.*') ? 'active' : '' }}">

                    <x-heroicon-s-academic-cap class="menu-icon"/>
                    <span>Nilai</span>

                </li>


            </ul>
        </nav>

    </aside>

</div>



{{-- ================= STYLE ================= --}}
<style>

.menu-item{
    display:flex;
    align-items:center;
    gap:12px;
    padding:16px;
    cursor:pointer;
    border-left:6px solid transparent;
    transition:.2s;
}

.menu-item.dropdown{
    justify-content:space-between;
}

.menu-item:hover{
    border-color:#2dd4bf;
    background:#f9fafb;
}

.menu-item.active{
    color:#2dd4bf;
    border-color:#2dd4bf;
    background:#f9fafb;
}

.menu-icon{
    width:20px;
    height:20px;
    color:#111827;
}

.dropdown-menu{
    max-height:0;
    overflow:hidden;
    transition:max-height .3s;
}

.dropdown-menu.open{
    max-height:200px;
}

.submenu{
    display:block;
    padding:12px 48px;
    font-size:16px;
    color:#111827;
}

.submenu.active{
    color:#2dd4bf;
}

#sidebar.hide{
    transform:translateX(-100%);
}

</style>



{{-- ================= SCRIPT ================= --}}
<script>

function toggleSidebar(){
    const sidebar = document.getElementById("sidebar")
    sidebar.classList.toggle("hide")
}


function toggleDropdown(el, dropdownId){

    const dropdown = document.getElementById(dropdownId)
    const icon = el.querySelector(".chevron-icon")

    dropdown.classList.toggle("open")

    if(icon){
        icon.classList.toggle("rotate-180")
    }

}

</script>