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
                            <th>Fecha de Ultima Mod</th>
                            <th>Opciones</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach($prestamos as $prestamo)
                                <tr data-id="{{$prestamo->id}}" class="{{($prestamo->trashed() ? 'danger': false)}}">
                                    <td>{{$prestamo->id}}</td>
                                    <td>{{$prestamo->user->name}}</td>
                                    <td>{{$prestamo->tipo_prestamo->nombre}}</td>
                                    <td>{{$prestamo->updated_at}}</td>
                                    <td>{{$prestamo->created_at}}</td>

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
    </script>
@endpush