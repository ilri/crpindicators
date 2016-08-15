<?php 
require_once("LtermtrainingDBO.php");
class Ltermtraining
{				
	var $id;			
	var $long_trainee_name;			
	var $trainee_sex;			
	var $program_name;			
	var $institution_name;			
	var $crpid;
	var $agroecologicalzoneid;
	var $crpattribution;
	var $rec_period;			
	var $userid;			
	var $url;			
	var $valid_data;
	var $themeid;
	var $valuechainid;
	var $ltermtrainingDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->long_trainee_name=str_replace("'","\'",$obj->long_trainee_name);
		$this->trainee_sex=str_replace("'","\'",$obj->trainee_sex);
		$this->program_name=str_replace("'","\'",$obj->program_name);
		$this->institution_name=str_replace("'","\'",$obj->institution_name);
		if(empty($obj->crpid))
			$obj->crpid='NULL';
		$this->crpid=$obj->crpid;
		
		$themes = new Themes();
		$fields="*";
		$where="";
		$groupby="";
		$having="";
		$orderby="";
		$themes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$array=array();
		$aRow = (array)$obj;
		while($row=mysql_fetch_object($themes->result)){
		  $id=$row->id;
		  $array[$row->id] = $aRow['theme'.$id];
		}
		$obj->themeid=json_encode($array);
		$this->themeid=str_replace("'","\'",$obj->themeid);
		
		
		$valuechains = new Valuechains();
		$fields="*";
		$where="";
		$groupby="";
		$having="";
		$orderby="";
		$valuechains->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$array=array();
		$aRow = (array)$obj;
		while($row=mysql_fetch_object($valuechains->result)){
		  $id=$row->id;
		  $array[$row->id] = $aRow['valuechain'.$id];
		}
		$obj->valuechainid=json_encode($array);
		$this->valuechainid=str_replace("'","\'",$obj->valuechainid);
		$this->agroecologicalzoneid=$obj->agroecologicalzoneid;
		$this->rec_period=str_replace("'","\'",$obj->rec_period);
		
		$crps = new Crps();
		$fields="*";
		$where="";
		$groupby="";
		$having="";
		$orderby="";
		$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$array=array();
		$aRow = (array)$obj;
		while($row=mysql_fetch_object($crps->result)){
		  $id=$row->id;
		  $array[$row->id] = $aRow[$id];
		}
		$obj->crpattribution=json_encode($array);
		$this->crpattribution=str_replace("'","\'",$obj->crpattribution);
		
		if(empty($obj->userid))
			$obj->userid='NULL';
		$this->userid=$obj->userid;
		$this->url=str_replace("'","\'",$obj->url);
		$this->valid_data=str_replace("'","\'",$obj->valid_data);
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

	//get long_trainee_name
	function getLong_trainee_name(){
		return $this->long_trainee_name;
	}
	//set long_trainee_name
	function setLong_trainee_name($long_trainee_name){
		$this->long_trainee_name=$long_trainee_name;
	}
	//get crpattribution
	function getCrpattribution(){
		return $this->crpattribution;
	}
	//set crpattribution
	function setCrpattribution($crpattribution){
		$this->crpattribution=$crpattribution;
	}

	//get trainee_sex
	function getTrainee_sex(){
		return $this->trainee_sex;
	}
	//set trainee_sex
	function setTrainee_sex($trainee_sex){
		$this->trainee_sex=$trainee_sex;
	}

	//get program_name
	function getProgram_name(){
		return $this->program_name;
	}
	//set program_name
	function setProgram_name($program_name){
		$this->program_name=$program_name;
	}

	//get institution_name
	function getInstitution_name(){
		return $this->institution_name;
	}
	//set institution_name
	function setInstitution_name($institution_name){
		$this->institution_name=$institution_name;
	}

	//get crpid
	function getCrpid(){
		return $this->crpid;
	}
	//set crpid
	function setCrpid($crpid){
		$this->crpid=$crpid;
	}
	
	//get agroecologicalzoneid
	function getAgroecologicalzoneid(){
		return $this->agroecologicalzoneid;
	}
	//set agroecologicalzoneid
	function setAgroecologicalzoneid($agroecologicalzoneid){
		$this->agroecologicalzoneid=$agroecologicalzoneid;
	}

	//get rec_period
	function getRec_period(){
		return $this->rec_period;
	}
	//set rec_period
	function setRec_period($rec_period){
		$this->rec_period=$rec_period;
	}

	//get userid
	function getUserid(){
		return $this->userid;
	}
	//set userid
	function setUserid($userid){
		$this->userid=$userid;
	}

	//get url
	function getUrl(){
		return $this->url;
	}
	//set url
	function setUrl($url){
		$this->url=$url;
	}

	//get valid_data
	function getValid_data(){
		return $this->valid_data;
	}
	//set valid_data
	function setValid_data($valid_data){
		$this->valid_data=$valid_data;
	}

	function add($obj){
		$ltermtrainingDBO = new LtermtrainingDBO();
		if($ltermtrainingDBO->persist($obj)){
// 			$this->id=$ltermtrainingDBO->id;
// 			$this->sql=$ltermtrainingDBO->sql;

			  $valueid=$ltermtrainingDBO->id;

			$tables = new Tables();
			$tableid = $tables->getTable("ltermtraining");
			
			$themes = new Themes();
			$fields="*";
			$where="";
			$groupby="";
			$having="";
			$orderby="";
			$themes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$array=array();
			$aRow = (array)$obj;
			while($row=mysql_fetch_object($themes->result)){
			  $id=$row->id;
			  //$array[$row->id] = $aRow['theme'.$id];
			  if(!empty($aRow['theme'.$id])){
			    $query="insert into indthmalloc(tableid,valueid,themeid,alloc) values('$tableid','$valueid','$id','1')";
			    mysql_query($query);
			  }
			}
			
			
			//add to indvlcalloc
			$valuechains = new Valuechains();
			$fields="*";
			$where="";
			$groupby="";
			$having="";
			$orderby="";
			$valuechains->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$array=array();
			$aRow = (array)$obj;
			while($row=mysql_fetch_object($valuechains->result)){
			  $id=$row->id;
			  //$array[$row->id] = $aRow['valuechain'.$id];
			  if(!empty($aRow['valuechain'.$id])){
			  $query="insert into indvlcalloc(tableid,valueid,valuechainid,alloc) values('$tableid','$valueid','$id','1')";
			    mysql_query($query);
			  }
			}
			
			
			//add data to indcrpalloc
			$crps = new Crps();
			$fields="*";
			$where="";
			$groupby="";
			$having="";
			$orderby="";
			$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$array=array();
			$aRow = (array)$obj;
			while($row=mysql_fetch_object($crps->result)){
			  $id=$row->id;
			  if($aRow[$id]>0){
			    $query="insert into indcrpalloc(tableid,valueid,crpsid,alloc) values('$tableid','$valueid','$id','$aRow[$id]')";
			    mysql_query($query);
			  }
			  //$array[$row->id] = $aRow[$id];
			}
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$ltermtrainingDBO = new LtermtrainingDBO();
		if($ltermtrainingDBO->update($obj,$where)){
			$valueid=$obj->id;

			$tables = new Tables();
			$tableid = $tables->getTable("ltermtraining");
			
			$themes = new Themes();
			$fields="*";
			$where="";
			$groupby="";
			$having="";
			$orderby="";
			$themes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$array=array();
			$aRow = (array)$obj;
			$ids="0,";
			while($row=mysql_fetch_object($themes->result)){
			  $id=$row->id;
			  //$array[$row->id] = $aRow['theme'.$id];
			  if(!empty($aRow['theme'.$id])){
			    $sql="select * from indthmalloc where tableid='$tableid' and valueid='$valueid' and themeid='$id'";
			    $rs = mysql_query($sql);
			    if(mysql_affected_rows()>0){
			      //do nothing
			      $r=mysql_fetch_object($rs);
			      $ids.=$r->id.",";
			    }else{
			      $query="insert into indthmalloc(tableid,valueid,themeid,alloc) values('$tableid','$valueid','$id','1')";
			      mysql_query($query);
			      $ids.=mysql_insert_id().",";
			    }
			    
			  }
			  
			}
			$ids=substr($ids,0,-1);
			mysql_query("delete from indthmalloc where id not in($ids) and tableid=$tableid and valueid=$valueid");
			
			//add to indvlcalloc
			$valuechains = new Valuechains();
			$fields="*";
			$where="";
			$groupby="";
			$having="";
			$orderby="";
			$valuechains->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$array=array();
			$ids="0,";
			$aRow = (array)$obj;
			while($row=mysql_fetch_object($valuechains->result)){
			  $id=$row->id;
			  //$array[$row->id] = $aRow['valuechain'.$id];
			  if(!empty($aRow['valuechain'.$id])){
			    $sql="select * from indvlcalloc where tableid='$tableid' and valueid='$valueid' and valuechainid='$id'";
			    $rs = mysql_query($sql);
			    if(mysql_affected_rows()>0){
			      //do nothing
			      $r=mysql_fetch_object($rs);
			      $ids.=$r->id.",";
			    }else{
				$query="insert into indvlcalloc(tableid,valueid,valuechainid,alloc) values('$tableid','$valueid','$id','1')";
				mysql_query($query);
				$ids.=mysql_insert_id().",";
			    }
			  }
			}
			$ids=substr($ids,0,-1);
			mysql_query("delete from indvlcalloc where id not in($ids) and tableid=$tableid and valueid=$valueid");
			
			//add data to indcrpalloc
			$crps = new Crps();
			$fields="*";
			$where="";
			$groupby="";
			$having="";
			$orderby="";
			$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$array=array();
			$ids="0,";
			$aRow = (array)$obj;
			while($row=mysql_fetch_object($crps->result)){
			  $id=$row->id;
			  if($aRow[$id]>0){
			    $sql="select * from indcrpalloc where tableid='$tableid' and valueid='$valueid' and crpsid='$id'";
			    $rs = mysql_query($sql);
			    if(mysql_affected_rows()>0){
			      //do nothing
			      mysql_query("update indcrpalloc set alloc='$aRow[$id]' where tableid='$tableid' and valueid='$valueid' and crpsid='$id'");
			      $r=mysql_fetch_object($rs);
			      $ids.=$r->id.",";
			    }else{
			      $query="insert into indcrpalloc(tableid,valueid,crpsid,alloc) values('$tableid','$valueid','$id','$aRow[$id]')";
			      mysql_query($query);
			      $ids.=mysql_insert_id().",";
			    }
			  }
			  //$array[$row->id] = $aRow[$id];
			}
			$ids=substr($ids,0,-1);
			mysql_query("delete from indcrpalloc where id not in($ids) and tableid=$tableid and valueid=$valueid");
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$ltermtrainingDBO = new LtermtrainingDBO();
		if($ltermtrainingDBO->delete($obj,$where=""))		
			$this->sql=$ltermtrainingDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$ltermtrainingDBO = new LtermtrainingDBO();
		$this->table=$ltermtrainingDBO->table;
		$ltermtrainingDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$ltermtrainingDBO->sql;
		$this->result=$ltermtrainingDBO->result;
		$this->fetchObject=$ltermtrainingDBO->fetchObject;
		$this->affectedRows=$ltermtrainingDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
