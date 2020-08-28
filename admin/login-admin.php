<?php
include_once 'funciones/funciones.php';
if (isset($_POST['usuario'])) {
    $usuario = $_POST['usuario'];
} else {
    $usuario = null;
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
} else {
    $password = null;
}
if (isset($_POST['login-admin'])) {
    //Insertar los datos a la BDD:
    try {
        $stmt = $conn->prepare(" SELECT * FROM admins WHERE usuario = ? ");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        //Bind Param nos regresa todos los datos devueltos por la BDD guardandolas segun el orden definido en la BDD:
        $stmt->bind_result($idAdmin, $usuarioAdmin, $nombreAdmin, $passwordAdmin, $editado, $nivel);
        //Si hubo un cambio en las filas de la BD, quiere decir que se registro el Admin correctamente.
        if ($stmt->affected_rows) {
            $existe = $stmt->fetch();
            if ($existe) {
                //Convierte el password ingresado a hash y despues lo compara con el de la BDD.
                if (password_verify($password, $passwordAdmin)) {
                    $respuesta = array(
                        'respuesta' => 'exitoso',
                        'usuario' => $nombreAdmin
                    );
                    //Se activa la sesion
                    session_start();
                    $_SESSION['usuario'] = $usuarioAdmin;
                    $_SESSION['nombre'] = $nombreAdmin;
                    $_SESSION['nivel'] = $nivel;
                    $_SESSION['id'] = $idAdmin;
                } else {
                    //Entonces el password no es correcto:
                    $respuesta = array(
                        'respuesta' => 'usuario_si_existe_pero_password_incorrecto'
                    );
                }
            } // if $existe
        } else {
            $respuesta = array(
                'respuesta' => 'usuario_no_existe'
            );
        }
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}