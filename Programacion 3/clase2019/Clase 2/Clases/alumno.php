<?php 
include "persona.php";
class Alumno extends persona
{
	public $legajo;
	public $dni;
	public $nombre;
	public $edad;

	/*public function __construct($nombre,$edad,$dni,$legajo)
	{
		parent::__construct($nombre,$edad,$dni);
		$this->legajo = $legajo;
	}*/

	public function __construct($nombre,$edad,$dni,$legajo)
	{
		$this->legajo = $legajo;
		$this->edad = $edad;
		$this->dni = $dni;
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
			fwrite($arch,"\r\n".$this->nombre .",". $this->edad.",". $this->dni.",". $this->legajo);
			fclose($arch);
		}
		else
		{
			$arch = fopen($pathfile,"w");
			fwrite($arch,$this->nombre .",". $this->edad.",". $this->dni.",". $this->legajo);
			fclose($arch);
		}
	}
	public function guardarAlumnoJson($pathfile)
	{
		if(file_exists($pathfile))
		{
			$arch = fopen($pathfile,"a");
			fwrite($arch,$this->jsonReturn()."\r\n");
			fclose($arch);
		}
		else
		{
			$arch = fopen($pathfile,"w");
			fwrite($arch,$this->jsonReturn()."\r\n");
			fclose($arch);
		}
	}
	public function mostrarAlumno()
	{
		echo "Nombre:" . $this->nombre;
		echo "Edad:" . $this->edad;
		echo "Dni:" . $this->dni;
		echo "Legajo:" . $this->legajo;
	}
}



?>