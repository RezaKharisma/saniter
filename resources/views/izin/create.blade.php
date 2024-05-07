<x-layouts.app title="Tambah Izin">

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.css') }}">
        <style>
            .select2 {
                width:100%!important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi / </span>Tambah Izin</h4>

    {{-- Menu --}}
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="btn btn-secondary d-block" href="{{ route('izin.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">
                    Form Izin
                </h5>
                <form method="post" action="{{ route('izin.store') }}" enctype="multipart/form-data" id="formSubmit">
                    @csrf
                    <div class="card-body">

                        {{-- Nama Lengkap --}}
                        @role('Teknisi')
                            <div class="mb-3">
                                <x-partials.label title="Nama Lengkap" required/>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="background-color: #eceef1" @error('name') style="border: solid red 1px;" @enderror readonly><i class="bx bx-user"></i></span>
                                    <input type="hidden" name="name" value="{{ auth()->user()->id }}">
                                    <input type="text" class="form-control" placeholder="Nama Lengkap" value="{{ auth()->user()->name }}" readonly/>
                                </div>
                                <x-partials.error-message name="name" class="d-block" />
                            </div>
                        @else
                            <div class="mb-3">
                                <x-partials.label title="Nama Lengkap" required/>
                                <select name="name" class="form-control @error('name')is-invalid @enderror" id="select-field" required data-placeholder="Pilih nama..." onchange="cekJumlahIzin(this)">
                                    <option></option>
                                    @foreach ($user as $item)
                                        <option @if(old('name') == $item->id) selected  @endif  value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <x-partials.error-message name="name" class="d-block" />
                            </div>
                        @endrole

                        {{-- Jenis Izin --}}
                        <div class="mb-3">
                            <x-partials.label title="Jenis Izin" required/>
                            <select name="jenis_izin" id="jenis_izin" class="form-control @error('jenis_izin')is-invalid @enderror" required>
                                <option value="" selected disabled>Pilih jenis izin...</option>
                                <option @if(old('jenis_izin') == "Sakit") selected  @endif value="Sakit" >Sakit</option>
                                <option @if(old('jenis_izin') == "Cuti") selected @endif value="Cuti">Cuti</option>
                                <option @if(old('jenis_izin') == "Izin") selected @endif value="Izin">Izin</option>
                            </select>
                            <x-partials.error-message name="jenis_izin" class="d-block" />
                        </div>

                        @role('Teknisi')
                            <div class="alert alert-warning" role="alert">Sisa Jumlah Izin : <span id="jumlah">{{ $jumlahIzin->jumlah_izin ?? 'Belum memiliki hak cuti / belum ditambahkan' }}</span></div>
                        @endrole

                        <div class="mb-3" id="alertSisaJumlahIzin"></div>

                        {{-- Tanggal Izin --}}
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-5 mb-3">
                                <x-partials.label title="Tanggal Mulai" required/>
                                <input type="text" class="form-control" id="start_time" name="tgl_mulai_izin" placeholder="Tanggal Mulai" onchange="tanggalAkhir(this)" required autocomplete="off"/>
                                <x-partials.error-message name="tgl_mulai_izin" class="d-block" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-5 mb-3">
                                <x-partials.label title="Tanggal Akhir" required/>
                                <input type="text" class="form-control" id="end_time" name="tgl_akhir_izin"  placeholder="Tanggal Akhir" onchange="totalHari(this)" required autocomplete="off"/>
                                <x-partials.error-message name="tgl_akhir_izin" class="d-block" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-2">
                                <x-partials.label title="Total Hari"/>
                                <input type="text" class="form-control" name="total_izin" id="total" placeholder="Total" disabled/>
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-partials.label title="Keterangan" />
                            <textarea name="keterangan" rows="4" class="form-control" placeholder="Keterangan" required>{{ old('keterangan') }}</textarea>
                        </div>

                        {{-- Dokumen --}}
                        <div class="">
                            <x-partials.label title="Dokumen Pendukung" required/>
                            <x-partials.input-file name="foto" id="foto" required/>
                            <x-partials.error-message name="foto" class="d-block" />
                        </div>

                    </div>
                    <div class="card-footer">
                        <a href="{{ route('izin.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.js') }}"></script>
        <script>
            $(document).ready(function () {
                $("#end_time").prop('disabled', true);
                var dateToday = new Date();
                $("#start_time").datepicker({
                    dateFormat: 'dd/mm/yy',
                    minDate: dateToday
                });

                $("#end_time").datepicker({});
                $( '#select-field' ).select2( {
                    theme: 'bootstrap-5'
                } );
            });

            function tanggalAkhir(e){
                $("#end_time").prop('disabled', false);
                $("#end_time").val("");

                var startTime = $("#start_time").val().split("/");
                var dateMulai = new Date(startTime[2], startTime[1] - 1, startTime[0])
                $("#end_time").datepicker("destroy");
                $("#end_time").datepicker({
                    dateFormat: 'dd/mm/yy',
                    minDate: dateMulai
                });
                $("#end_time").datepicker("refresh");
            }

            function totalHari(params) {
                total = 0;
                var oneDay  = 24*60*60*1000;
                var startTime = $("#start_time").val().split("/")
                var endTime = $("#end_time").val().split("/")
                var mulai = new Date(startTime[2], startTime[1] - 1, startTime[0]);
                var akhir = new Date(endTime[2], endTime[1] - 1, endTime[0]);
                total = Math.abs((mulai.getTime() - akhir.getTime()) / oneDay) + 1;

                if ($('#jumlah').html() < total) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'center',
                        icon: 'danger',
                        customClass: {
                            popup: 'colored-toast',
                        },
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                    })

                    ;(async () => {
                    await Toast.fire({
                        icon: 'error',
                        title: 'Total hari melebihi sisa izin!',
                    })})()
                    $('#total').val("")
                    $("#end_time").val("");
                }else{
                    $('#total').val(total)
                }
            }

            function resetForm(){
                $("#start_time").val('');
                $("#end_time").val('');
                $('#total').val('');
                $("#jenis_izin").val('')
                $('#foto').val('');
                $("#end_time").prop('disabled', true);
            }

            function cekJumlahIzin(e) {
                // Mengatur ajax csrf
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.getJumlahIzinUser') }}",
                    data: {
                        id: $(e).val() // Mengambil id pada event
                    },
                    dataType: "json",
                    success: function (response) { // Jika ajax sukses dan memberikan respon
                        resetForm();
                        var data = response.data;

                        if (data.jumlah_izin != undefined ) {
                            $('#alertSisaJumlahIzin').html('<div class="alert alert-warning" role="alert">Sisa Jumlah Izin : <span id="jumlah">'+data.jumlah_izin+'</span></div>')
                        }else{
                            $('#alertSisaJumlahIzin').html('<div class="alert alert-warning" role="alert">Belum memiliki hak cuti / belum ditambahkan. Tambahkan <a href="{{ route('pengaturan.izin.create') }}">Disini.</a></div>')
                        }
                    }
                });
            }
        </script>
    </x-slot>
</x-layouts.app>
