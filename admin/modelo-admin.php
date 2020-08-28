<?php
include_once 'funciones/funciones.php';

if (isset($_POST['usuario'])) {
    $usuario = $_POST['usuario'];
} else {
    $usuario = null;
}
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
} else {
    $nombre = null;
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
} else {
    $password = null;
}
if (isset($_POST['agregar-admin'])) {
    $agregarAdmin = $_POST['agregar-admin'];
} else {
    $agregarAdmin = null;
}
if (isset($_POST['id_registro'])) {
    $id_registro = $_POST['id_registro'];
} else {
    $id_registro = null;
}
if (isset($_POST['registro'])) {
    $registro = $_POST['registro'];
} else {
    $registro = null;
}


if ($registro == "nuevo") {

    //Mientras mas grande sea el costo de un hash, mayor será la dificultar de descubrir la contraseña
    //Entre mayor sea el costo, mayor carga tendrá el servidor, es decir será más pesado.
    $opciones = array(
        'cost' => 10
    );
    //Convertira la contraseña en un string de 60 caracteres
    $passwordHasehd = password_hash($password, PASSWORD_BCRYPT, $opciones);
    //Insertar los datos a la BDD:
    try {
        $stmt = $conn->prepare("INSERT INTO admins (usuario, nombre, password, editado) VALUES (?, ?, ?, NOW()) ");
        $stmt->bind_param("sss", $usuario, $nombre, $passwordHasehd);
        $stmt->execute();
        $id_registro = $stmt->insert_id;
        //Si hubo un cambio en las filas de la BD, quiere decir que se registro el Admin correctamente.
        if ($stmt->affected_rows > 0) {
            //Creo un array llamado respuesta, la cual confirma que el registr fue todo un exito.
            $respuesta = array(
                'respuesta' => 'exito',
                'id_admin' => $id_registro
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
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
} else  if ($registro == "actualizar") {

    try {
        //Si el password esta vacio:
        if (empty($_POST['password'])) {
            //Entonces que no actualice el password
            $stmt = $conn->prepare("UPDATE admins SET usuario = ?, nombre = ?, editado = NOW() WHERE id_admin = ? ");
            $stmt->bind_param("ssi", $usuario, $nombre, $id_registro);
        } else {
            //Si el password tiene algo entonces actualizarla:
            $opciones = array(
                'cost' => 10
            );
            $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);
            $stmt = $conn->prepare("UPDATE admins SET usuario = ?, nombre = ?, password = ?, editado = NOW() WHERE id_admin = ? ");
            $stmt->bind_param("sssi", $usuario, $nombre, $hash_password, $id_registro);
        }

        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'editado',
                'id_actualizado' => $stmt->insert_id
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
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
} else  if ($registro == "eliminar") {

    $idBorrar = $_POST['id'];
    try{
        $stmt = $conn->prepare(" DELETE FROM admins WHERE id_admin = ? ");
        $stmt->bind_param("i", $idBorrar);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'eliminado',
                'id_eliminado' => $idBorrar
            );
        }else{
            $respuesta = array(
                'respuesta' => 'error'
            );
        }

    }catch(Exception $e){
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}
