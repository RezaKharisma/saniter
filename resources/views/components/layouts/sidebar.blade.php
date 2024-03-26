<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
               <img src="{{ asset('assets/img/logo/logo-qinar.png') }}" alt="Logo Qinar" width="50px">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Saniter</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="index.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('user.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">User</div>
            </a>
        </li>

        

        
        <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Misc">Regional & Lokasi</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('regional.index') }}" class="menu-link">
                        {{-- <i class="menu-icon tf-icons bx bx-buildings"></i> --}}
                        <div data-i18n="Analytics">Regional</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('lokasi.index') }}" class="menu-link">
                        {{-- <i class="menu-icon tf-icons bx bx-current-location"></i> --}}
                        <div data-i18n="Analytics">Lokasi</div>
                    </a>
                </li>
              </ul>
            </li>
        @foreach (getMenu() as $group => $options)

            <!-- {{ $group }} -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">{{ $group }}</span></li>

            @foreach ($options as $item)

                <!-- {{ $item->judul }} -->
                <li class="menu-item">
                    <a href="@if (count(getSubMenu($item->id)) < 0) 'javascript:void(0);' @else {{ $item->url }} @endif" class="menu-link @if (count(getSubMenu($item->id)) > 0) menu-toggle @endif">
                        <i class="menu-icon tf-icons bx bx-{{ $item->icon }}"></i>
                        <div data-i18n="Layouts">{{ $item->judul }}</div>
                    </a>

                    @if (count(getSubMenu($item->id)) > 0)

                        <ul class="menu-sub">

                            @foreach (getSubMenu($item->id) as $sm)
                            <li class="menu-item">
                                <a href="{{ strval($item->url.'/'.$sm->url) }}" class="menu-link">
                                    <div data-i18n="Without menu">{{ $sm->judul }}</div>
                                </a>
                            </li>
                            @endforeach

                        </ul>

                    @endif

                </li>

            @endforeach

        @endforeach
    </ul>
</aside>
