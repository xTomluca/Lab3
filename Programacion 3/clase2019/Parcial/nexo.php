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
                if(isset($id)&&isset($nombre)&&isset($email)&&isset($foto))
                {
                    $rutaFoto = Proveedor::subirFoto($id,$foto);
                    $proveedor = new Proveedor($id,$nombre,$email,$rutaFoto);
                    $proveedor->cargarProveedor("proveedores.txt");
                }
            }
            else if($caso == "hacerPedido")
            {
                $producto = $_POST['producto'];
                $cantidad = $_POST['cantidad'];
                $idProveedor = $_POST['idProveedor'];
                Pedido::crearPedido($producto,$cantidad,$idProveedor);
            }
            else if($caso == "modificarProveedor")
            {
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $foto = $_FILES['foto'];
                
                Proveedor::modificarProveedor($id,$nombre,$email,$foto);

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
            else if($caso == "listarPedidosProveedor")
            {
                $idProveedor = $_GET['idProveedor'];
                Pedido::listarPedidosProveedor($idProveedor);
            }
            else if($caso == "fotosBack")
            {
                Proveedor::listarFotosBackUp();
            }
        }

    }



?>