<?php include "Views/templates/header.php"; ?>
<div class="row">


    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box">
            <div class="inner">
                <h3><?php echo $data['usuarios']['usuarios']; ?></h3>

                <p>Usuarios</p>
            </div>
            <div class="icon">
                <i class="ion fas fa-user text-gray"></i>
            </div>
            <a href="<?php echo base_url; ?>usuarios" class="small-box-footer bg-warning">Ver <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box">
            <div class="inner">
                <h3><?php echo $data['productos']['productos']; ?></h3>

                <p>Productos</p>
            </div>
            <div class="icon">
                <i class="fas fa-capsules text-gray"></i>
            </div>
            <a href="<?php echo base_url; ?>productos" class="small-box-footer bg-success">Ver <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box">
            <div class="inner">
                <h3><?php echo $data['proveedor']['proveedor']; ?></h3>

                <p>maquinaria</p>
            </div>
            <div class="icon">
                <i class="ion fas fa-box text-gray"></i>
            </div>
            <a href="<?php echo base_url; ?>proveedor" class="small-box-footer bg-orange">Ver <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box">
            <div class="inner">
                <h3><?php echo $data['ventas']['total_dia']; ?></h3>

                <p>Pedidos por Dia</p>
            </div>
            <div class="icon">
                <i class="ion fas fa-calendar-day text-gray"></i>
            </div>
            <a href="<?php echo base_url; ?>compras/historial_ventas" class="small-box-footer bg-danger">Buscar <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box">
            <div class="inner">
                <h3><br></h3>
                <p>Configuración</p>
            </div>
            <div class="icon">
                <i class="ion fas fa-cogs text-gray"></i>
            </div>
            <a href="<?php echo base_url; ?>admin/datos" class="small-box-footer bg-blue">Ver <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box">
            <div class="inner">
                <h3><br></h3>

                <p>Nuevo pedido</p>
            </div>
            <div class="icon">
                <i class="ion far fa-calendar-plus text-gray"></i>
            </div>
            <a href="<?php echo base_url; ?>compras/ventas" class="small-box-footer bg-fuchsia">Agregar Pedido <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- ./col -->
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box">
            <div class="inner">
            <h3><br></h3>
                <p>Calendario</p>
            </div>
            <div class="icon">
                <i class="ion fas fa-calendar-alt text-gray"></i>
            </div>
            <a href="<?php echo base_url; ?>calendario" class="small-box-footer bg-purple">Ver <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

</div>
<!-- /.row -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-6">
                <!-- AREA CHART -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Productos Más Agendados</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
            <div class="col-md-6">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Productos Stock Mínimo</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<?php include "Views/templates/footer.php"; ?>