<?php 
include "persona.php";
include "AccesoDatos.php";
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

	public function __construct()
	{
		$parametros = func_get_args(); // Obtengo parametros
		$numParametros = func_num_args(); // Numero de parametros
		$funcionConstruct = "__construct".$numParametros; //Nombre del constructor sobrecargado por nparametros
		if(method_exists($this,$funcionConstruct))
			call_user_func_array(array($this,$funcionConstruct),$parametros);

	}

	function __construct4($nombre,$edad,$dni,$legajo)
	{
		$this->nombre = $nombre;
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
		echo "Nombre: " . $this->nombre . "</br>";
		echo "Edad: " . $this->edad . "</br>";
		if(strlen($this->dni)==8)
			echo "Dni: ". substr($this->dni,0,2) .'.'. substr($this->dni,2,3) . '.' . substr($this->dni,5,3) . "</br>";	
		else
		echo "Dni: ". substr($this->dni,0,1) .'.'. substr($this->dni,1,3) . '.' . substr($this->dni,4,3) . "</br>";
		echo "Legajo :" . $this->legajo . "</br>";
		echo "</br>";
	}

	

	public static function TraerTodoLosCds()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select nombre,edad, dni, legajo,idLocalidad from alumno");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "alumno");		
  }
}


?>