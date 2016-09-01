<?php 
require_once("UsersDBO.php");
class Users
{				
	var $id;			
	var $user_login;			
	var $user_name;			
	var $user_pass;			
	var $user_email;			
	var $user_isadmin;			
	var $groupid;			
	var $centerid;			
	var $usersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->user_login))
			$obj->user_login='NULL';
		$this->user_login=$obj->user_login;
		$this->user_name=str_replace("'","\'",$obj->user_name);
		$this->user_pass=str_replace("'","\'",$obj->user_pass);
		$this->user_email=str_replace("'","\'",$obj->user_email);
		$this->user_isadmin=str_replace("'","\'",$obj->user_isadmin);
		if(empty($obj->groupid))
			$obj->groupid='NULL';
		$this->groupid=$obj->groupid;
		if(empty($obj->centerid))
			$obj->centerid='NULL';
		$this->centerid=$obj->centerid;
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

	//get user_login
	function getUser_login(){
		return $this->user_login;
	}
	//set user_login
	function setUser_login($user_login){
		$this->user_login=$user_login;
	}

	//get user_name
	function getUser_name(){
		return $this->user_name;
	}
	//set user_name
	function setUser_name($user_name){
		$this->user_name=$user_name;
	}

	//get user_pass
	function getUser_pass(){
		return $this->user_pass;
	}
	//set user_pass
	function setUser_pass($user_pass){
		$this->user_pass=$user_pass;
	}

	//get user_email
	function getUser_email(){
		return $this->user_email;
	}
	//set user_email
	function setUser_email($user_email){
		$this->user_email=$user_email;
	}

	//get user_isadmin
	function getUser_isadmin(){
		return $this->user_isadmin;
	}
	//set user_isadmin
	function setUser_isadmin($user_isadmin){
		$this->user_isadmin=$user_isadmin;
	}

	//get groupid
	function getGroupid(){
		return $this->groupid;
	}
	//set groupid
	function setGroupid($groupid){
		$this->groupid=$groupid;
	}

	//get centerid
	function getCenterid(){
		return $this->centerid;
	}
	//set centerid
	function setCenterid($centerid){
		$this->centerid=$centerid;
	}

	function add($obj){
		$obj->user_pass=md5($obj->user_pass);
		$usersDBO = new UsersDBO();
		if($usersDBO->persist($obj)){
			$this->id=$usersDBO->id;
			$this->sql=$usersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$obj->user_pass=md5($obj->user_pass);
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
	
		$users = new Users();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where user_login='$obj->user_login' and id not in($obj->id) ";
		$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		
		$user = new Users();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where user_login='$obj->user_login' and user_pass='".md5($obj->user_opass)."' ";
		$user->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		
		if(empty($obj->user_login)){
			$error="Username should be provided";
		}
		
		else if(empty($obj->user_name)){
			$error="Name should be provided";
		}
		
		else if($obj->editing==1 and empty($obj->user_opass)){
		  $error="Old Password should be provided";
		}
		
		else if(empty($obj->user_pass)){
			$error="Password should be provided";
		}
		
		else if($obj->editing==1 and empty($obj->user_cpass)){
		  $error="Confirm Password should be provided";
		}
		
		else if($obj->editing==1 and strcmp($obj->user_pass,$obj->user_cpass)!=0){
		  $error="Confirm Password Correctly";
		}
		
		else if($obj->editing==1 and $user->affectedRows<1){
			$error="Username and Old Password do not match!";
		}
		
		else if(empty($obj->centerid)){
			$error="Center should be provided";
		}
		
		else if($users->affectedRows>0){
			$error="Username already Exists!";
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
