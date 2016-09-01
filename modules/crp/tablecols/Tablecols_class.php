<?php 
require_once("TablecolsDBO.php");
class Tablecols
{				
	var $id;			
	var $tableid;			
	var $name;			
	var $tablecolsDBO;
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
		$this->name=str_replace("'","\'",$obj->name);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	function add($obj){
		$tablecolsDBO = new TablecolsDBO();
		if($tablecolsDBO->persist($obj)){
			$this->id=$tablecolsDBO->id;
			$this->sql=$tablecolsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$tablecolsDBO = new TablecolsDBO();
		if($tablecolsDBO->update($obj,$where)){
			$this->sql=$tablecolsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$tablecolsDBO = new TablecolsDBO();
		if($tablecolsDBO->delete($obj,$where=""))		
			$this->sql=$tablecolsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$tablecolsDBO = new TablecolsDBO();
		$this->table=$tablecolsDBO->table;
		$tablecolsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$tablecolsDBO->sql;
		$this->result=$tablecolsDBO->result;
		$this->fetchObject=$tablecolsDBO->fetchObject;
		$this->affectedRows=$tablecolsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->tableid)){
			$error="Indicator should be provided";
		}
		else if(empty($obj->name)){
			$error="Column Name should be provided";
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
