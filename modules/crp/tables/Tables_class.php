<?php 
require_once("TablesDBO.php");
class Tables
{				
	var $id;			
	var $name;			
	var $description;			
	var $remarks;			
	var $status;			
	var $indicator;			
	var $title;			
	var $position;			
	var $tablesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->description=str_replace("'","\'",$obj->description);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
		$this->indicator=str_replace("'","\'",$obj->indicator);
		$this->title=str_replace("'","\'",$obj->title);
		$this->position=str_replace("'","\'",$obj->position);
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

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get indicator
	function getIndicator(){
		return $this->indicator;
	}
	//set indicator
	function setIndicator($indicator){
		$this->indicator=$indicator;
	}

	//get title
	function getTitle(){
		return $this->title;
	}
	//set title
	function setTitle($title){
		$this->title=$title;
	}

	//get position
	function getPosition(){
		return $this->position;
	}
	//set position
	function setPosition($position){
		$this->position=$position;
	}

	function add($obj){
		$tablesDBO = new TablesDBO();
		if($tablesDBO->persist($obj)){
			$this->id=$tablesDBO->id;
			$this->sql=$tablesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$tablesDBO = new TablesDBO();
		if($tablesDBO->update($obj,$where)){
			$this->sql=$tablesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$tablesDBO = new TablesDBO();
		if($tablesDBO->delete($obj,$where=""))		
			$this->sql=$tablesDBO->sql;
			return true;	
	}
	function getTable($table){
	  $tables = new Tables();
	  $fields="*";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where name='$table'";
	  $tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $tables = $tables->fetchObject;
	  
	  return $tables->id;
	}
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$tablesDBO = new TablesDBO();
		$this->table=$tablesDBO->table;
		$tablesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$tablesDBO->sql;
		$this->result=$tablesDBO->result;
		$this->fetchObject=$tablesDBO->fetchObject;
		$this->affectedRows=$tablesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Table Name should be provided";
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
