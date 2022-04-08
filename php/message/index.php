<?php
require_once("../ReadFile.php");
require_once("Message.php");
$filename = "message.txt";
$stream = new ReadFile($filename);
$data = $stream->readfile();
$message = new Message($data);














