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
            Crear Invitado
            <small>Llena el formulario para crear un invitado.</small>
        </h1>
    </section>

    <!-- Main content -->
    <div class="row">
        <div class="col-md-8">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Crear Invitado</h3>
                </div>
                <div class="box-body">
                    <!-- form start -->
                    <form role="form" method="post" action="modelo-invitado.php" name="guardar-registro" id="guardar-registro-archivo" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="nombre_invitado">Nombre</label>
                                <input type="text" class="form-control" id="nombre_invitado" name="nombre_invitado" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <label for="apellido_invitado">Apellido</label>
                                <input type="text" class="form-control" id="apellido_invitado" name="apellido_invitado" placeholder="Apellido">
                            </div>
                            <!-- textarea -->
                            <div class="form-group">
                                <label>Biografía</label>
                                <textarea name="biografia_invitado" class="form-control" rows="3" placeholder="Escribe ..."></textarea>
                            </div>
                            <!-- File input< -->
                            <div class="form-group">
                                <label for="imagen_invitado">Imagen</label>
                                <input type="file" id="imagen_invitado" name="archivo-imagen">

                                <p class="help-block">Añada la imagen del invitado aquí.</p>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="hidden" name="registro" value="nuevo">
                            <button type="submit" class="btn btn-primary" id="crear_registro">Añadir</button>
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
<?php include_once 'templates/footer.php'; ?>