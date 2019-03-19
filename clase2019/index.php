<?php 
//echo "<h1>Hola</h1>";
//echo "Primer php";
include "alumno.php";
$nombre = "Tomas";
//$nombre = array("nombre" => "Tomas", "Edad"=> 11);
$array = array();
$array["Nombre"] = $nombre;
$array["Edad"] = 23;

//echo $nombre;
/*var_dump($array); //Inspecciona obj/variables

class miObj
{
	public $apellido;
}

$miObj = new stdClass();
$miObj->nombre = "Pepe";
$miObj->apellido = "PEPEPEPE";
var_dump($miObj);

$miAlumno = new alumno;
$miAlumno->nombre = "JOSUEEE";
$miAlumno->edad = 25;
var_dump($miAlumno);
*/
$alumnoDos = new alumno("Matias",125);
echo $alumnoDos->jsonReturn();
//var_dump($alumnoDos);
?>
