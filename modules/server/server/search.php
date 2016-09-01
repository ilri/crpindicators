<?php
require_once("../../../DB.php");
require_once("../../../lib.php");

$module=trim($_GET['module']);
$main=trim($_GET['main']);
$field=trim($_GET['field']);
$extra=trim($_GET['extra']);
$extratitle=trim($_GET['extratitle']);
logging("Here");
$str="../../../modules/".$main."/".$module."/".trim(initialcap($module))."_class.php";

require_once($str);

$q = strtolower($_GET['q']);
if(!empty($_GET['where']))
	$wher=" and ".$_GET['where'];
if (!$q) return;

//connect to db
$db=new DB();
$md=trim(initialCap($module));

$field = str_replace("\\", "", $field);

$mod=new $md;
$m=$main."_".$module;
$fields=" $field as name, $m.* ";

if(!empty($extra))
	$fields.=", $extra $extratitle ";

$join=str_replace("'", "", $_GET['join']);
$join = str_replace("\\", "", $join);
$having="";
$groupby="";
$orderby="";
$where=" where lower($field) like lower('%$q%') ".$wher;
$mod->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$res=$mod->result;
$str="";
if(mysql_affected_rows()>0){
	while($row=mysql_fetch_array($res)){
 	$rs=mysql_query("desc $mod->table");
 	
 	$st=$row['name']."|";
 	while($rw=mysql_fetch_array($rs)){
   		$st.=$row[$rw[0]]."|";
 	}
 	$st.=$row[$extratitle]."|";
 	$str.=substr($st,0,-1)."
";
	}
}
else
	$str="No Rows Selected";
echo $str;
?>
