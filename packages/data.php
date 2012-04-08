<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of data
 *
 * @author Señor pasajero
 */
class Data {
    var $link = false;
    var $resource = false;
    //private $pass = null;
    //put your code here
    public function  __construct($host, $user, $password, $database) {
        if(!$this->link)
            $this->link = mysql_connect($host, $user, $password);
                if($this->link)
                    $source = mysql_select_db($database,$this->link);
                        if($source)
                            return true;

    }

    public function go($sql){
        $this->resource = mysql_query($sql);
        return $this->resource;
    }

    public function get($table, $where = null, $order = null, $limit = null){
       //echo "SELECT * FROM " . $table . $where;
       $sql = "SELECT * FROM " . $table;
       if(!is_null($where))
           $sql .= " WHERE " . $where;

           if(!is_null($order))
               $sql .= " $order";
           
           if(!is_null($limit))
               $sql .= " $limit";
//echo $sql;
       $resource = $this->go($sql);
       if($resource){
           //$mode = "resultIn". (($mode)? $mode:"Array");
           if(!(mysql_num_rows($resource) > 0))
               return false;
           
           return $this->result();
       }else{
           return false;
       }
    }

    public function set($table,$values){
        //print_r($values);
        $sql = "INSERT INTO $table VALUES(" ;
        $values_list = null;
        foreach($values as $value){
            $values_list .= ($value[0])? "'{$value[1]}',":"{$value[1]},";
        }

        $sql .=  preg_replace("/,$/","",$values_list) . ")";
       // echo $sql;
        $resource = $this->go($sql);
        if(!$resource)
            return false;

        return true;
        
    }
    
    public function update($table,$values){
    	$sql = "UPDATE $table SET";
        $where_list = null;
        
        //print_r($values['SET']);
    	if(array_key_exists("WHERE",$values)){
	        $where = array_shift($values);
	        $where_row = $where[0];
	        $where_values = ($where[1])? " '{$where[2]}',":"{$where[2]}";
	        
	        $where_list = $where_row ." = " . $where_values;	        
    	}

    	if(!array_key_exists("SET",$values))
    		return false;
    	
        $values_list = null;
    	foreach($values['SET'] as $value){       	 
    		if(!is_null($value[2])){    		
    			$value_row = $value[0];
    			$value_record = ($value[1])? " '{$value[2]}',":"{$value[2]}";
    			$values_list .= " $value_row = $value_record";     			
    		}
    	}    	
    	$sql .= " " . preg_replace("/\,$/","",$values_list);
    	
    	if(!is_null($where_list))
    		$sql .= " WHERE $where_list"; 
    		
    	
    	$update = $this->go($sql);
    	if(!$update)
    		return false;
    		
    	return "300";
    }

    public function delete($table,$where){
        $sql = "DELETE FROM $table WHERE $where";
        $resource = $this->go($sql);
        if(!$resource)
            return false;

        return true;
    }

    public function result(){        
        if(!(mysql_num_rows($this->resource) > 1))
            return $this->in_array(mysql_fetch_array($this->resource));
        
        while($record = mysql_fetch_array($this->resource)){
            
            foreach($record as $column => $value){
                $record_format[preg_replace('/^[a-z][A-z].*_/','',$column)] =  $value;
            }
            $records[] = $record_format;
            //print_r($records);
        }
        //echo "<br />";
        //print_r($records);
        return $records;
    }

    public function in_array($record){
        $records = null;
        foreach($record as $column => $value){
            $records[preg_replace('/^[a-z][A-z].*_/','',$column)] =  $value;
        }
        if(!$records)
            return false;
        return $records;
    }

    public function records(){
        return mysql_num_rows($this->resource);
    }
}
?>
