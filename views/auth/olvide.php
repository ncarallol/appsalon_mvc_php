<h1 class="nombre-pagina">Recuperar contraseña</h1>
<p class="descripcion-pagina">Enviar email para recuperar la contraseña</p>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu email" >
    </div>
    <?php include_once __DIR__ . '/../templates/alertas.php'?>
    <input class="campo boton" type="submit" value="Recuperar contraseña">
</form>
    <div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia sesion</a>
    <a href="/crear-cuenta">Todavia no tienes una cuenta? Registrarme</a>
    </div>
