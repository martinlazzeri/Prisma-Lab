<?php	   
    foreach ($_FILES as $key) 
    {
        $name =$key['name'];

        $path='img/logo/'.$name;
        
		if(move_uploaded_file($key['tmp_name'],$path) === true)
        {   
        	echo "La imagen se subió correctamente.";      
            return;
        }
        else
        {
        	echo "No se pudo mover la imagen.";
        	return FALSE;
        }             
    }  
?>