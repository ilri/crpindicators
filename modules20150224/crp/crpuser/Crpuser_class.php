<?php 
require_once("CrpuserDBO.php");
class Crpuser
{				
	var $id;			
	var $crp_id;			
	var $userid;			
	var $join_date;			
	var $supervisor;			
	var $crpuserDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->crp_id=str_replace("'","\'",$obj->crp_id);
		$this->userid=str_replace("'","\'",$obj->userid);
		$this->join_date=str_replace("'","\'",$obj->join_date);
		$this->supervisor=str_replace("'","\'",$obj->supervisor);
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

	//get crp_id
	function getCrp_id(){
		return $this->crp_id;
	}
	//set crp_id
	function setCrp_id($crp_id){
		$this->crp_id=$crp_id;
	}

	//get userid
	function getUserid(){
		return $this->userid;
	}
	//set userid
	function setUserid($userid){
		$this->userid=$userid;
	}

	//get join_date
	function getJoin_date(){
		return $this->join_date;
	}
	//set join_date
	function setJoin_date($join_date){
		$this->join_date=$join_date;
	}

	//get supervisor
	function getSupervisor(){
		return $this->supervisor;
	}
	//set supervisor
	function setSupervisor($supervisor){
		$this->supervisor=$supervisor;
	}

	function add($obj){
		$crpuserDBO = new CrpuserDBO();
		if($crpuserDBO->persist($obj)){
			$this->id=$crpuserDBO->id;
			$this->sql=$crpuserDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$crpuserDBO = new CrpuserDBO();
		if($crpuserDBO->update($obj,$where)){
			$this->sql=$crpuserDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$crpuserDBO = new CrpuserDBO();
		if($crpuserDBO->delete($obj,$where=""))		
			$this->sql=$crpuserDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$crpuserDBO = new CrpuserDBO();
		$this->table=$crpuserDBO->table;
		$crpuserDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$crpuserDBO->sql;
		$this->result=$crpuserDBO->result;
		$this->fetchObject=$crpuserDBO->fetchObject;
		$this->affectedRows=$crpuserDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
