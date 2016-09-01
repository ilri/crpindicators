<?php 
require_once("CrpDBO.php");
class Crp
{				
	var $id;			
	var $crp_name;			
	var $crpDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->crp_name=str_replace("'","\'",$obj->crp_name);
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

	//get crp_name
	function getCrp_name(){
		return $this->crp_name;
	}
	//set crp_name
	function setCrp_name($crp_name){
		$this->crp_name=$crp_name;
	}

	function add($obj){
		$crpDBO = new CrpDBO();
		if($crpDBO->persist($obj)){
			$this->id=$crpDBO->id;
			$this->sql=$crpDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$crpDBO = new CrpDBO();
		if($crpDBO->update($obj,$where)){
			$this->sql=$crpDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$crpDBO = new CrpDBO();
		if($crpDBO->delete($obj,$where=""))		
			$this->sql=$crpDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$crpDBO = new CrpDBO();
		$this->table=$crpDBO->table;
		$crpDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$crpDBO->sql;
		$this->result=$crpDBO->result;
		$this->fetchObject=$crpDBO->fetchObject;
		$this->affectedRows=$crpDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
