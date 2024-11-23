<div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="usuarioModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="usuarioModalLabel">Registrar usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12" id="form_view">
                    <form id="usuarioForm">
                        @csrf
                        <div class="row">

                            <input type="hidden" id="id_user" value="" name="id_user">

                            <div class="form-group col-md-6">
                                <label for="nombre " class="label-modal">
                                    Nombres
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="nombre" id="nombre">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="apellido" class="label-modal">
                                    Apellidos
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="apellido" id="apellido">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email" class="label-modal">
                                    Correo
                                    <span class="required">*</span>
                                </label>
                                <input type="email" class="form-control" name="email" id="email">

                            </div>

                            <div class="form-group col-md-6">
                                <label for="first_name" class="label-modal">
                                    Teléfono
                                    <span class="required">*</span>
                                </label>
                                <input type="number" class="form-control" name="telefono" id="telefono" min="1"
                                    pattern="^[0-9]+">
                            </div>

                            <div class="col-md-12 row"  id="editForm" style="display: none">

                                <div class="form-group col-md-6" >
                                    <label for="first_name" class="label-modal">
                                        Estado
                                        <span class="required">*</span>
                                    </label>

                                    <select name="status" id="status" class="form-control">
                                        <option value="1"> Activo</option>
                                        <option value="0"> Inactivo </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6" >
                                    <label for="password" class="label-modal">
                                        Contraseña Anterior
                                        <span class="required">*</span>
                                    </label>
                                    <input type="password" class="form-control" name="old_password" id="old_password">

                                </div>
                            </div>


                            <div class="form-group col-md-12">
                                <label for="password" class="label-modal">
                                    Nueva Contraseña
                                    <span class="required">*</span>
                                </label>
                                <input type="password" class="form-control" name="password" id="password">

                            </div>

                            <div class="form-group col-md-12">
                                <label for="password2" class="label-modal">
                                    Confirmar Contraseña
                                    <span class="required">*</span>
                                </label>
                                <input type="password" class="form-control" name="confirm_password"
                                    id="confirm_password">

                            </div>

                            <input type="hidden" id="id_edit">
                        </div>
                        <div class="modal-footer" id="form_footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="save">Registrar</button>
                            <button type="submit" class="btn btn-primary" id="update"
                                style="display: none;">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
