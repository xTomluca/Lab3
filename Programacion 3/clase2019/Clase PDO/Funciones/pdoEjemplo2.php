<?php 
    include_once "../Clases/alumno.php";
    include_once "../Clases/AccesoDatos.php";
    $id = $_GET['id'];

    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	$consulta =$objetoAccesoDato->RetornarConsulta("select a.nombre,a.edad,a.dni,a.legajo, a.idLocalidad, l.codigoPostal from alumno as a, localidad as l where a.id = $id and a.idLocalidad = l.id");
	$consulta->execute();
    $mostrar = $consulta->fetch(PDO::FETCH_ASSOC);
    var_dump($mostrar);

    //$alumnoAMostrar = Alumno::TraerUnAlumno($id);
    //$alumnoAMostrar->mostrarAlumno();
?>