<?php include_once __DIR__ . '/../templates/barra.php' ?>
<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Cambia los datos</p>

<form class="formulario" method="POST">
    <?php include_once __DIR__ . '/formulario.php' ?>

    <?php include_once __DIR__ . '/../templates/alertas.php' ?>
        <div class="form">
            <input type="submit" class="boton" value="Actualizar Servicio">
            <a class="boton" href="/servicios">Volver</a>
        </div>
</form>