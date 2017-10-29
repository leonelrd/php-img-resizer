<?php

    $name_imagen = $_FILES['imagen']['name'];
    $tmp_imagen = $_FILES['imagen']['tmp_name'];

    //Comprobamos si los campos estan vacios.

    if($name_imagen == "" or $tmp_imagen == ""){

        echo "Debe elegir la imagen.";
        echo "<br><a href='img-form.html'>Regresar</a>";

    }else{
        //Establecemos el ancho fijo que tendran las miniaturas.
        $ancho = 1080;

        //obtenemos informacion acerca de la imagen para conocer su extension. 
        $info = pathinfo($name_imagen);
        $size = getimagesize($tmp_imagen);

        $width = $size[0]; //Ancho de la imagen.
        $height = $size[1]; //Alto de la imagen. 

        //Comprobar el ancho, para ver si supera los 120
        if($width > $ancho){

            $alto = intval($height * $ancho / $width);// Alto de la imagen nueva.
            
            //Comprobamos si la imagen es JPG. 
            if($info['extension'] == 'jpg'){
                $imagen_original = imagecreatefromjpeg($tmp_imagen);
                $imagen_nueva = imagecreatetruecolor($ancho,$alto);// Nueva imagen. 

                imagecopyresized($imagen_nueva, $imagen_original,0,0,0,0,$ancho,$alto,$width,$height);

                $original = "imagenes/$name_imagen";
                $copia = "imagenes/resize/resize_$name_imagen";
                
                copy($tmp_imagen, $original);// imagen.jpg
                imagejpeg($imagen_nueva, $copia);// resize_imagen.jpg

                echo "La imagen nueva se ha generado.";
                echo "<br><a href='img-form.html'>Regresar</a>";
            }
        }else{
            echo"La imagen debe tener un ancho mayor que 1080.";
            echo "<br><a href='img-form.html'>Regresar</a>";
        }
    }

?>