<?php
session_start();
require_once("../../../lib.php");
require_once("../../../DB.php");
require_once("../tables/Tables_class.php");

$page_title="Crp";
include"../../../head.php";

$db = new DB();

?>



<ul class="stats_box">
	<?php 
	$tables = new Tables();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by position ";
	$tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res=$tables->result;
	while($row=mysql_fetch_object($res)){
	
	if(checkGroup($row->name)){ ?>
	<li>
	<div class="stat_text">
	<a href="../../crp/<?php echo $row->name; ?>/<?php echo $row->name; ?>.php"><?php echo $row->title; ?></a><?php echo getRecords($row->name); ?>
	</div>
	</li>
	<?php
	}
	}
	?>	
	<?php if($_SESSION['user_isadmin']==1){ ?>
	<li><div class="stat_text"><a href="../../crp/crpuser/crpuser.php">CRP User</a></div></li>
	<li><div class="stat_text"><a href="../../crp/users/users.php">Users</a></div></li>
	<li><div class="stat_text"><a href="../../crp/groups/groups.php">Groups</a></div></li>
	<li><div class="stat_text"><a href="../../crp/usergroup/usergroup.php">User Groups</a></div></li>
	<li><div class="stat_text"><a href="../../crp/crps/crps.php">CRPs</a></div></li>
	<li><div class="stat_text"><a href="../../crp/tables/tables.php">Indicators</a></div></li>
	<li><div class="stat_text"><a href="../../crp/tablecols/tablecols.php">Indicator Fields</a></div></li>
	<li><div class="stat_text"><a href="../../crp/crptables/crptables.php">CRP Indicators</a></div></li>
	<li><div class="stat_text"><a href="../../crp/agroecologicalzones/agroecologicalzones.php">Agroecological Zones</a></div></li>
	<li><div class="stat_text"><a href="../../crp/themes/themes.php">Indicator Categories</a></div></li>
	<li><div class="stat_text"><a href="../../crp/valuechains/valuechains.php">Indicator Sub Categories</a></div></li>
	<li><div class="stat_text"><a href="../../crp/groupthemes/groupthemes.php">Group Categories</a></div></li>
	<li><div class="stat_text"><a href="../../crp/groupvaluechains/groupvaluechains.php">Group Sub Categories</a></div></li>
	<li><div class="stat_text"><a href="../../crp/centers/centers.php">Centers</a></div></li>
	<li><div class="stat_text"><a href="../../crp/periods/periods.php">Periods</a></div></li>
	<?php }?>
	
	<li><div class="stat_text"><a href="../../crp/tablecols/excel.php">Excel Template</a></div></li>
</ul>
<?php
include"../../../foot.php";
?>
