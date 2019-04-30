<?php

class tipoServicio
{
    public $id;
    public $tipo;
    public $precio;
    public $demora;

    public function __construct()
	{
		$parametros = func_get_args(); // Obtengo parametros
		$numParametros = func_num_args(); // Numero de parametros
		$funcionConstruct = "__construct".$numParametros; //Nombre del constructor sobrecargado por n parametros
		if(method_exists($this,$funcionConstruct))
			call_user_func_array(array($this,$funcionConstruct),$parametros);
    }
    
    function __construct4($id,$tipo,$precio,$demora)
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->precio  = $precio;
        $this->demora = $demora;
    }

    //3- (1 pts.) caso: cargarTipoServicio(post): 
    //Se recibe el nombre del servicio a realizar: id, tipo(de los 10.000km,
    //20.000km, 50.000km), precio y demora, y se guardara en el archivo tiposServicio.txt.
    static function cargarTipoServicio($id,$tipo,$precio,$demora)
    {
        
            if(isset($id)&&isset($tipo)&&isset($precio)&&isset($demora))
            {
                if(!strcasecmp("10000",$tipo)||!strcasecmp("20000",$tipo)||!strcasecmp("50000",$tipo))
                {
                    $auxServicio = new tipoServicio($id,$tipo,$precio,$demora);
                    
                    $auxServicio->guardarServicioTxt("tiposServicio.txt");
                }
                else
                    echo "Tipo de servicio incorrecto</br></br>";
            }
    }
    public function guardarServicioTxt($nombreArchivo)
    {
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"a");
            fwrite($arch,"\n".$this->id.",".$this->tipo.",".$this->precio.",".$this->demora);
            fclose($arch);
            echo "Alta servicio con exito</br></br>";
        }
        else
        {
            $arch = fopen($nombreArchivo,"w");
            fwrite($arch,$this->id.",".$this->tipo.",".$this->precio.",".$this->demora);
            fclose($arch);
            echo "Alta servicio con exito</br></br>";
        }
    }

    static function traerTipoServicioTxt($nombreArchivo)
    {
        $arrayServicios = array();
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"r");
            while(!feof($arch))
            {
                $stringServicio = trim(fgets($arch));
                $arrayServicio = explode(",",$stringServicio);
                $nuevoServicio = new tipoServicio($arrayServicio[0],$arrayServicio[1],$arrayServicio[2],$arrayServicio[3]);
                array_push($arrayServicios,$nuevoServicio);
            }
            fclose($arch);
        }
        else
        {
            echo "No existe el archivo $nombreArchivo"; 
        }
        if(!empty($arrayServicios))
            return $arrayServicios;
        return NULL;
    }
}
    ?>