<?php include "Views/templates/header.php"; ?>
<button class="btn btn-primary mb-2" type="button" onclick="frmProveedor();"><i class="fas fa-plus"></i></button>
<div class="table-responsive">
    <table class="table table-light display responsive nowrap" id="t_Pr" style="width: 100%;">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Limpieza profunda (min)</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div>
        <div id="nuevo_proveedor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="title">Nueva Maquinaria</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="frmProveedor" autocomplete="off">
                            <div class="form-group">
                                <input type="hidden" id="id" name="id">
                                <label for="ruc">Codigo</label>
                                <input id="ruc" class="form-control" type="text" name="ruc" placeholder="Codigo">
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Limpieza en campaña (min)</label>
                                <input id="telefono" class="form-control" type="number" name="telefono" placeholder="Limpieza en campaña (min)"">
                            </div>
                            <div class="form-group">
                                <label for="direccion">Descripcion</label>
                                <textarea id="direccion" class="form-control" name="direccion" placeholder="Descripcion" rows="3"></textarea>
                            </div>
                            <button class="btn btn-primary" type="button" onclick="registrarPr(event);" id="btnAccion">Registrar</button>
                            <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include "Views/templates/footer.php"; ?>