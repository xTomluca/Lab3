<?php

    //include_once "proveedor.php";
    include_once "vehiculo.php";
    include_once "tipoServicio.php";

    $dato = $_SERVER['REQUEST_METHOD'];
    if($dato=="POST")
    {
        $caso = $_POST['caso'];
        if(!empty($_POST['caso']))
        {
            if($caso == "cargarVehiculo")
            {
                $marca = $_POST['marca'];
                $modelo = $_POST['modelo'];
                $patente = $_POST['patente'];
                $precio = $_POST['precio'];
                Vehiculo::cargarVehiculo($marca,$modelo,$patente,$precio);
            }
            else if($caso == "cargarTipoServicio")
            {
                $id = $_POST['id'];
                $tipo = $_POST['tipo'];
                $precio = $_POST['precio'];
                $demora = $_POST['demora'];
                TipoServicio::cargarTipoServicio($id,$tipo,$precio,$demora);
            }
            else if($caso == "modificarVehiculo")
            {
                $marca = $_POST['marca'];
                $modelo = $_POST['modelo'];
                $patente = $_POST['patente'];
                $precio = $_POST['precio'];
                $foto = $_FILES['foto'];
                Vehiculo::modificarVehiculo($patente,$foto,$marca,$modelo,$precio);
            }
        }
    }
    else if($dato=="GET")
    {
        $caso = $_GET['caso'];
        if(!empty($_GET['caso']))
        {
            if($caso == "consultarVehiculo")
            {
                $criterio = $_GET['criterio'];
                Vehiculo::consultarVehiculos($criterio);
            }
            else if($caso == "sacarTurno")
            {
                $patente = $_GET['patente'];
                $fecha = $_GET['fecha'];
                $tipoServicio = $_GET['tipoServicio'];
                TipoServicio::sacarTurno($patente,$fecha,$tipoServicio);
            }
            else if($caso == "turnos")
            {
                TipoServicio::turnos();
            }
            else if($caso == "inscripciones")
            {
                $criterio = $_GET['criterio'];
                TipoServicio::inscripciones($criterio);
            }
            else if($caso == "vehiculos")
            {
                Vehiculo::vehiculos();
            }
        }
    }
?>
