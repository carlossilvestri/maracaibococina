<?php
include_once 'funciones/funciones.php';

//die(json_encode($_POST));
if (isset($_POST["nombre_invitado"])) {
    $nombreInvitado = $_POST["nombre_invitado"];
} else {
    $nombreInvitado = null;
}
if (isset($_POST["apellido_invitado"])) {
    $apellidoInvitado = $_POST["apellido_invitado"];
} else {
    $apellidoInvitado = null;
}
if (isset($_POST["biografia_invitado"])) {
    $biografiaInvitado = $_POST["biografia_invitado"];
} else {
    $biografiaInvitado = null;
}
if (isset($_POST['registro'])) {
    $registro = $_POST['registro'];
} else {
    $registro = null;
}
if (isset($_POST['id_registro'])) {
    $id_registro = $_POST['id_registro'];
} else {
    $id_registro = null;
}

if ($registro == "nuevo") {
    /* //Cuando necesites comprobar que se este enviando la imagen usa esto:
    $respuesta = array(
        'post'=> $_POST,
        'file'=> $_FILES
    );
    die(json_encode($respuesta));*/


    $directorio = "../img/invitados/";
    //Is_dir es una funcion que verifica que un directorio exista.
    if (!is_dir($directorio)) {
        //Si no existe entonces crea el directorio con mkdir();
        // 0755 es un permiso para que el directorio sea visto por los visitantes pero que no puedan modioficarlos.
        // true de recursivo. Vamos a crear archivos nuevos en la carpeta, sin esto tendrias que darle los permisos a cada
        //archivo por separado y no es lo que queremos.
        mkdir($directorio, 0755, true);
    }
    //Si se movió la imagen del directorio de oricen al directorio destino entonces:
    if (move_uploaded_file($_FILES['archivo-imagen']['tmp_name'], $directorio . $_FILES['archivo-imagen']['name'])) {
        //Guardamos el nombre de la imagen en la variable $imagenUrl:
        $imagenUrl = $_FILES['archivo-imagen']['name'];
        $imagenResultado = "Se subió correctamente";
    } else {
        $respuesta = array(
            'respuesta' => error_get_last()
        );
        $imagenUrl = null;
        $imagenResultado = "No se subió correctamente";
    }
    try {
        $stmt = $conn->prepare('INSERT INTO invitados (	nombre_invitado, apellido_invitado, descripcion, url, editado) VALUES (?, ?, ?, ?, NOW() ) ');
        $stmt->bind_param('ssss', $nombreInvitado, $apellidoInvitado, $biografiaInvitado, $imagenUrl);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;
        //Si hubo un cambio en las filas de la BD, quiere decir que se registro el Admin correctamente.
        if ($stmt->affected_rows > 0) {
            //Creo un array llamado respuesta, la cual confirma que el registr fue todo un exito.
            $respuesta = array(
                'respuesta' => 'exito',
                'id_admin' => $id_insertado
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
} else if ($registro == "actualizar") {

    $directorio = "../img/invitados/";
    //Is_dir es una funcion que verifica que un directorio exista.
    if (!is_dir($directorio)) {
        //Si no existe entonces crea el directorio con mkdir();
        // 0755 es un permiso para que el directorio sea visto por los visitantes pero que no puedan modioficarlos.
        // true de recursivo. Vamos a crear archivos nuevos en la carpeta, sin esto tendrias que darle los permisos a cada
        //archivo por separado y no es lo que queremos.
        mkdir($directorio, 0755, true);
    }
    //Si se movió la imagen del directorio de oricen al directorio destino entonces:
    if (move_uploaded_file($_FILES['archivo-imagen']['tmp_name'], $directorio . $_FILES['archivo-imagen']['name'])) {
        //Guardamos el nombre de la imagen en la variable $imagenUrl:
        $imagenUrl = $_FILES['archivo-imagen']['name'];
        $imagenResultado = "Se subió correctamente";
    } else {
        $respuesta = array(
            'respuesta' => error_get_last()
        );
        $imagenUrl = null;
        $imagenResultado = "No se subió correctamente";
    }
    try {
        //Con imagen nueva
        //Si $_FILES['archivo-imagen']['size'] > 0 eso quiere decir que se ingreso una nueva imagen.
        if ($_FILES['archivo-imagen']['size'] > 0) {
            $stmt = $conn->prepare("UPDATE invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion = ?, url = ?, editado = NOW() WHERE invitado_id = ? ");
            $stmt->bind_param('ssssi', $nombreInvitado, $apellidoInvitado, $biografiaInvitado, $imagenUrl, $id_registro);
        } else {
            //Sin imagen nueva o actualizada
            $stmt = $conn->prepare("UPDATE invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion = ?, editado = NOW() WHERE invitado_id = ? ");
            $stmt->bind_param('sssi', $nombreInvitado, $apellidoInvitado, $biografiaInvitado, $id_registro);
        }
        $stmt->execute();
        $registros = $stmt->affected_rows;
        if ($registros > 0) {
            $respuesta = array(
                'respuesta' => 'invitado-editado-exitosamente',
                'id_actualizado' => $id_registro
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
    try {
        $stmt = $conn->prepare(" DELETE FROM invitados WHERE invitado_id = ? ");
        $stmt->bind_param("i", $idBorrar);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'eliminado',
                'id_eliminado' => $idBorrar
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}
