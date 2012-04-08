<?php
class Session{
    public function __construct(){
        if(!session_start())
            return false;                

       
       //echo "NADA";
            /*

        echo "yehhh";
        if(session_id($token))
            return true;    */
    }

    public function start(){
        $token = md5(uniqid(rand(),true));

        if(!$this->register("token",$token))
            return false;
        
        return true;
    }

    public function register($key,$value){
        if(!$_SESSION[$key] = $value)
            return false;
        return true;
    }

    public function get($key = null){
        if(is_null($key)){
            return $_SESSION;
        }else{
            return $_SESSION[$key];
        }
    }

    public function token(){
        if(!isset ($_SESSION['token']))
            return false;

        return $_SESSION['token'];
        /*if(!session_id())
            return false;

        //echo "SI";
        return session_id();*/
    }

    public function stop(){
        //session_id("");
        if(!$this->token())
            return false;

        //session_unset();
        session_destroy();
        return true;
    }
}
?>