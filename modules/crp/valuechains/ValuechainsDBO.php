<?php 
require_once("../../../DB.php");
class ValuechainsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crp_valuechains";

	function persist($obj){
		$sql="insert into crp_valuechains(id,name,crpid,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->name',$obj->crpid,'$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update crp_valuechains set name='$obj->name',crpid=$obj->crpid,remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crp_valuechains $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crp_valuechains $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

