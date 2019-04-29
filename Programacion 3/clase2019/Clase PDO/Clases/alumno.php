<?php 
include "persona.php";
include "AccesoDatos.php";
class Alumno extends persona
{
	public $legajo;
	public $dni;
	public $nombre;
	public $edad;
	public $idLocalidad;

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

	function _constructArray($arrayParametros)
	{
        if(array_key_exists("nombre",(array)$arrayParametros))
        {
            $this->nombre=$arrayParametros['nombre'];
        }
        if(array_key_exists("dni",(array)$arrayParametros))
        {
            $this->dni=$arrayParametros['dni'];
        }
        if(array_key_exists("edad",(array)$arrayParametros))
        {
            $this->edad=$arrayParametros['edad'];
		}
		if(array_key_exists("legajo",(array)$arrayParametros))
        {
            $this->legajo=$arrayParametros['legajo'];
		}
		if(array_key_exists("idLocalidad",(array)$arrayParametros))
        {
            $this->legajo=$arrayParametros['idLocalidad'];
        }
	}

	function __construct5($nombre,$edad,$dni,$legajo,$idLocalidad)
	{
		self::__construct4($nombre,$edad,$dni,$legajo);
		$this->idLocalidad = $idLocalidad;
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

	
	public static function traerAlumnosArchivo($nombreArchivo)
	{
		$pathfile = "../Archivos/".$nombreArchivo;
        $arrayAlumnos = array();

        if(file_exists($pathfile))
        {
            $extArchivo = explode(".",$nombreArchivo);
            if(strcmp($extArchivo[1],"txt") ==0)
            {
                $resource = fopen($pathfile,"r");
                while(!feof($resource))
                {
                    $datosAlumno = explode(",",fgets($resource));
                    $auxAlumno = new Alumno($datosAlumno[0],$datosAlumno[1],$datosAlumno[2],$datosAlumno[3]);
                    array_push($arrayAlumnos,$auxAlumno);
                }
            }
            else if(strcmp($extArchivo[1],"json") ==0)
            {
                $resource = fopen($pathfile,"r");
                while(!feof($resource))
                {
                    $jsonDatos = json_decode(fgets($resource));
                    if($jsonDatos == NULL){}
                    else
                    {
                        $arrayJson = ((array)$jsonDatos);
                        $auxAlumno = new Alumno($arrayJson["nombre"],$arrayJson["edad"],$arrayJson["dni"],$arrayJson["legajo"]);
                        array_push($arrayAlumnos,$auxAlumno);
                    }
                }
            }
        }
        fclose($resource);
        return $arrayAlumnos;
	}

	public static function mostrarTodosLosAlumnosArchivo($arrayAlumnos)
    {
        foreach($arrayAlumnos as $auxAlumno)
        {
            $auxAlumno->mostrarAlumno();
        }
	}
	
	public static function mostrarAlumnosSql()
	{
		$alumno = new Alumno();
		$resultado = $alumno->TraerAlumnosSql();
		//var_dump($resultado);
		foreach($resultado as $unAlumno)
		{
			$unAlumno->mostrarAlumno();
		}
	}
	

	public static function TraerAlumnosSql()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select nombre,edad, dni, legajo,idLocalidad from alumno");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "alumno");		
	}

	public static function TraerUnAlumno($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select a.nombre,a.edad,a.dni,a.legajo from alumno as a where a.id = $id");
			$consulta->execute();
			$alumnoBuscado= $consulta->fetchObject('alumno');
			return $alumnoBuscado;
	}

	public function InsertarElAlumno() 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into alumno(nombre,edad,dni,legajo,idLocalidad)values('$this->nombre','$this->edad','$this->dni',0,'$this->idLocalidad')");
		$consulta->execute();
		$legajo = (int)$objetoAccesoDato->RetornarUltimoIdInsertado();
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE `alumno` SET `legajo`= $legajo WHERE id = $legajo");
		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}

	public function InsertarElCdParametros() 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into alumno(nombre,edad,dni,legajo,idLocalidad)values(:nombre,:edad,:dni,:legajo,:idLocalidad)");
		$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':edad', $this->edad, PDO::PARAM_INT);
		$consulta->bindValue(':dni', $this->dni, PDO::PARAM_STR);
		$consulta->bindValue(':legajo',0,PDO::PARAM_INT);
		$consulta->bindValue(':idLocalidad',$this->idLocalidad,PDO::PARAM_INT);
		$consulta->execute(); 
		$legajo = (int)$objetoAccesoDato->RetornarUltimoIdInsertado();
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE `alumno` SET `legajo`= $legajo WHERE id = $legajo");
		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}

	public function ModificarAlumnoSql($alumnoModificado) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$legajo = $alumnoModificado->legajo;
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE `alumno` SET `nombre` = $alumnoModificado->nombre, `dni` = $alumnoModificado->dni,`edad` = $alumnoModificado->edad, `idLocalidad` = $alumnoModificado->idLocalidad WHERE id = $alumnoModificado->legajo");
			return $consulta->execute();
	}
}


?>