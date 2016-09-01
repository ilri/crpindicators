<?
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Users_class.php");
require_once '../../sys/config/Config_class.php';

$db=new DB();
$users=new Users();

$url=$_GET['url'];
if(!empty($url))
{
	$url=$url;
}

$config = new Config();
$fields=" * ";
$join="  ";
$where="";
$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);

while($con=mysql_fetch_object($config->result)){
	$_SESSION[$con->name]=$con->value;
}

$levelerror=$_GET['levelerror'];
if($levelerror==1)
{
	$levelerror="You do not have the right priviledges to view this page. Login with an Account with higher priviledges.";
	$home="<a href='../'>Go To Home</a>";
}

$obj=(object)$_POST;
if($obj->action=="Login")
{
	$username=trim($obj->username);
	$password=trim($obj->password);
	
	//change to lower case
	$username=strtolower($username);
	//$password=strtolower($password);
	if(empty($username))
	{
	$error="username is required";
	}
	elseif(empty($password))
	{
	$error="password is required";
	}
	else
	{	
		$password=md5($password);
		$fields=" * ";
		$join="  ";
		$where=" where user_login='$username' and user_pass='$password' ";
		$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$user=$users->fetchObject;
		
		if($users->affectedRows==1)
		{
			if(true)
			{
				$per = mysql_fetch_object(mysql_query("select * from crp_periods where id='$obj->periodid'"));
				$user->lastlogin=date("Y-m-d H:i:s");
				//$users->edit($user);
				$_SESSION['username']=$user->user_login;
				$_SESSION['password']=$user->password;
				$_SESSION['level']=$user->levelid;//echo $_SESSION['level'];
				$_SESSION['userid']=$user->id;
				$_SESSION['rec_period']=$per->name;
				$_SESSION['periodid']=$per->id;
				$_SESSION['user_isadmin']=$user->user_isadmin;
				$_SESSION['user_name']=$user->user_name;
				$_SESSION['system']="CRP Indicators";
				
				$us = new Users();
				$ob=$user;
				//$us->edit($ob);
				
				redirect("../../index.php");
			}
			else
			{
				$error="User Account is inactive. Contact Administrator";
			}
		}
		else
		{
		$error="Invalid username and password";
		}
	}
}
include "login.html";


?>
