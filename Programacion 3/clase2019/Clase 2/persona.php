<?php
include "humano.php";

class Persona extends humano
{
	public $dni;
	public function __construct($nombre,$edad,$dni)
	{
		parent::__construct($nombre,$edad);
		$this->dni =$dni;
	}

	public function jsonReturn()
	{
		return json_encode($this);
	}
}

?>