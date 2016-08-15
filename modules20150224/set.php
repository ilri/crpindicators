<?php
session_start();
require_once("../lib.php");

$obj = (object)$_GET;

$_SESSION[$obj->name]=$obj->id;
logging("Here".$obj->id);
?>