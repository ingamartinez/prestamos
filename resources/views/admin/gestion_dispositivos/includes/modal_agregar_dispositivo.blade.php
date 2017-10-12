<div id="modal_agregar_dispositivo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Formulario Agregar Dispositivo</h4>
            </div>

            <form action="{{route('dispositivo.store')}}" method="POST" autocomplete="off" id="form_agregar_dispositivo">
                {{method_field('POST')}}
                {{csrf_field()}}

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre" class="control-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" data-remote="{{route('dispositivo.validar')}}" data-remote-method="POST" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cantidad" class="control-label">Cantidad</label>
                                <input type="text" class="form-control" id="cantidad" name="cantidad" data-remote="{{route('dispositivo.validar')}}" data-remote-method="POST" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select-tipo-dispositivo" class="control-label">Tipo de Dispositivo</label>
                                <select name="select-tipo-dispositivo" id="select-tipo-dispositivo" placeholder="Seleccione un dispositivo..." data-remote="{{route('dispositivo.validar')}}" data-remote-method="POST" required>
                                    <option value="">Seleccione un dispositivo...</option>
                                    @foreach($tipo_dispositivos as $tipo_dispositivo)
                                        <option value="{{$tipo_dispositivo->id}}">{{$tipo_dispositivo->nombre}}</option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Agregar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#form_agregar_dispositivo').validator();
            $('#select-tipo-dispositivo').selectize();

//            $('#form_agregar_usuario').on('submit',function (e) {
//                e.preventDefault();
//                $('#password').val(sha3_224($('#password').val()));
//                this.submit();
//            })

        });
    </script>

@endpush