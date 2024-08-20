<?php include "Views/templates/header.php"; ?>
<div class="card">
    <div class="card-header bg-secondary">
        Datos de la Empresa
    </div>
    <div class="card-body">
        <form id="frmEmpresa">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="identidad">Identidad</label>
                        <input type="hidden" name="id" id="id" value="<?php echo $data['id'] ?>">
                        <input id="identidad" class="form-control" type="text" name="identidad" value="<?php echo $data['identidad'] ?>" placeholder="Identidad" onkeypress="return soloNumeros(event);" oninput="longitud(event, 13)">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" value="<?php echo $data['nombre'] ?>" placeholder="Nombre de la empresa">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input id="telefono" class="form-control" type="text" name="telefono" value="<?php echo $data['telefono'] ?>" placeholder="Teléfono" onkeypress="return soloNumeros(event);" oninput="longitud(event, 10)">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <textarea id="direccion" class="form-control" name="direccion" rows="2" placeholder="Dirección"><?php echo $data['direccion'] ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" class="form-control" name="mensaje" rows="2" placeholder="Mensaje"><?php echo $data['mensaje'] ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Logo</label>
                        <div class="card border-primary">
                            <div class="card-body">
                                <label for="imagen" id="icon-image">
                                    <img class="img-thumbnail" id="img-preview" src="<?php echo base_url; ?>Assets/img/logo.png" width="200">
                                </label>
                                <span id="icon-cerrar"></span>
                                <input id="imagen" class="d-none" type="file" name="imagen" onchange="previewLogo(event)">
                                <input type="hidden" id="foto_actual" name="foto_actual">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary btn-block" type="button" onclick="modificarEmpresa()">Modificar</button>
            </div>

        </form>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>