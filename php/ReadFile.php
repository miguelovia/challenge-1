<?php
class ReadFile{
    var $filename; 
    function __construct($argv){
        $this->filename = $argv[1];
    } 

    public function readfile(){
        $result = [];
        try{
            if (!file_exists($this->filename) ) {
                throw new Exception('El archivo no se encuentra.');
            }
                

            $fn = fopen($this->filename,"r");
            if(!$fn)
                throw new Exception("El archivo no se puede abrir.");    

            while(! feof($fn))  {
                $content = fgets($fn);
                if(trim($content) !== "")
                    $result[] = trim($content); 
            }
            fclose($fn);
            return $result;
        }catch(Exception $e){
            printf("%s",$e->getMessage());
            die();
        }
    }

    public function writeFile($filename,$data){
        try{
            $newFile = fopen($filename, "w");
            fwrite($newFile, $data);
        }catch(Exception $e){
            printf("%s","Error al escribir archivo");
        }
    }

}