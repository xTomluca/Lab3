<?php 
include "persona.php";
class Alumno extends persona
{
	public $legajo;
	public function __construct($nombre,$edad,$dni,$legajo)
	{
		parent::__construct($nombre,$edad,$dni);
		$this->legajo = $legajo;
	}

	public function jsonReturn()
	{
		return json_encode($this);
	}

	public function guardarAlumno($pathfile)
	{
		if(file_exists($pathfile))
		{
			$arch = fopen($pathfile,"a");
			fwrite($arch,$this);
			fclose($arch);
		}
		else
		{
			$arch = fopen($pathfile,"w");
			fwrite($arch,$this);
			fclose($arch);
		}
	}
	
}



?>