<?php 
require_once("EmployeecalendarDBO.php");
class Employeecalendar
{				
	var $id;			
	var $employeeid;			
	var $startdate;			
	var $starttime;			
	var $enddate;			
	var $endtime;			
	var $eventname;			
	var $location;			
	var $description;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeecalendarDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->startdate=str_replace("'","\'",$obj->startdate);
		$this->starttime=str_replace("'","\'",$obj->starttime);
		$this->enddate=str_replace("'","\'",$obj->enddate);
		$this->endtime=str_replace("'","\'",$obj->endtime);
		$this->eventname=str_replace("'","\'",$obj->eventname);
		$this->location=str_replace("'","\'",$obj->location);
		$this->description=str_replace("'","\'",$obj->description);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get startdate
	function getStartdate(){
		return $this->startdate;
	}
	//set startdate
	function setStartdate($startdate){
		$this->startdate=$startdate;
	}

	//get starttime
	function getStarttime(){
		return $this->starttime;
	}
	//set starttime
	function setStarttime($starttime){
		$this->starttime=$starttime;
	}

	//get enddate
	function getEnddate(){
		return $this->enddate;
	}
	//set enddate
	function setEnddate($enddate){
		$this->enddate=$enddate;
	}

	//get endtime
	function getEndtime(){
		return $this->endtime;
	}
	//set endtime
	function setEndtime($endtime){
		$this->endtime=$endtime;
	}

	//get eventname
	function getEventname(){
		return $this->eventname;
	}
	//set eventname
	function setEventname($eventname){
		$this->eventname=$eventname;
	}

	//get location
	function getLocation(){
		return $this->location;
	}
	//set location
	function setLocation($location){
		$this->location=$location;
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
		$employeecalendarDBO = new EmployeecalendarDBO();
		if($employeecalendarDBO->persist($obj)){
			$this->id=$employeecalendarDBO->id;
			$this->sql=$employeecalendarDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeecalendarDBO = new EmployeecalendarDBO();
		if($employeecalendarDBO->update($obj,$where)){
			$this->sql=$employeecalendarDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeecalendarDBO = new EmployeecalendarDBO();
		if($employeecalendarDBO->delete($obj,$where=""))		
			$this->sql=$employeecalendarDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeecalendarDBO = new EmployeecalendarDBO();
		$this->table=$employeecalendarDBO->table;
		$employeecalendarDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeecalendarDBO->sql;
		$this->result=$employeecalendarDBO->result;
		$this->fetchObject=$employeecalendarDBO->fetchObject;
		$this->affectedRows=$employeecalendarDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->eventname)){
			$error="Event Name should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
