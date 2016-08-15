<?php 
require_once("GroupthemesDBO.php");
class Groupthemes
{				
	var $id;			
	var $groupid;			
	var $themeid;			
	var $remarks;			
	var $groupthemesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->groupid))
			$obj->groupid='NULL';
		$this->groupid=$obj->groupid;
		if(empty($obj->themeid))
			$obj->themeid='NULL';
		$this->themeid=$obj->themeid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get groupid
	function getGroupid(){
		return $this->groupid;
	}
	//set groupid
	function setGroupid($groupid){
		$this->groupid=$groupid;
	}

	//get themeid
	function getThemeid(){
		return $this->themeid;
	}
	//set themeid
	function setThemeid($themeid){
		$this->themeid=$themeid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	function add($obj){
		$groupthemesDBO = new GroupthemesDBO();
		if($groupthemesDBO->persist($obj)){
			$this->id=$groupthemesDBO->id;
			$this->sql=$groupthemesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$groupthemesDBO = new GroupthemesDBO();
		if($groupthemesDBO->update($obj,$where)){
			$this->sql=$groupthemesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$groupthemesDBO = new GroupthemesDBO();
		if($groupthemesDBO->delete($obj,$where=""))		
			$this->sql=$groupthemesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$groupthemesDBO = new GroupthemesDBO();
		$this->table=$groupthemesDBO->table;
		$groupthemesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$groupthemesDBO->sql;
		$this->result=$groupthemesDBO->result;
		$this->fetchObject=$groupthemesDBO->fetchObject;
		$this->affectedRows=$groupthemesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
