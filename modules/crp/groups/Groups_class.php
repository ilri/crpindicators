<?php 
require_once("GroupsDBO.php");
class Groups
{				
	var $id;			
	var $group_name;			
	var $groupsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->group_name=str_replace("'","\'",$obj->group_name);
		return $this;
	
	}
	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get group_name
	function getGroup_name(){
		return $this->group_name;
	}
	//set group_name
	function setGroup_name($group_name){
		$this->group_name=$group_name;
	}

	function add($obj){
		$groupsDBO = new GroupsDBO();
		if($groupsDBO->persist($obj)){
			$this->id=$groupsDBO->id;
			$this->sql=$groupsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$groupsDBO = new GroupsDBO();
		if($groupsDBO->update($obj,$where)){
			$this->sql=$groupsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$groupsDBO = new GroupsDBO();
		if($groupsDBO->delete($obj,$where=""))		
			$this->sql=$groupsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$groupsDBO = new GroupsDBO();
		$this->table=$groupsDBO->table;
		$groupsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$groupsDBO->sql;
		$this->result=$groupsDBO->result;
		$this->fetchObject=$groupsDBO->fetchObject;
		$this->affectedRows=$groupsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
