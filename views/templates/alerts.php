<?php
    foreach($alertas as $key => $alerta){
        foreach($alerta as $message){
?>
    <div class="alert alert__<?php echo $key; ?>">
        <?php echo $message;?>
    </div>
<?php
        }
    }