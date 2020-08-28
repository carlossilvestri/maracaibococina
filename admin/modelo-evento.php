<?php
include_once 'funciones/funciones.php';

if (isset($_POST['titulo_evento'])) {
    $tituloEvento = $_POST['titulo_evento'];
} else {
    $tituloEvento = null;
}
if (isset($_POST['categoria_evento'])) {
    $categoriaId = $_POST['categoria_evento'];
    //$categoriaId = (int) $categoriaId;
} else {
    $categoriaId = null;
}
if (isset($_POST['fecha_evento'])) {
    $fechaEvento = $_POST['fecha_evento'];
    $fechaFormateada = date('Y-m-d', strtotime($fechaEvento));
} else {
    $fechaEvento = null;
    $fechaFormateada = null;
}
if (isset($_POST['invitado_evento'])) {
    $invitadoId = $_POST['invitado_evento'];
    //$invitadoId = (int) $invitadoId;
} else {
    $invitadoId = null;
}
if (isset($_POST['registro'])) {
    $registro = $_POST['registro'];
} else {
    $registro = null;
}
if (isset($_POST['id_evento'])) {
    $eventoId = $_POST['id_evento'];
} else {
    $eventoId = null;
}
if (isset($_POST['hora_evento'])) {
    $horaEvento = $_POST['hora_evento'];
    $horaMilitar = date('H:i', strtotime($horaEvento));

    $horas = array(
        'hora' => $horaEvento,
        'horaMilitar' => $horaMilitar
    );
} else {
    $horaEvento = null;
    $horaMilitar = null;
    $horas = null;
}


//var_dump($_POST);
//die(json_encode($tituloEvento . " " . $fechaFormateada . " " . $horaEvento . " " . $categoriaId . " " . $invitadoId ));
if ($registro == "nuevo-evento") {

    try {
        $stmt = $conn->prepare('INSERT INTO eventos (nombre_evento, fecha_evento, hora_evento, id_cat_evento, id_inv, editado) VALUES (?, ?, ?, ?, ?, NOW() ) ');
        $stmt->bind_param('sssii', $tituloEvento, $fechaFormateada, $horaMilitar, $categoriaId, $invitadoId);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;
        //Si hubo un cambio en las filas de la BD, quiere decir que se registro el Admin correctamente.
        if ($stmt->affected_rows > 0) {
            //Creo un array llamado respuesta, la cual confirma que el registr fue todo un exito.
            $respuesta = array(
                'respuesta' => 'evento-creado-exitosamente',
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
} else if ($registro == "actualizar-evento") {

    try {

        $stmt = $conn->prepare("UPDATE eventos SET nombre_evento = ?, fecha_evento = ?, hora_evento = ?, id_cat_evento = ?, id_inv = ?, editado = NOW() WHERE evento_id = ? ");
        $stmt->bind_param("sssiii", $tituloEvento, $fechaFormateada, $horaMilitar, $categoriaId, $invitadoId, $eventoId);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'evento-editado',
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
        $stmt = $conn->prepare(" DELETE FROM eventos WHERE evento_id = ? ");
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
