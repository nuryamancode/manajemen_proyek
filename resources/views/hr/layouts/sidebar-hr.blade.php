<style>
    .sidebar-user__title {
        width: 100px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="left-sidebar">
    <div class="sidebar-footer">
        @if ($hr === null || $hr->user_id === null)
            <a href="{{ route('hr.profilku') }}" class="sidebar-user">
                <div class="sidebar-user-info">
                    <span class="sidebar-user__title">{{ null }}</span>
                    <span class="sidebar-user__subtitle">{{ $role }}</span>
                </div>
            </a>
        @else
            <a href="{{ route('hr.profilku') }}" class="sidebar-user">
                <span class="sidebar-user-img">
                    <picture>
                        @if ($hr === null || $hr->photo_profile === null)
                            <source
                                srcset="https://assets-a1.kompasiana.com/items/album/2021/03/24/blank-profile-picture-973460-1280-605aadc08ede4874e1153a12.png?t=o&v=780"
                                type="image/jpg">
                            <img src="https://assets-a1.kompasiana.com/items/album/2021/03/24/blank-profile-picture-973460-1280-605aadc08ede4874e1153a12.png?t=o&v=780"
                                alt="User Profile" width="50px" height="50px">
                        @else
                            <source srcset="{{ asset('photo_user/' . $hr->photo_profile) }}" type="image">
                            <img src="{{ asset('photo_user/' . $hr->photo_profile) }}" alt="User Profile"
                                width="50px" height="50px">
                        @endif
                    </picture>
                </span>
                <div class="sidebar-user-info">
                    <span class="sidebar-user__title">{{ $hr->name }}</span>
                    <span class="sidebar-user__subtitle">{{ $role }}</span>
                </div>
            </a>
        @endif

    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            <li class="sidebar-item mt-3">
                <a class="sidebar-link  {{ 'hr' == request()->path() ? 'active' : '' }}"
                    href="{{ route('hr.dashboard') }}" aria-expanded="false">
                    <span>
                        <i class="bi bi-grid-1x2-fill"></i>
                    </span>
                    <span class="hide-menu">Dashboard</span>
                </a>
            </li>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Data Master</span>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('hr.kriteria') }}"
                    class='sidebar-link {{ Str::startsWith(request()->path(), 'hr/kriteria') ? 'active' : '' }}'>
                    <i class="bi bi-clipboard2-data-fill"></i>
                    <span>Kelola Kriteria</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ Str::startsWith(request()->path(), 'hr/sub-kriteria') ? 'active' : '' }}"
                    href="{{ route('hr.sub.kriteria') }}" aria-expanded="false">
                    <span>
                        <i class="bi bi-clipboard2-check-fill"></i>
                    </span>
                    <span class="hide-menu">Kelola Sub Kriteria</span>
                </a>
            </li>
            <li class="sidebar-item  has-submenu">
                <a href="#"
                    class='sidebar-link {{ 'hr/data-karyawan' == request()->path() ? 'active' : '' }} {{ 'hr/data-bidang' == request()->path() ? 'active' : '' }}'>
                    <i class="bi bi-person-vcard-fill"></i>
                    <span>Karyawan</span>
                    <i class="bi bi-caret-down-fill"></i>
                </a>
                <ul class="submenu collapse">
                    <li class="active">
                        <a href="{{ route('hr.datakaryawan') }}"
                            class="sidebar-link {{ Str::startsWith(request()->path(), 'hr/data-karyawan') ? 'active' : '' }}">Data
                            Karyawan</a>
                    </li>
                    <li class=" ">
                        <a href="{{ route('hr.bidang') }}"
                            class="sidebar-link {{ Str::startsWith(request()->path(), 'hr/data-bidang') ? 'active' : '' }}">Data
                            Bidang</a>
                    </li>
                </ul>
            </li>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">AUTHENTICATE</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link {{ 'hr/manageuser' == request()->path() ? 'active' : '' }}"
                    href="{{ route('hr.manageuser') }}" aria-expanded="false">
                    <span>
                        <i class="bi bi-file-earmark-person-fill"></i>
                    </span>
                    <span class="hide-menu">Manage User</span>
                </a>
            </li>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">REPORT</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('maintenance') }}" aria-expanded="false">
                    <span>
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </span>
                    <span class="hide-menu">Rekap Hasil Penilaian</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('maintenance') }}" aria-expanded="false">
                    <span>
                        <i class="bi bi-file-text-fill"></i>
                    </span>
                    <span class="hide-menu">Laporan Hasil Kinerja</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>
<!-- End Sidebar scroll-->
