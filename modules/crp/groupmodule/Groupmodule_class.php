<?php 
require_once("GroupmoduleDBO.php");
class Groupmodule
{				
	var $id;			
	var $tableid;			
	var $groupid;			
	var $groupmoduleDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->tableid))
			$obj->tableid='NULL';
		$this->tableid=$obj->tableid;
		if(empty($obj->groupid))
			$obj->groupid='NULL';
		$this->groupid=$obj->groupid;
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

	//get tableid
	function getTableid(){
		return $this->tableid;
	}
	//set tableid
	function setTableid($tableid){
		$this->tableid=$tableid;
	}

	//get groupid
	function getGroupid(){
		return $this->groupid;
	}
	//set groupid
	function setGroupid($groupid){
		$this->groupid=$groupid;
	}

	function add($obj){
		$groupmoduleDBO = new GroupmoduleDBO();
		if($groupmoduleDBO->persist($obj)){
			$this->id=$groupmoduleDBO->id;
			$this->sql=$groupmoduleDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$groupmoduleDBO = new GroupmoduleDBO();
		if($groupmoduleDBO->update($obj,$where)){
			$this->sql=$groupmoduleDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$groupmoduleDBO = new GroupmoduleDBO();
		if($groupmoduleDBO->delete($obj,$where=""))		
			$this->sql=$groupmoduleDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$groupmoduleDBO = new GroupmoduleDBO();
		$this->table=$groupmoduleDBO->table;
		$groupmoduleDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$groupmoduleDBO->sql;
		$this->result=$groupmoduleDBO->result;
		$this->fetchObject=$groupmoduleDBO->fetchObject;
		$this->affectedRows=$groupmoduleDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
