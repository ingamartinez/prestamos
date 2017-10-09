@extends('layouts.dashboard')

@section('titulo', 'Gestión de usuarios')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="header">
                    <button class="btn btn-primary waves-effect waves-light btn-lg m-b-5" data-toggle="modal" data-target="#modal_agregar_usuario">Agregar Usuario</button>
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
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Fecha Creado</th>
                            <th>Fecha de Ultima Mod</th>
                            <th>Opciones</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($users as $user)
                            <tr data-id="{{$user->id}}" class="{{($user->trashed() ? 'danger': false)}}">
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @foreach($user->roles as $rol)
                                        {{$rol->name}}
                                    @endforeach
                                </td>
                                <td>{{$user->updated_at}}</td>
                                <td>{{$user->created_at}}</td>

                                <td>
                                    @if($user->trashed())
                                        <a href="#" class="restaurar"><i class="fa fa-undo fa-lg" style="color: #0c7cd5"></i></a>
                                    @elseif(!($user->id == auth()->user()->id))
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
    @include('admin.gestion_usuarios.includes.modal_agregar_usuario')
    @include('admin.gestion_usuarios.includes.modal_editar_usuario')
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
            url: '{{url('gestion-usuarios')}}/' + id,
            success: function (data) {

                $('#modal_editar_usuario_id').val(data.id);
                $('#modal_editar_usuario_name').val(data.name);
                $('#modal_editar_usuario_email').val(data.email);

                $('input:radio[name=radio_rol]').val([_.first(data.roles).slug]).radio('checked');


                $("#modal_editar_usuario").modal('toggle');
            }
        });
    });


    $('#form_editar_usuario').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            e.preventDefault();
            var id=$("#modal_editar_usuario_id").val();
//            console.log(id);

            $.ajax({
                type: 'PUT',
                url: '{{url('gestion-usuarios')}}/'+id,
                data: $('#form_editar_usuario').serialize(),
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
            title: 'Eliminar usuario',
            text: "¿Estas seguro de eliminar este usuario?",
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
                url: '{{url('gestion-usuarios')}}/' + id,
                success: function (data) {
                    swal({
                        title: 'Eliminado!',
                        text: "El usuario ha sido eliminado.",
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
            title: 'Restaurar Usuario',
            text: "¿Esta seguro de restaurar este usuario?",
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
                url: '{{url('restaurar-usuario')}}/' + id,
                success: function (data) {
                    swal({
                        title: 'Restaurado!',
                        text: "El usuario ha sido resaurado.",
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