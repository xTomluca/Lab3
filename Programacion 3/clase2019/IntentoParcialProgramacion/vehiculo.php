<?php

class Vehiculo
{
    public $marca;
    public $modelo;
    public $patente;
    public $precio;
    public $foto;

    public function __construct()
	{
        $parametros = func_get_args(); // Obtengo parametros
		$numParametros = func_num_args(); // Numero de parametros
		$funcionConstruct = "__construct".$numParametros; //Nombre del constructor sobrecargado por nparametros
		if(method_exists($this,$funcionConstruct))
			call_user_func_array(array($this,$funcionConstruct),$parametros);
    }

    public function __construct4($marca,$modelo,$patente,$precio)
    {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->patente = $patente;
        $this->precio = $precio;
        $this->foto = "SIN FOTO";
    }
    public function __construct5($marca,$modelo,$patente,$precio,$foto)
    {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->patente = $patente;
        $this->precio = $precio;
        $this->foto = $foto;
    }

    public function escribirVehiculo($insertarImagen)
    {
        if(!$insertarImagen)
            $datosVehiculo = $this->marca.",".$this->modelo.",".$this->patente.",".$this->precio;
        else
            $datosVehiculo = $this->marca.",".$this->modelo.",".$this->patente.",".$this->precio.",".$this->foto;
        return $datosVehiculo;
    }

    public function mostrarVehiculo()
    {
        $datosVehiculo = $this->marca."</br>".$this->modelo."</br>".$this->patente."</br>".$this->precio."</br></br>";
        return $datosVehiculo;
    }

    static function validarPatente($patente,$devuelveVehiculo)
    {
        $arrayVehiculos = self::traerVehiculos("vehiculos.txt");
        if($arrayVehiculos!=NULL)
        {
            foreach($arrayVehiculos as $vehiculoAux)
            {
                if(!$devuelveVehiculo && !strcasecmp($vehiculoAux->patente,$patente))
                {
                    return true;
                }
                else if($devuelveVehiculo && !strcasecmp($vehiculoAux->patente,$patente))
                {
                    return $vehiculoAux;
                }
            }
        }
        if(!$devuelveVehiculo)
        {
            return false;
        }
        else
        {
            return NULL;
        }

    }

    public function cargarVehiculoTxt($nombreArchivo)
    {
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"a");
            fwrite($arch,"\n".$this->escribirVehiculo(true));
            fclose($arch);
        }
        else
        {
            $arch = fopen($nombreArchivo,"w");
            fwrite($arch,$this->escribirVehiculo(true));
            fclose($arch);
        }
    }

    static function traerVehiculos($nombreArchivo)
    {
        $arrayVehiculos = array();
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"r");
            while(!feof($arch))
            {
                $stringVehiculo = trim(fgets($arch));
                $arrayVehiculo = explode(",",$stringVehiculo);
                $nuevoVehiculo = new Vehiculo($arrayVehiculo[0],$arrayVehiculo[1],$arrayVehiculo[2],$arrayVehiculo[3],$arrayVehiculo[4]);
                array_push($arrayVehiculos,$nuevoVehiculo);
            }
            fclose($arch);
            if(!empty($arrayVehiculos))
                return $arrayVehiculos;
        }
    }

    static function cargarVehiculo($marca,$modelo,$patente,$precio)
    {
        if(!self::validarPatente($patente,false))
        {
            $auxVehiculo = new Vehiculo($marca,$modelo,$patente,$precio);
            $auxVehiculo->cargarVehiculoTxt("vehiculos.txt");
            echo "Vehiculo cargado con exito</br></br>";
        }
        else
        {
            echo "Patente repetida $patente</br></br>";
        }

    }

    static function consultarVehiculos($criterio)
    {
        $arrayVehiculos = self::traerVehiculos("vehiculos.txt");
        $arrayVehiculosEncontrados = array();
        if($arrayVehiculos!=NULL)
        {
            foreach($arrayVehiculos as $auxVehiculo)
            {
                if(!strcasecmp($auxVehiculo->marca,$criterio))
                {
                    array_push($arrayVehiculosEncontrados,$auxVehiculo);
                }
                else if(!strcasecmp($auxVehiculo->modelo,$criterio))
                {
                    array_push($arrayVehiculosEncontrados,$auxVehiculo);
                }
                else if(!strcasecmp($auxVehiculo->patente,$criterio))
                {
                    array_push($arrayVehiculosEncontrados,$auxVehiculo);
                }
            }

            if($arrayVehiculosEncontrados!=NULL)
            {
                foreach($arrayVehiculosEncontrados as $auxVehiculo)
                {
                    echo $auxVehiculo->mostrarVehiculo();
                }
            }
        }
        else
        {
            echo "No hay vehiculos cargados, no existe $criterio</br></br>";
        }
    }
    

    static function subirFoto($patente,$fotoFile)
    {
        $fotoTmp = $fotoFile["tmp_name"];
        $fotoNombre = $fotoFile["name"];            
        $fotoNombreCortado=explode(".",$fotoNombre);

        if(file_exists("./fotos/$patente.$fotoNombreCortado[1]"))
        {
            self::actualizarFoto("$patente.$fotoNombreCortado[1]");
            move_uploaded_file($fotoTmp,"./fotos/$patente.$fotoNombreCortado[1]");
            return "./fotos/$patente.$fotoNombreCortado[1]";
        }
        else
        {
            move_uploaded_file($fotoTmp,"./fotos/$patente.$fotoNombreCortado[1]");
            return "./fotos/$patente.$fotoNombreCortado[1]";
        }
    }
    
    static function actualizarFoto($rutaFoto)
    {
        $dia = getdate();
        $nombreCortado=explode(".",$rutaFoto);
        $oldpath = "./fotos/$rutaFoto";
        $newpath = "./backUpFotos/$nombreCortado[0]" ."-". $dia["mday"]."-". $dia["mon"] . "-" . $dia["year"] . "-" . $dia["hours"] ."-" . $dia["minutes"] ."-" . $dia["seconds"] . "." .$nombreCortado[1];
        rename($oldpath,$newpath);
    }
    
    static function modificarVehiculo($patente,$fotoFile,$marca,$modelo,$precio)
    {
        $arrayVehiculos = self::traerVehiculos("vehiculos.txt");
        if($arrayVehiculos!=NULL)
        {
            if(self::validarPatente($patente,false))
            {
                unlink("vehiculos.txt");
                foreach($arrayVehiculos as $auxVehiculo)
                {
                    if(!strcasecmp($auxVehiculo->patente,$patente))
                    {
                        $foto = self::subirFoto($patente,$fotoFile);
                        $nuevoVehiculo = new Vehiculo($marca,$modelo,$patente,$precio,$foto);
                        $nuevoVehiculo->cargarVehiculoTxt("vehiculos.txt");
                        echo "Vehiculo actualizado con exito</br></br>";
                    }
                    else
                    {
                        $auxVehiculo->cargarVehiculoTxt("vehiculos.txt");
                    }
                }
            }
            else
                echo "No se encontro la patente $patente</br></br>";
        }
        else
            echo "No hay vehiculos cargados</br></br>";
    }

    static function vehiculos()
    {
        $arrayVehiculos = self::traerVehiculos("vehiculos.txt");
        if($arrayVehiculos!=NULL)
        {
            echo "<table>";
            echo "<tr>";
            echo "<th>MARCA</th>";
            echo "<th>MODELO</th>";
            echo "<th>PATENTE</th>";
            echo "<th>PRECIO</th>";
            echo "<th>FOTO</th>";
            echo "</tr>";
            foreach($arrayVehiculos as $auxVehiculo)
            {
                echo "<tr>";
                echo "<td>".$auxVehiculo->marca."</td>";
                echo "<td>".$auxVehiculo->modelo."</td>";
                echo "<td>".$auxVehiculo->patente."</td>";
                echo "<td>".$auxVehiculo->precio."</td>";
                if(!strcmp($auxVehiculo->foto,"SIN FOTO"))
                    echo "<td>".$auxVehiculo->foto."</td>";
                else
                    echo "<td>"."<img src='$auxVehiculo->foto' border='0'>"."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else
        {
            echo "No hay vehiculos cargados</br></br>";
        }
    }
}

?>