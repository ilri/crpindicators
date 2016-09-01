<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

$ob = (object)$_GET;

$db = new DB();

$value="";

if(empty($ob->valid_data))
	$value=1;

$query="update crp_$ob->tbl set valid_data='$value' where id='$ob->id' ";
mysql_query($query);echo mysql_error();
redirect("../$ob->tbl/$ob->tbl.php");
?>
