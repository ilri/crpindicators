<?php 
require_once("../../../DB.php");
class LtermtrainingDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crp_ltermtraining";

	function persist($obj){
		$sql="insert into crp_ltermtraining(id,long_trainee_name,trainee_sex,program_name,institution_name,crpid,agroecologicalzoneid,rec_period,userid,url,valid_data,crpattribution,themeid,valuechainid)
						values('$obj->id','$obj->long_trainee_name','$obj->trainee_sex','$obj->program_name','$obj->institution_name','$obj->crpid','$obj->agroecologicalzoneid', '$obj->rec_period',$obj->userid,'$obj->url','$obj->valid_data','$obj->crpattribution','$obj->themeid','$obj->valuechainid')";		
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
		$sql="update crp_ltermtraining set long_trainee_name='$obj->long_trainee_name',trainee_sex='$obj->trainee_sex',program_name='$obj->program_name',institution_name='$obj->institution_name',crpid=$obj->crpid,agroecologicalzoneid='$obj->agroecologicalzoneid',rec_period='$obj->rec_period',crpattribution='$obj->crpattribution',userid=$obj->userid,url='$obj->url',valid_data='$obj->valid_data',themeid='$obj->themeid',valuechainid='$obj->valuechainid' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crp_ltermtraining $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crp_ltermtraining $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

