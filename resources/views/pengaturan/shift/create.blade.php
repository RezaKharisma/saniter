<x-layouts.app title="Shift">

    <x-slot name="style">
        <style>
            .table th {
                text-align: left !important;
            }
            input[type=time]::-webkit-datetime-edit-ampm-field {
                display: none;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan /</span> Tambah Shift</h4>

    <a href="{{ route('shift.index') }}" class="btn btn-secondary mb-3"><i class="bx bx-arrow-back me-1"></i> Kembali</a>

<!-- Striped Rows -->
<div class="card">
    <h5 class="card-header">Form Tambah Shift</h5>

    <form method="post" action="{{ route('shift.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <div class="mb-3">
                {{-- Input Nama Shift --}}
                <x-partials.label title="Regional" />
                <select name="regional_id" id="regional_id" class="form-control @error('regional_id') is-invalid @enderror" required>
                    <option value="" selected disabled>Pilih regional...</option>
                    @foreach ($regional as $item)
                        <option value="{{ $item->id }}" @if(old('regional_id') == $item->id) selected @endif>{{ $item->nama }}</option>
                    @endforeach
                </select>
                <x-partials.error-message name="nama" class="d-block"/>
            </div>

            <div>
                {{-- Input Nama Shift --}}
                <x-partials.label title="Shift" />
                <select name="nama" class="form-control @error('nama') is-invalid @enderror" required>
                    <option value="" selected disabled>Pilih Shift...</option>
                    <option value="Pagi" @if(old('nama') == "Pagi") selected @endif>Pagi</option>
                    <option value="Siang" @if(old('nama') == "Siang") selected @endif>Siang</option>
                    <option value="Sore" @if(old('nama') == "Sore") selected @endif>Sore</option>
                    <option value="Malam" @if(old('nama') == "Malam") selected @endif>Malam</option>
                </select>
                <x-partials.error-message name="nama" class="d-block"/>
            </div>

            <div class="row mt-3">
                <div class="col-12 col-sm-12 col-md-4 mb-3 mb-sm-3 mb-md-0">
                    <x-partials.label title="Timezone" />
                    <select name="timezone" id="timezone" class="form-control @error('timezone') is-invalid @enderror" required>
                        <option value="" selected disabled>Pilih timezone...</option>
                        @foreach ($timezones as $key => $item)
                            <option value="{{ $item[0] }}" @if(old('timezone') == $item[0]) selected @endif>({{ $item[0] }}) {{ $item[1] }}</option>
                        @endforeach
                    </select>
                    <x-partials.error-message name="timezone" class="d-block"/>
                    {{-- <div class='form-text mt-1'>
                        Lihat area timezone GMT <a href="#" onclick="openModalTimezone()" data-bs-toggle="modal" data-bs-target="#modalTimezone">Disini.</a>
                    </div> --}}
                </div>

                <div class="col-12 col-sm-12 col-md-4 mb-3 mb-sm-3 mb-md-0">

                    {{-- Input Jam Masuk --}}
                    <x-partials.label title="Jam Masuk" />
                    {{-- <input class="form-control @error('jam_masuk') is-invalid @enderror" type="datetime" name="jam_masuk" value="{{ old('jam_masuk') }}"> --}}
                    <input type="text" class="form-control @error('jam_masuk') is-invalid @enderror" placeholder="HH:MM" id="jam_masuk" name="jam_masuk" style="background-color: white" value="{{ old('jam_masuk') }}" required />
                    <x-partials.error-message name="jam_masuk" class="d-block"/>

                </div>
                <div class="col-12 col-sm-12 col-md-4 mb-3 mb-sm-3 mb-md-0">

                    {{-- Input Jam Pulang --}}
                    <x-partials.label title="Jam Pulang" />
                    <input type="text" class="form-control @error('jam_pulang') is-invalid @enderror" placeholder="HH:MM" id="jam_pulang" name="jam_pulang" style="background-color: white" value="{{ old('jam_keluar') }}" required/>
                    <x-partials.error-message name="jam_pulang" class="d-block"/>

                </div>
            </div>

            <div class="mt-3 mb-3">
                <x-partials.label title="Kondisi" />
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_diff_day">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Shift berikut akan melewati batas jam 00:00 malam.</label>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 col-sm-12 col-md-4 mb-3 mb-sm-3 mb-md-0">
                    <div class="card shadow">
                        <h5 class="card-header text-center">Terlambat 1</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <x-input-number title="Menit" name='terlambat_1' placeholder='Menit Keterlambatan' required/>
                                    <x-partials.error-message name="terlambat_1" class="d-block"/>
                                    <x-partials.input-desc text='Ketik menitnya saja, contoh 20' />
                                </div>
                                <div class="col-12">
                                    <x-partials.label title="Potongan" />
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" @error('potongan_1') style="border: solid red 1px;" @enderror>Rp. </span>
                                        <input type="text" name="potongan_1" class="form-control @error('potongan_1') is-invalid @enderror" placeholder="Pemotongan Upah" onkeyup="formatRupiah(this)" value="{{ old('potongan_1') }}" required/>
                                    </div>
                                    <x-partials.error-message name="potongan_1" class="d-block"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 mb-3 mb-sm-3 mb-md-0">
                    <div class="card shadow">
                        <h5 class="card-header text-center">Terlambat 2</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <x-input-number title="Menit" name='terlambat_2' placeholder='Menit Keterlambatan' required/>
                                    <x-partials.error-message name="terlambat_2" class="d-block"/>
                                    <x-partials.input-desc text='Ketik menitnya saja, contoh 40' />
                                </div>
                                <div class="col-12">
                                    <x-partials.label title="Potongan" />
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" @error('potongan_2') style="border: solid red 1px;" @enderror>Rp. </span>
                                        <input type="text" name="potongan_2" class="form-control @error('potongan_2') is-invalid @enderror" placeholder="Pemotongan Upah" onkeyup="formatRupiah(this)" value="{{ old('potongan_2') }}" required/>
                                    </div>
                                    <x-partials.error-message name="potongan_2" class="d-block"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 mb-3 mb-sm-3 mb-md-0">
                    <div class="card shadow">
                        <h5 class="card-header text-center">Terlambat 3</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <x-input-number title="Menit" name='terlambat_3' placeholder='Menit Keterlambatan' required/>
                                    <x-partials.error-message name="terlambat_3" class="d-block"/>
                                    <x-partials.input-desc text='Ketik menitnya saja, contoh 60' />
                                </div>
                                <div class="col-12">
                                    <x-partials.label title="Potongan" />
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" @error('potongan_3') style="border: solid red 1px;" @enderror>Rp. </span>
                                        <input type="text" name="potongan_3" class="form-control @error('potongan_3') is-invalid @enderror" placeholder="Pemotongan Upah" onkeyup="formatRupiah(this)" value="{{ old('potongan_3') }}" required/>
                                    </div>
                                    <x-partials.error-message name="potongan_3" class="d-block"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <a href="{{ route('shift.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

{{-- <div class="modal fade" id="modalTimezone" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Denah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body ">
                    <img src="{{ asset('assets/img/timezone-map/map.png') }}" class="img-fluid">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<x-slot name="script">
    <script>
        $(document).ready(function () {
            $("#regional_id").select2({
                theme: "bootstrap-5",
            });

            $("#timezone").select2({
                theme: "bootstrap-5",
            });

            $("#jam_masuk").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });

            $("#jam_pulang").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });
        });

        function formatRupiah(e){
            var number_string = $(e).val().replace(/[^,\d]/g, '').toString(),
                split	= number_string.split(','),
                sisa 	= split[0].length % 3,
                rupiah 	= split[0].substr(0, sisa),
                ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            $(e).val(rupiah);
        }

        function openModalTimezone(){
            $('#modalTimezone').modal('show');
        }
    </script>
</x-slot>

</x-layouts.app>
