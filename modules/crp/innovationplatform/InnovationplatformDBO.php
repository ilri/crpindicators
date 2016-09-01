<?php 
require_once("../../../DB.php");
class InnovationplatformDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crp_innovationplatform";

	function persist($obj){
		$sql="insert into crp_innovationplatform(id,innovation_name,country,partners,crpid,agroecologicalzoneid,rec_period,userid,url,valid_data,crpattribution,themeid,valuechainid)
						values('$obj->id','$obj->innovation_name','$obj->country','$obj->partners','$obj->crpid','$obj->agroecologicalzoneid','$obj->rec_period',$obj->userid,'$obj->url','$obj->valid_data','$obj->crpattribution','$obj->themeid','$obj->valuechainid')";		
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
		$sql="update crp_innovationplatform set innovation_name='$obj->innovation_name',country='$obj->country',partners='$obj->partners',crpid=$obj->crpid,agroecologicalzoneid='$obj->agroecologicalzoneid', crpattribution='$obj->crpattribution',rec_period='$obj->rec_period',userid=$obj->userid,url='$obj->url',valid_data='$obj->valid_data',themeid='$obj->themeid',valuechainid='$obj->valuechainid' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crp_innovationplatform $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crp_innovationplatform $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

