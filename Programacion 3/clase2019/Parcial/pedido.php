<?php
include_once "proveedor.php";

class Pedido
{
    public $producto;
    public $cantidad;
    public $idProveedor;
    
    function __construct($producto,$cantidad,$idProveedor)
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
        $arrayPedidos = Pedido::traerPedidos("pedidos.txt");
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


}



?>