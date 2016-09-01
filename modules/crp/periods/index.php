<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");

$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$orderby=" order by priority ";
$having="";
$where=" where name='crp_periods'";
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;


include"../../../head.php";
?>
<ul id="cmd-buttons">
<?php
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where indx='crp_periods' and status=1";
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
while($row=mysql_fetch_object($submodules->result)){
?>
		<li><a class="button icon chat" href="<?php echo trim($row->url); ?>"><?php echo trim(initialCap($row->description)); ?></a></li>
<?php
}
?>
</ul>
<?php

include "../../../foot.php";
?>
