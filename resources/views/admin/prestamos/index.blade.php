@extends('layouts.dashboard')

@section('titulo', 'Gestión Prestamos')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="header">
                    <a class="btn btn-primary waves-effect waves-light btn-lg m-b-5" href="{{route('prestamos.create')}}">Agregar Prestamo</a>
                </div>
                <div class="content">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @include('flash::message')

                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Tipo de Prestamo</th>
                            <th>Fecha Creado</th>
                            <th>Fecha de Finalizado</th>
                            <th>Opciones</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach($prestamos as $prestamo)
                                <tr data-id="{{$prestamo->id}}" class="{{($prestamo->trashed() ? 'success': false)}}">
                                    <td>{{$prestamo->id}}</td>
                                    <td>{{$prestamo->user->name}}</td>
                                    <td>{{$prestamo->tipo_prestamo->nombre}}</td>
                                    <td>{{$prestamo->created_at}}</td>
                                    <td>{{$prestamo->deleted_at}}</td>

                                    <td>
                                        <a href="#" class="detalle" style="color: #252422"><i class="fa fa-align-justify fa-lg" style="color: #2c61c4"></i> Detalle </a>
                                        @if(!$prestamo->trashed())
                                            <a href="#" class="finalizar" style="color: #252422"><i class="fa fa-check fa-lg" style="color: #10c469"></i> Finalizar</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- end col -->
    </div>
@endsection

@section('modals')

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                "language": {
                    "url": "{{asset('assets/js/Spanish.json')}}"
                }
            });
        });

        $('.finalizar').on('click', function (e) {
            e.preventDefault();

            var fila = $(this).parents('tr');
            var id = fila.data('id');

            swal({
                title: 'Finalizar Prestamo',
                text: "¿Estas seguro de finalizar este prestamo?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1ccc51',
                confirmButtonText: 'Si'
            }).then(function () {
                $.ajax({
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url('prestamos')}}/' + id,
                    success: function (data) {
                        swal({
                            title: 'Finalizado!',
                            text: "El prestamo ha sido finalizado.",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then(function () {
                            location.reload();
                        });
                    },
                    error:function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseText);
                        swal(
                            'Ha ocurrido un error',
                            jqXHR.responseText,
                            'error'
                        );

                    }
                });
            });
        });

        $('.detalle').on('click', function (e) {
            e.preventDefault();

            var fila = $(this).parents('tr');
            var id = fila.data('id');

            $.ajax({
                type: 'GET',
                url: '{{url('detalle-prestamo')}}/' + id,
                success: function (data) {
                    var html="";

                    _.each(data, function (dispositivo) {

                        html=html+
                            '<div style="text-align: justify"><br><b>Dispositivo: </b>'+dispositivo.nombre + '<br>'+
                            '<b>Cantidad: </b>'+dispositivo.pivot.cantidad+'<br></div>'
                    });

                    swal({
                        title: 'Detalle del Prestamo',
                        html:html,
                        showCloseButton: true,
                        focusConfirm: true,
                        confirmButtonText:
                            '<i class="fa fa-thumbs-up"></i> Ok!',
                        confirmButtonAriaLabel: 'Thumbs up, great!'
                    })
                },
                error:function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                    swal(
                        'Ha ocurrido un error',
                        jqXHR.responseText,
                        'error'
                    );

                }
            });
        });

    </script>
@endpush