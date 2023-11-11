
<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<div class="acciones">
<?php if($exito ===1) :?>
<a class="boton" href="/">Iniciar Sesion</a>
<?php endif?>
<?php if(!$exito) :?>
    <a class="boton" href="/olvide">Recuperar Contraseña</a>
<?php endif?>

    
</div>
