@extends('layouts.dashboard')

@section('titulo', 'Gestión Prestamos')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="header">
                    <h3>Realizar Prestamo</h3>
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

                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Escoja un Estudiante</h4>

                            <label for="select-estudiante"></label>
                            <select name="select-estudiante" id="select-estudiante" placeholder="Seleccione un estudiante...">
                                <option value="">Seleccione un estudiante...</option>
                                @foreach($estudiantes as $estudiante)
                                    <option value="{{$estudiante->id}}">{{$estudiante->name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-lg-6">
                            <h4>Escoja Tipo de Prestamo</h4>

                            <label for="select-prestamo"></label>
                            <select name="select-prestamo" id="select-prestamo" placeholder="Seleccione un tipo de prestamo...">
                                <option value="">Seleccione un tipo de prestamo...</option>
                                @foreach($tipo_prestamos as $tipo_prestamo)
                                    <option value="{{$tipo_prestamo->id}}">{{$tipo_prestamo->nombre}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <h4>Añada una cantidad de dispositivos</h4>

                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Disponible</th>
                                    <th>Nombre Disp</th>
                                    <th>Tipo de Dispostivo</th>
                                    <th>Fecha Creado</th>
                                    <th>Fecha de Ultima Mod</th>
                                    <th>Cantidad</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($dispositivos as $dispositivo)
                                    <tr data-id="{{$dispositivo->id}}" data-cantidad="{{$dispositivo->cantidad}}">
                                        <td>{{$dispositivo->cantidad}}</td>
                                        <td>{{$dispositivo->nombre}}</td>
                                        <td>{{$dispositivo->tipo_dispositivo->nombre}}</td>
                                        <td>{{$dispositivo->updated_at}}</td>
                                        <td>{{$dispositivo->created_at}}</td>

                                        <td>
                                            <a class="btn btn-sm add">
                                                <i class="fa fa-plus" title="Align Left"></i>
                                            </a>

                                            <span style="padding-left: 5px;padding-right: 5px">0</span>

                                            <a class="btn btn-sm sub" href="#">
                                                <i class="fa fa-minus" title="Align Left"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    <h4>Finalizar Prestamo</h4>

                    <a class="btn btn-large sub" href="#" id="finalizar"><i class="fa fa-check" title="Align Left"></i> Finalizar Prestamo</a>

                </div>
            </div>
        </div><!-- end col -->
    </div>
@endsection

@section('modals')

@endsection

@push('script')
    <script>
        var id_usuario;
        var id_tipo_prestamo;
        var dispositivos=[];

        $(document).ready(function () {
            $('#datatable').DataTable({
                "language": {
                    "url": "{{asset('assets/js/Spanish.json')}}"
                }
            });
        });

        $('#select-estudiante').selectize();
        $('#select-prestamo').selectize();

        $('.add').on('click', function () {

            var cantidad = $(this).parents('tr').data('cantidad');

            $this = $(this).next('span');

            if (parseInt($this.text()) < cantidad) {
                $this.text(parseInt($this.text()) + 1);
            }
        });

        $('.sub').on('click', function () {
            $this = $(this).prev('span');

            if (parseInt($this.text()) > 0) {
                $this.text(parseInt($this.text()) - 1);
            }
        });

        $('#select-estudiante').on('change',function () {
            id_usuario=$(this).val();
        });

        $('#select-prestamo').on('change',function () {
            id_tipo_prestamo=$(this).val();
        });

        $('#finalizar').on('click',function () {
            $('span').each(function () {
                var cantidad_disponible = $(this).text();
                if(parseInt(cantidad_disponible) > 0){
                    var id = $(this).parents('tr').data('id');
//                    dispositivos[id]=cantidad_disponible;
//                    dispositivos[id]=cantidad_disponible;
                    dispositivos.push({id:id,cantidad:cantidad_disponible});


                }
            });

            console.log(dispositivos);

            $.ajax({
                url: '{{url('realizar-prestamo')}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
//                dataType: "json",
                method: 'post',
                data: {
                    'id_usuario': id_usuario,
                    'id_tipo_prestamo': id_tipo_prestamo,
                    'dispositivos[]': JSON.stringify(dispositivos)
                },
                success: function (data) {
                    swal({
                        title: 'Prestamo realizado!',
                        text: "Se ha realizado el prestamo con exito",
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
        })

    </script>
@endpush