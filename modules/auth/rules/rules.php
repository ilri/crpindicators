<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Rules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../../auth/levels/Levels_class.php");
require_once("../../auth/roles/Roles_class.php");

$page_title="Rules";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="10";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$rules=new Rules();
if(!empty($delid)){
	$rules->id=$delid;
	$rules->delete($rules);
	redirect("rules.php");
}
?>
<script type="text/javascript" charset="utf-8">
function loadTableFunction(){
  $(document).ready(function() {
	  TableToolsInit.sSwfPath = "../../media/swf/ZeroClipboard.swf";
	  $('#tbl').dataTable( {
		    "bProcessing": true,
		    "sScrollY": 500,
		    "bJQueryUI": true,
		    "sPaginationType": "full_numbers",
		    "sScrollX": "100%",
		    "sScrollXInner": "100%",
		    "sAjaxSource": 'data.txt',
	    } );
  } );
}
function getContent()
{
    request = getHTTPObject();
    request.onreadystatechange = sendData;
    request.open("GET", "data.php", true);
    request.send(null);
}

function getHTTPObject()
{
    var xhr = false;
    if (window.XMLHttpRequest)
    {
        xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        try
        {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(e)
        {
            try
            {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(e)
            {
                xhr = false;
            }
        }
    }
    return xhr;
}

function sendData()
{
    if(request.readyState == 4)
    {
        //document.write(request.responseText);
		loadTableFunction(request.responseText);
    }
    else if(request.readyState == 1)
    {
        //dC.innerHTML = "<img src="loading.gif" alt="" /> Requesting content..."
    }
}
getContent();
womAdd('getContent()');
womOn();
</script> 
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
	<?php $rules= new Rules (); ?>
	var url="../../server/server/matrix.php?checked="+checked+"&arr="+arr+"&xaxis="+xaxis+"&yaxis="+yaxis+"&field="+field+"&value="+value+"&module=auth_rules";
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}
	</script>

<table style="clear:both;"  class="tgrid display" id="tbl" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<th>#</th>
		<th>&nbsp;</th>
	<?php
	$levels=new Levels ();
	$fields=" * " ;
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	while($rw=mysql_fetch_object($levels->result)){
	?>
		<th><?php echo initialCap($rw->name); ?></th>
	<?php
	}
	?>
	</thead>
	<tbody>

	</tbody>
</table>
<?php
include"../../../foot.php";
?>
