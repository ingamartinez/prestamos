<div id="modal_editar_usuario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Formulario Editar Usuario</h4>
            </div>

            <form method="POST" autocomplete="off" id="form_editar_usuario">

                {{csrf_field()}}

                <input type="hidden" name="id" id="modal_editar_usuario_id" value="">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="modal_editar_usuario_name" name="name" placeholder="Ej: Alejandro Martinez" data-remote="{{route('usuario.validar')}}" data-remote-method="POST" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input type="text" class="form-control" id="modal_editar_usuario_email" name="email" placeholder="Ej: ing.amartinez94@gmail.com" data-remote="{{route('usuario.validar')}}" data-remote-method="POST" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Escoja un Rol</label>
                                <div class="radio radio-success">
                                    <input type="radio" name="radio_rol" id="modal_editar_usuario_radio_admin" value="admin" data-remote="{{route('usuario.validar')}}" data-remote-method="POST" required>
                                    <label for="modal_editar_usuario_radio_admin">
                                        Usuario Administrador
                                    </label>
                                </div>
                                <div class="radio radio-info">
                                    <input type="radio" name="radio_rol" id="modal_editar_usuario_radio_estudiante" value="estudiante" data-remote="{{route('usuario.validar')}}" data-remote-method="POST" required>
                                    <label for="modal_editar_usuario_radio_estudiante">
                                        Usuario Estudiante
                                    </label>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Editar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#form_editar_usuario').validator();
        });
    </script>

@endpush