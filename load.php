<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of load
 *
 * @author señor pasajero
 */
class Load {
    //put your code here    

    static function _class($classname){
        if(class_exists($classname)){
            return false;
        }
        $classname =  PATH . DIRECTORY_SEPARATOR . str_replace("_", DIRECTORY_SEPARATOR, $classname). ".php";
        if(!self::_require($classname)){
            //echo "ERROR CARGANDO LA CLASE";
            return false;
        }else{
            return true;
        }
    }

    static function _file($filename){
        $filename =  PATH . DIRECTORY_SEPARATOR . str_replace("_", DIRECTORY_SEPARATOR, $filename). ".php";
        if(!self::_require($filename)){
            //echo "ERROR CARGANDO EL ARCHIVO";
            return false;
        }else{
            return true;
        }
    }

    static function _require($file){
        if(file_exists($file)){
            if(require_once($file))
                return  true;
        }else{
            return false;
        }
    }
}
?>
