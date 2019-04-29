<?php
class Proveedor
{
    public $id;
    public $nombre;
    public $email;
    public $foto;

    function __construct($id,$nombre,$email,$foto)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email  = $email;
        $this->foto = $foto;

    }

    public function MostrarProveedor()
    {
        $datosProveedor = "id Proveedor: " . $this->id . "</br>" . "Nombre: " . $this->nombre . "</br>" . "Email: " . $this->email . "</br>" . "Foto: </br>" ."<img src='$this->foto' border='0'>" . "</br>";
        return $datosProveedor;
    }

    static function listarProveedores()
    {
        $mostrarProveedores = Proveedor::traerProveedores("proveedores.txt");
                
        foreach($mostrarProveedores as $auxProveedor)
        {
            echo $auxProveedor->MostrarProveedor() . "</br>";
        }
    }

    static function consultarProveedor($nombre)
    {
        $proveedor = Proveedor::buscarProveedor("proveedores.txt",$nombre);
        if($proveedor != NULL)
        {
            echo $proveedor->MostrarProveedor();
        }
        else
        {
            echo "No se encontro proveedor ".$nombre."</br>"; 
        }
    }

    public function escribirProveedor()
    {
        $datosProveedor = $this->id.",".$this->nombre.",".$this->email.",".$this->foto;
        return $datosProveedor;
    }

    public function cargarProveedor($nombreArchivo)
    {
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"a");
            fwrite($arch,"\n".$this->escribirProveedor());
            fclose($arch);
        }
        else
        {
            $arch = fopen($nombreArchivo,"w");
            fwrite($arch,$this->escribirProveedor());
            fclose($arch);
        }
    }

    static function buscarProveedor($nombreArchivo,$datoProveedor)
    {
        $arrayProveedores = self::traerProveedores($nombreArchivo);
                    
        foreach($arrayProveedores as $auxProveedor)
        {
                
            if(strcasecmp($auxProveedor->nombre,$datoProveedor)==0)
            {
                return $auxProveedor;
            }
            else if($auxProveedor->id == $datoProveedor)
            {
                return $auxProveedor;
            }
        }
        return NULL;        
    }

    static function modificarProveedor($id,$nombre,$email,$foto)
    {
        $arrayProveedores = Proveedor::traerProveedores("proveedores.txt");
        $nuevoArrayProveedores = array();
        if(isset($nombre)&&isset($email)&&isset($foto)&&isset($id))
        {
            $proveedorExiste = Proveedor::buscarProveedor("proveedores.txt",$id);
            if($proveedorExiste!=NULL)
            {
                foreach($arrayProveedores as $auxProveedor)
                {
                    if($auxProveedor->id == $id)
                    {
                        $rutaFoto = Proveedor::subirFoto($id,$foto);
                        $proveedor = new Proveedor($id,$nombre,$email,$rutaFoto);
                        array_push($nuevoArrayProveedores,$proveedor);
                        echo "Se modifico usuario satisfactoriamente</br>";
                    }
                    else
                    {
                        array_push($nuevoArrayProveedores,$auxProveedor);
                    }
                }
                unlink("proveedores.txt");
                foreach($nuevoArrayProveedores as $auxProveedor)
                {
                    $auxProveedor->cargarProveedor("proveedores.txt");
                }
            }
            else
                echo "No existe el proveedor con el ID: $id</br></br>";
        }
    }

    static function subirFoto($idProveedor,$fotoFile)
    {
        $fotoTmp = $fotoFile["tmp_name"];
        $fotoNombre = $fotoFile["name"];            
        $fotoNombreCortado=explode(".",$fotoNombre);
        
        if(file_exists("./fotos/$idProveedor.$fotoNombreCortado[1]"))
        {
            $auxProveedor = self::buscarProveedor("proveedores.txt",$idProveedor);
            $auxProveedor->actualizarFoto("$idProveedor.$fotoNombreCortado[1]");
            move_uploaded_file($fotoTmp,"./fotos/$idProveedor.$fotoNombreCortado[1]");
            return "./fotos/$idProveedor.$fotoNombreCortado[1]";
        }
        else
        {
            move_uploaded_file($fotoTmp,"./fotos/$idProveedor.$fotoNombreCortado[1]");
            return "./fotos/$idProveedor.$fotoNombreCortado[1]";
        }
    }
    
    public function actualizarFoto($rutaFoto)
    {
        $dia = getdate();
        $nombreCortado=explode(".",$rutaFoto);
        $oldpath = "./fotos/$rutaFoto";
        $newpath = "./fotosbackup/$nombreCortado[0]" ."-". $dia["mday"]."-". $dia["mon"] . "-" . $dia["year"] . "-" . $dia["hours"] ."-" . $dia["minutes"] ."-" . $dia["seconds"] . "." .$nombreCortado[1];
        rename($oldpath,$newpath);
    }

    static function traerProveedores($nombreArchivo)
    {
        $arrayProveedores = array();
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"r");
            while(!feof($arch))
            {
                $stringProveedor = trim(fgets($arch));
                $arrayProveedor = explode(",",$stringProveedor);
                $nuevoProveedor = new Proveedor($arrayProveedor[0],$arrayProveedor[1],$arrayProveedor[2],$arrayProveedor[3]);
                array_push($arrayProveedores,$nuevoProveedor);
            }
            fclose($arch);
        }
        else
        {
            echo "No existe el archivo $nombreArchivo"; 
        }
        if(!empty($arrayProveedores))
            return $arrayProveedores;
    }

    static function listarFotosBackUp()
    {
        $directorio = opendir("./fotosbackup");
        while ($archivo = readdir($directorio))
        {
            if (!is_dir($archivo))
            {
                $arrayNombreArchivo = explode("-",$archivo);
                echo "</br>";
                if(count($arrayNombreArchivo)==7)
                {
                    echo "<img src='./fotosbackup/$archivo' border='0'></br></br>";
                    $arraySegundosExt = explode(".",$arrayNombreArchivo[6]);
                    $fechaCreacion = "Fecha de creacion: ".$arrayNombreArchivo[1]."/".$arrayNombreArchivo[2]."/".$arrayNombreArchivo[3];
                    $horaCreacion = "Hora de creacion: ".$arrayNombreArchivo[4].":".$arrayNombreArchivo[5].":".$arraySegundosExt[0];
                    $proveedor = self::buscarProveedor("proveedores.txt",$arrayNombreArchivo[0]);
                    echo $fechaCreacion."</br>".$horaCreacion."</br>"."Nombre del proveedor: ".$proveedor->nombre;
                }
            }
        }
    }

    /*static function validarIdProveedor($idProveedor,$nombreArchivo)
    {
        $arrayProveedores = self::traerProveedores($nombreArchivo);
        foreach($arrayProveedores as $auxProveedor)
        {
            if($auxProveedor->id == $idProveedor)
                return true;
        }
        return false;
    }*/

   /* function cargarProveedor($id,$nombre,$email,$foto,$nombreArchivo)
    {
        $proveedor = new Proveedor($nombre,$edad,$dni,$legajo);
        $proveedor->guardar_proveedor($nombreArchivo);        
        echo "Proveedor agregado exito";
    }*/

    
}

?>