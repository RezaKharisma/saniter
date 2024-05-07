<x-layouts.app title="Dashboard">

    <x-slot name="style">
        <style>
            canvas{
                background: url("{{ asset('assets/cuyFKkLzVdKV5i3KrzpVWxfKttCF1url83vjSobR.jpg') }}");
                background-size: contain;
                background-repeat: no-repeat;
            }

        </style>
    </x-slot>

    {{-- <div class="card">
        <div class="card-body">
            <x-partials.label title="Nomor" />
            <input type="text" id="nomorDenah" class="form-control" readonly>
        </div>
        <div class="card-body">
            <div class="row justify-content-center d-flex">
                <div class="col-12 col-sm-12 col-md-8">
                    <div class="card shadow overflow-hidden" style="height: 500px">
                        <h5 class="card-header">Denah</h5>
                        <div class="card-body p-4" id="both-scrollbars-example">
                            <canvas id="canvas" width="600" height="800"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/vendor/libs/jcanvas/jcanvas.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                var nomor = [];

                $('canvas').drawRect({
                    layer: true,
                    strokeStyle: 'rgb(204,51,51)',
                    strokeWidth: 5,
                    x: 100, y: 80,
                    width: 80,
                    height: 140,
                    cornerRadius: 10,
                    click: function(layer) {
                        if (layer.strokeStyle == 'rgb(204,51,51)') {
                            addNomor("tambah",1);
                            $(this).animateLayer(layer, {
                                strokeStyle: 'rgb(40,167,69)',
                            }, 1);
                        }

                        if (layer.strokeStyle == 'rgb(40,167,69)') {
                            addNomor("hapus",1);
                            $(this).animateLayer(layer, {
                                strokeStyle: 'rgb(204,51,51)',
                            }, 1);
                        }
                    }
                });

                $('canvas').drawRect({
                    layer: true,
                    strokeStyle: 'rgb(204,51,51)',
                    strokeWidth: 5,
                    x: 192, y: 80,
                    width: 80,
                    height: 140,
                    cornerRadius: 10,
                    click: function(layer) {
                        if (layer.strokeStyle == 'rgb(204,51,51)') {
                            addNomor("tambah",2);
                            $(this).animateLayer(layer, {
                                strokeStyle: 'rgb(40,167,69)',
                            }, 1);
                        }

                        if (layer.strokeStyle == 'rgb(40,167,69)') {
                            addNomor("hapus",2);
                            $(this).animateLayer(layer, {
                                strokeStyle: 'rgb(204,51,51)',
                            }, 1);
                        }
                    }
                });

                function addNomor(event, no){
                    if (event == "tambah") {
                        nomor.push(no)
                        nomor.sort();
                        $('#nomorDenah').val(nomor);
                    }else{
                        nomor = $.grep(nomor, function(value) {
                            return value != no;
                        });
                        nomor.sort();
                        $('#nomorDenah').val(nomor);
                    }
                }
            });
        </script>
    </x-slot> --}}
</x-layouts.app>
