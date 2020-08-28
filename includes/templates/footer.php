<footer class="site-footer">
    <div class="contenedor clearfix">
        <div class="footer-informacion">
            <h3>Sobre <span>MCBO COCINA</span> </h3>
            <p>Somos una organización amante de la cocina. Nuestra misión es enseñarte las técnicas necesarías para que puedas hacer platos increíbles. Queremos que conozcas platos venezolanos e internacionales y lo mejor de todo: ¡Sin que tengas que
                invertir un dólar en viajes para que lo hagas!
            </p>
        </div>
        <div class="ultimos-tweets">
            <h3>Últimos <span>tweets</span></h3>
            <a class="twitter-timeline" data-height="350" data-theme="light" href="https://twitter.com/Silvestri_C?ref_src=twsrc%5Etfw">Tweets by Silvestri_C</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
        <div class="menu">
            <h3>Redes <span>sociales</span> </h3>
            <nav class="redes-sociales">
                <a href="https://www.facebook.com/profile.php?id=100004958981799"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/Silvestri_C" class="twitter"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-pinterest-p"></i></a>
                <a href="https://www.youtube.com/channel/UCOIJE4oIw9JQNmIgXF8noPg?view_as=subscriber"><i class="fab fa-youtube"></i></a>
                <a href="https://www.instagram.com/carlossilvestri/?hl=es-la"><i class="fab fa-instagram"></i></a>
            </nav>
        </div>
    </div>
    <p class="copyright">Todos los Derechos Reservados - Carlos Silvestri.</p>
</footer>


<script src="https://code.jquery.com/jquery-3.4.1.min.js " integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin=" anonymous "></script>
<script src="https://kit.fontawesome.com/a602e044b9.js "></script>
<script src="js/vendor/modernizr-3.7.1.min.js "></script>
<script src="js/plugins.js "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js" integrity="sha256-Ikk5myJowmDQaYVCUD0Wr+vIDkN8hGI58SGWdE671A8=" crossorigin="anonymous"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lettering.js/0.7.0/jquery.lettering.min.js" integrity="sha256-7sov0P4cWkfKMVHQ/NvnWVqcLSPYrPwxdz+MtZ+ahl8=" crossorigin="anonymous"></script>
<?php
//GUARDAMOS EL NOMBRE DE LA PAGINA EN LA QUE ESTAMOS. EJEMPLO: invitados.php
$archivo = basename($_SERVER['PHP_SELF']);
//LE QUITAMOS LA EXTENSION .php 
//CON LA FUNCION str_replace("lo que queremos quitar","lo que queremos poner", cadena de caracteres);
$pagina = str_replace(".php", "", $archivo);
switch ($pagina) {
    case 'invitados':
        echo '<script src="js/jquery.colorbox-min.js"></script>';
        break;
    case 'conferencia':
        echo '<script src="js/lightbox.js"></script>';
        break;
    case 'index':
        echo '<script src="js/jquery.colorbox-min.js"></script>';
        echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-animateNumber/0.0.14/jquery.animateNumber.min.js" integrity="sha256-GCAeRKCXFEtLTZ+gG1SCIrtGkYq1zZjMXkj+XUFNJqo=" crossorigin="anonymous"></script>';
        break;
} ?>
<script src="js/indexjs.js"></script>



<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
    window.ga = function() {
        ga.q.push(arguments)
    };
    ga.q = [];
    ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto');
    ga('set', 'transport', 'beacon');
    ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js " async></script>
<?php
	// Guarda todo el contenido a un archivo
	$fp = fopen($archivoCache, 'w');
	fwrite($fp, ob_get_contents());
	fclose($fp);
	// Enviar al navegador
	ob_end_flush();
?>
</body>

</html>