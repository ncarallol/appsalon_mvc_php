<h1 class="nombre-pagina">Recuperar contraseña</h1>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>
<?php if($error) return;?>
<p class="descripcion-pagina">Coloca tu nuevo password</p>
<form class="formulario" method="POST">
    <div class="campo">
            <label for="password">Nuevo Password</label>
            <input type="password" id="password" name="password" placeholder="Tu password">
    </div>
    
    <input class="campo boton" type="submit" value="Guardar contraseña">
</form>
<div class="acciones">
    <a href="/crear-cuenta">Todavia no tienes una cuenta? Registrarme</a>
    <a href="/olvide">Olvidaste la contraseña?</a>
</div>