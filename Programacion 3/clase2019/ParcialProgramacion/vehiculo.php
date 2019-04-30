<?php

class Vehiculo
{
    public $marca;
    public $modelo;
    public $patente;
    public $precio;

    public function __construct()
	{
		$parametros = func_get_args(); // Obtengo parametros
		$numParametros = func_num_args(); // Numero de parametros
		$funcionConstruct = "__construct".$numParametros; //Nombre del constructor sobrecargado por n parametros
		if(method_exists($this,$funcionConstruct))
			call_user_func_array(array($this,$funcionConstruct),$parametros);
    }
    
    function __construct4($marca,$modelo,$patente,$precio)
    {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->patente  = $patente;
        $this->precio = $precio;
    }

    static function cargarVehiculo($marca,$modelo,$patente,$precio)
    {
        if(self::buscarPorCriterio($patente,false)!=true)
        {
            if(isset($marca)&&isset($modelo)&&isset($patente)&&isset($precio))
            {
                $vehiculoAux = new Vehiculo($marca,$modelo,$patente,$precio);
                $vehiculoAux->guardarVehiculoTxt("vehiculos.txt");
            }
        }
        else
        {
            echo "Patente repetida</br></br>";
        }
    }

    static function buscarPorCriterio($dato,$crearArray)
    {
        $arrayVehiculos = self::traerVehiculosTxt("vehiculos.txt");
        $arrayBuscados = array();
        $encontreAuto = false;
        if($arrayVehiculos!=NULL)
        {
            foreach($arrayVehiculos as $vehiculo)
            {
                if(!strcasecmp($vehiculo->patente,$dato)&&$crearArray == false)
                {
                    return true;
                }
                if(!strcasecmp($vehiculo->patente,$dato)&& $crearArray == true)
                {
                    return $vehiculo;
                }
                if(!strcasecmp($vehiculo->modelo,$dato) && $crearArray == true)
                {
                    array_push($arrayBuscados,$vehiculo);
                    $encontreAuto=true;
                }
                if(!strcasecmp($vehiculo->marca,$dato)&& $crearArray == true)
                {
                    array_push($arrayBuscados,$vehiculo);
                    $encontreAuto=true;
                }
            }
        }
        if($encontreAuto==true)
            if(count($arrayBuscados)>1)
                return $arrayBuscados;
            else
                return $arrayBuscados[0];
        return NULL;
    }

    static function mostrarVehiculosBuscados($dato)
    {
        $arrayBuscados = self::buscarPorCriterio($dato,true);
        if(count($arrayBuscados)>1)
        {
            foreach($arrayBuscados as $auxVehiculo)
            {
                echo $auxVehiculo->mostrarVehiculo();
            }
        }
        else if(count($arrayBuscados)==1)
            echo $arrayBuscados->mostrarVehiculo();
        else
            echo "No existe $dato</br></br>";
    }

    public function mostrarVehiculo()
    {
        $datosVehiculo = $this->marca."</br>".$this->modelo."</br>".$this->patente."</br>".$this->precio."</br></br>";
        return $datosVehiculo;
    }

    public function escribirVehiculo()
    {
        $datosVehiculo = $this->marca.",".$this->modelo.",".$this->patente.",".$this->precio;
        return $datosVehiculo;
    }
    public function guardarVehiculoTxt($nombreArchivo)
    {
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"a");
            fwrite($arch,"\n".$this->escribirVehiculo());
            fclose($arch);
            echo "Alta vehiculo con exito</br></br>";
        }
        else
        {
            $arch = fopen($nombreArchivo,"w");
            fwrite($arch,$this->escribirVehiculo());
            fclose($arch);
            echo "Alta vehiculo con exito</br></br>";
        }
    }

    static function traerVehiculosTxt($nombreArchivo)
    {
        $vehiculos = array();
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"r");
            while(!feof($arch))
            {
                $stringVehiculo = trim(fgets($arch));
                $arrayVehiculo = explode(",",$stringVehiculo);
                $nuevoVehiculo = new Vehiculo($arrayVehiculo[0],$arrayVehiculo[1],$arrayVehiculo[2],$arrayVehiculo[3]);
                array_push($vehiculos,$nuevoVehiculo);
            }
            fclose($arch);
        }
        else
        {
            echo "No existe el archivo $nombreArchivo"; 
        }
        if(!empty($vehiculos))
            return $vehiculos;
        return NULL;
    }
    /*4- (2pts.) caso: sacarTurno (get): Se recibe patente y fecha (día) 
    y se debe guardar en el archivo turnos.txt, fecha,
    patente, marca, modelo, precio y tipo de servicio. 
    Si no hay cupo o la materia no existe informar cada caso
    particular.*/

    static function sacarTurno($patente,$dia,$servicio)
    {
        if(!strcasecmp("10000",$servicio)||!strcasecmp("20000",$servicio)||!strcasecmp("50000",$servicio))
        {
            $vehiculo = self::buscarPorCriterio($patente,true);
            if($vehiculo!=NULL)
            {
                $vehiculo->guardarTurnoTxt("sacarTurno.txt",$dia,$servicio);
            }
        }
        else
            echo "tipo de servicio incorrecto</br></br>";
    }

    public function guardarTurnoTxt($nombreArchivo,$dia,$servicio)
    {
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"a");
            fwrite($arch,"\n".$dia.",".$this->patente.",".$this->marca.",".$this->modelo.",".$this->precio.",".$this->modelo.",".$servicio);
            fclose($arch);
            echo "Alta servicio con exito</br></br>";
        }
        else
        {
            $arch = fopen($nombreArchivo,"w");
            fwrite($arch,$dia.",".$this->patente.",".$this->marca.",".$this->modelo.",".$this->precio.",".$this->modelo.",".$servicio);
            fclose($arch);
            echo "Alta servicio con exito</br></br>";
        }
    }
}