<?php
include_once "proveedor.php";
include_once "AccesoDatos.php";
class Pedido
{
    public $producto;
    public $cantidad;
    public $idProveedor;
    
    public function __construct()
	{
		$parametros = func_get_args(); // Obtengo parametros
		$numParametros = func_num_args(); // Numero de parametros
		$funcionConstruct = "__construct".$numParametros; //Nombre del constructor sobrecargado por nparametros
		if(method_exists($this,$funcionConstruct))
			call_user_func_array(array($this,$funcionConstruct),$parametros);
	}

    function __construct3($producto,$cantidad,$idProveedor)
    {
        $this->producto = $producto;
        $this->cantidad = $cantidad;
        $this->idProveedor = $idProveedor;
    }
    static function crearPedido($producto,$cantidad,$idProveedor)
    {
        if(Proveedor::buscarProveedor("proveedores.txt",$idProveedor)!=NULL)
        {
            $nuevoPedido = new Pedido($producto,$cantidad,$idProveedor);
            $nuevoPedido->hacerPedidoTxt("pedidos.txt");
                echo "Pedido realizado con exito</br>";
        }
        else
        {
            echo "No se encontro proveedor, no se puede realizar pedido</br>";
        }
    }

    static function crearPedidoSql($producto,$cantidad,$idProveedor)
    {
        if(isset($producto)&&isset($cantidad)&&isset($idProveedor))
            if(Proveedor::buscarProveedorSql("id",$idProveedor)!=NULL)
            {    
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
                $auxPedidoSql = new Pedido($producto,$cantidad,$idProveedor);
                $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into pedido(producto,cantidad,idProveedor)values('$auxPedidoSql->producto','$auxPedidoSql->cantidad','$auxPedidoSql->idProveedor')");
                $consulta->execute();
                if($consulta->rowCount()==0)
                    echo "No se pudo crear pedido en Base de datos</br></br>";
                else
                    echo "Pedido cargado con exito en Base de datos</br></br>";
            }
            else
                    echo "No se pudo crear pedido en Base de datos</br></br>";
    }

    public function escribirPedido()
    {
        $datosPedido = $this->producto.",".$this->cantidad.",".$this->idProveedor;
        return $datosPedido;
    }

    public function mostrarPedido()
    {
        $datosPedido = "Producto: " . $this->producto . "</br>" . "Cantidad: " . $this->cantidad . "</br>" . "Id Proveedor: " . $this->idProveedor . "</br>";
        return $datosPedido;
    }

    static function listarPedidos()
    {
        $arrayPedidos = self::traerPedidos("pedidos.txt");
        $arrayProveedores = Proveedor::traerProveedores("proveedores.txt");
        if(!empty($arrayPedidos)&&!empty($arrayProveedores))
        {
            echo "<b>Lista de pedidos:</b> </br></br>";
            foreach($arrayPedidos as $auxPedido)
            {
                $auxProveedor = Proveedor::buscarProveedor("proveedores.txt",$auxPedido->idProveedor);
                if($auxProveedor != NULL)
                {
                    echo $auxPedido->MostrarPedido()."Nombre Proveedor: ".$auxProveedor->nombre."</br></br>";
                }
                    }
        }
        else
            echo "No se pueden mostrar los pedidos</br>";
    }

    static function listarPedidosSql()
    {
        $arrayPedidosSql = self::traerPedidosSql();
        if($arrayPedidosSql!=NULL)
        {
            foreach($arrayPedidosSql as $auxPedidoSql)
            {
                $auxProveedorSql = Proveedor::buscarProveedorSql("id",$auxPedidoSql->idProveedor);
                if($auxProveedorSql!=NULL)
                    echo $auxPedidoSql->mostrarPedido()."Nombre Proveedor: ".$auxProveedorSql->nombre."</br></br>";
            }
        }
    }

    static function listarPedidosProveedor($idProveedor)
    {
        $auxProveedor = Proveedor::buscarProveedor("proveedores.txt",$idProveedor);
        $arrayPedidos = Pedido::traerPedidos("pedidos.txt");
        $encontroPedido = false;
        if($auxProveedor!=NULL)
        {
            foreach($arrayPedidos as $auxPedido)
            {
                if($auxPedido->idProveedor == $auxProveedor->id)
                {
                    if(!$encontroPedido)
                    {
                        echo "<b>Pedidos del proveedor ID $auxProveedor->id ($auxProveedor->nombre): </b></br></br>";
                        $encontroPedido = true;
                    }
                    echo $auxPedido->MostrarPedido()."Nombre Proveedor: ".$auxProveedor->nombre."</br></br>";
                }
            }
        }
        else
            echo "No existe proveedor ID <b>$idProveedor</br></b>";
    }
    static function listarPedidosProveedorSql($idProveedor)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select producto,cantidad,idProveedor from pedido where idProveedor = '$idProveedor'");
        $consulta->execute();
        if($consulta->rowCount()==0)
        {
            echo "No se pudo traer pedidos</br></br>";
        }
        else
        {
            $arrayPedidosProveedor = $consulta->fetchAll(PDO::FETCH_CLASS, "pedido");
            foreach($arrayPedidosProveedor as $auxPedido)
            {
                echo $auxPedido->mostrarPedido();
            }
        }
    }
    public function hacerPedidoTxt($nombreArchivo)
    {
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"a");
            fwrite($arch,"\n".$this->escribirPedido());
            fclose($arch);
        }
        else
        {
            $arch = fopen($nombreArchivo,"w");
            fwrite($arch,$this->escribirPedido());
            fclose($arch);
        }
    }

    static function modificarPedidosSql($producto,$cantidad,$idProveedor)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        if(Proveedor::buscarProveedorSql("id",$idProveedor)!=NULL)
        {
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE `pedido` SET `producto`='$producto',`cantidad`=$cantidad,`idProveedor`=$idProveedor WHERE `producto` = '$producto'");
            $consulta->execute();
            if($consulta->rowCount()==0)
                echo "No se pudo modificar pedido </br></br>";
            else
                echo "Se modifico pedido con exito </br></br>";
        }
        else
            echo "No se pudo modificar pedido </br></br>";

    }
    
    static function traerPedidos($nombreArchivo)
    {
        $arrayPedidos = array();
        if(file_exists($nombreArchivo))
        {
            $arch = fopen($nombreArchivo,"r");
            while(!feof($arch))
            {
                $stringPedido = trim(fgets($arch));
                $arrayPedido = explode(",",$stringPedido);
                $nuevoPedido = new Pedido($arrayPedido[0],$arrayPedido[1],$arrayPedido[2]);
                array_push($arrayPedidos,$nuevoPedido);
            }
            fclose($arch);
        }
        else
        {
            echo "No existe el archivo proveedores.txt"; 
        }
        if(!empty($arrayPedidos))
            return $arrayPedidos;
    }

    static function traerPedidosSql()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select producto,cantidad,idProveedor from pedido");
        $consulta->execute();
        if($consulta->rowCount()==0)
        {
            echo "No se pudo traer Pedidos de Base de datos";
            return NULL;
        }
        else
		    return $consulta->fetchAll(PDO::FETCH_CLASS, "pedido");	
    }


}



?>