<?php 
require_once("../../../DB.php");
class NotificationrecipientsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pm_notificationrecipients";

	function persist($obj){
		$sql="insert into pm_notificationrecipients(id,notificationid,employeeid,email,notifiedon,readon,status,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->notificationid,$obj->employeeid,'$obj->email','$obj->notifiedon','$obj->readon','$obj->status','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}	echo mysql_error();	
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update pm_notificationrecipients set notificationid=$obj->notificationid,employeeid=$obj->employeeid,email='$obj->email',notifiedon='$obj->notifiedon',readon='$obj->readon',status='$obj->status',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pm_notificationrecipients $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pm_notificationrecipients $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

