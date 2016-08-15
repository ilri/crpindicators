<?php 
require_once("../../../DB.php");
class PubtargetinecosystemsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crp_pubtargetinecosystems";

	function persist($obj){
		$sql="insert into crp_pubtargetinecosystems(id,ecosystem_name,country,region,publication_name,authors,journal_mag_book,url,crpid,agroecologicalzoneid,rec_period,userid,valid_data,crpattribution,themeid,valuechainid)
						values('$obj->id','$obj->ecosystem_name','$obj->country','$obj->region','$obj->publication_name','$obj->authors','$obj->journal_mag_book','$obj->url',$obj->crpid,'$obj->agroecologicalzoneid','$obj->rec_period',$obj->userid,'$obj->valid_data','$obj->crpattribution','$obj->themeid','$obj->valuechainid')";		
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
		$sql="update crp_pubtargetinecosystems set ecosystem_name='$obj->ecosystem_name',country='$obj->country',region='$obj->region',publication_name='$obj->publication_name',authors='$obj->authors',journal_mag_book='$obj->journal_mag_book',url='$obj->url',crpid=$obj->crpid,agroecologicalzoneid='$obj->agroecologicalzoneid',crpattribution='$obj->crpattribution',rec_period='$obj->rec_period',userid=$obj->userid,valid_data='$obj->valid_data',themeid='$obj->themeid',valuechainid='$obj->valuechainid'  where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crp_pubtargetinecosystems $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crp_pubtargetinecosystems $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

