<?php include "Views/templates/header.php"; ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-borderd table-hover table-striped display responsive nowrap" id="t_limpieza" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Fecha</th>
                        <th>Maquinaria</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div id="nueva_limpieza" class="modal fade" data-focus="false" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nueva Limpieza</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="Views\limpiezas\registroLimpieza.php" method="post" id="frmLimpieza" autocomplete="off">
                
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                            <input type="hidden" id="id" name="id">
                                <label for="id_producto">Producto</label>
                                <select id="id_producto" class="form-control" name="id_producto">
                                <?php foreach ($data as $row) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['descripcion']; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="id_maquinaria">Maquinaria</label>
                                <select id="id_maquinaria" class="form-control" name="id_maquinaria">
                                <?php foreach ($data as $row) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['descripcion']; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                            <label for="orden">Orden</label>
                                <select name="orden" class="form-control" >
                                    <option value="1"selected>Surtidora</option>
                                    <option value="2">Mezcladora</option>
                                    <option value="3">Primario</option>
                                    <option value="4">Secundario</option>
                                    <option value="5">Terciario</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tiempo">Tiempo (min)</label>
                                <input id="tiempo" class="form-control" type="number" min="0.00" name="tiempo" placeholder="Tiempo" required>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="SUBMIT" value="Insertar"  id="btnAccion">Registrar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>