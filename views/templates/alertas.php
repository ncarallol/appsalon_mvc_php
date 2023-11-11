<div class="alertas">
<?php 
    foreach ($alertas as $key => $alerta) :
        foreach ($alerta as $mensaje):

    ?>
    
    <div class="<?php echo $key; ?> alerta"><?php echo $mensaje?>
    </div>
    
    <?php
            endforeach;
        endforeach;
    ?> 
</div>