<?php
    include_once "vehiculo.php";
class TipoServicio
{
    public $id;
    public $tipo;
    public $precio;
    public $demora;

    public function __construct()
	{
        $parametros = func_get_args(); // Obtengo parametros
		$numParametros = func_num_args(); // Numero de parametros
		$funcionConstruct = "__construct".$numParametros; //Nombre del constructor sobrecargado por nparametros
		if(method_exists($this,$funcionConstruct))
			call_user_func_array(array($this,$funcionConstruct),$parametros);
    }

    public function __construct4($id,$tipo,$precio,$demora)
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->demora = $demora;
    }

    public function escribirTipoServicio()
    {
        $datosTipoServicio = $this->id.",".$this->tipo.",".$this->precio.",".$this->demora;
        return $datosTipoServicio;
    }

    public function mostrarTipoServicio()
    {
        $datosTipoServicio = $this->id."</br>".$this->tipo."</br>".$this->precio."</br>".$this->demora."</br></br>";
        return $datosTipoServicio;
    }

    public function guardarTipoServicioTxt($nombreArchivo)
    {
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"a");
            fwrite($arch,"\n".$this->escribirTipoServicio());
            fclose($arch);
            return true;
        }
        else
        {
            $arch = fopen($nombreArchivo,"w");
            fwrite($arch,$this->escribirTipoServicio());
            fclose($arch);
            return true;
        }
        return false;
    }

    static function traerTipoServicio($nombreArchivo)
    {
        $arrayTipoServicios = array();
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"r");
            while(!feof($arch))
            {
                $strigTipoServicio = trim(fgets($arch));
                $arrayTipoServicio = explode(",",$strigTipoServicio);
                $nuevoTipoServicio = new TipoServicio($arrayTipoServicio[0],$arrayTipoServicio[1],$arrayTipoServicio[2],$arrayTipoServicio[3]);
                array_push($arrayTipoServicios,$nuevoTipoServicio);
            }
            fclose($arch);
            if(!empty($arrayTipoServicios))
                return $arrayTipoServicios;
        }
    }

    static function cargarTipoServicio($id,$tipo,$precio,$demora)
    {
        if(!strcmp($tipo,10000)||!strcmp($tipo,20000)||!strcmp($tipo,50000))
        {
            $auxTipoServicio = new TipoServicio($id,$tipo,$precio,$demora);
            if($auxTipoServicio->guardarTipoServicioTxt("tipoServicio.txt"))
            {
                echo "Se guardo con exito el Tipo de Servicio</br></br>";
            }
            else
            {
                echo "No se puedo guardar el Tipo de Servicio</br></br>";
            }
        }
        else
        {
            echo "El tipo de servicio: $tipo no existe, tipo de servicios disponibles: 10000,20000,50000</br></br>";
        }
    }

    static function sacarTurno($patente,$fecha,$tipoServicio)
    {
        $vehiculoPatente = Vehiculo::validarPatente($patente,true);

        if($vehiculoPatente!=NULL)
        {
            if(TipoServicio::guardarTurnoTxt("turnos.txt",$fecha,$vehiculoPatente,$tipoServicio))
            {
                echo "Se guardo con exito el Turno</br></br>";
            }
            else
            {
                echo "No se puedo guardar el Turno</br></br>";
            }
        }
            else
        {
            echo "No se encontro el vehiculo $patente, registre primero el vehiculo</br></br>";
        }
    }
    
    static function guardarTurnoTxt($nombreArchivo,$fecha,$vehiculoPatente,$tipoServicio)
    {
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"a");
            fwrite($arch,"\n".$fecha.",".$vehiculoPatente->escribirVehiculo(true).",".$tipoServicio);
            fclose($arch);
            return true;
        }
        else
        {
            $arch = fopen($nombreArchivo,"w");
            fwrite($arch,$fecha.",".$vehiculoPatente->escribirVehiculo(true).",".$tipoServicio);
            fclose($arch);
            return true;
        }
        return false;
    }

    static function turnos()
    {
        $turnos = self::traerTurnos("turnos.txt");
        if($turnos!=NULL)
        {
            echo "<table>";
            echo "<tr>";
            echo "<th>DIA</th>";
            echo "<th>MARCA</th>";
            echo "<th>MODELO</th>";
            echo "<th>PATENTE</th>";
            echo "<th>PRECIO</th>";
            echo "<th>TIPO SERVICIO</th>";
            echo "</tr>";
            foreach($turnos as $auxTurno)
            {
                $stringTurno = explode(",",$auxTurno);
                //DIA,MARCA,MODELO,PATENTE,PRECIOAUTO,TIPOSERVICIO
                echo "<tr>";
                echo "<td>".$stringTurno[0]."</td>";
                echo "<td>".$stringTurno[1]."</td>";
                echo "<td>".$stringTurno[2]."</td>";
                echo "<td>".$stringTurno[3]."</td>";
                echo "<td>".$stringTurno[4]."</td>";
                echo "<td>".$stringTurno[5]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else
        {
            echo "No hay turnos cargados</br></br>";
        }
    }

    static function inscripciones($criterio)
    {
        $turnos = self::traerTurnos("turnos.txt");
        if($turnos!=NULL)
        {
            echo "<table>";
            echo "<tr>";
            echo "<th>DIA</th>";
            echo "<th>MARCA</th>";
            echo "<th>MODELO</th>";
            echo "<th>PATENTE</th>";
            echo "<th>PRECIO</th>";
            echo "<th>TIPO SERVICIO</th>";
            echo "</tr>";
            foreach($turnos as $auxTurno)
            {
                $stringTurno = explode(",",$auxTurno);
                if($stringTurno[0] == $criterio || $stringTurno[5] == $criterio)
                {
                    //DIA,MARCA,MODELO,PATENTE,PRECIOAUTO,TIPOSERVICIO
                    echo "<tr>";
                    echo "<td>".$stringTurno[0]."</td>";
                    echo "<td>".$stringTurno[1]."</td>";
                    echo "<td>".$stringTurno[2]."</td>";
                    echo "<td>".$stringTurno[3]."</td>";
                    echo "<td>".$stringTurno[4]."</td>";
                    echo "<td>".$stringTurno[5]."</td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
        }
        else
        {
            echo "No hay turnos cargados</br></br>";
        }
    }


    static function traerTurnos($nombreArchivo)
    {
        $arrayTurnos = array();
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"r");
            while(!feof($arch))
            {
                $strigTurno = trim(fgets($arch));
                array_push($arrayTurnos,$strigTurno);
            }
            fclose($arch);
            if(!empty($arrayTurnos))
                return $arrayTurnos;
        }
    }
}

?>