<?php 
require_once("../../../DB.php");
class PoliciesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crp_policies";

	function persist($obj){
		$sql="insert into crp_policies(id,policy_name,policy_type,country,analysed,presented_consult,presented_legislation,approved,implemented,crpid,agroecologicalzoneid,rec_period,userid,url,valid_data,crpattribution,themeid,valuechainid)
						values('$obj->id','$obj->policy_name','$obj->policy_type','$obj->country','$obj->analysed','$obj->presented_consult','$obj->presented_legislation','$obj->approved','$obj->implemented',$obj->crpid,'$obj->agroecologicalzoneid','$obj->rec_period',$obj->userid,'$obj->url','$obj->valid_data','$obj->crpattribution','$obj->themeid','$obj->valuechainid')";		
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
		$sql="update crp_policies set policy_name='$obj->policy_name',policy_type='$obj->policy_type',country='$obj->country',analysed='$obj->analysed',presented_consult='$obj->presented_consult',presented_legislation='$obj->presented_legislation',approved='$obj->approved',implemented='$obj->implemented',crpid=$obj->crpid, agroecologicalzoneid='$obj->agroecologicalzoneid', crpattribution='$obj->crpattribution',rec_period='$obj->rec_period',userid=$obj->userid,url='$obj->url',valid_data='$obj->valid_data',themeid='$obj->themeid',valuechainid='$obj->valuechainid' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crp_policies $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crp_policies $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

