<?php
class Upload{		
	
	
	function load($file,$dir){
		$tamaño = $file['size'];
		$tipo = $file['type'];
		$nombre = $file['name'];

        $nombre = substr(md5(uniqid(rand(),true)),0,16) . "_" . $nombre;

		if(move_uploaded_file($file['tmp_name'],$dir."/". $nombre)){
			return $nombre;
		}else{
			return false;
		}
	}
	
        function load_and_resize($file, $dir, $tamaño = 65){
	        //echo $dir;
			$nombre = $this->load($file, $dir);
                if(!$nombre)
                    return false;
                   
            if(!$this->resize($dir . "/" .$nombre, $tamaño))
            	return false;

            	
            return $nombre;
	}
	
	function resize($file, $tamaño = 128, $altura = null, $copy = 0){			
		$file = pathinfo($file);
		$dirfile = $file['dirname'];		
		$basename = $file['basename'];
		$pathfile = $dirfile."/". $basename; 
		
		list($ancho, $alto, $tipo) = getimagesize($pathfile);
		$thancho = $tamaño;
				
		if(is_null($altura)){
			$thalto = $alto * $tamaño / $ancho;
		}else{
			$thalto = $altura;
		}
		
		$th = imagecreatetruecolor($thancho,$thalto);		
		
		if($tipo == 1){
			$thimagen = imagecreatefromgif($pathfile);
			imagecopyresampled($th,$thimagen,0,0,0,0,$thancho,$thalto,$ancho,$alto);
			if($copy){
				imagegif($th,$dirfile."/".$tamaño."_".$basename);								
			}else{
				imagegif($th,$dirfile."/".$basename);
			}
			return true;
		}elseif($tipo == 2){
			$thimagen = imagecreatefromjpeg($pathfile);
			imagecopyresampled($th,$thimagen,0,0,0,0,$thancho,$thalto,$ancho,$alto);
			if($copy){
				imagejpeg($th,$dirfile."/".$tamaño."_".$basename);
			}else{
				imagejpeg($th,$dirfile."/".$basename);	
			}
			return true;
		}elseif($tipo == 3){
			$thimagen = imagecreatefrompng($pathfile);	
			imagecopyresampled($th,$thimagen,0,0,0,0,$thancho,$thalto,$ancho,$alto);
			if($copy){
				imagepng($th,$dirfile."/".$tamaño."_".$basename);
			}else{
				imagepng($th,$dirfile."/".$basename);
			}
			return true;
		}
	}
}
?>