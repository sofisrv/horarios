<?php include "Views/templates/header.php"; ?>
<button class="btn btn-primary mb-2" type="button" onclick="frmPedido();"><i class="fas fa-plus"></i></button>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-borderd table-hover table-striped display responsive nowrap" id="t_pedido" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Fecha de creacion</th>
                        <th>Fecha de Entrega</th>
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
<div id="nuevo_pedido" class="modal fade" data-focus="false" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Pedido</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="Views\pedidos\registroPedido.php" method="post" id="frmPedido" autocomplete="off">
                    <div class="row">
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="codigo">codigo</label>
                                <input type="hidden" id="id" name="id">
                                <input id="codigo" class="form-control" type="text" name="codigo" placeholder="codigo" required>
                            </div>
                        </div>
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
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="fecha_creacion">fecha_creacion</label>
                                <input id="fecha_creacion" class="form-control" type="date" name="fecha_creacion" placeholder="fecha_creacion" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_entrega">fecha_entrega</label>
                                <input id="fecha_entrega" class="form-control" type="date"  name="fecha_entrega" placeholder="fecha_entrega" required>
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