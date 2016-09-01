<?php 
require_once("../../../DB.php");
class ToolsproducedDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crp_toolsproduced";

	function persist($obj){
		$sql="insert into crp_toolsproduced(id,tool_name,targeting_women,gender_disaggregated,url,crpid,agroecologicalzoneid,rec_period,userid,valid_data,crpattribution,themeid,valuechainid)
						values('$obj->id','$obj->tool_name','$obj->targeting_women','$obj->gender_disaggregated','$obj->url',$obj->crpid,'$obj->agroecologicalzoneid','$obj->rec_period',$obj->userid,'$obj->valid_data','$obj->crpattribution','$obj->themeid','$obj->valuechainid')";		
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
		$sql="update crp_toolsproduced set tool_name='$obj->tool_name',targeting_women='$obj->targeting_women',gender_disaggregated='$obj->gender_disaggregated',url='$obj->url',crpid=$obj->crpid,agroecologicalzoneid='$obj->agroecologicalzoneid',rec_period='$obj->rec_period', crpattribution='$obj->crpattribution',userid=$obj->userid,valid_data='$obj->valid_data', themeid='$obj->themeid', valuechainid='$obj->valuechainid' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crp_toolsproduced $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crp_toolsproduced $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

