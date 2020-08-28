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
            Crear Administrador
            <small>Llena el formulario para crear un administrador.</small>
        </h1>
    </section>

    <!-- Main content -->
    <div class="row">
        <div class="col-md-8">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Crear Admin</h3>
                </div>
                <div class="box-body">
                    <!-- form start -->
                    <form role="form" method="post" action="modelo-admin.php" name="guardar-registro" id="guardar-registro">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="usuario">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Completo">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                            </div>
                            <div class="form-group">
                                <label for="password">Repetir Contraseña</label>
                                <input type="password" class="form-control" id="repetir_password" name="repetir_password" placeholder="Contraseña">
                                <span id="resultado_password" class="help-block"></span>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="hidden" name="registro" value="nuevo">
                            <button type="submit" class="btn btn-primary" id="crear_registro_admin">Añadir</button>
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