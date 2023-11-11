<?php include_once __DIR__ . '/../templates/barra.php' ?>
<h1 class="nombre-pagina">Panel de Administracion</h1>

<div class="busqueda">
    <h2>Buscar citas</h2>
    <form class="formulario">
    <div class="campo">
        <label for="fecha">Fecha</label>
        <input 
        type="date"
        id="fecha"
        name="fecha"
        value="<?php echo $fecha; ?>"
        >
    </div>
    </form>
</div>
<?php 
    if(count($citas) ===0) {
        echo "<h2>No hay citas en esta fecha</h2>";
    }
?>

<div class="panel-citas">
    <ul class="citas">
    <?php
        $idCita = 0;
        
    
    foreach ($citas as $key => $cita) {
        
        
        if($idCita !== $cita->id) {
            $total = 0;
            $idCita = $cita->id
            
    ?>
    <li >
    <p>ID: <span><?php echo $cita->id ?></span></p>
    <P>Hora: <span><?php echo $cita->hora ?></span></P>
    <P>Cliente: <span><?php echo $cita->cliente ?></span></P>
    <P>Email: <span><?php echo $cita->email ?></span></P>
    <P>Telefono: <span><?php echo $cita->telefono ?></span></P>
    </li>
    
    <h2>Servicios</h2>
    

    <?php } //fin del if ?>
    <p class="servicio"><?php echo $cita->servicio . " $" . $cita->precio ?></p>
    <?php 
    $total += $cita->precio;
    $actual = $cita->id;
    $proximo = $citas[$key +1]->id ?? 0;



    if(esUltimo($actual, $proximo)) { ?>
    <p class="precio-total">Precio total:<span> $<?php echo $total; ?></span></p>

        <form method="POST" action="/api/eliminar">
            <input type="hidden" name="id" value="<?php echo $cita->id ?>">
            <input type="submit" value="eliminar" class="boton-eliminar">   
        </form>
    
    <?php } } ?>
    </ul>
</div>

<?php
    $script = "<script src='build/js/buscador.js'></script>"
?>