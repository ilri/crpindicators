<?php 
require_once("UsergroupDBO.php");
class Usergroup
{				
	var $user_id;			
	var $group_id;			
	var $join_date;			
	var $usergroupDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		if(empty($obj->user_id))
			$obj->user_id='NULL';
		$this->user_id=$obj->user_id;
		if(empty($obj->group_id))
			$obj->group_id='NULL';
		$this->group_id=$obj->group_id;
		$this->join_date=str_replace("'","\'",$obj->join_date);
		return $this;
	
	}
	//get user_id
	function getUser_id(){
		return $this->user_id;
	}
	//set user_id
	function setUser_id($user_id){
		$this->user_id=$user_id;
	}

	//get group_id
	function getGroup_id(){
		return $this->group_id;
	}
	//set group_id
	function setGroup_id($group_id){
		$this->group_id=$group_id;
	}

	//get join_date
	function getJoin_date(){
		return $this->join_date;
	}
	//set join_date
	function setJoin_date($join_date){
		$this->join_date=$join_date;
	}

	function add($obj){
		$usergroupDBO = new UsergroupDBO();
		if($usergroupDBO->persist($obj)){
			$this->id=$usergroupDBO->id;
			$this->sql=$usergroupDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$usergroupDBO = new UsergroupDBO();
		if($usergroupDBO->update($obj,$where)){
			$this->sql=$usergroupDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$usergroupDBO = new UsergroupDBO();
		if($usergroupDBO->delete($obj,$where=""))		
			$this->sql=$usergroupDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$usergroupDBO = new UsergroupDBO();
		$this->table=$usergroupDBO->table;
		$usergroupDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$usergroupDBO->sql;
		$this->result=$usergroupDBO->result;
		$this->fetchObject=$usergroupDBO->fetchObject;
		$this->affectedRows=$usergroupDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->user_id)){
			$error="User Id should be provided";
		}
		else if(empty($obj->group_id)){
			$error="Group Id should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
