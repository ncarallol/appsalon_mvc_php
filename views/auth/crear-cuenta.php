<h1 class="nombre-pagina">Crear una cuenta</h1>
<p class="descripcion-pagina">Completa con tus datos</p>


<form  class="formulario" method="POST">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="nombre" id="nombre" name="nombre" placeholder="Tu nombre" value="<?php echo s($usuario->nombre) ?>">
    </div>
    <div class="campo"> 
        <label for="apellido">Apellido</label>
        <input type="apellido" id="apellido" name="apellido" placeholder="Tu apellido" value="<?php echo s($usuario->apellido) ?>">
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu email" value="<?php echo s($usuario->email) ?>">
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="telefono" id="telefono" name="telefono" placeholder="Tu telefono" value="<?php echo s($usuario->telefono) ?>">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu password" >
    </div>
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>
    <input class="campo boton" type="submit" value="Crear cuenta">
    </form>
    <div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia sesion</a>
    <a href="/olvide">Olvidaste la contraseña?</a>
    </div>

