<?php include "Views/templates/header.php"; ?>
<div class="card">
    <div class="card-header bg-dark text-white">
        <h6>Nuevo Proceso</h6>
    </div>
    <div class="card-body">
        <form id="frmVenta">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="codigo_venta"><i class="fas fa-barcode"></i> Buscar Producto</label>
                        <input type="hidden" id="id" name="id">
                        <input id="codigo_venta" class="form-control" type="text" name="codigo_venta" placeholder="Código o nombre del producto">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombre">Descripción</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Descripción del productos" disabled>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="cantidad">Cant</label>
                        <input id="cantidad" class="form-control" type="number" name="cantidad" onkeyup="calcularPrecioV(event)" placeholder="Cant" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio venta" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="sub_total">Sub Total</label>
                        <input id="sub_total" class="form-control" type="text" name="sub_total" placeholder="Sub total" disabled>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-light table-bordered table-hover" id="t_ventas_hist" style="width: 100%;">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Aplicar</th>
                <th>Descuento</th>
                <th>Precio</th>
                <th>Sub Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="t_ven">
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="cliente"><i class="fas fa-users"></i> Buscar Cliente</label>
            <input type="hidden" id="id_cli" name="id_cli" value="1">
            <input id="cliente" class="form-control" type="text" name="cliente" placeholder="Nombre del cliente">
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input id="direccion" class="form-control" type="text" name="direccion" placeholder="Dirección" disabled>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="total" class="font-weight-bold">Total a Pagar</label>
            <input id="total" class="form-control" type="text" name="total" placeholder="Total" disabled>
            <button class="btn btn-primary mt-2 btn-block" type="button" onclick="generarVenta()">Generar Venta</button>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>