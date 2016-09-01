<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Groupmodule_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../../crp/groups/Groups_class.php");
require_once("../../crp/tables/Tables_class.php");

$page_title="Groupmodule";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8886";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$groupmodule=new Groupmodule();
if(!empty($delid)){
	$groupmodule->id=$delid;
	$groupmodule->delete($groupmodule);
	redirect("groupmodule.php");
}
?>
<script type="text/javascript">
	function addMatrix(str,xaxis,yaxis,field,value,arr)
	{
		if(str.checked)
	{
		var checked=1;
	}
	else
	{
		var checked=0;
	}
	if (str=="")
	{
	document.getElementById("txtHint").innerHTML="";
	return;
	 }
	if (window.XMLHttpRequest)
	{
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	 }
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	 {
	 document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
	 }
	}
	<?php $groupmodule= new Groupmodule(); ?>
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=crp_groupmodule";
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}
	</script>

<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<th>#</th>
		<th>&nbsp;</th>
	<?php
	$groups=new Groups();
	$fields=" * " ;
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$groups->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($groups->result)){
	?>
		<th><?php echo initialCap($rw->group_name); ?></th>
	<?php
	}
	?>
	</thead>
	<tbody>
	<?php
	$i=0;
	$tables=new Tables();
	$fields=" * " ;
	$where="";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by position ";
	$tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($tables->result)){
	$i++;
	?>
	<tr>
		<td><?php echo initialCap($i); ?></td>
		<td><?php echo initialCap($rw->name); ?> (<?php echo $rw->indicator; ?>)</td>
	<?php
		$groups=new Groups();
		$fields=" * " ;
		$where="  " ;
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$groups->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		while($rw1=mysql_fetch_object($groups->result)){
			$groupmodule= new Groupmodule();
			$fields=" * ";
			$where = " where tableid=$rw->id and groupid=$rw1->id "; 
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$groupmodule->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$arr=array('tableid'=>$rw->id, 'groupid'=>$rw1->id);

			$sarr=rawurlencode(serialize($arr));

			?>
			<td><input type='checkbox' name="<?php echo $rw->id; ?><?php echo $rw1->id; ?>" <?php if($groupmodule->affectedRows>0){echo "checked";}?> onchange="addMatrix(this,<?php echo $rw1->id; ?>,<?php echo $rw->id; ?>,'field',this.value,'<?php echo $sarr; ?>');" ></td>
			<?php
		}
		?>
	</tr>
		<?php
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
