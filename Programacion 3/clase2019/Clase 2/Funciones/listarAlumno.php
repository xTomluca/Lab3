<?php
    $pathfile = "elarchivo.txt";
    if(file_exists($pathfile))
		{
            $resource = fopen($pathfile,"r");
            while(!feof($resource))
            {
                echo fgets($resource);
            }
                
			fclose($resource);
		} 
?>