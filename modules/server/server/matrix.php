<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

$module = $_GET['module'];
$main = $_GET['main'];
$field = $_GET['field'];
$value = $_GET['value'];
$arr=$_GET['arr'];

$arr=str_replace("\\", "", $arr);

$arr=unserialize(rawurldecode($arr));
$arr2=$arr;
if($field!="field")
	$arr[$field]=$value;

$url=explode("_",$module);
require_once("../../$url[0]/$url[1]/".trim(initialCap($url[1]))."_class.php");

$md=trim(initialCap($url[1]));

$mod=new $md;
$db=new DB();

$ob=(object)$arr;

$where=" where ";
$fields=" * ";
$ar=array_keys($arr2);
for($i=0;$i<count($ar);$i++){
	$key=$ar[$i];
	if($i>0)
		$where.=" and ";
	$where.="$key = $arr2[$key]";
}
$mod->retrieve($fields, $join, $where, $having, $groupby, $orderby);echo $mod->sql;

$obj=$mod->fetchObject;

$ob->id=$obj->id;
$ob->createdby=$_SESSION['userid'];
$ob->createdon=date("Y-m-d H:i:s");
$ob->lasteditedby=$_SESSION['userid'];
$ob->lasteditedon=date("Y-m-d H:i:s");
if($mod->affectedRows>0 and $field!="field")
	$mod->edit($ob);
elseif($mod->affectedRows>0 and $field=="field")
	$mod->delete($ob);
else
	$mod->add($ob);
?>
