<?php

    include_once "proveedor.php";
    include_once "pedido.php";

    $dato = $_SERVER['REQUEST_METHOD'];
    if($dato=="POST")
    {
        $caso = $_POST['caso'];
        if(!empty($_POST['caso']))
        {
            if($caso == "cargarProveedor")
            {
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $foto = $_FILES['foto'];
                Proveedor::cargarProveedor($id,$nombre,$email,$foto);
            }
            else if($caso == "hacerPedido")
            {
                $producto = $_POST['producto'];
                $cantidad = $_POST['cantidad'];
                $idProveedor = $_POST['idProveedor'];
                Pedido::crearPedido($producto,$cantidad,$idProveedor);
            }
            else if($caso == "hacerPedidoSql")
            {
                $producto = $_POST['producto'];
                $cantidad = $_POST['cantidad'];
                $idProveedor = $_POST['idProveedor'];
                Pedido::crearPedidoSql($producto,$cantidad,$idProveedor);
            }
            else if($caso == "modificarProveedor")
            {
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $foto = $_FILES['foto'];
                
                Proveedor::modificarProveedor($id,$nombre,$email,$foto);

            }
            else if($caso == "modificarProveedorSql")
            {
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $foto = $_FILES['foto'];
                
                Proveedor::modificarProveedorSql($id,$nombre,$email,$foto);

            }
            else if($caso == "modificarPedidoSql")
            {
                $producto = $_POST['producto'];
                $cantidad = $_POST['cantidad'];
                $idProveedor = $_POST['idProveedor'];
                Pedido::modificarPedidosSql($producto,$cantidad,$idProveedor);
            }
            else if($caso == "cargarProveedorSql")
            {
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $foto = $_FILES['foto'];
                Proveedor::cargarProveedorSql($id,$nombre,$email,$foto);
            }
            

            /*7- (2 pts.) caso: modificarProveedor(post):  Debe poder modificar todos los datos del proveedor menos el id 
            y guardar la foto antigua en la carpeta /backUpFotos , el nombre de la foto será el id y la fecha.  */
        }

    }
    if($dato=="GET")
    {
        $caso = $_GET['caso'];
        if(!empty($_GET['caso']))
        {
            if($caso == "consultarProveedor")
            {
                $nombre = $_GET['nombre'];
                Proveedor::consultarProveedor($nombre);
            }
            else if($caso == "proveedores")
            {
                Proveedor::listarProveedores();
            }
            else if($caso == "listarPedidos")
            {
                Pedido::listarPedidos();
            }
            else if($caso == "listarPedidosSql")
            {
                Pedido::listarPedidosSql();
            }
            else if($caso == "listarPedidosProveedor")
            {
                $idProveedor = $_GET['idProveedor'];
                Pedido::listarPedidosProveedor($idProveedor);
            }
            else if($caso == "listarPedidosProveedorSql")
            {
                $idProveedor = $_GET['idProveedor'];
                Pedido::listarPedidosProveedorSql($idProveedor);
            }
            else if($caso == "fotosBack")
            {
                Proveedor::listarFotosBackUp();
            }
            else if($caso == "proveedoresSql")
            {
                Proveedor::listarProveedoresSql();
            }
            else if($caso == "consultarProveedorSql")
            {
                $nombre = $_GET['nombre'];
                Proveedor::consultarProveedorSql("nombre",$nombre);
            }
        }

    }



?>