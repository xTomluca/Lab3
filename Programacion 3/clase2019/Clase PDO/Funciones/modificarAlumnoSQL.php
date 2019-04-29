<?php 
    include_once "../Clases/alumno.php";
    include_once "../Clases/AccesoDatos.php";

    $parametrosLeidos=json_decode(file_get_contents("php://input"), true);
    /*$parametro = ($_POST['nombre'],$_POST['edad'],$_POST['dni'],$_POST['idLocalidad'],$_POST['legajo']);

    foreach($parametro as $auxParametro)
    {
        switch(key($parametro))
        {
            case 'nombre':
                break;
            case 'edad':
                break;
            case 'dni':
                break;
            case '':
                break;
        }
    }*/
    if(isset($parametrosLeidos))
    {
        $alumnoSql = Alumno::TraerUnAlumno($parametrosLeidos['legajo']);
        echo $alumnoSql->MostrarAlumno();
        $alumnoModificado = new Alumno();
        $alumnoModificado->_constructArray($parametrosLeidos);
        echo $alumnoModificado->MostrarAlumno();
        var_dump($alumnoSql->ModificarAlumnoSql($alumnoModificado));        
    }
?>