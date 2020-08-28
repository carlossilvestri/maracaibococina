(function() {
    //Con el EFI aseguramos que el código se ejecute una sola vez.
    "use strict";
    document.addEventListener('DOMContentLoaded', function() {
        //Campos Datos Usuario
        var nombre = document.getElementById('nombre');
        var apellido = document.getElementById('apellido');
        var email = document.getElementById('email');

        //Campos Pases:
        var pase_dia = document.getElementById('pase_dia');
        var pase_completo = document.getElementById('pase_completo');
        var pase_dosdias = document.getElementById('pase_dosdias');
        //Botones y divs
        var calcular = document.getElementById('calcular');
        var errorDiv = document.getElementById('error');
        var botonRegistro = document.getElementById('btnRegistro');
        var lista_productos = document.getElementById('lista-productos');
        var suma = document.getElementById('suma-total');
        var bandera = false;

        //Extras
        var etiquetas = document.getElementById('etiquetas'),
            camisas = document.getElementById('camisa_evento');
        //DESABILITAR LA OPCION DE PAGAR Y COLOCAR EN NEGRO EL BOTON PAGAR
        botonRegistro.disabled = true;
        botonRegistro.style.background = '#131111';
        botonRegistro.style.border = 'none';


        if (document.getElementById('calcular')) {


            calcular.addEventListener('click', calcularMontos);
            pase_dia.addEventListener('blur', mostrarDias); // blur ya que el input tipo number requiere más que solo hacer click.
            pase_completo.addEventListener('blur', mostrarDias); // blur ya que el input tipo number requiere más que solo hacer click.
            pase_dosdias.addEventListener('blur', mostrarDias); // blur ya que el input tipo number requiere más que solo hacer click.

            nombre.addEventListener('blur', validarCampos);
            apellido.addEventListener('blur', validarCampos);
            email.addEventListener('blur', validarCampos);
            email.addEventListener('blur', validarMail);

            var formulario_editar = document.getElementsByClassName('editar-registrado');
            if (formulario_editar.length > 0) {
                if (pase_dia.value || pase_dosdias.value || pase_completo.value) {
                    mostrarDias();
                }
            }



            function validarCampos() {
                if (this.value === '') {
                    errorDiv.style.display = 'block';
                    errorDiv.innerHTML = 'Este campo es obligatorio';
                    this.style.border = '1px solid red';
                    errorDiv.style.border = '1px solid red';
                } else {
                    errorDiv.style.display = 'none';
                    this.style.border = '1px solid #cccccc';
                }
            }

            function validarMail() {
                if (this.value.indexOf('@') > -1) { //indexOf permite conocer si en un array existe un carácter determinado, 
                    //si existe nos devuelve un número mayor a -1, y si no nos devuelve un -1.
                    errorDiv.style.display = 'none';
                    this.style.border = '1px solid #cccccc';
                } else {
                    errorDiv.style.display = 'block';
                    errorDiv.innerHTML = 'Debe tener almenos una @';
                    this.style.border = '1px solid red';
                    errorDiv.style.border = '1px solid red';
                }
            }

            function calcularMontos(e) {
                e.preventDefault();
                if (regalo.value === ' ') {
                    alert('Debes elegir un regalo');
                    bandera = true;
                    regalo.focus();
                } else if (nombre.value === '' || apellido.value === '' || email.value === '') {
                    alert('Faltan datos por ingresar');
                    bandera = true;
                } else if (pase_dia.value === "0" && pase_completo.value === "0" && pase_dosdias.value === "0") {
                    alert('Debe elegir tu cantidad de boletos');
                    bandera = true;
                } else if (pase_dia.value === "" && pase_completo.value === "" && pase_dosdias.value === "") {
                    alert('Debe elegir tu cantidad de boletos');
                    bandera = true;
                } else {

                    var boletosDia = parseInt(pase_dia.value, 10) || 0,
                        boletos2Dias = parseInt(pase_dosdias.value) || 0,
                        boletosCompleto = parseInt(pase_completo.value) || 0,
                        cantCamisas = parseInt(camisas.value) || 0,
                        cantEtiquetas = parseInt(etiquetas.value) || 0;

                    var totalPagar = (boletosDia * 30) + (boletos2Dias * 45) + (boletosCompleto * 50) + ((cantCamisas * 10) * .93) + (cantEtiquetas * 2);

                    var listadiProductos = [];
                    if (boletosDia >= 1) {
                        listadiProductos.push(boletosDia + ' pases por día.');
                    }
                    if (boletosCompleto === 1) {
                        listadiProductos.push(boletosCompleto + ' pase completo.');
                    }

                    if (boletosCompleto > 1) {
                        listadiProductos.push(boletosCompleto + ' pases completos.');
                    }
                    if (boletos2Dias >= 1) {
                        listadiProductos.push(boletos2Dias + ' pases por 2 días.');
                    }
                    if (cantCamisas >= 1) {
                        listadiProductos.push(cantCamisas + ' camisas');
                    }
                    if (etiquetas >= 1) {
                        listadiProductos.push(etiquetas + ' etiquetas.');
                    }
                    lista_productos.style.display = 'block';

                    lista_productos.innerHTML = '';
                    for (var i = 0; i < listadiProductos.length; i++) {
                        lista_productos.innerHTML += listadiProductos[i] + '<br>';
                    }
                    suma.innerHTML = '$' + totalPagar.toFixed(2);

                    botonRegistro.disabled = false;
                    botonRegistro.style.background = '#808080';
                    document.getElementById('total_pedido').value = totalPagar;

                }
            }

            function mostrarDias(e) {

                var boletosDia = parseInt(pase_dia.value, 10) || 0,
                    boletos2Dias = parseInt(pase_dosdias.value) || 0,
                    boletosCompleto = parseInt(pase_completo.value) || 0;

                var diasElegidos = [];
                if (boletosDia > 0) {
                    diasElegidos.push('viernes');
                } else {
                    document.getElementById('viernes').style.display = 'none';
                }
                if (boletos2Dias > 0) {
                    diasElegidos.push('viernes', 'sabado');
                } else {
                    if (!boletosDia > 0) {
                        document.getElementById('viernes').style.display = 'none';
                    }
                    document.getElementById('sabado').style.display = 'none';
                }
                if (boletosCompleto > 0) {
                    diasElegidos.push('viernes', 'sabado', 'domingo');
                } else {
                    if (!boletos2Dias > 0) {
                        document.getElementById('viernes').style.display = 'none';
                        document.getElementById('sabado').style.display = 'none';
                    }
                    document.getElementById('domingo').style.display = 'none';
                }
                for (var i = 0; i < diasElegidos.length; i++) {
                    document.getElementById(diasElegidos[i]).style.display = 'block';
                }
            }
        }
    }); //DOMContentLoaded
})();