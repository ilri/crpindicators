<?php 
require_once("NotificationsDBO.php");
class Notifications
{				
	var $id;			
	var $notificationtypeid;			
	var $subject;			
	var $body;			
	var $taskid;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $notificationsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->notificationtypeid))
			$obj->notificationtypeid='NULL';
		$this->notificationtypeid=$obj->notificationtypeid;
		$this->subject=str_replace("'","\'",$obj->subject);
		$this->body=str_replace("'","\'",$obj->body);
		if(empty($obj->taskid))
			$obj->taskid='NULL';
		$this->taskid=$obj->taskid;
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

	//get notificationtypeid
	function getNotificationtypeid(){
		return $this->notificationtypeid;
	}
	//set notificationtypeid
	function setNotificationtypeid($notificationtypeid){
		$this->notificationtypeid=$notificationtypeid;
	}

	//get subject
	function getSubject(){
		return $this->subject;
	}
	//set subject
	function setSubject($subject){
		$this->subject=$subject;
	}

	//get body
	function getBody(){
		return $this->body;
	}
	//set body
	function setBody($body){
		$this->body=$body;
	}

	//get taskid
	function getTaskid(){
		return $this->taskid;
	}
	//set taskid
	function setTaskid($taskid){
		$this->taskid=$taskid;
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
		$notificationsDBO = new NotificationsDBO();
		if($notificationsDBO->persist($obj)){
			$this->id=$notificationsDBO->id;
			$this->sql=$notificationsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$notificationsDBO = new NotificationsDBO();
		if($notificationsDBO->update($obj,$where)){
			$this->sql=$notificationsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$notificationsDBO = new NotificationsDBO();
		if($notificationsDBO->delete($obj,$where=""))		
			$this->sql=$notificationsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$notificationsDBO = new NotificationsDBO();
		$this->table=$notificationsDBO->table;
		$notificationsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$notificationsDBO->sql;
		$this->result=$notificationsDBO->result;
		$this->fetchObject=$notificationsDBO->fetchObject;
		$this->affectedRows=$notificationsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->notificationtypeid)){
			$error="Notification Type should be provided";
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
