<?php 
require_once("../../../DB.php");
class TargetsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crp_targets";

	function persist($obj){
		$sql="insert into crp_targets(id,tableid,crpid,target,userid,year,datekeyed)
						values('$obj->id',$obj->tableid,$obj->crpid,'$obj->target',$obj->userid,'$obj->year','$obj->datekeyed')";		
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
		$sql="update crp_targets set tableid=$obj->tableid,crpid=$obj->crpid,target='$obj->target',userid=$obj->userid,year='$obj->year',datekeyed='$obj->datekeyed' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crp_targets $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crp_targets $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

