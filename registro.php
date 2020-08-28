<?php include_once 'includes/templates/header.php'; ?>
<section class="seccion">
    <div class="contenedor">
        <h2>Registro de Usuarios</h2>
        <form id="registro" action="pagar.php" class="registro" method="POST">
            <div id="datos_usuario " class="registro caja clearfix ">
                <div class="campo">
                    <label for="nombre">Nombre: </label>
                    <input type="text" id="nombre" name="nombre" placeholder="Tu Nombre ">
                </div>
                <div class="campo">
                    <label for="apellido">Apellido: </label>
                    <input type="text" id="apellido" name="apellido" placeholder="Tu Apellido ">
                </div>
                <div class="campo">
                    <label for="email">Email: </label>
                    <input type="email" id="email" name="email" placeholder="Tu Email ">
                </div>
                <div id="error"></div>
            </div>
            <!--Datos Usuario-->
            <div id="paquetes" class="paquetes">
                <h3 class="block ">Elige el número de boletos</h3>
                <ul class="lista-precios clearfix ">
                    <li>
                        <div class="tabla-precio">
                            <h3>Pase por día (Viernes)</h3>
                            <p class="numero">$30</p>
                            <ul>
                                <li>Bocadillos Gratis</li>
                                <li>Todas las Conferencias</li>
                                <li>Todos los talleres</li>
                            </ul>
                            <div class="orden">
                                <label for="pase_dia">Boletos deseados</label>
                                <input type="number" id="pase_dia" min="0" size="3" name="boletos[un_dia][cantidad]" placeholder="0">
                                <input type="hidden" value="30" name="boletos[un_dia][precio]">
                            </div>
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
                            <div class="orden">
                                <label for="pase_completo">Boletos deseados</label>
                                <input type="number" id="pase_completo" min="0" size="3" name="boletos[completo][cantidad]" placeholder="0">
                                <input type="hidden" value="50" name="boletos[completo][precio]">
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tabla-precio">
                            <h3>Pase por 2 días</h3>
                            <p class="numero ">$45</p>
                            <ul>
                                <li>Bocadillos Gratis</li>
                                <li>Todas las Conferencias</li>
                                <li>Todos los talleres</li>
                            </ul>
                            <div class="orden">
                                <label for="pase_dosdias">Boletos deseados</label>
                                <input type="number" id="pase_dosdias" min="0" size="3" name="boletos[2dias][cantidad]" placeholder="0">
                                <input type="hidden" value="45" name="boletos[2dias][precio]">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <!--Paquetes-->
            <div id="eventos" class="eventos clearfix">
                <h3>Elige tus talleres</h3>
                <div class="caja">
                    <?php
                    try {
                        require_once("includes/funciones/bd_conexion.php");
                        $sql = " SELECT eventos.*, categoria_evento.cat_evento, invitados.nombre_invitado, invitados.apellido_invitado ";
                        $sql .= " FROM eventos ";
                        $sql .= " JOIN categoria_evento ";
                        $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
                        $sql .= " JOIN invitados ";
                        $sql .= " ON eventos.id_inv = invitados.invitado_id ";
                        $sql .= " ORDER BY eventos.fecha_evento, eventos.id_cat_evento, eventos.hora_evento ";

                        //echo $sql;

                        $resultado = $conn->query($sql);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }

                    $eventos_dias = array();
                    while ($eventos = $resultado->fetch_assoc()) {
                        $fecha = $eventos['fecha_evento'];
                        setlocale(LC_ALL, 'es_ES');

                        $dia_semana = utf8_encode(strftime("%A", strtotime($fecha)));
                        $categoria = $eventos['cat_evento'];

                        $dia = array(
                            'nombre_evento' => $eventos['nombre_evento'],
                            'hora' => $eventos['hora_evento'],
                            'id' => $eventos['evento_id'],
                            'nombre_invitado' => $eventos['nombre_invitado'],
                            'apellido_invitado' => $eventos['apellido_invitado']
                        );
                        $eventos_dias[$dia_semana]['eventos'][$categoria][] = $dia;
                    }

                    ?>

                    <?php foreach ($eventos_dias as $dia => $eventos) : ?>
                        <?php //los ID no pueden tener acentos por eso sábado se reemplaza usando str_replace()
                        //el cual toma 3 parametros. Lo que quieres quitar, por lo que quieres poner y por último en donde. 
                        ?>
                        <div id="<?php echo str_replace('á', 'a', $dia); ?>" class="contenido-dia clearfix">
                            <h4><?php echo $dia; ?></h4>
                            <?php
                            foreach ($eventos['eventos'] as $tipo => $evento_dia) :
                            ?>
                                <div>
                                    <p><?php echo $tipo; ?> </p>
                                    <?php
                                    foreach ($evento_dia as $evento) : ?>
                                        <label><input type="checkbox" name="registro[]" id="<?php echo $evento['id'] ?>" value="<?php echo $evento['id'] ?>"><time><?php echo $evento['hora'] ?></time> <?php echo $evento['nombre_evento'] ?></label>
                                        <span class="autor"> <?php echo $evento['nombre_invitado'] . " " . $evento['apellido_invitado']; ?></span>
                                        <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!--#viernes-->
                    <?php endforeach; ?>
                </div>
                <!--.caja-->
            </div>
            <!--#eventos-->
            <div id="resumen" class="resumen">
                <h3>Pago y Extras</h3>
                <div class="caja clearfix ">
                    <div class="extras ">
                        <div class="orden ">
                            <label for="camisa_evento">Camisa del evento $10 <small>(promoción 7% dto.)</small></label>
                            <input type="number" id="camisa_evento" min="0" size="3 " placeholder="0" name="pedido_extra[camisas][cantidad]">
                            <input type="hidden" value="10" name="pedido_extra[camisas][precio]">
                        </div>
                        <!--Orden-->
                        <div class="orden ">
                            <label for="etiquetas">Paquete de 10 etiquetas $2 <small>(HTML5, CSS3, JavaScript, Chrome)</small></label>
                            <input type="number" id="etiquetas" min="0" size="3" placeholder="0" name="pedido_extra[etiquetas][cantidad]">
                            <input type="hidden" value="2" name="pedido_extra[etiquetas][precio]">
                        </div>
                        <!--Orden-->
                        <div class="orden">
                            <label for="regalo">Seleccione un regalo</label> <br>
                            <select name="regalo" id="regalo" required>
                                <option value=""> -- Seleccione un regalo -- </option>
                                <option value="2">Etiquetas</option>
                                <option value="1">Pulseras</option>
                                <option value="3">Plumas</option>
                            </select>
                        </div>
                        <!--Orden-->
                        <input type="button" value="calcular" id="calcular" class="button">
                    </div>
                    <!--extras-->
                    <div class="total">
                        <p>Resumen</p>
                        <div id="lista-productos">

                        </div>
                        <p>Total</p>
                        <div id="suma-total">

                        </div>
                        <!-- POR MOTIVOS DE SEGURIDAD hidden para que el id no se vea en el HTML. -->
                        <input type="hidden" name="total_pedido" id="total_pedido">
                        <input id="btnRegistro" type="submit" value="Pagar" class="button pagar" name="submit">
                    </div>
                    <!--total-->
                </div>
                <!--caja-->
            </div>
            <!--resumen-->
        </form>
    </div>
</section>
<?php include_once 'includes/templates/footerRegistro.php'; ?>