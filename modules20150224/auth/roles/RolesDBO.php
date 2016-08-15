<?php 
require_once("../../../DB.php");
class RolesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="auth_roles";

	function persist($obj){
		$sql="insert into auth_roles(id,name,moduleid,module,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->name','$obj->moduleid','$obj->module','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj){			
		$sql="update auth_roles set name='$obj->name',moduleid='$obj->moduleid',module='$obj->module',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where id='$obj->id' ";
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj){			
		$sql="delete from auth_roles where id='$obj->id'";
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from auth_roles $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

