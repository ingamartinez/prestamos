@extends('layouts.dashboard')

@section('titulo', 'Gestión de Dispositivos')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="header">
                    <button class="btn btn-primary waves-effect waves-light btn-lg m-b-5" data-toggle="modal" data-target="#modal_agregar_dispositivo">Agregar Dispositivo</button>
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
                            <th>Cantidad</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Fecha Creado</th>
                            <th>Fecha de Ultima Mod</th>
                            <th>Opciones</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($dispositivos as $dispositivo)
                            <tr data-id="{{$dispositivo->id}}" class="{{($dispositivo->trashed() ? 'danger': false)}}">
                                <td>{{$dispositivo->cantidad}}</td>
                                <td>{{$dispositivo->nombre}}</td>
                                <td>{{$dispositivo->tipo_dispositivo->nombre}}</td>

                                <td>{{$dispositivo->created_at}}</td>
                                <td>{{$dispositivo->updated_at}}</td>

                                <td>
                                    @if($dispositivo->trashed())
                                        <a href="#" class="restaurar"><i class="fa fa-undo fa-lg" style="color: #0c7cd5"></i></a>
                                        <a href="#" class="editar"><i class="fa fa-pencil fa-lg" style="color: #10c469"></i></a>
                                    @else
                                        <a href="#" class="editar"><i class="fa fa-pencil fa-lg" style="color: #10c469"></i></a>
                                        <a href="#" class="eliminar"><i class="fa fa-trash-o fa-lg" style="color: #ff5b5b"></i></a>
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
    @include('admin.gestion_dispositivos.includes.modal_agregar_dispositivo')
    @include('admin.gestion_dispositivos.includes.modal_editar_dispositivo')
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

    $('.editar').on('click', function (e) {
        e.preventDefault();
        var fila = $(this).parents('tr');
        var id = fila.data('id');
        $.ajax({
            type: 'GET',
            url: '{{url('gestion-dispositivos')}}/' + id,
            success: function (data) {

                $('#modal_editar_dispositivo_id').val(data.id);
                $('#modal_editar_dispositivo_nombre').val(data.nombre);
                $('#modal_editar_dispositivo_cantidad').val(data.cantidad);

                edit_select.setValue(data.tipo_dispositivo_id);

                $("#modal_editar_dispositivo").modal('toggle');
            }
        });
    });


    $('#form_editar_dispositivo').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            e.preventDefault();
            var id=$("#modal_editar_dispositivo_id").val();
//            console.log(id);

            $.ajax({
                type: 'PUT',
                url: '{{url('gestion-dispositivos')}}/'+id,
                data: $('#form_editar_dispositivo').serialize(),
                success: function(){
                    location.reload();
                }
            });
        }
    });

    $('.eliminar').on('click', function (e) {
        e.preventDefault();

        var fila = $(this).parents('tr');
        var id = fila.data('id');

        swal({
            title: 'Eliminar dispositivo',
            text: "¿Estas seguro de eliminar este dispositivo?",
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
                url: '{{url('gestion-dispositivos')}}/' + id,
                success: function (data) {
                    swal({
                        title: 'Eliminado!',
                        text: "El dispositivo ha sido eliminado.",
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

    $('.restaurar').on('click', function (e) {
        e.preventDefault();

        var fila = $(this).parents('tr');
        var id = fila.data('id');

        swal({
            title: 'Restaurar Dispositivo',
            text: "¿Esta seguro de restaurar este dispositivo?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1ccc51',
            confirmButtonText: 'Si'
        }).then(function () {
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('restaurar-dispositivo')}}/' + id,
                success: function (data) {
                    swal({
                        title: 'Restaurado!',
                        text: "El dispositivo ha sido resaurado.",
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

</script>
@endpush