<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Rules_class.php");
require_once("../roles/Roles_class.php");
require_once("../levels/Levels_class.php");

$filename="data.txt";
$fd=fopen($filename,"w");

fwrite($fd,'{"aaData":[');
fwrite($fd,"\n");
$i=0;

$roles=new Roles ();
$fields=" * " ;
$where=" where auth_roles.moduleid in(2,3,4,7,11,30,31) ";
$join="";
$having="";
$groupby="";
$orderby=" order by auth_roles.moduleid, auth_roles.id ";
$roles->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$num = $roles->affectedRows;

while($rw=mysql_fetch_object($roles->result)){
$i++;
fwrite($fd,'["'.$i.'","'.initialCap($rw->name).'",');
	$levels=new Levels ();
	$fields=" * " ;
	$where="  " ;
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$str="";
	while($rw1=mysql_fetch_object($levels->result)){
		$rules= new Rules ();
		$fields=" * ";
		$where = " where roleid=$rw->id and levelid=$rw1->id "; 
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$rules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$arr=array('roleid'=>$rw->id, 'levelid'=>$rw1->id);

		$sarr=rawurlencode(serialize($arr));
		
		$st="";
		if($rules->affectedRows>0){$st= 'checked';}
		
		if($rw->id==1 and $rw1->id==1){
		  $link="<input type='checkbox' name='$rw->id$rw1->id' $st onchange='addMatrix(this,$rw1->id,$rw->id,&quot;field&quot;,this.value,&quot;$sarr&quot;);' disabled>";
		
		}
		else{
		  $link="<input type='checkbox' name='$rw->id$rw1->id' $st onchange='addMatrix(this,$rw1->id,$rw->id,&quot;field&quot;,this.value,&quot;$sarr&quot;);'>";
		}
		$str.='"'.$link.'",';
	}
	$str=substr($str,0,-1);
	fwrite($fd,$str);
	fwrite($fd,']');
	
	if($i<$num)
	{
		fwrite($fd,",\n");
	}
	else
	{
		fwrite($fd,"\n");
	}
	
}
fwrite($fd,"]}");
fclose($fd);

?>