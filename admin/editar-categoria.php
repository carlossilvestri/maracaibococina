<?php
$id =  $_GET['id'];

if (!filter_var($id, FILTER_VALIDATE_INT)) :
    die("Error");
else :
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
                Editar Categoría de Eventos
                <small></small>
            </h1>
        </section>

        <!-- Main content -->
        <div class="row">
            <div class="col-md-8">
                <!-- Default box -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar Categoría de Eventos</h3>
                    </div>
                    <div class="box-body">

                        <?php
                        $sql = "SELECT * FROM categoria_Evento WHERE id_categoria = $id ";
                        $resultado = $conn->query($sql);
                        $categoria = $resultado->fetch_assoc();?>

                        <!-- form start -->
                        <form role="form" method="post" action="modelo-categoria.php" name="guardar-registro" id="guardar-registro">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="nombre_categoria">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" placeholder="Categoría" value="<?php echo $categoria['cat_evento']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="icono">Icono</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-address-book"> </i>
                                        </div>
                                        <input type="text" class="form-control" id="icono" name="icono" placeholder="Nombre Completo" value="<?php echo $categoria['icono']; ?>">
                                    </div>

                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                                <input type="hidden" name="registro" value="actualizar">
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <section class="content">

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php include_once 'templates/footer.php';
endif;
?>