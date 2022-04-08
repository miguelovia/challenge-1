<?php
class Message{
	
	var $ins1;
	var $ins2;
	var $msg;

	function __construct($data){
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

		//Validations
		foreach($limits as $num){
			if(!is_numeric($num)){
				echo "Los datos del tamaño de los mensaje son incorrectos";
				return;
			}
		}

		list($lengthIns1, $lengthIns2,$lengthMsg) = array_map(function($value) {
			return intval($value);
		}, $limits);
		$ins1 = $data[1];
		$ins2 = $data[2];
		$msg = $data[3];
		
		$lengthInsAllowed = range(2,50);
		$lengthMsgAllowed = range(3,500);
		
		if(!in_array(strlen($ins1),$lengthInsAllowed) || !in_array(strlen($ins2),$lengthInsAllowed) || !in_array(strlen($msg),$lengthMsgAllowed)){
			echo "Los valores del tamaño de los mensajes no se encuentran en el rango permitido";
			return;
		}
		
		if($lengthIns1 != strlen($ins1) || $lengthIns2 != strlen($ins2) || $lengthIns2 != strlen($ins2)){
			echo "El tamaño de los mensajes no coincide con los datos de entrada";
			return;
		}

		$this->ins1 = $ins1;
		$this->ins2 = $ins2;
		$this->msg = $msg;
		return true;
	}

	public function findInstruction($msg, $instructions){
		$result = preg_replace('/(.)\1{1}/', '$1', $msg);
		if($msg == $result) return false;
		foreach($instructions as $index => $value){
			if(strpos($result,$value)){
				return $index;
			}
		}
		return $this->findInstruction($result,$instructions);
	}


	public function result(){
		$output = [0 => "SI<br>NO", 1 => "NO<br>SI"];
		$finded = $this->findInstruction($this->msg,[$this->ins1,$this->ins2]);
		if($finded === false) 
			echo "No hay coincidencias";
		else
			echo $output[$finded];
	}

}
