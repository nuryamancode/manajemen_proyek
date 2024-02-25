<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-lg bg-white">
        <div class="navbar-header" data-logobg="skin6">
            <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <!-- Logo -->
            <div class="navbar-brand" style="background-color: #212529">
                <a href="{{ route('karyawan.dashboard') }}">
                    <img src="{{ asset('image/simprodpek.png') }}" alt="" class="img-fluid mt-5" width="80%">
                </a>
            </div>
            <!-- End Logo -->

            <!-- Toggle which is visible on mobile only -->
            <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                    class="ti-more"></i></a>
        </div>
        <!-- End Logo -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- toggle and nav items -->
            <ul class="navbar-nav float-left me-auto ms-3 ps-1">
                <!-- Notification -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                        id="bell" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span><i data-feather="bell" class="svg-icon"></i></span>
                        <span class="badge text-bg-primary notify-no rounded-circle">{{ $jumlah }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                        <ul class="list-style-none">
                            @if ($notifikasi->isEmpty())
                                <li>
                                    <a class="nav-link pt-3 text-center text-dark disabled" href="javascript:void(0);">
                                        <strong>Tidak ada notifikasi</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            @else
                                <li>
                                    <div class="message-center notifications position-relative" style="width: 400px">
                                        @foreach ($notifikasi as $item)
                                            <a href="{{ route('karyawan.baca.notifikasi', $item->id_notifikasi) }}"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <span class="btn btn-primary rounded-circle btn-circle"><i
                                                        data-feather="box" class="text-white"></i></span>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1">{{ $item->judul }}
                                                        @if ($item->dibaca == false)
                                                        <span class="badge text-bg-danger notify-no rounded-circle">Belum Dibaca</span></h6>
                                                        @else
                                                            {{ null }}
                                                        @endif
                                                    <span
                                                        class="font-12 d-block text-muted" style="max-width: 200px;">{{$item->pesan}}</span>
                                                    <span class="font-12 text-nowrap d-block text-muted">{{ $item->created_at->locale('id')->diffForHumans() }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </li>
                            @endif

                            <li>
                                <a class="nav-link pt-3 text-center text-dark" href="{{ route('karyawan.notifikasi') }}">
                                    <strong>Check all notifications</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- End Notification -->
                <!-- create new -->
            </ul>
            <!-- Right side toggle and nav items -->
            <ul class="navbar-nav float-end">
                <!-- User profile and search -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        @if ($karyawan === null || $karyawan->photo_profile === null)
                            <img src="https://assets-a1.kompasiana.com/items/album/2021/03/24/blank-profile-picture-973460-1280-605aadc08ede4874e1153a12.png?t=o&v=780"
                                alt="User Profile" width="40" class="rounded-circle">
                        @else
                            <img src="{{ asset('photo_user/' . $karyawan->photo_profile) }}" alt="User Profile"
                                width="40"class="rounded-circle">
                        @endif
                        <span class="ms-2 d-none d-lg-inline-block">
                            <span class="text-dark">
                                @if ($karyawan->name === null)
                                    Nama Tidak ada
                                @else
                                    {{ $karyawan->name }}
                                @endif
                            </span> <i data-feather="chevron-down" class="svg-icon"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                        <a class="dropdown-item" href="{{ route('karyawan.profil') }}"><i data-feather="user"
                                class="svg-icon me-2 ms-1"></i>
                            My Profile</a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"><i data-feather="power"
                                class="svg-icon me-2 ms-1"></i>
                            Logout</a>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
                <!-- User profile and search -->
            </ul>
        </div>
    </nav>
</header>
