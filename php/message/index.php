<?php
require_once("../ReadFile.php");
require_once("Message.php");
if($argc == 1){
    echo "Debes especificar el nombre del archivo";
    return;
}
$stream = new ReadFile($argv);
$message = new Message($stream);














