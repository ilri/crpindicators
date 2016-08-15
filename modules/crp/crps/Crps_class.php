<?php 
require_once("CrpsDBO.php");
class Crps
{				
	var $id;			
	var $crpno;			
	var $crp_name;			
	var $category;			
	var $subcategory;			
	var $crpsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->crpno=str_replace("'","\'",$obj->crpno);
		$this->crp_name=str_replace("'","\'",$obj->crp_name);
		$this->category=str_replace("'","\'",$obj->category);
		$this->subcategory=str_replace("'","\'",$obj->subcategory);
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

	//get crpno
	function getCrpno(){
		return $this->crpno;
	}
	//set crpno
	function setCrpno($crpno){
		$this->crpno=$crpno;
	}

	//get crp_name
	function getCrp_name(){
		return $this->crp_name;
	}
	//set crp_name
	function setCrp_name($crp_name){
		$this->crp_name=$crp_name;
	}

	//get category
	function getCategory(){
		return $this->category;
	}
	//set category
	function setCategory($category){
		$this->category=$category;
	}

	//get subcategory
	function getSubcategory(){
		return $this->subcategory;
	}
	//set subcategory
	function setSubcategory($subcategory){
		$this->subcategory=$subcategory;
	}

	function add($obj){
		$crpsDBO = new CrpsDBO();
		if($crpsDBO->persist($obj)){
			$this->id=$crpsDBO->id;
			$this->sql=$crpsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$crpsDBO = new CrpsDBO();
		if($crpsDBO->update($obj,$where)){
			$this->sql=$crpsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$crpsDBO = new CrpsDBO();
		if($crpsDBO->delete($obj,$where=""))		
			$this->sql=$crpsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$crpsDBO = new CrpsDBO();
		$this->table=$crpsDBO->table;
		$crpsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$crpsDBO->sql;
		$this->result=$crpsDBO->result;
		$this->fetchObject=$crpsDBO->fetchObject;
		$this->affectedRows=$crpsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
