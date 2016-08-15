<?php 
require_once("../../../DB.php");
class TechongroundDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crp_techonground";

	function persist($obj){
		$sql="insert into crp_techonground(id,technology_name,country,region,location,area,newarea,women,men,crpid,agroecologicalzoneid,crpattribution,rec_period,userid,url,valid_data,themeid,valuechainid)
						values('$obj->id','$obj->technology_name','$obj->country','$obj->region','$obj->location','$obj->area','$obj->newarea','$obj->women','$obj->men','$obj->crpid','$obj->agroecologicalzoneid','$obj->crpattribution','$obj->rec_period',$obj->userid,'$obj->url','$obj->valid_data','$obj->themeid','$obj->valuechainid')";//echo$sql;		
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
		$sql="update crp_techonground set technology_name='$obj->technology_name',country='$obj->country',region='$obj->region',location='$obj->location',area='$obj->area',newarea='$obj->newarea',women='$obj->women',men='$obj->men',crpid=$obj->crpid, agroecologicalzoneid='$obj->agroecologicalzoneid',crpattribution='$obj->crpattribution',rec_period='$obj->rec_period',userid=$obj->userid,url='$obj->url',valid_data='$obj->valid_data', themeid='$obj->themeid', valuechainid='$obj->valuechainid' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crp_techonground $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crp_techonground $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

