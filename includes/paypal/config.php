<?php 

//url aquispe
define('URL_SITIO', 'http://localhost/conferencia%20de%20cocina/');

require('PayPal-PHP-SDK/autoload.php');
//Datos del Sandbox de PayPal de Conferencia de cocina en maracaibo

$apiContext = new \PayPal\Rest\ApiContext(
  new \PayPal\Auth\OAuthTokenCredential(
     'AbIAcY1VnkVaVeAErwTxeEpGKAiEcBo5A1YchopvuCTZvmQq0hCwSzdPbOSQeM7pvNjzenN-4BrYNBMA',     // ClientID
     'EBzShCpfnNMtL0oc98LVtI_IQDijDs6xuHME9-1darYj5MHmAClHjMLOWC29S62CWwHgULX3fM0yXo2O'      // ClientSecret
   )
 );
 
/*
$apiContext->setConfig([
 'mode'=>'sandbox',
 'http.ConnectionTimeOut'=>30,
 'log.LogEnabled'=>false,
 'log.FileName'=>'',
 'log.LogLevel'=>'FINE',
 'validation.level'=>'log'
]);
*/
