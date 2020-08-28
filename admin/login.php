<?php 

session_start();
if(isset( $_GET['cerrar_sesion'])){
    $cerrar_sesion = $_GET['cerrar_sesion'];
}else{
    $cerrar_sesion = null;
}

if($cerrar_sesion){
    session_destroy();
}

include_once 'funciones/funciones.php';
include_once 'templates/header.php';
?>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../index.php"><b>MCBO</b>COCINA</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Inicia sesión aquí.</p>

            <form name="login-admin-form" role="form" method="post" action="login-admin.php" id="login-admin">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="usuario" placeholder="Usuario">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Contraseña">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <input type="hidden" name="login-admin" value="1">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Inicia Sesión</button>
                    </div>
                    <!-- /.col -->
                    
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
</body>
<?php include_once 'templates/footer.php'; ?>