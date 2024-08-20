<?php include "Views/templates/header.php"; ?>
<button class="btn btn-primary mb-2" type="button" onclick="frmCampana();"><i class="fas fa-plus"></i></button>
<div class="table-responsive">
    <table class="table table-light display responsive nowrap" id="t_cam" style="width: 100%;">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Producto 1</th>
                <th>Producto 2</th>
                <th>Tiempo limpieza en Campaña (min)</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div id="nueva_campana" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nueva Campaña</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="Views\campanas\registroCampana.php" method="post" id="frmCampana" autocomplete="off">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" id="id" name="id">
                            <label for="id1">Producto 1</label>
                            <select id="id1" class="form-control" name="id1">
                            <?php foreach ($data as $row) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['descripcion']; ?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id2">Producto 2</label>
                            <select id="id2" class="form-control" name="id2">
                            <?php foreach ($data as $row) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['descripcion']; ?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tiempo_campana">Tiempo limpieza en campana</label>
                        <input min="0" id="tiempo_campana" class="form-control" name="tiempo_campana" type="text" required>
                    </div>
                    <button class="btn btn-primary" type="SUBMIT" value="Insertar"  id="btnAccion">Registrar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>