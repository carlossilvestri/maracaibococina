<?php //SE COLOCA TODO ESTO ANTES DEL /funciones/header.php PORQUE PARA USAR LA FUNCION header()
//NECESITAMOS QUE NO SE MANDE ABSOLUTAMENTE NADA AL NAVEGADOR. LA FUNCION header() NOS EVITARA
//QUE AL RECARGAR LA PAGINA SE VUELVAN A ENVIAR LOS DATOS A LA BASE DE DATOS 
//COMPRUEBA QUE EXISTAN LOS RESULTADOS POR EL BOTON submit (PAGAR):
if (isset($_POST['submit'])):
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $regalo = $_POST['regalo'];
    $total = $_POST['total_pedido'];
    $fecha = date('Y-m-d H:i:s');
    //PEDIDOS
    $boletos = $_POST['boletos'];
    $camisas = $_POST['pedido_camisas'];
    $etiquetas = $_POST['pedido_etiquetas'];
    include_once 'includes/funciones/funciones.php';
    $pedido = productos_json($boletos, $camisas, $etiquetas);
    //Eventos
    $eventos = $_POST['registro'];
    $registro = eventos_json($eventos);
    //ARREGLO ASOCIATIVO. Por la (KEY) es el atributo, ejemplo 'pais'
    $factura = array(
        'nombre' => $_POST['nombre'],
        'apellido' => $apellido,
        'email' => $email
      );
    //$factura = array($nombre,$apellido,$email, $boletos,$regalo, $fecha,$total,$camisas,$etiquetas);
    // 0=nombre, 1=apellido, 2=email,3=boletos, 4=regalo,5=fecha, 6=total, 7=camisas, 8=etiquetas. 
    try {
        require_once('includes/funciones/bd_conexion.php'); //Funcion que se encarga de incluir un archivo.
        //PREPARE STATEMENT CONTRA MYSQL INJECTION (ATAQUES INFORMATICOS A LA BASE DE DATOS)
        $stmt = $conn->prepare("INSERT INTO registrados 
                (nombre_registrado, apellido_registrado, email_registrado, fecha_registrado,
                 pases_articulos, talleres_registrados, regalo, total_pagado) VALUES(?,?,?,?,?,?,?,?) ");
        $stmt->bind_param("ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
        $stmt->execute();
        $stmt->close();
        //FUNCION QUE EVITA QUE AL RECARGAR LA PAGINA SE ENVIEN NUEVAMENTE LOS DATOS A LA BASE DE DATOS
        header('Location: validar_registro.php?exitoso=1');
        $conn->close();
    } catch (\Exception $e) {
        echo $e->getMessage();
    } ?>
<?php endif; ?>
<?php include_once 'includes/templates/header.php'; ?>
<section class="seccion">
    <div class="contenedor">
        <h2>Resumen Registro</h2>
        <?php if(isset($_GET['exitoso'])== "1"):
        echo "<h4>";
         echo "Registro Exitoso. ";
         echo "</h4>";
            // echo "<h3>";
            // echo "¡Felicidades! " . $factura[0] . " " . $factura[1] . " tu Registro ha sido exitoso.";
            // echo "</h3>";
            // echo "<br>";
            // echo "<h4>";
            // echo "Has seleccionado " . $factura[3] . ", " .  $factura[7]. ", ". $factura[8];
            // echo "</h4>";
            // echo "<br>";
            // echo "<h4>";
            // echo "Y has pagado " . "$" .  $factura[6];
            // echo "</h4>";
        endif;
            ?>


    </div>
</section>
<?php include_once 'includes/templates/footerRegistro.php'; ?>