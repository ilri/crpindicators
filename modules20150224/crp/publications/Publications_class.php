<?php 
require_once("PublicationsDBO.php");
class Publications
{				
	var $id;			
	var $publication_name;			
	var $publication_year;			
	var $authors;			
	var $journal_name;			
	var $url;			
	var $crpid;
	var $agroecologicalzoneid;
	var $crpattribution;
	var $rec_period;			
	var $userid;			
	var $valid_data;
	var $themeid;
	var $valuechainid;
	var $publicationsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->publication_name=str_replace("'","\'",$obj->publication_name);
		$this->publication_year=str_replace("'","\'",$obj->publication_year);
		$this->authors=str_replace("'","\'",$obj->authors);
		$this->journal_name=str_replace("'","\'",$obj->journal_name);
		$this->url=str_replace("'","\'",$obj->url);
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

	//get publication_name
	function getPublication_name(){
		return $this->publication_name;
	}
	//set publication_name
	function setPublication_name($publication_name){
		$this->publication_name=$publication_name;
	}

	//get publication_year
	function getPublication_year(){
		return $this->publication_year;
	}
	//set publication_year
	function setPublication_year($publication_year){
		$this->publication_year=$publication_year;
	}

	//get authors
	function getAuthors(){
		return $this->authors;
	}
	//set authors
	function setAuthors($authors){
		$this->authors=$authors;
	}

	//get journal_name
	function getJournal_name(){
		return $this->journal_name;
	}
	//set journal_name
	function setJournal_name($journal_name){
		$this->journal_name=$journal_name;
	}

	//get url
	function getUrl(){
		return $this->url;
	}
	//set url
	function setUrl($url){
		$this->url=$url;
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
	
	//get crpattribution
	function getCrpattribution(){
		return $this->crpattribution;
	}
	//set crpattribution
	function setCrpattribution($crpattribution){
		$this->crpattribution=$crpattribution;
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

	//get valid_data
	function getValid_data(){
		return $this->valid_data;
	}
	//set valid_data
	function setValid_data($valid_data){
		$this->valid_data=$valid_data;
	}

	function add($obj){
		$publicationsDBO = new PublicationsDBO();
		if($publicationsDBO->persist($obj)){
// 			$this->id=$publicationsDBO->id;
// 			$this->sql=$publicationsDBO->sql;


			  $valueid=$publicationsDBO->id;

			$tables = new Tables();
			$tableid = $tables->getTable("publications");
			
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
		$publicationsDBO = new PublicationsDBO();
		if($publicationsDBO->update($obj,$where)){
			$valueid=$obj->id;

			$tables = new Tables();
			$tableid = $tables->getTable("publications");
			
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
		$publicationsDBO = new PublicationsDBO();
		if($publicationsDBO->delete($obj,$where=""))		
			$this->sql=$publicationsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$publicationsDBO = new PublicationsDBO();
		$this->table=$publicationsDBO->table;
		$publicationsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$publicationsDBO->sql;
		$this->result=$publicationsDBO->result;
		$this->fetchObject=$publicationsDBO->fetchObject;
		$this->affectedRows=$publicationsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
