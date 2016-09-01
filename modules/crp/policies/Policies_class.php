<?php 
require_once("PoliciesDBO.php");
class Policies
{				
	var $id;			
	var $policy_name;
	var $policy_type;
	var $country;			
	var $analysed;			
	var $presented_consult;			
	var $presented_legislation;			
	var $approved;			
	var $implemented;			
	var $crpid;	
	var $agroecologicalzoneid;
	var $crpattribution;
	var $rec_period;			
	var $userid;			
	var $url;			
	var $valid_data;
	var $themeid;
	var $valuechainid;
	var $policiesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->policy_name=str_replace("'","\'",$obj->policy_name);
		$this->policy_type=str_replace("'","\'",$obj->policy_type);
		$this->country=str_replace("'","\'",$obj->country);
		$this->analysed=str_replace("'","\'",$obj->analysed);
		$this->presented_consult=str_replace("'","\'",$obj->presented_consult);
		$this->presented_legislation=str_replace("'","\'",$obj->presented_legislation);
		$this->approved=str_replace("'","\'",$obj->approved);
		$this->implemented=str_replace("'","\'",$obj->implemented);
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

	//get policy_name
	function getPolicy_name(){
		return $this->policy_name;
	}
	//set policy_name
	function setPolicy_name($policy_name){
		$this->policy_name=$policy_name;
	}
	//get policy_type
	function getPolicy_type(){
		return $this->policy_type;
	}
	//set policy_type
	function setPolicy_type($policy_type){
		$this->policy_type=$policy_type;
	}

	//get country
	function getCountry(){
		return $this->country;
	}
	//set country
	function setCountry($country){
		$this->country=$country;
	}

	//get analysed
	function getAnalysed(){
		return $this->analysed;
	}
	//set analysed
	function setAnalysed($analysed){
		$this->analysed=$analysed;
	}

	//get presented_consult
	function getPresented_consult(){
		return $this->presented_consult;
	}
	//set presented_consult
	function setPresented_consult($presented_consult){
		$this->presented_consult=$presented_consult;
	}

	//get presented_legislation
	function getPresented_legislation(){
		return $this->presented_legislation;
	}
	//set presented_legislation
	function setPresented_legislation($presented_legislation){
		$this->presented_legislation=$presented_legislation;
	}

	//get approved
	function getApproved(){
		return $this->approved;
	}
	//set approved
	function setApproved($approved){
		$this->approved=$approved;
	}

	//get implemented
	function getImplemented(){
		return $this->implemented;
	}
	//set implemented
	function setImplemented($implemented){
		$this->implemented=$implemented;
	}
	
	//get crpattribution
	function getCrpattribution(){
		return $this->crpattribution;
	}
	//set crpattribution
	function setCrpattribution($crpattribution){
		$this->crpattribution=$crpattribution;
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
		$policiesDBO = new PoliciesDBO();
		if($policiesDBO->persist($obj)){
// 			$this->id=$policiesDBO->id;
// 			$this->sql=$policiesDBO->sql;


			$valueid=$policiesDBO->id;

			$tables = new Tables();
			$tableid = $tables->getTable("policies");
			
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
		$policiesDBO = new PoliciesDBO();
		if($policiesDBO->update($obj,$where)){
			$valueid=$obj->id;

			$tables = new Tables();
			$tableid = $tables->getTable("policies");
			
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
		$policiesDBO = new PoliciesDBO();
		if($policiesDBO->delete($obj,$where=""))		
			$this->sql=$policiesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$policiesDBO = new PoliciesDBO();
		$this->table=$policiesDBO->table;
		$policiesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$policiesDBO->sql;
		$this->result=$policiesDBO->result;
		$this->fetchObject=$policiesDBO->fetchObject;
		$this->affectedRows=$policiesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
