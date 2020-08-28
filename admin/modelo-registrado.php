<?php
include_once 'funciones/funciones.php';

if (isset($_POST['registro'])) {
    $registro = $_POST['registro'];
} else {
    $registro = null;
}

if (isset($_POST["nombre_registrado"])) {
    $nombre = $_POST["nombre_registrado"];
} else {
    $nombre = null;
}

if (isset($_POST["apellido_registrado"])) {
    $apellido = $_POST["apellido_registrado"];
} else {
    $apellido = null;
}
if (isset($_POST["email"])) {
    $email = $_POST["email"];
} else {
    $email = null;
}
if (isset($_POST["pedido_extra"]["camisas"]["cantidad"])) {
    $cantidadDeCamisas = $_POST["pedido_extra"]["camisas"]["cantidad"];
} else {
    $cantidadDeCamisas = null;
}
if (isset($_POST["pedido_extra"]["etiquetas"]["cantidad"])) {
    $cantidadDeEtiquetas = $_POST["pedido_extra"]["etiquetas"]["cantidad"];
} else {
    $cantidadDeEtiquetas = null;
}
if (isset($_POST["boletos"])) {
    $boletos_adquiridos = $_POST["boletos"];
    $pedido = productos_json($boletos_adquiridos, $cantidadDeCamisas, $cantidadDeEtiquetas);
} else {
    $boletos_adquiridos = null;
}
if (isset($_POST["total_pedido"])) {
    $total = $_POST["total_pedido"];
} else {
    $total = null;
}
if (isset($_POST["regalo"])) {
    $regalo = $_POST["regalo"];
} else {
    $regalo = null;
}
if (isset($_POST["registro_evento"])) {
    $eventos = $_POST["registro_evento"];
    $registro_evento = eventos_json($eventos);
} else {
    $eventos = null;
    $registro_evento = null;
}
if (isset($_POST["fecha_registrado"])) {
    $fecha_registrado = $_POST["fecha_registrado"];
} else {
    $fecha_registrado = null;
}
if (isset($_POST["id_registro"])) {
    $id_registro = $_POST["id_registro"];
} else {
    $id_registro = null;
}

if ($registro == "nuevo") {

    try {
        $stmt = $conn->prepare('INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registrado, pases_articulos, talleres_registrados, regalo, total_pagado, pagado) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, 1 ) ');
        $stmt->bind_param('sssssis', $nombre, $apellido, $email, $pedido, $registro_evento, $regalo, $total);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;
        //Si hubo un cambio en las filas de la BD, quiere decir que se registro el Admin correctamente.
        if ($stmt->affected_rows > 0) {
            //Creo un array llamado respuesta, la cual confirma que el registr fue todo un exito.
            $respuesta = array(
                'respuesta' => 'registrado-creado-exitosamente',
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
}  else if ($registro == "actualizar") {
    try {
        $stmt = $conn->prepare("UPDATE registrados SET nombre_registrado = ?, apellido_registrado = ?, email_registrado = ?, fecha_registrado = ?, pases_articulos = ?, talleres_registrados = ?, regalo = ?, total_pagado = ?, pagado = 1 WHERE id_registrados = ? ");
        $stmt->bind_param("ssssssisi", $nombre, $apellido, $email, $fecha_registrado, $pedido, $registro_evento, $regalo, $total, $id_registro);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'editado',
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
        $stmt = $conn->prepare(" DELETE FROM registrados WHERE id_registrados = ? ");
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

