<x-layouts.app title="Pengaturan">

        <h4 class="fw-bold py-3 mb-4">Pengaturan</h4>

        <div class="row">
            <div class="col-md-12">

                {{-- Menu --}}
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item me-3">
                        {{-- Jika request url adalah url yg di tentukan, set class active --}}
                        <a class="btn btn-primary" href="{{ route('pengaturan.menu.index') }}">
                            <i class="bx bx-user me-1"></i> Menu
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        {{-- Jika request url adalah url yg di tentukan, set class active --}}
                        <a class="btn btn-primary" href="{{ route('pengaturan.submenu.index') }}">
                            <i class="bx bx-user me-1"></i> Sub Menu
                        </a>
                    </li>
                </ul>

            </div>
        </div>

</x-layouts.app>
