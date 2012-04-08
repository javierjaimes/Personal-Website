<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Load::_class("packages_api");
class Rest{    
    
    public function request(){
        $match = preg_match("/\//",$_GET['api'],$matches);       

        if($match && !(count($matches[0]) > 1)){
            list($class, $method) = explode("/",preg_replace("/\/$/","",$_GET['api']));
        }else{            
            $class = preg_replace("/\/$/","",$_GET['api']);
            $method = null;
        }
        
        if(is_null($method))
            $method = $_SERVER['REQUEST_METHOD'];
        
        if(!Load::_class($class)){
            Load::_class("packages_api_".$class);
        }
        
        
        $class = new $class();
        if(!method_exists($class, $method))
            //echo "NO EXISTE";
            return false;
        
        return $class->$method();
    }
}
?>
