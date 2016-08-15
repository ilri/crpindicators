<?php 
require_once("AgroecologicalzonesDBO.php");
class Agroecologicalzones
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $agroecologicalzonesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
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
		$agroecologicalzonesDBO = new AgroecologicalzonesDBO();
		if($agroecologicalzonesDBO->persist($obj)){
			$this->id=$agroecologicalzonesDBO->id;
			$this->sql=$agroecologicalzonesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$agroecologicalzonesDBO = new AgroecologicalzonesDBO();
		if($agroecologicalzonesDBO->update($obj,$where)){
			$this->sql=$agroecologicalzonesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$agroecologicalzonesDBO = new AgroecologicalzonesDBO();
		if($agroecologicalzonesDBO->delete($obj,$where=""))		
			$this->sql=$agroecologicalzonesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$agroecologicalzonesDBO = new AgroecologicalzonesDBO();
		$this->table=$agroecologicalzonesDBO->table;
		$agroecologicalzonesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$agroecologicalzonesDBO->sql;
		$this->result=$agroecologicalzonesDBO->result;
		$this->fetchObject=$agroecologicalzonesDBO->fetchObject;
		$this->affectedRows=$agroecologicalzonesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Agroecological Zones should be provided";
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
