<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Crpuser_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../../crp/users/Users_class.php");
require_once("../../crp/crps/Crps_class.php");

$page_title="Crpuser";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8878";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$id = $_GET['id'];

$crpuser=new Crpuser();
if(!empty($delid)){
	$crpuser->id=$delid;
	$crpuser->delete($crpuser);
	redirect("crpuser.php");
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
	<?php $crpuser= new Crpuser(); ?>
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=crp_crpuser";
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}
	</script>

<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<th>#</th>
		<th>&nbsp;</th>
	<?php
	$users=new Users();
	$fields=" * " ;
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id in($id)  " ;
	$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($users->result)){
	?>
		<th><?php echo $rw->user_login; ?></th>
	<?php
	}
	?>
	</thead>
	<tbody>
	<?php
	$i=0;
	$crps=new Crps();
	$fields=" * " ;
	$where="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$crps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($crps->result)){
	$i++;
	?>
	<tr>
		<td><?php echo initialCap($i); ?></td>
		<td><?php echo initialCap($rw->crp_name); ?></td>
	<?php
		$users=new Users();
		$fields=" * " ;
		$where=" where id in($id)  " ;
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		while($rw1=mysql_fetch_object($users->result)){
			$crpuser= new Crpuser();
			$fields=" * ";
			$where = " where crp_id=$rw->id and userid=$rw1->id "; 
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$crpuser->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$arr=array('userid'=>$rw1->id, 'crp_id'=>$rw->id);

			$sarr=rawurlencode(serialize($arr));

			?>
			<td><input type='checkbox' name="<?php echo $rw->id; ?><?php echo $rw1->id; ?>" <?php if($crpuser->affectedRows>0){echo "checked";}?> onchange="addMatrix(this,<?php echo $rw1->id; ?>,<?php echo $rw->id; ?>,'field',this.value,'<?php echo $sarr; ?>');" ></td>
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
