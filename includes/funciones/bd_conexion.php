<?php
$conn = new mysqli('localhost', 'root', '', 'mcbo_cocina'); //Servidor, usuario, contraseña, nombre de la base de datos.
mysqli_set_charset($conn, 'utf8');  //Coloca UTF8 en PHP (SIN ESTO no puedo colocar acentos ni ñ).
if ($conn->connect_error) {
    echo $error->$conn->connect_error;
}
?>