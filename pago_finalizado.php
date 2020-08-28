</html>
<?php include_once 'includes/templates/header.php';

use PayPal\Rest\ApiContext;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payment;

require 'includes/paypal/config.php';
?>
<section class="seccion">
  <div class="contenedor">
    <h2>Resumen Registro</h2>
    <?php

    $nombreRegistrado = $_GET['nombre'];
    $paymentId = $_GET['paymentId'];
    $id_registrado =  $_GET['id_registrado'];

    //Peticion a REST API
    $pago = Payment::get($paymentId, $apiContext);
    $execution = new PaymentExecution();
    $execution->setPayerId($_GET['PayerID']);

    //Resultado tiene la info de la transaccion:
    $resultado = $pago->execute($execution, $apiContext);

    //Respuesta tendria un completed con esto:
    $respuesta = $resultado->transactions[0]->related_resources[0]->sale->state;


    if ($respuesta  == "completed") {
      echo "<div class='resultado correcto'>";
      echo "<h3 class='negro'>";
      echo "Hola " . $nombreRegistrado;
      echo "</h3>";
      echo '<br>';
      echo '<br>';
      echo "Muchísimas gracias el pago se realizó correctamente. ";
      echo '<br>';
      echo "Recuerda guardar el n.º del pago de PayPal: " . $paymentId;
      echo '<br>';
      echo "</div>";

      require_once('includes/funciones/bd_conexion.php');
      $stmt = $conn->prepare('UPDATE registrados SET pagado = ? WHERE id_registrados = ? ');
      $pagado = 1;
      $stmt->bind_param('ii', $pagado, $id_registrado);
      $stmt->execute();
      $stmt->close();
      $conn->close();
    } else {
      echo "<div class='resultado error'>";
      echo "El pago no se realizó.";
      echo "</div>";
    }

    ?>
  </div>
</section>
<?php include_once 'includes/templates/footerRegistro.php'; ?>