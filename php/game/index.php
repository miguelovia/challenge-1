<?php
require_once("../ReadFile.php");
require_once("Score.php");
if($argc == 1){
    echo "Debes especificar el nombre del archivo";
    return;
}
$stream = new ReadFile($argv);
$score = new Score($stream);



