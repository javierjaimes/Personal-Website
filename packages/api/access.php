<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Access extends Api{
    
    
    public function login(){
        if(!isset($_POST['name']) && !isset($_POST['password']))
            return false;
        
        //echo "SELECT * FROM user WHERE user_name = '{$_POST['name']}' AND user_password = MD5('{$_POST['password']}')";
        $user = $this->resource->get("user", "user_name = '{$_POST['name']}' AND user_password = MD5('{$_POST['password']}')");
        if(!$user)
            return "400";

        $this->token = $this->session->start();
        if(!$this->token)
            return false;
        //print_r($user);
        $this->session->register("user_name",$user['name']);
        $this->session->register("user_id",$user['id']);
        
        return "300";
    }

    public function logout(){
        if(!$this->session->stop())
            return false;        
        //session_unset();
        
        return "300";
    }
}
?>
