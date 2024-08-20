<?php include "Views/templates/header.php"; ?>
<div class="card">
    <div class="card-header">
        Datos del usuario
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <h5 class="card-title"><b>Usuario</b></h5>
                <p class="card-text"><i class="fas fa-user"></i> <?php echo $data['usuario']; ?></p>
            </div>
            <div class="col-md-3">
                <h5 class="card-title"><b>Nombre</b></h5>
                <p class="card-text"><i class="fas fa-check"></i> <?php echo $data['nombre']; ?></p>
            </div>
            <div class="col-md-3">
                <h5 class="card-title"><b>Correo</b></h5>
                <p class="card-text"><i class="fas fa-envelope"></i> <?php echo $data['correo']; ?></p>
            </div>
            <div class="col-md-2">
                <h5 class="card-title"><b>Fecha de registro</b></h5>
                <p class="card-text"><i class="fas fa-calendar"></i> <?php echo $data['fecha']; ?></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                Perfil de Usuario
            </div>
            <div class="card-body">
                <form id="frmPerfil">
                    <div class="form-group">
                        <label>Foto</label>
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <label for="imagen" id="icon-image">
                                    <?php if (!file_exists('Assets/img/usuarios/' . $_SESSION['id_usuario'] . '.png')) { ?>
                                        <img class="img-thumbnail" id="img-preview" src="<?php echo base_url; ?>Assets/img/avatar.svg" width="200">
                                    <?php } else { ?>
                                        <img class="img-thumbnail" id="img-preview" src="<?php echo base_url; ?>Assets/img/usuarios/<?php echo $_SESSION['id_usuario']; ?>.png" width="350">
                                    <?php } ?>
                                </label>
                                <span id="icon-cerrar"></span>
                                <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event)">
                                <input type="hidden" id="foto_actual" name="foto_actual">
                            </div>
                        </div>
                    </div>
                    <?php if (!file_exists('Assets/img/usuarios/' . $_SESSION['id_usuario'] . '.png')) { ?>
                        <button class="btn btn-primary" type="button" onclick="modificarPerfil()">Modificar</button>
                    <?php } else { ?>
                        <button class="btn btn-primary" type="button" onclick="modificarPerfil()">Modificar</button>
                        <button class="btn btn-danger" type="button" onclick="EliminarPerfil()">Eliminar</button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                Perfil de Usuario
            </div>
            <div class="card-body">
                <form id="frmPass">
                    <div class="form-group">
                        <label for="actual"><i class="fas fa-key fa-2x"></i> Contraseña Actual</label>
                        <input id="actual" class="form-control" type="password" name="actual" placeholder="Contraseña Actual">
                    </div>
                    <div class="form-group">
                        <label for="nueva"><i class="fas fa-key fa-2x"></i> Contraseña Nueva</label>
                        <input id="nueva" class="form-control" type="password" name="nueva" placeholder="Contraseña Nueva">
                    </div>
                    <div class="form-group">
                        <label for="confirmar"><i class="fas fa-key fa-2x"></i> Confirmar Contraseña</label>
                        <input id="confirmar" class="form-control" type="password" name="confirmar" placeholder="Confirmar Contraseña">
                    </div>
                    <button class="btn btn-primary" type="button" onclick="cambiarPass()">Cambiar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>