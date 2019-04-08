<?php

class Humano{

	public $nombre;
	public $edad;

	public function __construct($nombre,$edad)
	{
		$this->nombre = $nombre;
		$this->edad = $edad;
	}

	public function jsonReturn()
	{
		return json_encode($this);
	}

}

?>