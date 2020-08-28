<?php
include_once 'funciones/sesiones.php';
include_once 'funciones/funciones.php';
include_once 'templates/header.php';
include_once 'templates/barra.php';
include_once 'templates/navegacion.php';
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Información sobre el evento</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- LINE CHART -->
            <div class="box box-info col-md-8">
                <div class="box-header with-border">
                    <h3 class="box-title">Line Chart</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="grafica-registros" style="height: 300px;"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <section class="content-header">
                <h2>Resumen de Registros</h2>
            </section>

        <div class="row">
            <div class="col-lg-3 col-xs-6">

                <?php
                try {

                    $sql = " SELECT COUNT(id_registrados) AS registros FROM registrados ";
                    $resultado = $conn->query($sql);
                    $registrados = $resultado->fetch_assoc();
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    echo $error;
                }

                ?>
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo $registrados['registros']; ?></h3>

                        <p>Total Registrados</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más Información <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">

                <?php
                try {

                    $sql = " SELECT COUNT(id_registrados) AS registros FROM registrados WHERE pagado = 1 ";
                    $resultado = $conn->query($sql);
                    $registrados = $resultado->fetch_assoc();
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    echo $error;
                }

                ?>
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo $registrados['registros']; ?></h3>

                        <p>Total Pagados</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más Información <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">

                <?php
                try {

                    $sql = " SELECT COUNT(id_registrados) AS registros FROM registrados WHERE pagado = 0 ";
                    $resultado = $conn->query($sql);
                    $registrados = $resultado->fetch_assoc();
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    echo $error;
                }

                ?>
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo $registrados['registros']; ?></h3>

                        <p>Total sin pagar</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-times"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más Información <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">

                <?php
                try {

                    $sql = " SELECT SUM(total_pagado) AS ganancias FROM registrados WHERE pagado = 1 ";
                    $resultado = $conn->query($sql);
                    $registrados = $resultado->fetch_assoc();
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    echo $error;
                }

                ?>
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo '$' . (float) $registrados['ganancias']; ?></h3>

                        <p>Ganancias</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-usd"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más Información <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h2>
                    Regalos
                </h2>
            </section>
            <div class="col-lg-3 col-xs-6">
                <?php
                try {

                    $sql = " SELECT COUNT(total_pagado) AS pulseras FROM registrados WHERE pagado = 1  AND regalo = 1 ";
                    $resultado = $conn->query($sql);
                    $regalo = $resultado->fetch_assoc();
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    echo $error;
                }

                ?>
                <!-- small box -->
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3><?php echo $regalo['pulseras']; ?></h3>

                        <p>Pulseras</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-gift"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más Información <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">

                <?php
                try {

                    $sql = " SELECT COUNT(total_pagado) AS etiquetas FROM registrados WHERE pagado = 1 AND regalo = 2 ";
                    $resultado = $conn->query($sql);
                    $regalo = $resultado->fetch_assoc();
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    echo $error;
                }

                ?>
                <!-- small box -->
                <div class="small-box bg-maroon">
                    <div class="inner">
                        <h3><?php echo $regalo['etiquetas']; ?></h3>

                        <p>Eftiquetas</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-gift"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más Información <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">

                <?php
                try {

                    $sql = " SELECT COUNT(total_pagado) AS plumas FROM registrados WHERE pagado = 1 AND regalo = 3 ";
                    $resultado = $conn->query($sql);
                    $regalo = $resultado->fetch_assoc();
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    echo $error;
                }

                ?>
                <!-- small box -->
                <div class="small-box bg-navy">
                    <div class="inner">
                        <h3><?php echo $regalo['plumas']; ?></h3>

                        <p>Plumas</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-gift"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más Información <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>





    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once 'templates/footer.php'; ?>