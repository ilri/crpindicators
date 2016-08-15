<?php 
require_once("NewtechnologiesDBO.php");
class Newtechnologies
{				
	var $id;			
	var $technology_name;			
	var $country;			
	var $region;			
	var $location;			
	var $number_women;			
	var $number_men;			
	var $newtech;			
	var $crpid;
	var $agroecologicalzoneid;
	var $crpattribution;
	var $rec_period;			
	var $userid;			
	var $url;			
	var $valid_data;
	var $themeid;
	var $valuechainid;
	var $newtechnologiesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->technology_name=str_replace("'","\'",$obj->technology_name);
		$this->country=str_replace("'","\'",$obj->country);
		$this->region=str_replace("'","\'",$obj->region);
		$this->location=str_replace("'","\'",$obj->location);
		$this->number_women=str_replace("'","\'",$obj->number_women);
		$this->number_men=str_replace("'","\'",$obj->number_men);
		$this->newtech=str_replace("'","\'",$obj->newtech);
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

	//get technology_name
	function getTechnology_name(){
		return $this->technology_name;
	}
	//set technology_name
	function setTechnology_name($technology_name){
		$this->technology_name=$technology_name;
	}

	//get country
	function getCountry(){
		return $this->country;
	}
	//set country
	function setCountry($country){
		$this->country=$country;
	}

	//get region
	function getRegion(){
		return $this->region;
	}
	//set region
	function setRegion($region){
		$this->region=$region;
	}

	//get location
	function getLocation(){
		return $this->location;
	}
	//set location
	function setLocation($location){
		$this->location=$location;
	}

	//get number_women
	function getNumber_women(){
		return $this->number_women;
	}
	//set number_women
	function setNumber_women($number_women){
		$this->number_women=$number_women;
	}

	//get number_men
	function getNumber_men(){
		return $this->number_men;
	}
	//set number_men
	function setNumber_men($number_men){
		$this->number_men=$number_men;
	}

	//get newtech
	function getNewtech(){
		return $this->newtech;
	}
	//set newtech
	function setNewtech($newtech){
		$this->newtech=$newtech;
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
		$newtechnologiesDBO = new NewtechnologiesDBO();
		if($newtechnologiesDBO->persist($obj)){
// 			$this->id=$newtechnologiesDBO->id;
// 			$this->sql=$newtechnologiesDBO->sql;

			$valueid=$newtechnologiesDBO->id;

			$tables = new Tables();
			$tableid = $tables->getTable("newtechnologies");
			
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
			    mysql_query("insert into indvlcalloc(tableid,valueid,themeid,alloc) values('$tableid','$valueid','$id','1')");
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
			    mysql_query("insert into indvlcalloc(tableid,valueid,valuechainid,alloc) values('$tableid','$valueid','$id','1')");
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
			    mysql_query("insert into indcrpalloc(tableid,valueid,crpsid,alloc) values('$tableid','$valueid','$id','$aRow[$id]')");
			  }
			  //$array[$row->id] = $aRow[$id];
			}
			
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$newtechnologiesDBO = new NewtechnologiesDBO();
		if($newtechnologiesDBO->update($obj,$where)){
			$valueid=$obj->id;

			$tables = new Tables();
			$tableid = $tables->getTable("newtechnologies");
			
			$themes = new Themes();
			$fields="*";
			$where="";
			$groupby="";
			$having="";
			$orderby="";
			$themes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$array=array();
			$aRow = (array)$obj;
			$ids="";
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
			mysql_query("delete from indthmalloc where id not in($ids)");
			
			//add to indvlcalloc
			$valuechains = new Valuechains();
			$fields="*";
			$where="";
			$groupby="";
			$having="";
			$orderby="";
			$valuechains->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$array=array();
			$ids="";
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
			mysql_query("delete from indvlcalloc where id not in($ids)");
			
			//add data to indcrpalloc
			$crps = new Crps();
			$fields="*";
			$where="";
			$groupby="";
			$having="";
			$orderby="";
			$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$array=array();
			$ids="";
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
			}echo $ids;
			$ids=substr($ids,0,-1);
			mysql_query("delete from indcrpalloc where id not in($ids)");
		}
			return true;
	}			
	function delete($obj,$where=""){			
		$newtechnologiesDBO = new NewtechnologiesDBO();
		if($newtechnologiesDBO->delete($obj,$where=""))		
			$this->sql=$newtechnologiesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$newtechnologiesDBO = new NewtechnologiesDBO();
		$this->table=$newtechnologiesDBO->table;
		$newtechnologiesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$newtechnologiesDBO->sql;
		$this->result=$newtechnologiesDBO->result;
		$this->fetchObject=$newtechnologiesDBO->fetchObject;
		$this->affectedRows=$newtechnologiesDBO->affectedRows;
	}			
	function validate($obj){
		$error=validateCRPAttribution($obj);
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
