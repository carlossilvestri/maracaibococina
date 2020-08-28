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
                Editar Invitado
                <small>Llena el formulario para editar un invitado.</small>
            </h1>
        </section>

        <!-- Main content -->
        <div class="row">
            <div class="col-md-8">
                <!-- Default box -->
                <div class="box">

                    <?php
                    try {

                        $sql = "SELECT * FROM invitados WHERE invitado_id = $id ";
                        $resultado = $conn->query($sql);
                        $invitado = $resultado->fetch_assoc();
                    } catch (Exception $e) {
                        $error = $e->getMessage();
                        echo $error;
                    }
                    ?>
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar Invitado</h3>
                    </div>
                    <div class="box-body">
                        <!-- form start -->
                        <form role="form" method="post" action="modelo-invitado.php" name="guardar-registro" id="guardar-registro-archivo" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="nombre_invitado">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_invitado" name="nombre_invitado" placeholder="Nombre" value="<?php echo $invitado['nombre_invitado'];  ?>">
                                </div>
                                <div class="form-group">
                                    <label for="apellido_invitado">Apellido</label>
                                    <input type="text" class="form-control" id="apellido_invitado" name="apellido_invitado" placeholder="Apellido" value="<?php echo $invitado['apellido_invitado'];  ?>">
                                </div>
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>Biografía</label>
                                    <textarea name="biografia_invitado" class="form-control" rows="3" placeholder="Escribe ..." > <?php echo $invitado['descripcion'];  ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="imagen_actual">Imagen Actual</label>
                                    <br>
                                    <img src="../img/invitados/<?php echo $invitado['url'] ?>" width = "200">
                                </div>
                                <!-- File input< -->
                                <div class="form-group">
                                    <label for="imagen_invitado">Imagen</label>
                                    <input type="file" id="imagen_invitado" name="archivo-imagen">

                                    <p class="help-block">Edite la imagen del invitado aquí.</p>
                                </div>

                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <input type="hidden" name="registro" value="actualizar">
                                <button type="submit" class="btn btn-primary" id="crear_registro">Editar</button>
                                <input type="hidden" name="id_registro" value="<?php echo $invitado['invitado_id']; ?>">
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
endif; ?>