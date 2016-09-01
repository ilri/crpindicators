<?php 
require_once("ThemesDBO.php");
class Themes
{				
	var $id;			
	var $name;			
	var $crpid;
	var $status;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $themesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->crpid))
			$obj->crpid='NULL';
		$this->crpid=$obj->crpid;
		$this->status=$obj->status;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
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

	//get crpid
	function getCrpid(){
		return $this->crpid;
	}
	//set crpid
	function setCrpid($crpid){
		$this->crpid=$crpid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	//get createdby
	function getCreatedby(){
		return $this->createdby;
	}
	//set createdby
	function setCreatedby($createdby){
		$this->createdby=$createdby;
	}

	//get createdon
	function getCreatedon(){
		return $this->createdon;
	}
	//set createdon
	function setCreatedon($createdon){
		$this->createdon=$createdon;
	}

	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
	}

	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	function add($obj){
		$themesDBO = new ThemesDBO();
		if($themesDBO->persist($obj)){
			$this->id=$themesDBO->id;
			$this->sql=$themesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$themesDBO = new ThemesDBO();
		if($themesDBO->update($obj,$where)){
			$this->sql=$themesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$themesDBO = new ThemesDBO();
		if($themesDBO->delete($obj,$where=""))		
			$this->sql=$themesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$themesDBO = new ThemesDBO();
		$this->table=$themesDBO->table;
		$themesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$themesDBO->sql;
		$this->result=$themesDBO->result;
		$this->fetchObject=$themesDBO->fetchObject;
		$this->affectedRows=$themesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
