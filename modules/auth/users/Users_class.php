<?php 
require_once("UsersDBO.php");
class Users
{				
	var $id;			
	var $employeeid;			
	var $username;			
	var $password;			
	var $cpassword;
	var $levelid;			
	var $status;			
	var $lastlogin;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $usersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->username=str_replace("'","\'",$obj->username);
		$this->password=$obj->password;
		$this->cpassword=str_replace("'","\'",$obj->cpassword);
		$this->levelid=str_replace("'","\'",$obj->levelid);
		$this->status=str_replace("'","\'",$obj->status);
		$this->lastlogin=str_replace("'","\'",$obj->lastlogin);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get username
	function getUsername(){
		return $this->username;
	}
	//set username
	function setUsername($username){
		$this->username=$username;
	}

	//get password
	function getPassword(){
		return $this->password;
	}
	//set password
	function setPassword($password){
		$this->password=md5($password);
	}
	
	//get password
	function getcPassword(){
		return $this->cpassword;
	}
	//set password
	function setcPassword($cpassword){
		$this->cpassword=$cpassword;
	}

	//get levelid
	function getLevelid(){
		return $this->levelid;
	}
	//set levelid
	function setLevelid($levelid){
		$this->levelid=$levelid;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get lastlogin
	function getLastlogin(){
		return $this->lastlogin;
	}
	//set lastlogin
	function setLastlogin($lastlogin){
		$this->lastlogin=$lastlogin;
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
		$usersDBO = new UsersDBO();
		if($usersDBO->persist($obj)){
			$this->id=$usersDBO->id;
			$this->sql=$usersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$usersDBO = new UsersDBO();
		if($usersDBO->update($obj,$where)){
			$this->sql=$usersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$usersDBO = new UsersDBO();
		if($usersDBO->delete($obj,$where=""))		
			$this->sql=$usersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$usersDBO = new UsersDBO();
		$this->table=$usersDBO->table;
		$usersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$usersDBO->sql;
		$this->result=$usersDBO->result;
		$this->fetchObject=$usersDBO->fetchObject;
		$this->affectedRows=$usersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->username)){
			$error="Username should be provided";
		}
		else if(empty($obj->oldpassword)){
			$error="Old Password should be provided";
		}
		else if(empty($obj->password)){
			$error="Password should be provided";
		}
		else if(empty($obj->cpassword)){
			$error="Confirm Password should be provided";
		}
		elseif($obj->password!=$obj->cpassword)
		{
			$error="password incorrectly confirmed";
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