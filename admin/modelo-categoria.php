<?php
include_once 'funciones/funciones.php';
if (isset($_POST['registro'])) {
    $registro = $_POST['registro'];
} else {
    $registro = null;
}
if (isset($_POST['nombre_categoria'])) {
    $nombreCategoria = $_POST['nombre_categoria'];
} else {
    $nombreCategoria = null;
}
if (isset($_POST['icono'])) {
    $icono = $_POST['icono'];
} else {
    $icono = null;
}
if (isset($_POST["id_registro"])) {
    $categoriaId = $_POST["id_registro"];
} else {
    $categoriaId = null;
}

if ($registro == "nueva-categoria") {
    try {
        $stmt = $conn->prepare('INSERT INTO categoria_evento (cat_evento, icono, editado) VALUES (?, ?, NOW() ) ');
        $stmt->bind_param('ss',$nombreCategoria, $icono);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;
        //Si hubo un cambio en las filas de la BD, quiere decir que se registro el Admin correctamente.
        if ($stmt->affected_rows > 0) {
            //Creo un array llamado respuesta, la cual confirma que el registr fue todo un exito.
            $respuesta = array(
                'respuesta' => 'categoria-creada-exitosamente',
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
    try {
        $stmt = $conn->prepare("UPDATE categoria_evento SET cat_evento = ?, icono = ?, editado = NOW() WHERE id_categoria = ? ");
        $stmt->bind_param("ssi", $nombreCategoria , $icono, $categoriaId);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'categoria-editada',
                'id_actualizado' => $id_insertado
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
        $stmt = $conn->prepare(" DELETE FROM categoria_evento WHERE id_categoria = ? ");
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
