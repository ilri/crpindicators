<?php 
require_once("TaskdocumentsDBO.php");
class Taskdocuments
{				
	var $id;			
	var $title;			
	var $taskid;			
	var $documenttypeid;			
	var $file;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $taskdocumentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->title=str_replace("'","\'",$obj->title);
		if(empty($obj->taskid))
			$obj->taskid='NULL';
		$this->taskid=$obj->taskid;
		if(empty($obj->documenttypeid))
			$obj->documenttypeid='NULL';
		$this->documenttypeid=$obj->documenttypeid;
		$this->file=str_replace("'","\'",$obj->file);
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

	//get title
	function getTitle(){
		return $this->title;
	}
	//set title
	function setTitle($title){
		$this->title=$title;
	}

	//get taskid
	function getTaskid(){
		return $this->taskid;
	}
	//set taskid
	function setTaskid($taskid){
		$this->taskid=$taskid;
	}

	//get documenttypeid
	function getDocumenttypeid(){
		return $this->documenttypeid;
	}
	//set documenttypeid
	function setDocumenttypeid($documenttypeid){
		$this->documenttypeid=$documenttypeid;
	}

	//get file
	function getFile(){
		return $this->file;
	}
	//set file
	function setFile($file){
		$this->file=$file;
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
		$taskdocumentsDBO = new TaskdocumentsDBO();
		if($taskdocumentsDBO->persist($obj)){
			$this->id=$taskdocumentsDBO->id;
			$this->sql=$taskdocumentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$taskdocumentsDBO = new TaskdocumentsDBO();
		if($taskdocumentsDBO->update($obj,$where)){
			$this->sql=$taskdocumentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$taskdocumentsDBO = new TaskdocumentsDBO();
		if($taskdocumentsDBO->delete($obj,$where=""))		
			$this->sql=$taskdocumentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$taskdocumentsDBO = new TaskdocumentsDBO();
		$this->table=$taskdocumentsDBO->table;
		$taskdocumentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$taskdocumentsDBO->sql;
		$this->result=$taskdocumentsDBO->result;
		$this->fetchObject=$taskdocumentsDBO->fetchObject;
		$this->affectedRows=$taskdocumentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->title)){
			$error="Title should be provided";
		}
		else if(empty($obj->taskid)){
			$error="Task should be provided";
		}
		else if(empty($obj->documenttypeid)){
			$error="Document Type should be provided";
		}
		else if(empty($obj->file)){
			$error="Upload File should be provided";
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
