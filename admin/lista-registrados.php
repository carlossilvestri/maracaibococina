<?php
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
            Listado de Personas Registradas
            <small></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Maneja las personas registradas en esta sección.</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="registros" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="letra-mediana">Nombre</th>
                                    <th class="letra-mediana">Email</th>
                                    <th class="letra-mediana">Fecha Registro</th>
                                    <th class="letra-mediana">Artículos</th>
                                    <th class="letra-mediana">Talleres</th>
                                    <th class="letra-mediana">Regalo</th>
                                    <th class="letra-mediana">Compra</th>
                                    <th class="letra-mediana">Acciones</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                try {

                                    $sql = " SELECT registrados.*, regalos.nombre_regalo FROM registrados ";
                                    $sql .= " JOIN regalos ";
                                    $sql .= " ON registrados.regalo = regalos.id_regalo ";
                                    $resultado = $conn->query($sql);
                                } catch (Exception $e) {
                                    $error = $e->getMessage();
                                    echo $error;
                                }
                                while ($registrados = $resultado->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td class="letra-chiquita">
                                            <?php echo $registrados['nombre_registrado'] . " " . $registrados['apellido_registrado']; ?>
                                            <?php $pagado = $registrados['pagado'];
                                            if ($pagado) {
                                                echo '<br><span class="badge bg-green">Pagado</span>';
                                            } else {
                                                echo '<br><span class="badge bg-red">No Pagado</span>';
                                            }
                                            ?>
                                        </td>
                                        <td class="letra-chiquita"><?php echo $registrados['email_registrado']; ?></td>
                                        <td class="letra-chiquita"><?php echo $registrados['fecha_registrado']; ?></td>
                                        <td class="letra-chiquita">
                                            <?php
                                            //Convertir un json a un arreglo
                                            $articulos = json_decode($registrados['pases_articulos'], true);
                                            $arreglo_articulo = array(
                                                'un_dia' => 'Pase de 1 día',
                                                'pase_2dias' => 'Pase de 2 días',
                                                'pase_completo' => 'Pase Completo',
                                                'camisas' => 'Camisas',
                                                'etiquetas' => 'Etiquetas'
                                            );
                                            foreach ($articulos as $llave => $articulo) {
                                                
                                                if(is_int($articulo)){
                                                    echo $articulo . " " . $arreglo_articulo[$llave] . "<br>";
                                                }else if (array_key_exists('cantidad', $articulo)) {
                                                    echo $articulo['cantidad'] . " " . $arreglo_articulo[$llave] . "<br>";
                                                }
    
                                            }

                                            ?>
                                        </td>
                                        <td class="letra-chiquita">

                                            <?php

                                            $eventos_resultado = $registrados['talleres_registrados'];
                                            //Convertir un json a un arreglo
                                            $talleres = json_decode($eventos_resultado, true);
                                            //Implode lo que hace es que todos los valores de un arreglo los coloca en una cadena
                                            $talleres = implode("', '", $talleres['eventos']);
                                            try {

                                                $sql_talleres = " SELECT nombre_evento, fecha_evento, hora_evento FROM eventos WHERE clave IN ('$talleres') OR evento_id IN ('$talleres') ";
                                                $resultado_talleres = $conn->query($sql_talleres);
                                            } catch (Exception $e) {
                                                $error = $e->getMessage();
                                                echo $error;
                                            }
                                            while ($eventos = $resultado_talleres->fetch_assoc()) {
                                                echo $eventos['nombre_evento'] . " " . $eventos['fecha_evento'] . " " . $eventos['hora_evento'] . "<br>";
                                            }


                                            ?>

                                        </td>
                                        <td class="letra-chiquita"><?php echo $registrados['nombre_regalo']; ?></td>
                                        <td class="letra-chiquita"><?php echo (float) $registrados['total_pagado']; ?></td>
                                        <td class="letra-chiquita">
                                            <a href="editar-registro.php?id=<?php echo $registrados['id_registrados']; ?>" class="btn bg-orange btn-flat margin">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" data-id="<?php echo $registrados['id_registrados']; ?>" data-tipo="registrado" class="btn bg-maroon btn-flat margin borrar_registro">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>

                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="letra-mediana">Nombre</th>
                                    <th class="letra-mediana">Email</th>
                                    <th class="letra-mediana">Fecha Registro</th>
                                    <th class="letra-mediana">Artículos</th>
                                    <th class="letra-mediana">Talleres</th>
                                    <th class="letra-mediana">Regalo</th>
                                    <th class="letra-mediana">Compra</th>
                                    <th class="letra-mediana">Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once 'templates/footer.php'; ?>