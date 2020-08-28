$(document).ready(function() {
    $('#guardar-registro').on('submit', function(e) {
        e.preventDefault();
        var datos = $(this).serializeArray();
        var tipoDeAccion = "";
        var primerTexto = "";
        var segundoTexto = "";
        var tercerTexto = "";
        console.log(datos);
        /* var datosLongitud = datos.length;
         var tipoDeAccion = "";
         //Si la longitud de los datos es menor a 6 eso quiere decir que proviene de Admin
         if (datosLongitud < 6) {
             tipoDeAccion = datos[4].value;
             console.log('Admin existe');
         } else {
             //Sino es porque proviene de eventos.
             tipoDeAccion = datos[5].value;
         }
         console.log(datos);
         var primerTexto = "";
         var segundoTexto = "";
         var tercerTexto = "";
         switch (tipoDeAccion) {
             case "actualizar-evento":
                 primerTexto = "editar el evento";
                 segundoTexto = "evento se editará";
                 tercerTexto = "editar."
                 break;
             case "nuevo-evento":
                 primerTexto = "agregar el evento";
                 segundoTexto = "evento se agregará";
                 tercerTexto = "agregar."
                 break;
             case "nuevo":
                 primerTexto = "agregar el administrador/a";
                 segundoTexto = "administrador/a se agregará";
                 tercerTexto = "agregar."
                 break;
             case "actualizar":
                 primerTexto = "editar el administrador/a";
                 segundoTexto = "administrador/a se editará";
                 tercerTexto = "editar."
                 break;
             default:
                 primerTexto = "agregarlo";
                 segundoTexto = "registro se guardará ";
                 tercerTexto = "crear";
                 break;
         }*/
        Swal.fire({
            title: '¿Estás seguro/a de ' + primerTexto + "?",
            text: "El " + segundoTexto + " en la Base de Datos.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, ' + tercerTexto,
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            //Si se oprimio "Si, eliminar" entonces:
            if ((result.value)) {
                $.ajax({
                    //Todos estos keys son de ajax en jquery (type, data, url)
                    type: $(this).attr('method'),
                    data: datos,
                    url: $(this).attr('action'),
                    dataType: 'json',
                    success: function(data) {
                        console.log('Succes: ' + data);
                        var resultado = data;
                        console.log(data);
                        if (resultado.respuesta == 'exito') {
                            Swal.fire(
                                '¡Correcto!',
                                '¡El Admin se creó correctamente!',
                                'success'
                            )
                        } else if (resultado.respuesta == 'editado') {
                            Swal.fire(
                                '¡Correcto!',
                                '¡Se editó correctamente!',
                                'success'
                            )
                        } else if (resultado.respuesta == 'evento-creado-exitosamente') {
                            Swal.fire(
                                '¡Correcto!',
                                '¡El evento se creó correctamente!',
                                'success'
                            )

                        } else if (resultado.respuesta == 'evento-editado') {
                            Swal.fire(
                                '¡Correcto!',
                                '¡El evento se editó correctamente!',
                                'success'
                            )

                        } else if (resultado.respuesta == 'categoria-creada-exitosamente') {
                            Swal.fire(
                                '¡Correcto!',
                                '¡La categoría se creó correctamente!',
                                'success'
                            )
                        } else if (resultado.respuesta == 'categoria-editada') {
                            Swal.fire(
                                '¡Correcto!',
                                '¡La categoría se edito correctamente!',
                                'success'
                            )
                        } else if (resultado.respuesta == 'registrado-creado-exitosamente') {
                            Swal.fire(
                                '¡Correcto!',
                                '¡El registrado se creó correctamente!',
                                'success'
                            )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '¡Error!',
                                text: '¡Algo salió mal. Por favor vuelve a intentarlo!'
                            })
                        }
                    },
                    error: console.log('Error')
                });
            } //.then((result))
        })
    }); // $('#guardar-registro')

    //Eliminar un registro:
    $('.borrar_registro').on('click', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');
        Swal.fire({
                title: '¿Estás seguro/a?',
                text: "No se podrá recuperar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar.',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                //Si se oprimio "Si, eliminar" entonces:
                if ((result.value)) {
                    $.ajax({
                        type: 'post',
                        data: {
                            'id': id,
                            'registro': 'eliminar'
                        },
                        url: 'modelo-' + tipo + '.php',
                        success: function(data) {
                            console.log(data);
                            var resultado = JSON.parse(data);

                            if (resultado.respuesta == 'eliminado') {
                                Swal.fire(
                                    '¡Eliminado!',
                                    'Se ha eliminado correctamente.',
                                    'success'
                                )
                                jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: '¡Algo salió mal!'
                                })
                            }
                        }
                    });
                }
            }) //.then((result) 


    }); // $('.borrar_registro')

    /*Se ejecuta cuando hay un archivo */
    $('#guardar-registro-archivo').on('submit', function(e) {
        e.preventDefault();
        var datos = new FormData(this);
        console.log(datos);

        Swal.fire({
            title: '¿Estás seguro/a?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí ',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            //Si se oprimio "Si, eliminar" entonces:
            if ((result.value)) {
                $.ajax({
                    //Todos estos keys son de ajax en jquery (type, data, url)
                    type: $(this).attr('method'),
                    data: datos,
                    url: $(this).attr('action'),
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    async: true,
                    cache: false,
                    success: function(data) {
                        console.log('Succes: ' + data);
                        var resultado = data;
                        console.log(data);
                        if (resultado.respuesta == 'exito') {
                            Swal.fire(
                                '¡Correcto!',
                                '¡El Invitado se creó correctamente!',
                                'success'
                            )
                        } else if (resultado.respuesta == 'invitado-editado-exitosamente') {
                            Swal.fire(
                                '¡Correcto!',
                                '¡El Invitado se editó correctamente!',
                                'success'
                            )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '¡Error!',
                                text: '¡Algo salió mal. Por favor vuelve a intentarlo!'
                            })
                        }
                    },
                    error: console.log('Error')
                });
            } //.then((result))
        })
    }); //  $('#guardar-registro-archivo')

}); //Documente Read