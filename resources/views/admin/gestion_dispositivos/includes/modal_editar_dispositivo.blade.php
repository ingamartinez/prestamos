<div id="modal_editar_dispositivo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Formulario Editar Usuario</h4>
            </div>

            <form method="POST" autocomplete="off" id="form_editar_dispositivo">

                {{csrf_field()}}

                <input type="hidden" name="id" id="modal_editar_dispositivo_id" value="">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre" class="control-label">Nombre</label>
                                <input type="text" class="form-control" id="modal_editar_dispositivo_nombre" name="nombre" placeholder="Ej: Alejandro Martinez" data-remote="{{route('usuario.validar')}}" data-remote-method="POST" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cantidad" class="control-label">Cantidad</label>
                                <input type="text" class="form-control" id="modal_editar_dispositivo_cantidad" name="cantidad" placeholder="Ej: ing.amartinez94@gmail.com" data-remote="{{route('usuario.validar')}}" data-remote-method="POST" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="elect-editar-tipo-dispositivo" class="control-label">Tipo de Dispositivo</label>
                                <select name="select-tipo-dispositivo" id="select-editar-tipo-dispositivo" placeholder="Seleccione un dispositivo..." data-remote="{{route('dispositivo.validar')}}" data-remote-method="POST" required>
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
                    <button type="submit" class="btn btn-info waves-effect waves-light">Editar Dispositivo</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->

@push('script')
    <script type="text/javascript">
        var edit_select;
        $(document).ready(function() {
            $('#form_editar_dispositivo').validator();
            edit_select=$('#select-editar-tipo-dispositivo').selectize();
            edit_select= edit_select[0].selectize;
        });
    </script>

@endpush