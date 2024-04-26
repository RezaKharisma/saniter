<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search menu..." aria-label="Search..." onclick="searchMenu()"/>
            </div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item lh-1 me-3">
                <span class="badge bg-secondary">Regional {{ getRegional(auth()->user()->regional_id) }}</span>
            </li>

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    @if (checkNewMaterial() == true)
                        <i class="bx bx-bell" style="font-size: 25px"></i>
                        <span class="badge badge-center rounded-pill bg-danger" style="transform: translate(-10px, -10px);width:10px;height:12px;font-size: 10px"> </span>
                    @else
                        <i class="bx bx-bell me-2" style="font-size: 25px"></i>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h5 class="text-body mb-0 me-auto">Notifikasi</h5>
                            <a href="javascript:void(0)" class="dropdown-notifications-all text-body" ><i class="bx fs-4 bx-envelope-open"></i></a>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    @if (checkNewMaterial() == true)
                        <li>
                            <a class="dropdown-item" href="{{ route('stok-material.pengajuan.index') }}">
                                <h6 class="mb-1">Material Baru</h6>
                                <p class="mb-0">Baru ditambahkan, menunggu validasi.</p>
                            </a>
                        </li>
                    @else
                        <li class="p-2">
                            <div class="alert alert-primary mb-0" style="width: 300px" role="alert">
                                Belum ada notifikasi terbaru.
                            </div>
                        </li>
                    @endif
                </ul>
            </li>

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('storage/'.Auth()->user()->foto) }}" :alt="Auth()->user()->name" class="w-px-40 rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('storage/'.Auth()->user()->foto) }}" :alt="Auth()->user()->name" class="w-px-40 rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ Str::limit(Auth()->user()->name, 20) }}</span>
                                    <small class="text-muted">
                                        @if (isset(auth()->user()->getRoleNames()[0]))
                                            {{ auth()->user()->getRoleNames()[0] }}
                                        @else
                                            Belum Memiliki Hak Akses
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">Profil</span>
                        </a>
                    </li>

                    {{-- Menu Pengaturan Admin --}}
                    @role(['Admin|Administrator'])
                        <li>
                            <a class="dropdown-item" href="{{ route('pengaturan.index') }}">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Pengaturan</span>
                            </a>
                        </li>
                    @endrole

                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                            <i class="bx bx-power-off me-2"></i>
                                @csrf
                                <button type="submit" class="btn btn-link" style="color: #697a8d; margin-left: -20px">Keluar</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

