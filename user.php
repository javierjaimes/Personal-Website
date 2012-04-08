<?php
Load::_class("packages_session");
Load::_class("packages_data");
Load::_class("packages_interfaces_methods");
Load::_class("packages_interfaces_user");

class User implements Methods, User_Extends{
    var $resource = false;
    var $session = false;

    var $ready = false;
    static $token = false;

    static $name = null;
    static $states = null;
    static $state_active = null;
    static $states_num = null;
    static $published = null;
    static $published_num = null;

    public function  __construct() {                
        if(!$this->resource)
            $this->resource = new Data(HOST, USER, PASSWORD, DATABASE);

        if($this->resource)
            
            $user = $this->resource->get("user");
            if(!$user)
                return false;
            //echo $resource;
            //if($user)
                //$user = mysql_fetch_array($resource);            
            
            if(!$this->session)
                $this->session = new Session();

                        
            ////$this->session->stop();
            if(!self::$token)
                self::$token = $this->session->token();

            //echo self::$token;
            //echo $this->session->get("user_name");
            //print_r($_SESSION);

            //echo "<br /><br /><br />";
            self::$name = $user['name'];
            self::$state_active = $this->STATE_ACTIVE();            
            self::$states = $this->STATES();
            
            //$published_state = (isset($_GET['state']))?$_GET['state']:null;
            self::$published = $this->PUBLISHED();
            self::$published_num = $this->PUBLISHED_NUM();
			self::$states_num = $this->STATES_NUM();

            //print_r(self::$published);
            $this->ready = true;
    }    
    
    public function STATE_ACTIVE(){        
        $state = $this->resource->get("states","states_active = 1");
        if(!$state)
            return false;
        
        return $state;
    }
    public function STATES($id = null){
        if(is_null($id)){
            $states = $this->resource->get("states", null, "ORDER BY states_id", null);
            if(!$states)
                return false;            
            return $states;
        }else{
            $state = $this->resource->get("states","states_id = $id");
            if(!$state)
                return  false;

            return $state;
        }
        
    }
    
    public function STATES_NUM(){
    	$states = $this->resource->get("states");
    	if(!$states)
    		return false;

    	return $this->resource->records();
    }

    public function PUBLISHED(){
        $state = (isset($_GET['state']))? $_GET['state']:null;
        $where = (!is_null($state))? "publish_states = $state ":null;
        
        $published = $this->resource->get("publish",$where, "ORDER BY publish_register DESC");
        if(!$published)
            return false;

        return $published;
    }
    public function PUBLISHED_NUM(){
        $where = (isset($_GET['state']))? "publish_states = {$_GET['state']}":null;
        $publish = $this->resource->get("publish",$where);
        if(!$publish)
            return false;

        return $this->resource->records();
    }

    public function GET(){

    }
    public function POST(){

    }
    public function PUT(){

    }
    public function DELETE(){
        
    }
    
}
?>