<?php 
require_once("ConfigDBO.php");
class Config
{				
	var $id;			
	var $name;			
	var $value;			
	var $configDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->value=str_replace("'","\'",$obj->value);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get value
	function getValue(){
		return $this->value;
	}
	//set value
	function setValue($value){
		$this->value=$value;
	}

	function add($obj){
		$configDBO = new ConfigDBO();
		if($configDBO->persist($obj)){
			$this->id=$configDBO->id;
			$this->sql=$configDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$configDBO = new ConfigDBO();
		if($configDBO->update($obj,$where)){
			$this->sql=$configDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$configDBO = new ConfigDBO();
		if($configDBO->delete($obj,$where=""))		
			$this->sql=$configDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$configDBO = new ConfigDBO();
		$this->table=$configDBO->table;
		$configDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$configDBO->sql;
		$this->result=$configDBO->result;
		$this->fetchObject=$configDBO->fetchObject;
		$this->affectedRows=$configDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Name should be provided";
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
