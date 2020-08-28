<?php
try { //SE REALIZA LA CONEXION AGREGANDO EL ARCHIVO CONEXION:
    require_once('includes/funciones/bd_conexion.php'); //Funcion que se encarga de incluir un archivo.
    //CODIGO DE CONSULTA SQL:
    $sql = " SELECT * FROM  invitados ";
    //NOS ASEGURAMOS QUE PHP INCLUYA ACENTOS:           
    mysqli_set_charset($conn, 'utf8');  //Coloca UTF8 en PHP (SIN ESTO no puedo colocar acentos ni ñ).
    //RESUMIMOS TODO EN UNA SOLA VARIABLE:
    $resultado = $conn->query($sql);
    //SI HAY UN ERROR, EL CATCH HACE QUE LA PAGINA SIGA FUNCIONANDO:
} catch (\Exception $e) {
    //SE MUESTRA CUAL FUE EL ERROR:
    echo $e->getMessage();
} ?>

<section class="invitadosseccion seccion">
    <div class="contenedor">
        <h2>Invitados</h2>
        <ul class="lista-invitados clearfix">
            <?php
            //MIENTRAS LOS DATOS SE CONSIGAN SE IRA REPITIENDO POR EL WHILE
            while ($invitados = $resultado->fetch_assoc()) { ?>
                <?php //fetch_assoc() permite usar las llaves (keys) ejemplo: $invitados['key'],
                    //TAMBIEN EXISTE fetch_all(), fetch_array()
                    ?>
                <li>
                    <div class="invitado">
                        <a class="invitado-info" href="#invitado<?php echo $invitados['invitado_id']; ?>">
                            <img src="img/invitados/<?php echo $invitados['url']; ?>" alt="Invitado">
                        </a>
                        <p><?php echo $invitados['nombre_invitado'] . " " . $invitados['apellido_invitado']; ?></p>
                    </div>
                </li>
                <div style="display:none;">
                    <div class="invitado-info" id="invitado<?php echo $invitados['invitado_id']; ?>">
                        <h2><?php echo $invitados['nombre_invitado'] . " " . $invitados['apellido_invitado']; ?></h2>
                        <img src="img/invitados/<?php echo $invitados['url']; ?>" alt="Invitado">
                        <p><?php echo $invitados['descripcion']; ?></p>
                    </div>
                </div>

            <?php } //FIN DEL WHILE
            ?>
        </ul>
        <?php
        $conn->close();
        ?>
    </div>
</section>
<!--seccion-->