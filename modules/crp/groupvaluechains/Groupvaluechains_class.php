<?php 
require_once("GroupvaluechainsDBO.php");
class Groupvaluechains
{				
	var $id;			
	var $groupid;			
	var $valuechainid;			
	var $remarks;			
	var $groupvaluechainsDBO;
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
		if(empty($obj->valuechainid))
			$obj->valuechainid='NULL';
		$this->valuechainid=$obj->valuechainid;
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

	//get valuechainid
	function getValuechainid(){
		return $this->valuechainid;
	}
	//set valuechainid
	function setValuechainid($valuechainid){
		$this->valuechainid=$valuechainid;
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
		$groupvaluechainsDBO = new GroupvaluechainsDBO();
		if($groupvaluechainsDBO->persist($obj)){
			$this->id=$groupvaluechainsDBO->id;
			$this->sql=$groupvaluechainsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$groupvaluechainsDBO = new GroupvaluechainsDBO();
		if($groupvaluechainsDBO->update($obj,$where)){
			$this->sql=$groupvaluechainsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$groupvaluechainsDBO = new GroupvaluechainsDBO();
		if($groupvaluechainsDBO->delete($obj,$where=""))		
			$this->sql=$groupvaluechainsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$groupvaluechainsDBO = new GroupvaluechainsDBO();
		$this->table=$groupvaluechainsDBO->table;
		$groupvaluechainsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$groupvaluechainsDBO->sql;
		$this->result=$groupvaluechainsDBO->result;
		$this->fetchObject=$groupvaluechainsDBO->fetchObject;
		$this->affectedRows=$groupvaluechainsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
