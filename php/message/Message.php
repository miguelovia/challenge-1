<?php
class Message{
	
	var $ins1;
	var $ins2;
	var $msg;
	var $stream; 

	function __construct($stream){
		$this->stream = $stream;
        $data = $this->stream->readfile();
		if($this->parse($data)){
			$this->result();
		}
	}

	public function parse($data){
		if(!count($data)){
            echo "Error al leer datos del archivo"; 
            return;  
        }

		$limits = $data[0];

		$limits = explode(" ",$limits);
		$limits = array_filter($limits,function($value) {
			if(is_numeric($value)) return intval($value);
		});

		//Validations
		if(count($limits) != 3){
			echo "Los valores de los límites de caracteres deben ser 3 y numéricos";
			return; 
		};
	
		
		list($lengthIns1, $lengthIns2,$lengthMsg) = $limits;
		
		$ins1 = $data[1];
		$ins2 = $data[2];
		$msg = $data[3];
		
		$lengthInsAllowed = range(2,50);
		$lengthMsgAllowed = range(3,500);
		
		if(!in_array(strlen($ins1),$lengthInsAllowed) || !in_array(strlen($ins2),$lengthInsAllowed) || !in_array(strlen($msg),$lengthMsgAllowed)){
			echo "Los valores del tamaño de los mensajes no se encuentran en el rango permitido";
			return;
		}
		
		if($lengthIns1 != strlen($ins1)){
			echo "El tamaño de la instrucción 1 es diferente al límite establecido";
			return;
		}

		if($lengthIns2 != strlen($ins2)){
			echo "El tamaño de la instrucción 2 es diferente al límite establecido";
			return;
		}

		if($lengthMsg != strlen($msg)){
			echo "El tamaño del mensaje es diferente al límite establecido";
			return;
		}

		$this->ins1 = $ins1;
		$this->ins2 = $ins2;
		$this->msg = $msg;
		return true;
	}

	public function findInstruction($msg, $instruction,&$results){
		$result = preg_replace('/(.)\1{1}/', '$1', $msg);
		if($msg == $result) return 0;
		array_push($results,$result);
		foreach($results as $index => $value){
			if(strpos($value,$instruction)){
				return 1;
			}
		} 
		return $this->findInstruction($result,$instruction,$results);
	}


	public function result(){
		$outFile = "output.txt";
		$output = [0 => "NO",1 => "SI",];
		$arr1 = [];
		$arry2 = [];
		$finded1 = $this->findInstruction($this->msg,$this->ins1,$arr1);
		$finded2 = $this->findInstruction($this->msg,$this->ins2,$arry2);
		$this->stream->writeFile($outFile,$output[$finded1]."\n".$output[$finded2]);
	}

}
