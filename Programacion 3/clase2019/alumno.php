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
}



?>