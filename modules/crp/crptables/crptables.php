<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Crptables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../../crp/crps/Crps_class.php");
require_once("../../crp/tables/Tables_class.php");

$page_title="Crptables";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9011";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$crptables=new Crptables();
if(!empty($delid)){
	$crptables->id=$delid;
	$crptables->delete($crptables);
	redirect("crptables.php");
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
	<?php $crptables= new Crptables(); ?>
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=crp_crptables";
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}
	</script>

<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<th>#</th>
		<th>&nbsp;</th>
	<?php
	$crps=new Crps();
	$fields=" * " ;
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($crps->result)){
	?>
		<th><?php echo substr($rw->crp_name,0,20); ?> </th>
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
	$orderby=" order by position";
	$tables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($tables->result)){
	$i++;
	?>
	<tr>
		<td><?php echo initialCap($i); ?></td>
		<td><?php echo initialCap($rw->name); ?> (<?php echo $rw->indicator; ?>) </td>
	<?php
		$crps=new Crps();
		$fields=" * " ;
		$where="  " ;
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		while($rw1=mysql_fetch_object($crps->result)){
			$crptables= new Crptables();
			$fields=" * ";
			$where = " where tableid=$rw->id and crpid=$rw1->id "; 
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$crptables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$arr=array('crpid'=>$rw1->id, 'tableid'=>$rw->id);

			$sarr=rawurlencode(serialize($arr));

			?>
			<td><input type='checkbox' name="<?php echo $rw->id; ?><?php echo $rw1->id; ?>" <?php if($crptables->affectedRows>0){echo "checked";}?> onchange="addMatrix(this,<?php echo $rw1->id; ?>,<?php echo $rw->id; ?>,'field',this.value,'<?php echo $sarr; ?>');" ></td>
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
