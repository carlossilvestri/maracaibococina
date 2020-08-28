$(document).ready(function() {
    $('#login-admin').on('submit', function(e) {
        e.preventDefault();
        var datos = $(this).serializeArray();
        console.log('Datos: ' + $(this));
        $.ajax({
            //Todos estos keys son de ajax en jquery (type, data, url)
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data) {

                resultado = data;
                if (resultado.respuesta == 'exitoso') {
                    Swal.fire(
                        'Login Correcto',
                        '¡Bienvenid@ ' + resultado.usuario + '!',
                        'success'
                    )
                    setTimeout(() => {
                        window.location.href = 'admin-area.php';
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: '¡Usuario o contraseña incorrectos!'
                    })
                }

            },
            error: function(data) {
                console.log('Error: ' + data);
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: '¡Usuario o contraseña incorrectos!'
                })
            }
        })
    });
});