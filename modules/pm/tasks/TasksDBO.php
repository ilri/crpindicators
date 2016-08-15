<?php 
require_once("../../../DB.php");
class TasksDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pm_tasks";

	function persist($obj){
		$sql="insert into pm_tasks(id,name,tasktype,description,projectid,routeid,routedetailid,projecttype,employeeid,ownerid,assignmentid,documenttype,documentno,priority,tracktime,reqduration,reqdurationtype,deadline,startdate,starttime,enddate,endtime,duration,durationtype,remind,taskid,origtask,statusid,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->name','$obj->tasktype','$obj->description','$obj->projectid',$obj->routeid,'$obj->routedetailid','$obj->projecttype',$obj->employeeid,'$obj->ownerid',$obj->assignmentid,'$obj->documenttype','$obj->documentno','$obj->priority','$obj->tracktime','$obj->reqduration','$obj->reqdurationtype','$obj->deadline','$obj->startdate','$obj->starttime','$obj->enddate','$obj->endtime','$obj->duration','$obj->durationtype','$obj->remind','$obj->taskid','$obj->origtask',$obj->statusid,'$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;//echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update pm_tasks set name='$obj->name',tasktype='$obj->tasktype',description='$obj->description',projectid='$obj->projectid',routeid=$obj->routeid,routedetailid='$obj->routedetailid',projecttype='$obj->projecttype',employeeid=$obj->employeeid,ownerid='$obj->ownerid',assignmentid=$obj->assignmentid,documenttype='$obj->documenttype',documentno='$obj->documentno',priority='$obj->priority',tracktime='$obj->tracktime',reqduration='$obj->reqduration',reqdurationtype='$obj->reqdurationtype',deadline='$obj->deadline',startdate='$obj->startdate',starttime='$obj->starttime',enddate='$obj->enddate',endtime='$obj->endtime',duration='$obj->duration',durationtype='$obj->durationtype',remind='$obj->remind',taskid='$obj->taskid',origtask='$obj->origtask',statusid=$obj->statusid,ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pm_tasks $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pm_tasks $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

