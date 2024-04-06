<x-layouts.app title="Pengaturan">
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan / </span> Pekerjaan</h4>

<div class="row">
    <div class="col-md-12">

    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="bx bx-user me-1"></i>Jenis Pekerja</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#"><i class="bx bxs-spreadsheet me-1"></i>Kategori Pekerjaan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="bx bx-collection me-1"></i>Item Pekerjaan</a>
        </li>
    </ul>

    {{-- <ul class="nav nav-pills flex-md-row mb-3">
            <li class="nav-item">
                <a class="nav-link btn-regional" href="#"></a><i class="bx bx-plus-circle me-1"></i> Judul Pekerjaan </a>
            </li>

            <li class="nav-item">
                <a class="nav-link btn-regional" href="#"></a><i class="bx bx-plus-circle me-1"></i> Item Pekerjaan </a>
            </li>
    </ul> --}}
        <div class="card mb-4">
            <h5 class="card-header">
                Kategori Pekerjaan
            </h5>

            <div class="card-body">
            <a href="#" class="mb-4 btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Kategori Pekerjaan
            </a>
                <table class="table table-hover" id="izin-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori Pekerjaan</th>
                            <th>aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <td>1</td>
                            <td>Pekerjaan Persiapan </td>
                            <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                <a class="dropdown-item" href="#"><i class="bx bx-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Kategori Pekerjaan</th>
                            <th>aksi</th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>
