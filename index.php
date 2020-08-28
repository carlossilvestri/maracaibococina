<?php include_once 'includes/templates/header.php'; ?>
<section class="">
    <div class="contenedor">
        <h2>La mejor conferencia de cocina</h2>
        <p class="centrar">¿Estás en Maracaibo? Ven y disfruta de <strong>MCBO COCINA </strong>, conocerás cómo realizar increíbles platos venezolanos e internacionales, hechos por los mejores chefs.
        </p>
    </div>
</section>
<!--seccion-->

<section class="programa">
    <div class="contenedor-video">
        <video class="alturaVideo" autoplay loop poster="img/video/imgComidaFondo-min.png">
            <source src="img/video/comidaVideo.mp4" type="video/mp4">
        </video>
    </div>
    <!--contenedor video-->
    <div class="contenido-programa">
        <div class="contenedor">
            <div class="programa-evento">
                <h2>Programa del Evento</h2>
                <?php
                try {
                    require_once('includes/funciones/bd_conexion.php'); //Funcion que se encarga de incluir un archivo.
                    $sql = " SELECT * FROM `categoria_evento` ";
                    mysqli_set_charset($conn, 'utf8');  //Coloca UTF8 en PHP (SIN ESTO no puedo colocar acentos ni ñ).
                    $resultado = $conn->query($sql);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                } ?>
                <nav class="menu-programa">
                    <?php
                    //MIENTRAS LOS DATOS SE CONSIGAN SE IRA REPITIENDO POR EL WHILE
                    while ($cat = $resultado->fetch_array(MYSQLI_ASSOC)) : ?>
                        <?php $categoria = $cat['cat_evento']; ?>
                        <a href="#<?php echo strtolower($categoria); ?>"><i class="fa <?php echo $cat['icono']; ?>" aria-hidden="true"></i> <?php echo $categoria; ?></a>
                    <?php endwhile; ?>
                    
                    
                </nav>
                <?php
                try {
                    require_once('includes/funciones/bd_conexion.php'); //Funcion que se encarga de incluir un archivo.
                    //MULTI CONSULTAS CON MYSQLI: CONSULTA 1
                    //SE COLOCA $sql SIN PUNTO PARA QUE SE BORRE EL CODIGO $sql ANTERIOR
                    $sql = " SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono ,nombre_invitado, apellido_invitado ";
                    $sql .= " FROM eventos ";
                    $sql .= " INNER JOIN categoria_evento ";
                    $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
                    $sql .= " INNER JOIN invitados ";
                    $sql .= " ON eventos.id_inv = invitados.invitado_id ";
                    $sql .= " AND eventos.id_cat_evento = 1 ";
                    $sql .= " ORDER BY evento_id LIMIT 2; "; //ORDER BY evento_id pone el id de menor a mayor.
                    // CONSULTA 2
                    $sql .= " SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono ,nombre_invitado, apellido_invitado ";
                    $sql .= " FROM eventos ";
                    $sql .= " INNER JOIN categoria_evento ";
                    $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
                    $sql .= " INNER JOIN invitados ";
                    $sql .= " ON eventos.id_inv = invitados.invitado_id ";
                    $sql .= " AND eventos.id_cat_evento = 2 ";
                    $sql .= " ORDER BY evento_id LIMIT 2; "; //ORDER BY evento_id pone el id de menor a mayor.
                    // CONSULA 3
                    $sql .= " SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono ,nombre_invitado, apellido_invitado ";
                    $sql .= " FROM eventos ";
                    $sql .= " INNER JOIN categoria_evento ";
                    $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
                    $sql .= " INNER JOIN invitados ";
                    $sql .= " ON eventos.id_inv = invitados.invitado_id ";
                    $sql .= " AND eventos.id_cat_evento = 3 ";
                    $sql .= " ORDER BY evento_id LIMIT 2; "; //ORDER BY evento_id pone el id de menor a mayor.
                    //mysqli_set_charset($conn, 'utf8');  //Coloca UTF8 en PHP (SIN ESTO no puedo colocar acentos ni ñ)
                } catch (\Exception $e) {
                    echo $e->getMessage();
                } ?>
                <?php
                //MULTI-QUERY ya no se pone query().
                $conn->multi_query($sql); ?>
                <?php
                do {
                    $resultado = $conn->store_result();
                    $row = $resultado->fetch_all(MYSQLI_ASSOC);?>
                    <?php $i = 0; ?>
                    <?php foreach ($row as $evento) : ?>
                        <?php
                                //SI LA DIVISION MODULAR ES 0, ENTONCES ES PAR.
                                if ($i % 2 == 0) : ?>
                            <div id="<?php echo strtolower($evento['cat_evento']);?>" class="info-curso ocultar clearfix">
                            <?php endif; ?>
                            <div class="detalle-evento">
                                <h3><?php echo $evento['nombre_evento']; ?></h3>
                                <p><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo $evento['hora_evento']; ?></p>
                                <p><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $evento['fecha_evento']; ?></p>
                                <p><i class="fa fa-user" aria-hidden="true"></i><?php echo $evento['nombre_invitado'] . " " . $evento['apellido_invitado']; ?></p>
                            </div> 
                            <?php if ($i % 2 == 1) :  ?>
                            <a href="#" class="button float-right">Ver Todos</a>    
                                </div>
                            <?php endif; ?>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                        <?php $resultado->free(); ?>
                    <?php } while ($conn->more_results() && $conn->next_result()); ?>
            </div>
            <!-- programa-evento-->
        </div>
        <!-- contenedor -->
    </div>
    <!-- contenido-programa -->
</section>
<?php include_once 'includes/templates/invitados.php'; ?>

<div class="contador parallax">
    <div class="contenedor">
        <ul class="resumen-evento clearfix">
            <li>
                <p class="numero negro">0</p> Invitados
            </li>
            <li>
                <p class="numero negro">0</p> Talleres
            </li>
            <li>
                <p class="numero negro">0</p> Días
            </li>
            <li>
                <p class="numero negro">0</p> Conferencias
            </li>
        </ul>
    </div>
</div>

<section class="precios seccion">
    <h2>Precios</h2>
    <div class="contenedor">
        <ul class="lista-precios clearfix">
            <li>
                <div class="tabla-precio">
                    <h3>Pase por día</h3>
                    <p class="numero">$30</p>
                    <ul>
                        <li>Bocadillos Gratis</li>
                        <li>Todas las Conferencias</li>
                        <li>Todos los talleres</li>
                    </ul>
                    <a href="#" class="button hollow">Comprar</a>
                </div>
            </li>
            <li>
                <div class="tabla-precio">
                    <h3>Todos los Días</h3>
                    <p class="numero">$50</p>
                    <ul>
                        <li>Bocadillos Gratis</li>
                        <li>Todas las Conferencias</li>
                        <li>Todos los talleres</li>
                    </ul>
                    <a href="#" class="button">Comprar</a>
                </div>
            </li>
            <li>
                <div class="tabla-precio">
                    <h3>Pase por 2 días</h3>
                    <p class="numero">$45</p>
                    <ul>
                        <li>Bocadillos Gratis</li>
                        <li>Todas las Conferencias</li>
                        <li>Todos los talleres</li>
                    </ul>
                    <a href="#" class="button hollow">Comprar</a>
                </div>
            </li>
        </ul>
    </div>
</section>
<section class="mapa">
<h2>Mapa</h2>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3921.014985818696!2d-71.59609618571382!3d10.655943364321049!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e89988d04bb6749%3A0x4137bee05553bef2!2sVereda%20del%20Lago!5e0!3m2!1ses-419!2sve!4v1570296649152!5m2!1ses-419!2sve" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
</section>
</section>

<!-- <div class="mapa" id="mapa"></div> -->

<section class="seccion">
    <h2>Testimoniales</h2>
    <div class="testimoniales contenedor clearfix">
        <div class="testimonial">
            <blockquote>
                <p>Una conferencia que jamás olvidaré, aprendí muchísimas cosas que no sabía del hermoso mundo de la cocina. Además te dan la oportunidad de probar algunos platos, todo estuvo delicioso y muy bien organizado, felicitaciones a los cocineros.</p>
                <footer class="info-testimonial clearfix"> <img src="img/Foto_mia1.png" alt="Testimnonial">
                    <cite>Carlos Silvestri<span>Espectador de la conferencia</span></cite>
                </footer>
            </blockquote>
        </div>
        <!--Testimnoal-->
        <div class="testimonial">
            <blockquote>
                <p>Soy turista, me gustó la conferencia, conocí un poco más sobre la comida venezolana, me encanta. Las arepas, las hallacas, el pan de jamón son increíbles, espero volver y conocer qué más sorpresas tendrán. Estoy muy complacido. </p>
                <footer class="info-testimonial clearfix"> <img src="img/testimonial.jpg" alt="Testimnonial">
                    <cite>Oswaldo Aponte Escobedo <span>Espectador de la conferencia</span></cite>
                </footer>
            </blockquote>
        </div>
        <!--Testimnoal-->
        <div class="testimonial">
            <blockquote>
                <p>Es un placer para mí compartir algunos de mis conocimientos de cocina. En el evento podrás encontrar un poco de todo, comida japonesa, venezolana, mexicana... ¡No esperes más! Ven y conoce el maravilloso mundo de la cocina sin tener
                    que viajar.</p>
                <footer class="info-testimonial clearfix"> <img src="img/invitados/chef5p.png" alt="Testimnonial">
                    <cite>Qiang García <span>Cocinero</span></cite>
                </footer>
            </blockquote>
        </div>
        <!--Testimnoal-->
    </div>
</section>
<div class="newsletter parallax">
    <div class="contenido contenedor">
        <p>regístrate al newsletter</p>
        <h3>MCBO COCINA</h3>
        <a href="#" class="button transparent">Regístrate</a>
    </div>
    <!--contenido-->
</div>
<!--newsletter-->

<section class="seccion fondo-blanco">
    <h2>Faltan</h2>
    <div class="cuenta-regresiva contenedor">
        <ul class="clearfix">
            <li>
                <p id="dias" class="numero"></p> días
            </li>
            <li>
                <p id="horas" class="numero"></p> horas
            </li>
            <li>
                <p id="minutos" class="numero"></p> minutos
            </li>
            <li>
                <p id="segundos" class="numero"></p> segundos
            </li>
        </ul>
    </div>
</section>
<?php include_once 'includes/templates/footer.php'; ?>