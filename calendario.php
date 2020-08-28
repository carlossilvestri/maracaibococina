<?php include_once 'includes/templates/header.php'; ?>
<section class="">
    <div class="contenedor">
        <h2>Calendario de Eventos</h2>
        <?php
        try {
            require_once('includes/funciones/bd_conexion.php'); //Funcion que se encarga de incluir un archivo.

            $sql = " SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono ,nombre_invitado, apellido_invitado ";
            $sql .= " FROM eventos ";
            $sql .= " INNER JOIN categoria_evento ";
            $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
            $sql .= " INNER JOIN invitados ";
            $sql .= " ON eventos.id_inv = invitados.invitado_id ";
            $sql .= " ORDER BY evento_id "; //ORDER BY evento_id pone el id de menor a mayor.           
            $resultado = $conn->query($sql);
        } catch (\Exception $e) {
            echo $e->getMessage();
        } ?>
        <div class="calendario">
            <?php
            //fetch_assoc() permite usar las llaves (keys) ejemplo: $eventos['key'], fetch_all(), fetch_array()
            $calendario = array();
            while ($eventos = $resultado->fetch_assoc()) {
                //Obtiene la fecha del evento:
                $fecha = $eventos['fecha_evento'];
                $categoria = $eventos['cat_evento'];

                $evento = array(
                    'titulo' => $eventos['nombre_evento'],
                    'fecha' => $eventos['fecha_evento'],
                    'hora' => $eventos['hora_evento'],
                    'categoria' => $eventos['cat_evento'],
                    'icono' =>  "fa " . $eventos['icono'],
                    'invitado' => $eventos['nombre_invitado'] . " " . $eventos['apellido_invitado']
                );
                $calendario[$fecha][] = $evento;?>
            <?php } //while de fetch_assoc
            ?>
            <?php //Imprime todos los eventos:
            ?>
            <?php foreach ($calendario as $dia => $lista_eventos) : ?>
                <h3>
                    <i class="fa fa-calendar"></i>
                    <?php
                        //Windows (date solo lo pone en ingles, lo necesito en español).
                        setlocale(LC_TIME, 'spanish');
                        $textoDia = "%A, %d de %B del %Y";
                        $fechaCompleta = utf8_encode(strftime($textoDia, strtotime($dia))); //utf8_encode() para los acentos.
                        echo ucfirst($fechaCompleta);
                        // ucfirst() Pone la 1era letra en mayúscula. ucwords() pone en mayúscula la 1era letra de CADA palabra.
                        ?>
                </h3>
                <?php foreach ($lista_eventos as $evento) : ?>
                <div class="dia centrar">
                    <p class="titulo"> <?php echo $evento['titulo'] ?> </p>
                    <p class="hora"> <i class="fa fa-clock-o" aria-hidden="true"></i>
                     <?php echo $evento['fecha'] . " " .  $evento['hora']; ?> </p>
                     <p><i class="<?php echo $evento['icono'];?>" aria-hidden="true"></i> <?php echo $evento['categoria']; ?> </p>
                     <p><i class="fa fa-user" aria-hidden="true"></i>
                     <?php echo $evento['invitado']; ?> </p>
 
                </div>
                <?php endforeach; //fin foreach 2?>
            <?php endforeach; //fin foreach 1 de dias
            $conn->close();
            ?>
        </div>
    </div>
</section>
<!--seccion-->


<?php include_once 'includes/templates/footer.php'; ?>