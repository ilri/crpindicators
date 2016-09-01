<?php 
require_once("../../../DB.php");
class AgsystemfieldtestinDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crp_agsystemfieldtestin";

	function persist($obj){
		$sql="insert into crp_agsystemfieldtestin(id,ecosystem_name,practice_name,country,region,decrease_inequality,publications,crpid,agroecologicalzoneid,rec_period,userid,url,valid_data,crpattribution,themeid,valuechainid)
						values('$obj->id','$obj->ecosystem_name','$obj->practice_name','$obj->country','$obj->region','$obj->decrease_inequality','$obj->publications',$obj->crpid,'$obj->agroecologicalzoneid','$obj->rec_period',$obj->userid,'$obj->url','$obj->valid_data','$obj->crpattribution','$obj->themeid','$obj->valuechainid')";
						echo $sql;	
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
		$sql="update crp_agsystemfieldtestin set ecosystem_name='$obj->ecosystem_name',practice_name='$obj->practice_name',country='$obj->country',region='$obj->region',decrease_inequality='$obj->decrease_inequality', publications='$obj->publications',crpid=$obj->crpid,agroecologicalzoneid='$obj->agroecologicalzoneid',rec_period='$obj->rec_period',userid=$obj->userid,url='$obj->url',valid_data='$obj->valid_data',crpattribution='$obj->crpattribution', themeid='$obj->themeid', valuechainid='$obj->valuechainid' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crp_agsystemfieldtestin $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crp_agsystemfieldtestin $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

