<?php 
require_once("../../../DB.php");
class LevelsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="auth_levels";

	function persist($obj){
		$sql="insert into auth_levels(id,name,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->name','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj){			
		$sql="update auth_levels set name='$obj->name',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where id='$obj->id' ";
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj){			
		$sql="delete from auth_levels where id='$obj->id'";
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from auth_levels $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

