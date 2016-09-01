<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

$tbl = $_GET['tbl'];

$db = new DB();

$query="update crp_$tbl set valid_data=1 where valid_data='' ";
mysql_query($query);echo mysql_error();
redirect("index.php");
?>