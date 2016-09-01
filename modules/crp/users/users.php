<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Users_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Users";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8962";//View
$auth->levelid=$_SESSION['level'];

$obj = (object)$_POST;

if(!empty($obj->action)){
  
  $id="";
  $users = new Users();
  $fields="*";
  $join=" ";
  $having="";
  $groupby="";
  $orderby="";
  $where="";
  $users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  while($row=mysql_fetch_object($users->result)){
    if(isset($_POST[$row->id]))
      $id.=$row->id.",";
  }
  
  $id=substr($id,0,-1);
  
  if($obj->action=="CRPs"){
    redirect("../crpuser/crpuser.php?id=".$id);
  }
  if($obj->action=="Groups"){
    redirect("../usergroup/usergroup.php?id=".$id);
  }
}

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$users=new Users();
if(!empty($delid)){
	$users->id=$delid;
	$users->delete($users);
	redirect("users.php");
}
//Authorization.
$auth->roleid="8961";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addusers_proc.php',600,430);" value="Add Users " type="button"/></div>
<?php }?>

<form action="users.php" method="post">
<table>

<tr>
  <td><input type="submit" name="action" value="CRPs"/></td>
  <td><input type="submit" name="action" value="Groups"/></td>
</tr>

</table>

<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;</th>
			<th>Name </th>
			<th>Username </th>
			<th>Email </th>
			<th>Is admin? </th>
			<th>Center </th>
			<th>Group(s) </th>
<?php
//Authorization.
$auth->roleid="8963";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8964";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="crp_users.id, crp_users.user_login, crp_users.user_name, crp_users.user_pass, crp_users.user_email, case when crp_users.user_isadmin=1 then 'Yes' else 'No' end user_isadmin, crp_centers.name as centerid";
		$join=" left join crp_centers on crp_users.centerid=crp_centers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$users->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><input type="checkbox" name="<?php echo $row->id; ?>" value="1"/>
			<td><?php echo $row->user_name; ?></td>
			<td><?php echo $row->user_login; ?></td>
			<td><?php echo $row->user_email; ?></td>
			<td><?php echo $row->user_isadmin; ?></td>
			<td><?php echo $row->centerid; ?></td>
			<td><?php echo $row->groupid; ?></td>
<?php
//Authorization.
$auth->roleid="8963";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addusers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8964";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='users.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
</form>

<?php
include"../../../foot.php";
?>
