<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Load::_class("packages_net_upload");
Load::_class("packages_interfaces_methods");
class States extends Api implements Methods{
    public function GET(){
        
    }
    public function POST(){
        if($_POST['token'] != $this->session->token())
                return false;

        //echo $_POST['state-name'];
        $values = array(
            array(0, "NULL"),
            array (1, $_POST['state_name']),
            array(1, $_POST['state_description']),
            array(1, ""),
            array(0, 0)
        );
        
        $resource = $this->resource->set("states",$values);
        if(!$resource)
            return false;

        return "300";
    }
    
    public function PUT(){
        $response = 300;
        
        if($_POST['token'] != $this->session->token())
                return false;

        $image = false;
        if(isset($_FILES['image'])){
            $upload = new Upload();
            $image = $upload->load_and_resize($_FILES['image'],PATH . "/pics",178);
            if(!$image)
            	$image = false;
        }
                
        
        if(isset($_POST['states_active']) && $_POST['states_active']){
        	$active = $this->resource->update("states",array("SET" => array(array("states_active",0,0))));
                    if(!$active)
                        return false;

        $register = $this->resource->set("register", array(array(0,"NULL"), array (0, "NOW()"), array(0,$_POST['states_id'])));
            if(!$register)
                return false;
        }
        
        $values = array(     	
        	"WHERE" => array("states_id",0,(isset($_POST['states_id']))? $_POST['states_id']:null),
        	"SET" => array(
        		array("states_name",1,(isset($_POST['states_name']))? $_POST['states_name']:null),
        		array("states_description",1,(isset($_POST['states_description']))? $_POST['states_description']:null),
        		array("states_image",1,($image)?$image:null),
        		array("states_active",0,($_POST['states_active'])? $_POST['states_active']:null)        		
        	)     	
        );        
        
        
        //$where = " states_id = {$_POST['state']}";        
        $update = $this->resource->update("states",$values);
       if(!$update)
       	return false;
               	
       	
       	if(isset ($_POST['response']) && $_POST['response'] == "html")
            $response = 200;

            
       	return $response;
    }
    
    public function DELETE(){
        $token = (isset($_POST['token']))? $_POST['token']:$_GET['token'];
        $id = (isset($_POST['token']))? $_POST['id']:$_GET['id'] ;
        if($token != $this->session->token())
                return false;

        if(!$id)
            return  false;

        $delete = $this->resource->delete("states","states_id = $id");
        if(!$delete)
            return false;

        return "300";
    }
}
?>
