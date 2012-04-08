<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Load::_class("packages_interfaces_methods");
class Publish extends Api implements Methods{
    public function GET(){

    }
    public function POST(){
        $owner = 0;

        if(isset($_POST['token']) && $_POST['token'] == $this->session->token())
            $owner = 1;

        echo $this->session->token();

        $values = array (
            array(0, "NULL"),
            array(1, $_POST['publish_text']),
            array(0, "NOW()"),
            array(0, $_POST['state']),
            array(0, $owner)
        );

        //print_r($values);
        //exit();

        $resource = $this->resource->set("publish",$values);
        if(!$resource)
            return false;

        return "300";
    }
    
    public function  PUT(){

    }
    public function DELETE(){
        if($_POST['token'] != $this->session->token())
            return false;

        $id = substr($_POST['id'],1);
        $delete = $this->resource->delete("publish","publish_id = $id");
        if(!$delete)
            return false;
        
        return "200";
    }
}
?>