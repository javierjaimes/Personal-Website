<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Load::_class("packages_session");
Load::_class("packages_data");

class Api{
    var $resource = false;
    var $session = false;
    var $token = null;

    public function  __construct(){
        if(!$this->resource)
            $this->resource = new Data(HOST, USER, PASSWORD, DATABASE);
       
        if(isset($_POST['token']))
            $this->token = $_POST['token'];

        if(!$this->session)
            $this->session = new Session($this->token);
    
        
    }
}
?>
