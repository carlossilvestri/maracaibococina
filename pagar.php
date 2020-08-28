<?php

if (!isset($_POST['submit'])) {
  exit("Hubo un error");
}

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


require 'includes/paypal/config.php';
if (isset($_POST['submit'])) :
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $email = $_POST['email'];
  $regalo = $_POST['regalo'];
  $total = $_POST['total_pedido'];
  $fecha = date('Y-m-d H:i:s');
  //PEDIDOS
  $boletos = $_POST['boletos'];
  $cantBoletos = $boletos;
  $pedidoExtra = $_POST['pedido_extra'];
  $cantCamisas = $_POST['pedido_extra']['camisas']['cantidad'];
  $precioCamisas = $_POST['pedido_extra']['camisas']['precio'];
  $cantEtiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];
  $precioEtiquetas = $_POST['pedido_extra']['etiquetas']['precio'];
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

    try {
      require_once('includes/funciones/bd_conexion.php'); //Funcion que se encarga de incluir un archivo.
      //PREPARE STATEMENT CONTRA MYSQL INJECTION (ATAQUES INFORMATICOS A LA BASE DE DATOS)
      $stmt = $conn->prepare("INSERT INTO registrados 
              (nombre_registrado, apellido_registrado, email_registrado, fecha_registrado,
               pases_articulos, talleres_registrados, regalo, total_pagado) VALUES(?,?,?,?,?,?,?,?) ");
      $stmt->bind_param("ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
      $stmt->execute();
      $id_registro = $stmt->insert_id;
      $stmt->close();
      //FUNCION QUE EVITA QUE AL RECARGAR LA PAGINA SE ENVIEN NUEVAMENTE LOS DATOS A LA BASE DE DATOS
      //header('Location: validar_registro.php?exitoso=1');
      $conn->close();
  } catch (\Exception $e) {
      echo $e->getMessage();
  } 

$envio = 0; //El envio es gratis.

$compra = new Payer();
$compra->setPaymentMethod('paypal');

$i = 0;
$arreglo_pedido = array();
foreach ($cantBoletos as $key => $value) {

  if ((int) $value['cantidad'] > 0) {
    ${"articulo$i"} = new Item();
    $arreglo_pedido[] = ${"articulo$i"};
    ${"articulo$i"}->setName('Pase: ' . $key)
      ->setCurrency('USD')
      ->setQuantity((int) $value['cantidad'])
      ->setPrice((int) $value['precio']);

    $i++;
  }
}
$i = 0;
foreach ($pedidoExtra as $key => $value) {
  if ((int) $value['cantidad'] > 0) {
    if ($key == 'camisas') {
      $precio = (float) $value['precio'] * .93;
    } else {
      $precio = (int) $value['precio'];
    }

    ${"articulo$i"} = new Item();
    $arreglo_pedido[] = ${"articulo$i"};
    ${"articulo$i"}->setName('Extra: ' . $key)
      ->setCurrency('USD')
      ->setQuantity((int) $value['cantidad'])
      ->setPrice($precio);
    $i++;
  }
}


$listaArticulos = new ItemList();
$listaArticulos->setItems($arreglo_pedido);
         
          
$cantidad = new Amount();
$cantidad->setCurrency('USD')
          ->setTotal($total);
          
$transaccion = new Transaction();
$transaccion->setAmount($cantidad)
               ->setItemList($listaArticulos)
               ->setDescription('Pago de la Conferencia de Cocina MCBO.')
               ->setInvoiceNumber($id_registro);

               

$redireccionar = new RedirectUrls();
$redireccionar->setReturnUrl(URL_SITIO . "/pago_finalizado.php?id_registrado=$id_registro&nombre=$nombre")
              ->setCancelUrl(URL_SITIO . "/pago_finalizado.php&id_registrado=$id_registro&nombre=$nombre");
              
            
$pago = new Payment();
$pago->setIntent("sale")
     ->setPayer($compra)
     ->setRedirectUrls($redireccionar)
     ->setTransactions(array($transaccion));

     
     try {
       $pago->create($apiContext);

     } catch (PayPal\Exception\PayPalConnectionException $pce) {
       // Don't spit out errors or use "exit" like this in production code
       echo '<pre>';print_r(json_decode($pce->getData()));exit;

   }


$aprobado = $pago->getApprovalLink();


header("Location: {$aprobado}");
endif;

