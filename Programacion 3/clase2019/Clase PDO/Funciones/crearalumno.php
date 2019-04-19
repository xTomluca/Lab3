<?php

require_once '../Clases/alumno.php';
//var_dump($_GET);
//var_dump($_POST);
//var_dump($_REQUEST);

$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$dni = $_POST['dni'];
$legajo = $_POST['legajo'];
$path = $_POST['path'];
$pathjson = $_POST['pathjson'];
$alumnoPost = new alumno($nombre,$edad,$dni,$legajo);

echo $alumnoPost->jsonReturn();
//var_dump($alumnoPost);
$alumnoPost->guardarAlumno($path);
$alumnoPost->guardarAlumnoJson($pathjson);

//------------------------------------------------- FOTOS ----------------------------------////

$filefoto = $_FILES['archivo'];
$filemarca = $_FILES['marca'];


$filetmpname = $filefoto["tmp_name"];
$fotoname = $filefoto["name"];
$filecutname=explode(".",$fotoname);

function crearMarcaDeAgua($foto,$filemarca)
{
    $marca = $filemarca["name"];
    $marcatmp = $filemarca["tmp_name"];
    move_uploaded_file($marcatmp,"./fotos/$marca");
    $margen_dcho = 0;
    $margen_inf = 0;

    $fotoImg=NULL;
    $marcaImg=NULL;
    $fotoCut = explode(".",$foto);
    $marcaCut= explode(".",$marca);
    if(!strcmp($marcaCut[1],"jpg"))
    {
        if(!strcmp($fotoCut[1],"jpg"))
        {
            $marcaImg = imagecreatefromjpeg("./fotos/$marca");
            $fotoImg = imagecreatefromjpeg("./fotos/$foto");
            var_dump($marcaImg);
            $sx = imagesx($marcaImg);
            $sy = imagesy($marcaImg);
            imagecopy($fotoImg, $marcaImg, imagesx($fotoImg) 
            - $sx - $margen_dcho, imagesy($marcaImg) - $sy - $margen_inf, 0, 0, imagesx($marcaImg), imagesy($marcaImg));
            imagejpeg($fotoImg,"./fotos/$foto");
            return true;
        }
        else if(!strcmp($fotoCut[1],"png"))
        {
            $marcaImg = imagecreatefromjpeg("./fotos/$marca");
            $fotoImg = imagecreatefrompng("./fotos/$foto");
            $sx = imagesx($marcaImg);
            $sy = imagesy($marcaImg);
            imagecopy($fotoImg, $marcaImg, imagesx($fotoImg) 
            - $sx - $margen_dcho, imagesy($marcaImg) - $sy - $margen_inf, 0, 0, imagesx($marcaImg), imagesy($marcaImg));
            imagepng($fotoImg,"./fotos/$foto");
            return true;
        }
        else
            return false;
    }
    else if(!strcmp($marcaCut[1],"png"))
    {
        if(!strcmp($fotoCut[1],"png"))
        {
            $fotoImg = imagecreatefrompng("./fotos/$foto");
            $marcaImg = imagecreatefrompng("./fotos/$marca");
            $sx = imagesx($marcaImg);
            $sy = imagesy($marcaImg);
            imagecopy($fotoImg, $marcaImg, imagesx($fotoImg) 
            - $sx - $margen_dcho, imagesy($marcaImg) - $sy - $margen_inf, 0, 0, imagesx($marcaImg), imagesy($marcaImg));
            imagepng($fotoImg,"./fotos/$foto");
            return true;
        }
        else if(!strcmp($fotoCut[1],"jpg"))
        {
            $fotoImg = imagecreatefromjpeg("./fotos/$foto");
            $marcaImg = imagecreatefrompng("./fotos/$marca");
            $sx = imagesx($marcaImg);
            $sy = imagesy($marcaImg);
            imagecopy($fotoImg, $marcaImg, imagesx($fotoImg) 
            - $sx - $margen_dcho, imagesy($marcaImg) - $sy - $margen_inf, 0, 0, imagesx($marcaImg), imagesy($marcaImg));
            imagejpeg($fotoImg,"./fotos/$foto");
            return true;
        }
        else
            return false;
    }
    else
        return false;
}

function actualizarFoto($rutaFoto)
{
    $dia = getdate();
    $filecutname=explode(".",$rutaFoto);
    $oldpath = "./fotos/$rutaFoto";
    $newpath = "./fotosbackup/$filecutname[0]" ."-". $dia["mday"]."-". $dia["mon"] . "-" . $dia["year"] . "." .$filecutname[1];
    rename($oldpath,$newpath);
}

if(file_exists("./fotos/$legajo.jpg"))
{
    actualizarFoto("$legajo.jpg");
    move_uploaded_file($filetmpname,"./fotos/$legajo.jpg");
  
    crearMarcaDeAgua("$legajo.jpg",$filemarca);
}
else if(file_exists("./fotos/$legajo.png"))
{
    echo $legajo;
    actualizarFoto("$legajo.png");
    move_uploaded_file($filetmpname,"./fotos/$legajo.png");
    crearMarcaDeAgua("$legajo.png",$filemarca);
}
else
{
    move_uploaded_file($filetmpname,"./fotos/$legajo.$filecutname[1]");
    crearMarcaDeAgua("$legajo.$filecutname[1]",$filemarca);
}

?>
