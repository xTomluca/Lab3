<?php
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
            else if($caso =="cargarTipoServicio")
            {
            $id = $_POST['id'];
            $tipo = $_POST['tipo'];
            $precio = $_POST['precio'];
            $demora = $_POST['demora'];
            tipoServicio::cargarTipoServicio($id,$tipo,$precio,$demora);
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
                if(isset($_GET['criterio']))
                {
                    $criterio = $_GET['criterio'];
                    Vehiculo::mostrarVehiculosBuscados($criterio);
                }
            }
            else if($caso == "sacarTurno")
            {
                $dia = $_GET['dia'];
                $patente = $_GET['patente'];
                $tipoServicio = $_GET['tipoServicio'];
                Vehiculo::sacarTurno($patente,$dia,$tipoServicio);
            }

        }

    }

    
?>