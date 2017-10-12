<div id="modal_agregar_usuario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Formulario Agregar Usuario</h4>
            </div>

            <form action="{{route('usuario.store')}}" method="POST" autocomplete="off" id="form_agregar_usuario">
                {{method_field('POST')}}
                {{csrf_field()}}

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="name" name="name" data-remote="{{route('usuario.validar')}}" data-remote-method="POST" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" data-remote="{{route('usuario.validar')}}" data-remote-method="POST" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="control-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" data-remote="{{route('usuario.validar')}}" data-remote-method="POST" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="control-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="password-confirm" data-match="#password" data-match-error="Las contraseñas no coinciden" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Escoja un Rol</label>
                                <div class="radio radio-success">
                                    <input type="radio" name="radio_rol" id="radio_admin" value="admin" data-remote="{{route('usuario.validar')}}" data-remote-method="POST" required>
                                    <label for="radio_admin">
                                        Usuario Administrador
                                    </label>
                                </div>
                                <div class="radio radio-info">
                                    <input type="radio" name="radio_rol" id="radio_usuario" value="estudiante" data-remote="{{route('usuario.validar')}}" data-remote-method="POST" required>
                                    <label for="radio_usuario">
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
                    <button type="submit" class="btn btn-info waves-effect waves-light">Agregar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#form_agregar_usuario').validator();

//            $('#form_agregar_usuario').on('submit',function (e) {
//                e.preventDefault();
//                $('#password').val(sha3_224($('#password').val()));
//                this.submit();
//            })

        });
    </script>

@endpush