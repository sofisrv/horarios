<?php include "Views/templates/header.php"; ?>
<div class="card">
    <div class="card-header bg-secondary">
        Buscar
    </div>
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-md-4">
                    <label for="">Desde</label>
                    <input class="form-control" id="min" type="date" value="<?php echo date('Y-m-d'); ?>" placeholder="Selecciona Fecha Inicio">
                </div>
                <div class="col-md-4">
                    <label for="">Hasta</label>
                    <input class="form-control" id="max" type="date" value="<?php echo date('Y-m-d'); ?>" placeholder="Selecciona Fecha Fin">
                </div>
            </div>

        </form>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-light table-bordered table-hover display responsive nowrap" id="t_ventas" style="width: 100%;">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
<?php include "Views/templates/footer.php"; ?>