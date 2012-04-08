<?php
require("load.php");

define("PATH",dirname(__FILE__));
define("URL","http://".$_SERVER['HTTP_HOST']. dirname($_SERVER['PHP_SELF']));

define("HOST","127.0.0.1");
define("USER","root");
define("PASSWORD","1200");
define("DATABASE","user");
//echo URL;
//echo PATH;



//si es una petición api
if(isset($_GET['api'])){
    Load::_class("rest");
    $api = new Rest();
    $response = $api->request();
    
    if(!$response)
        return false;
        //header("HTTP/1.1 404 Not Found");
        //header("Status: 404 Not Found");


    if(is_numeric($response))
        switch ($response) {
            case 300:
                //echo $_SERVER['HTTP_REFERER'] ."   JAVIIERER";
                header("location: {$_SERVER['HTTP_REFERER']}");
                break;

            case 200:
                echo $response;
                break;

            case 400:
                header("location: {$_SERVER['HTTP_REFERER']}?login_error=1");
                break;            
            default :
                echo "ERROR ";
                break;
        }

    if(is_string($response))
        echo $response;
    
    return false;
}
//si es una petición web
Load::_class("user");
$user = new User();
if($user->ready)        
   	if(Load::_file("skin_index"))
    	return true;    


Load::_file("install");
?>