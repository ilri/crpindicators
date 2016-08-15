<?php 
require_once("CrptablesDBO.php");
class Crptables
{				
	var $id;			
	var $crpid;			
	var $tableid;			
	var $remarks;			
	var $crptablesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->crpid))
			$obj->crpid='NULL';
		$this->crpid=$obj->crpid;
		if(empty($obj->tableid))
			$obj->tableid='NULL';
		$this->tableid=$obj->tableid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get crpid
	function getCrpid(){
		return $this->crpid;
	}
	//set crpid
	function setCrpid($crpid){
		$this->crpid=$crpid;
	}

	//get tableid
	function getTableid(){
		return $this->tableid;
	}
	//set tableid
	function setTableid($tableid){
		$this->tableid=$tableid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	function add($obj){
		$crptablesDBO = new CrptablesDBO();
		if($crptablesDBO->persist($obj)){
			$this->id=$crptablesDBO->id;
			$this->sql=$crptablesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$crptablesDBO = new CrptablesDBO();
		if($crptablesDBO->update($obj,$where)){
			$this->sql=$crptablesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$crptablesDBO = new CrptablesDBO();
		if($crptablesDBO->delete($obj,$where=""))		
			$this->sql=$crptablesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$crptablesDBO = new CrptablesDBO();
		$this->table=$crptablesDBO->table;
		$crptablesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$crptablesDBO->sql;
		$this->result=$crptablesDBO->result;
		$this->fetchObject=$crptablesDBO->fetchObject;
		$this->affectedRows=$crptablesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->crpid)){
			$error="CRP should be provided";
		}
		else if(empty($obj->tableid)){
			$error="Indicator should be provided";
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
