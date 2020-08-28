<?php
$id =  $_GET['id'];

if (!filter_var($id, FILTER_VALIDATE_INT)) :
    die("Error");
else :
    include_once 'funciones/sesiones.php';
    include_once 'funciones/funciones.php';
    include_once 'templates/header.php';
    include_once 'templates/barra.php';
    include_once 'templates/navegacion.php';
?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Editar un Registrado Manual
                <small>Llena el formulario para Editar un registrado.</small>
            </h1>
        </section>

        <!-- Main content -->
        <div class="row">
            <div class="col-md-8">
                <!-- Default box -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar un Registrado Manual</h3>
                    </div>
                    <div class="box-body">


                        <?php
                        try {

                            $sql = "SELECT * FROM registrados WHERE id_registrados = $id ";
                            $resultado = $conn->query($sql);
                            $registrado = $resultado->fetch_assoc();
                        } catch (Exception $e) {
                            $error = $e->getMessage();
                            echo $error;
                        }
                        ?>
                        <!-- form start -->
                        <form class="editar-registrado" role="form" method="post" action="modelo-registrado.php" name="guardar-registro" id="guardar-registro">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="nombre_registrado">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre_registrado" placeholder="Nombre" value="<?php echo $registrado['nombre_registrado'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="apellido_registrado">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido_registrado" placeholder="Apellido" value="<?php echo $registrado['apellido_registrado'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="mail" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $registrado['email_registrado'] ?>">
                                </div>
                                <div id="error"></div>
                                <?php
                                $pedido = $registrado['pases_articulos'];
                                $boletos = json_decode($pedido, true);

                                ?>
                                <div class="form-group">
                                    <!--Datos Usuario-->
                                    <div id="paquetes" class="paquetes">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Elige el número de boletos</h3>
                                        </div>
                                        <ul class="lista-precios row clearfix ">
                                            <li class="col-md-4">
                                                <div class="tabla-precio text-center">
                                                    <h3>Pase por día (Viernes)</h3>
                                                    <p class="numero">$30</p>
                                                    <ul>
                                                        <li>Bocadillos Gratis</li>
                                                        <li>Todas las Conferencias</li>
                                                        <li>Todos los talleres</li>
                                                    </ul>
                                                    <div class="orden">
                                                        <label for="pase_dia">Boletos deseados</label>
                                                        <input value="<?php echo $boletos['un_dia']['cantidad']; ?>" type="number" id="pase_dia" min="0" size="3" name="boletos[un_dia][cantidad]" placeholder="0" class="form-control">
                                                        <input type="hidden" value="30" name="boletos[un_dia][precio]">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="col-md-4">
                                                <div class="tabla-precio text-center">
                                                    <h3>Todos los Días</h3>
                                                    <p class="numero">$50</p>
                                                    <ul>
                                                        <li>Bocadillos Gratis</li>
                                                        <li>Todas las Conferencias</li>
                                                        <li>Todos los talleres</li>
                                                    </ul>
                                                    <div class="orden">
                                                        <label for="pase_completo">Boletos deseados</label>
                                                        <input value="<?php echo $boletos['pase_completo']['cantidad']; ?>" type="number" id="pase_completo" min="0" size="3" name="boletos[completo][cantidad]" placeholder="0" class="form-control">
                                                        <input type="hidden" value="50" name="boletos[completo][precio]">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="col-md-4">
                                                <div class="tabla-precio text-center">
                                                    <h3>Pase por 2 días</h3>
                                                    <p class="numero ">$45</p>
                                                    <ul>
                                                        <li>Bocadillos Gratis</li>
                                                        <li>Todas las Conferencias</li>
                                                        <li>Todos los talleres</li>
                                                    </ul>
                                                    <div class="orden">
                                                        <label for="pase_dosdias">Boletos deseados</label>
                                                        <input value="<?php echo $boletos['pase_2dias']['cantidad']; ?>" type="number" id="pase_dosdias" min="0" size="3" name="boletos[2dias][cantidad]" placeholder="0" class="form-control">
                                                        <input type="hidden" value="45" name="boletos[2dias][precio]">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- .paquetes -->
                                </div>
                                <!-- .form-group -->
                                <div class="form-group">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Elige los Talleres</h3>
                                    </div>
                                    <!--Paquetes-->
                                    <div id="eventos" class="eventos clearfix">

                                        <div class="caja">
                                            <?php
                                            $eventos = $registrado['talleres_registrados'];
                                            $id_eventos_registrados = json_decode($eventos, true);

                                            try {
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
                                                <div id="<?php echo str_replace('á', 'a', $dia); ?>" class="contenido-dia clearfix row">
                                                    <h4 class="text-center nombre_dia"><?php echo $dia; ?></h4>
                                                    <?php
                                                    foreach ($eventos['eventos'] as $tipo => $evento_dia) :
                                                    ?>
                                                        <div class="col-md-4">
                                                            <p class="eventos"><?php echo $tipo; ?> </p>
                                                            <?php
                                                            foreach ($evento_dia as $evento) : ?>
                                                                <label>
                                                                    <input <?php
                                                                            if (in_array($evento['id'], $id_eventos_registrados['eventos'])) {
                                                                                echo 'checked';
                                                                            } else {
                                                                                echo '';
                                                                            } ?> type="checkbox" class="flat-red" name="registro_evento[]" id="<?php echo $evento['id'] ?>" value="<?php echo $evento['id'] ?>"> <time><?php echo $evento['hora'] ?></time> <?php echo $evento['nombre_evento'] ?>
                                                                </label>
                                                                <br>
                                                                <span class="autor"> <?php echo $evento['nombre_invitado'] . " " . $evento['apellido_invitado']; ?></span>
                                                                <br>
                                                                <br>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <!--#viernes-->
                                            <?php endforeach; ?>
                                        </div>
                                        <!--.caja-->
                                    </div>
                                </div>
                                <div id="resumen" class="resumen">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Pagos y Extras</h3>
                                    </div>
                                    <br>
                                    <div class="caja clearfix row">
                                        <div class="extras col-md-6">
                                            <div class="orden ">
                                                <label for="camisa_evento">Camisa del evento $10 <small>(promoción 7% dto.)</small></label>
                                                <input value="<?php echo $boletos['camisas']; ?>" type="number" class="form-control" id="camisa_evento" min="0" size="3 " placeholder="0" name="pedido_extra[camisas][cantidad]">
                                                <input type="hidden" value="10" name="pedido_extra[camisas][precio]">
                                            </div>
                                            <!--Orden-->
                                            <div class="orden ">
                                                <label for="etiquetas">Paquete de 10 etiquetas $2 <small>(HTML5, CSS3, JavaScript, Chrome)</small></label>
                                                <input value="<?php echo $boletos['camisas']; ?>" type="number" class="form-control" id="etiquetas" min="0" size="3" placeholder="0" name="pedido_extra[etiquetas][cantidad]">
                                                <input type="hidden" value="2" name="pedido_extra[etiquetas][precio]">
                                            </div>
                                            <!--Orden-->
                                            <div class="orden">
                                                <label for="regalo">Seleccione un regalo</label> <br>
                                                <select name="regalo" id="regalo" class="form-control" required>
                                                    <option value=""> -- Seleccione un regalo -- </option>
                                                    <option value="2" <?php if ($registrado['regalo'] == '2') {
                                                                            echo 'selected';
                                                                        } else {
                                                                            echo '';
                                                                        } ?>>Etiquetas</option>
                                                    <option value="1" <?php if ($registrado['regalo'] == '1') {
                                                                            echo 'selected';
                                                                        } else {
                                                                            echo '';
                                                                        } ?>> Pulseras</option>
                                                    <option value="3" <?php if ($registrado['regalo'] == '3') {
                                                                            echo 'selected';
                                                                        } else {
                                                                            echo '';
                                                                        } ?>> Plumas</option>
                                                </select>
                                            </div>
                                            <!--Orden-->
                                            <br>
                                            <input type="button" value="Calcular" id="calcular" class="btn btn-success">
                                        </div>
                                        <!--extras-->
                                        <div class="total col-md-6">
                                            <p>Resumen</p>
                                            <div id="lista-productos">
                                            </div>
                                            <p>Total Ya Pagado: <?php echo (float) $registrado['total_pagado']; ?></p>
                                            <p>Total</p>
                                            <div id="suma-total">

                                            </div>

                                        </div>
                                        <!--total-->
                                    </div>
                                    <!--caja-->
                                </div>
                                <!--resumen-->


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <!-- POR MOTIVOS DE SEGURIDAD hidden para que el id no se vea en el HTML. -->
                                <input type="hidden" name="total_pedido" id="total_pedido">
                                <input type="hidden" name="total_descuento" id="total_descuento" value="total_descuento" class="button pagar">
                                <input type="hidden" name="registro" value="actualizar">
                                <input type="hidden" name="id_registro" value="<?php echo $registrado['id_registrados']; ?>">
                                <input type="hidden" name="fecha_registrado" value="<?php echo $registrado['fecha_registrado']; ?>">
                                <button type="submit" class="btn btn-primary" id="btnRegistro">Guardar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- col-md-8 -->
        </div>
        <!--  -->
        <section class="content">

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php include_once 'templates/footerCrearRegistrado.php';
endif; ?>