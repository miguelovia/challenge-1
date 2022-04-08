<?php
require_once("../ReadFile.php");
require_once("Score.php");
$filename = "scores.txt";
$stream = new ReadFile($filename);
$score = new Score($stream->readfile());


