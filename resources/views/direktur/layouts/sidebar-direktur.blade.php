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
        @if ($direktur === null || $direktur->user_id === null)
            <a href="{{ route('direktur.profil') }}" class="sidebar-user">
                <div class="sidebar-user-info">
                    <span class="sidebar-user__title">{{ null }}</span>
                    <span class="sidebar-user__subtitle">{{ $role }}</span>
                </div>
            </a>
        @else
            <a href="{{ route('direktur.profil') }}" class="sidebar-user">
                <span class="sidebar-user-img">
                    <picture>
                        @if ($direktur === null || $direktur->photo_profile === null)
                            <source
                                srcset="https://assets-a1.kompasiana.com/items/album/2021/03/24/blank-profile-picture-973460-1280-605aadc08ede4874e1153a12.png?t=o&v=780"
                                type="image/jpg">
                            <img src="https://assets-a1.kompasiana.com/items/album/2021/03/24/blank-profile-picture-973460-1280-605aadc08ede4874e1153a12.png?t=o&v=780"
                                alt="User Profile" width="50px" height="50px">
                        @else
                            <source srcset="{{ asset('photo_user/' . $direktur->photo_profile) }}"
                                type="image">
                            <img src="{{ asset('photo_user/' . $direktur->photo_profile) }}" alt="User Profile"
                                width="50px" height="50px">
                        @endif
                    </picture>
                </span>
                <div class="sidebar-user-info">
                    <span class="sidebar-user__title">{{ $direktur->name }}</span>
                    <span class="sidebar-user__subtitle">{{ $role }}</span>
                </div>
            </a>
        @endif

    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            <li class="sidebar-item mt-3">
                <a class="sidebar-link  {{ 'direktur' == request()->path() ? 'active' : '' }}"
                    href="{{ route('direktur.dashboard') }}" aria-expanded="false">
                    <span>
                        <i class="bi bi-grid-1x2-fill"></i>
                    </span>
                    <span class="hide-menu">Dashboard</span>
                </a>
            </li>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">MANAJEMEN PROYEK</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ Str::startsWith(request()->path(), 'direktur/klien') ? 'active' : '' }}"
                    href="{{ route('direktur.klien') }}" aria-expanded="false">
                    <span>
                        <i class="bi bi-file-earmark-person-fill"></i>
                    </span>
                    <span class="hide-menu">Daftar Klien</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ Str::startsWith(request()->path(), 'direktur/proyek') ? 'active' : '' }}"
                    href="{{ route('direktur.proyek') }}" aria-expanded="false">
                    <span>
                        <i class="bi bi-file-earmark-person-fill"></i>
                    </span>
                    <span class="hide-menu">Daftar Proyek</span>
                </a>
            </li>
            <li class="sidebar-item  has-submenu">
                <a href="#"
                    class='sidebar-link {{ Str::startsWith(request()->path(), 'direktur/status') ? 'active' : '' }}'>
                    <i class="bi bi-clipboard2-check-fill"></i>
                    <span>Status Proyek</span>
                    <i class="bi bi-caret-down-fill"></i>
                </a>
                <ul class="submenu collapse">
                    <li class="">
                        <a href="{{ route('direktur.inprogress.proyek') }}"
                            class="sidebar-link {{ 'direktur/inprogress/proyek' == request()->path() ? 'active' : '' }}">Proyek
                            Daftar Proyek Proses</a>
                    </li>
                    <li class=" ">
                        <a href="{{ route('direktur.done.proyek') }}"
                            class="sidebar-link {{ 'direktur/done/proyek' == request()->path() ? 'active' : '' }}">Proyek
                            Daftar Proyek Selesai</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ 'direktur/kalender-proyek' == request()->path() ? 'active' : '' }}"
                    href="{{ route('direktur.kalender.proyek') }}" aria-expanded="false">
                    <span>
                        <i class="bi bi-file-earmark-person-fill"></i>
                    </span>
                    <span class="hide-menu">Kalender Proyek</span>
                </a>
            </li>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">REPORT</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ 'direktur/laporan-selesai' == request()->path() ? 'active' : '' }}"
                    href="{{ route('direktur.laporan.selesai') }}" aria-expanded="false">
                    <span>
                        <i class="bi bi-file-earmark-person-fill"></i>
                    </span>
                    <span class="hide-menu">Laporan Proyek Selesai</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ 'manageuser' == request()->path() ? 'active' : '' }}"
                    href="{{ route('maintenance') }}" aria-expanded="false">
                    <span>
                        <i class="bi bi-file-earmark-person-fill"></i>
                    </span>
                    <span class="hide-menu">Laporan Kinerja Karyawan</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>
<!-- End Sidebar scroll-->
