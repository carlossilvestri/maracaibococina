<footer class="site-footer ">
    <div class="contenedor clearfix ">
        <div class="footer-informacion ">
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
            <nav class="redes-sociales ">
                <a target="_blank" href="https://www.facebook.com/profile.php?id=100004958981799"><i class="fab fa-facebook-f "></i></a>
                <a target="_blank" href="https://twitter.com/Silvestri_C" class="twitter "><i class="fab fa-twitter "></i></a>
                <a href="# "><i class="fab fa-pinterest-p "></i></a>
                <a href="# "><i class="fab fa-youtube "></i></a>
                <a target="_blank" href="https://www.instagram.com/carlossilvestri/?hl=es-la "><i class="fab fa-instagram "></i></a>
            </nav>
        </div>
    </div>
    <p class="copyright ">Todos los Derechos Reservados - Carlos Silvestri.</p>
</footer>



<script src="https://kit.fontawesome.com/a602e044b9.js "></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="js/vendor/modernizr-3.7.1.min.js "></script>
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js " integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=" "></script>
<!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js " integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin=" anonymous "></script> -->
<script>
    window.jQuery || document.write('<script src="js/vendor/jquery-3.4.1.min.js"><\/script>')
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js" integrity="sha256-Ikk5myJowmDQaYVCUD0Wr+vIDkN8hGI58SGWdE671A8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lettering.js/0.7.0/jquery.lettering.min.js" integrity="sha256-7sov0P4cWkfKMVHQ/NvnWVqcLSPYrPwxdz+MtZ+ahl8=" crossorigin="anonymous"></script>
<script src="js/indexjs.js "></script>
<script src="js/main.js"></script>

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