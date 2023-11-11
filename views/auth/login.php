<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>


    <form  class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu email" >
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu password" >
    </div>
    <?php include_once __DIR__ . '/../templates/alertas.php'?>
    <input class="campo boton" type="submit" value="Iniciar Sesion">
    </form>
    <div class="acciones">
    <a href="/crear-cuenta">Todavia no tienes una cuenta? Registrarme</a>
    <a href="/olvide">Olvidaste la contraseña?</a>
    </div>

