<?php 
require_once("../../../DB.php");
class UsersDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crp_users";

	function persist($obj){
		$sql="insert into crp_users(id,user_login,user_name,user_pass,user_email,user_isadmin,centerid)
						values('$obj->id','$obj->user_login','$obj->user_name','$obj->user_pass','$obj->user_email','$obj->user_isadmin',$obj->centerid)";		
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
		$sql="update crp_users set user_login='$obj->user_login',user_name='$obj->user_name',user_pass='$obj->user_pass',user_email='$obj->user_email',user_isadmin='$obj->user_isadmin',centerid=$obj->centerid where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crp_users $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crp_users $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

