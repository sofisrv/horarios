<?php include "Views/templates/header.php"; ?>
<button class="btn btn-primary mb-2" type="button" onclick="frmProducto();"><i class="fas fa-plus"></i></button>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-borderd table-hover table-striped display responsive nowrap" id="t_pro" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Categoria</th>
                        <th>Tiempo limpieza Profunda (min)</th>
                        <th>Stock</th>
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
<div id="nuevo_producto" class="modal fade" data-focus="false" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Producto</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmProducto" onsubmit="registrarPro(event);" autocomplete="off">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="codigo">Código de barras</label>
                                <input type="hidden" id="id" name="id">
                                <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Código de barras" oninput="longitud(event, 8)" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del Producto" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="categoria">Categoria</label>
                                <select id="categoria" class="form-control" name="categoria">
                                    <?php foreach ($data as $row) { ?>
                                        <option value="<?php echo $row['id_cat']; ?>"><?php echo $row['categoria']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="precio_compra">Tamano lote PT</label>
                                <input id="precio_compra" class="form-control" type="number" step="1" min="0.0" name="precio_compra" placeholder="Tamano lote PT" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="precio_venta">Tiempo limpieza P</label>
                                <input id="precio_venta" class="form-control" type="number" step="1"  min="0.0" name="precio_venta" placeholder="Tiempo min" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="minimo">Stock Mínimo</label>
                                <input type="number" class="form-control" name="minimo" id="minimo" placeholder="Stock m." required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Foto</label>
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <label for="imagen" id="icon-image">
                                            <img class="img-thumbnail" id="img-preview" src="<?php echo base_url; ?>Assets/img/logo.png" width="200">
                                        </label>
                                        <span id="icon-cerrar"></span>
                                        <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event)">
                                        <input type="hidden" id="foto_actual" name="foto_actual">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <button class="btn btn-primary" type="submit" id="btnAccion">Registrar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>