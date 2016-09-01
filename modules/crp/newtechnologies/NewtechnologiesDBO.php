<?php 
require_once("../../../DB.php");
class NewtechnologiesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crp_newtechnologies";

	function persist($obj){
		$sql="insert into crp_newtechnologies(id,technology_name,country,region,location,number_women,number_men,newtech,crpid,agroecologicalzoneid,rec_period,userid,url,valid_data,crpattribution,themeid,valuechainid)
						values('$obj->id','$obj->technology_name','$obj->country','$obj->region','$obj->location','$obj->number_women','$obj->number_men','$obj->newtech',$obj->crpid,'$obj->agroecologicalzoneid','$obj->rec_period',$obj->userid,'$obj->url','$obj->valid_data','$obj->crpattribution','$obj->themeid','$obj->valuechainid')";		
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
		$sql="update crp_newtechnologies set technology_name='$obj->technology_name',country='$obj->country',region='$obj->region',location='$obj->location',number_women='$obj->number_women',number_men='$obj->number_men',newtech='$obj->newtech',crpid=$obj->crpid,agroecologicalzoneid='$obj->agroecologicalzoneid',rec_period='$obj->rec_period', crpattribution='$obj->crpattribution',userid=$obj->userid,url='$obj->url',valid_data='$obj->valid_data',themeid='$obj->themeid',valuechainid='$obj->valuechainid' where $where ";
		$this->sql=$sql;logging($sql);
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crp_newtechnologies $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crp_newtechnologies $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

