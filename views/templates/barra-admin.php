<?php 

    if(isset($_SESSION['admin'])) { ?>
    <div class="barra-servicios">
    <a class="servicios boton" href="/admin">Ver Citas</a>
    <a class="servicios boton" href="/servicios">Ver Servicios</a>
    <a class="servicios boton" href="/servicios/crear">Nuevo Servicio</a>
    </div>


   <?php } ?>   