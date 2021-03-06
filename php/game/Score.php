<?php

class Score{

    var $player1 = 0;
    var $player2 = 0;    
    var $p1 = [];
    var $p2 = [];
    var $score = [];
    var $sump1 = 0;
    var $sump2 = 0;
    var $stream; 

    function __construct($stream){
        $this->stream = $stream;
        $data = $this->stream->readfile();
        if($this->parse($data) && count($this->score)){
			$this->proccess();
            $this->result();
        }
    }

    public function parse($data){
        if(!count($data)){
            echo "Error al leer datos del archivo"; 
            return;  
        }
        //Get limit
        $limit = array_shift($data);
        if(!is_numeric($limit)){
            echo "El número de rondas no es numérico";
            return;
        }

        $limit = intval($limit);

        if($limit > 10000){
            echo "El número de rondas debe ser menor o igual a 10000";
            return;
        }

        foreach($data as $index=>$ele){
            foreach(explode(" ",$ele) as $sub){
                if(!is_numeric($sub)){
                    echo "Los puntajes de la ronda ".($index+1)." no son correctos";        
                    return;
                }
            }
        }
        //Get scores
        $data = array_chunk($data,1);
        if(count($data) != $limit){
            echo "El número de rondas en el archivo y el límite establecido no coinciden";
            return;
        }
        

        foreach ($data as $key => $ele) {
            array_push($this->score, explode(" ",$ele[0]));    
        }
        
        return true;
    }

    public function proccess(){
        foreach($this->score as $index => $value){
            $this->player1 += intval($value[0]);
            $this->player2 += intval($value[1]);
            $final = abs($this->player1-$this->player2);
            if($this->player1 > $this->player2){
                $this->p1[] = $final;
                $this->sump1 += $final;
            }else{
                if($this->player2 > $this->player1){
                    $this->p2[] = $final;
                    $this->sump2 += $final;
                }
            }	
        }
    }
    
    public function result(){
        $outFile = "output.txt";
        if($this->sump1 > $this->sump2){
            $this->stream->writeFile($outFile,"1 ".max($this->p1));
        }else{
            if($this->sump1 < $this->sump2){
                $this->stream->writeFile($outFile,"2 ".max($this->p2));
            }else {
                echo "Por favor revisa la información ingresada ya que no puede haber empate";
            } 
        }
    }

}