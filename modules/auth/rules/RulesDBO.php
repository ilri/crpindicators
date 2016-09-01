<?php 
require_once("../../../DB.php");
class RulesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="auth_rules";

	function persist($obj){
		$sql="insert into auth_rules(id,levelid,roleid,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->levelid','$obj->roleid','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj){			
		$sql="update auth_rules set levelid='$obj->levelid',roleid='$obj->roleid',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where id='$obj->id' ";
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj){			
		$sql="delete from auth_rules where id='$obj->id'";
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from auth_rules $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

