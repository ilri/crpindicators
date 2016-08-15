<?
session_start();
require_once("lib.php");
require_once 'DB.php';
//require_once("modules/crp/crps/Crps_class.php");

$_SESSION['crpid']="";

$db = new DB();

$obj = (object)$_POST;

if($obj->action=="Load"){
  if(!empty($obj->crpid)){
    $_SESSION['crpid']=$obj->crpid;
    
    $query="select * from crp_crps where id='$obj->crpid'";
    $crps = mysql_fetch_object(mysql_query($query));
    
    $_SESSION['crp']=$crps->crp_name;
    
    redirect("modules/crp/crp/");
   }else{
    showError("Must select CRP");
   }
}

date_default_timezone_set('Africa/Nairobi');

if(empty($_SESSION['userid'])){
	redirect("modules/crp/users/login.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="js/jquery-1.7.1.js" type="text/javascript"></script>
<script src="js/ui/jquery-ui.js"></script>
<script src="js/functions.js"></script>

<script type="text/javascript" language="javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" type="text/css" href="js/jquery-ui-timepicker-addon.css" />


<script language="javascript" src="j-modal/js/jqmodal.js" type="text/javascript" ></script>
<script language="javascript" src="j-modal/js/jqDnR.js" type="text/javascript"></script>
<script language="javascript" src="js/tabIndex.js" type="text/javascript"></script> 
<script language="javascript" type="text/javascript" src="js/jquery.ifixpng.js"></script>
<script language="javascript" type="text/javascript" src="lkimage/jquery.autocomplete.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="js/cal.js"></script>
<script type="text/javascript" src="js/shortcut.js"></script>
<script type="text/javascript" src="js/womon.js"></script>
<link rel="stylesheet" type="text/css" href="dmodal/style.css" />
<link rel="stylesheet" type="text/css" href="dmodal/subModal.css" />
<script type="text/javascript" src="dmodal/common.js"></script>
<script type="text/javascript" src="dmodal/subModal.js"></script>  
	
	<script src="js/jquery.bgiframe-2.1.2.js"></script>

	<script src="js/ui/jquery.ui.core.js"></script>
	<script src="js/ui/jquery.ui.widget.js"></script>
	<script src="js/ui/jquery.ui.mouse.js"></script>
	<script src="js/ui/jquery.ui.button.js"></script>
	<script src="js/ui/jquery.ui.draggable.js"></script>
	<script src="js/ui/jquery.ui.position.js"></script>
	<script src="js/ui/jquery.ui.resizable.js"></script>
	<script src="js/ui/jquery.ui.dialog.js"></script>
	<script src="js/ui/jquery.effects.core.js"></script>
	<script src="js/ui/jquery.ui.tabs.js"></script>
	<script>
	$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			modal: true,

		});

		$( "#nyef" )
			.button()
			.click(function() {
				$( "#dialog-form" ).dialog( "open" );
			});
	});
	</script>

<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>

		<script>
		jQuery(document).ready(function () {
			$('input.date_input').datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange:  '1930:2100',
					dateFormat: 'yy-mm-dd'
				});
			});
	</script>

<script language="javascript" type="text/javascript">
function checkDate(field){
	var allowBlank = true; var minYear = 1902; var maxYear = 2099; 
	var errorMsg = ""; 
// regular expression to match required date format 
	//re = /^(\d{4})\/(\d{1,2})\/(\d{1,2})$/; 
	re = /^(\d{4})-(\d{1,2})-(\d{1,2})/;
	if(field.value != ''){
		if(regs = field.value.match(re)) { 
			if(regs[3] < 1 || regs[3] > 31) { 
				errorMsg = "Invalid value for day: " + regs[3];
			} 
			else if(regs[2] < 1 || regs[2] > 12) { 
				errorMsg = "Invalid value for month: " + regs[2]; 
			} else if(regs[1] < minYear || regs[1] > maxYear) { 
				errorMsg = "Invalid value for year: " + regs[1] + " - must be between " + minYear + " and " + maxYear; 
			} 
		 } 
		 else { 
		 	errorMsg = "Invalid date format: " + field.value; 
		} 
	} 
	else if(!allowBlank) { 
		errorMsg = "Empty date not allowed!"; 
	} 
	if(errorMsg != "") {
		 alert(errorMsg); field.focus(); 
		 return false; 
		} 
	return true; 
}
</script>
<script type="text/javascript">
<!--
function showmenu(id){
var s = document.getElementById(id).style;
s.visibility='visible'; 
}
//-->
function timeOut(id){
setTimeout('hideShow("'+id+'")',3000)
}
function hideShow(id){
var s = document.getElementById(id).style;
s.visibility=s.visibility=='hidden'?'visible':'hidden'; 
} 
</script>
<script language="javascript" type="text/javascript">
var newwindow;
function poptastic(url,h,w)
{
	var ht=h;
	var wd=w;
	newwindow=window.open(url,'name','height='+ht+',width='+wd+',scrollbars=yes,left=250,top=80');
	if (window.focus) {newwindow.focus()}
}

function placeCursorOnPageLoad()
{
	if(document.stores)
		showUser();
	document.cashsales.itemname.focus();
		
}
</script>
<!-- TemplateBegin<img src="../edit.png" alt="edit" title="edit" />able name="doctitle" -->
<title>CRP INDICATORS</title>
<!-- TemplateEnd<img src="../edit.png" alt="edit" title="edit" />able -->
<script language="javascript" type="text/javascript">
$(document).ready(function(){
var t = $('#ex4 div.jqmdMSG');
$('#ex4').jqm({
		trigger: 'a.addpop',
		ajax: '@href', /* Extract ajax URL from the 'href' attribute of triggering element */
		target: t,
		modal: true, /* FORCE FOCUS */
		onHide: function(h) { 
			t.html('Please Wait...');  // Clear Content HTML on Hide.
			h.o.remove(); // remove overlay
			h.w.fadeOut(888); // hide window
		},
		overlay: 0}).jqmHide();
$('a.addpop').bind('click',function(){
		var x = $('a.addpop').attr('rel');
		var y = []; 
		y = x.split(',');
		var jWidth = y[0]+'px';
		var jHeight = y[1]+'px';
		$('.jqmdBC').css({'width':jWidth,'height':jHeight});
		return false;
});
$('#ex4').jqDrag('.jqDrag').jqResize('.jqResize');	

	   if($.browser.msie)
		$('input')
		  .focus(function(){$(this).addClass('iefocus');})
		  .blur(function(){$(this).removeClass('iefocus');})
 });
</script>	
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$('#formbox').hide();
	$("#uselog").click(function(){
		$(this).next("#formbox").animate({opacity:"show", top: "50"},"slow");
	});
	$("a#slick-hide").click(function(){
		$('#formbox').hide('fast');
		return false;
	});

});
</script>
<!-- thecss -->
<link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
<link href="css/fa/css/font-awesome.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="fs-css/elements.css" media="all" type="text/css" rel="stylesheet" /> 
<link href="fs-css/html-elements.css" media="all" type="text/css" rel="stylesheet" /> 
<link href="css/bootstrap.min.css" rel="stylesheet">  
<!--  theCssEnd -->
	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="css/datepicker.css" rel="stylesheet">
	<link href="css/fa/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="css/fa/datatables/demo_page.css">	
	<link href="lkimage/jquery.autocomplete.css" media="all" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" href="css/fa/datatables/css/DT_bootstrap.css">
	<link rel="stylesheet" href="css/lib/datepicker/css/datepicker.css">
	<link href="css/main.css" rel="stylesheet">
	<link href="fs-css/elements.css" media="all" type="text/css" rel="stylesheet" />
	<link href="fs-css/html-elements.css" media="all" type="text/css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" language="javascript" src="media/js/TableTools.js"></script>


<!-- TemplateBegin<img src="../edit.png" alt="edit" title="edit" />able name="head" -->
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	TableToolsInit.sSwfPath = "media/swf/ZeroClipboard.swf";
	$('#example').dataTable( {
		"sScrollY": 500,
		"bJQueryUI": true,
		"iDisplayLength": 200,
		"sPaginationType": "full_numbers"
	} );
} );
</script> 
<!-- TemplateEnd<img src="../edit.png" alt="edit" title="edit" />able -->
<style media="all" type="text/css">
#navamenu
{
visibility:hidden;
}
</style>

</head>
<?php
if (get_magic_quotes_gpc()){
 $_GET = array_map('stripslashes', $_GET);
 $_POST = array_map('stripslashes', $_POST);
 $_COOKIE = array_map('stripslashes', $_COOKIE);
}
?>
<body>
       
<div class='navbar'>

      <div class='navbar-inner nav-collapse' style="height: auto;">

    <div class="topnav">

        <div class="btn-toolbar">
            <div class="btn-group">
                <a data-placement="bottom" data-original-title="Back" data-toggle="tooltip" class="btn btn-success btn-sm" href="./">
                    <i class="fa fa-resize-horizontal"></i>
                </a>
            </div>

            <div class="btn-group">
                <a href="modules/crp/users/logout.php" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
		  <i class="fa fa-power-off"></i>
                </a>
            </div>
        </div>


    </div>
<!-- /.topnav -->
        <!-- .nav -->
            <ul class="nav navbar-nav">
            <li><a href="">CRP Indicators</a></li>
            <li><a href="modules/crp/targets/targets.php">CRP Targets</a></li>
            <li><a href="#">CRP:&nbsp;<?php echo $_SESSION['crp'];?></a></li>
            <li><a href="#">Period: <?php echo $_SESSION['rec_period'];?></a></li>
            
        </ul>
        <!-- /.nav -->
 
    </div>
      </div>
      

   <div class="clear"></div> 
   
<div >
 <div class="span4">

<!-- <div id="left">
   <div class="media user-media">
    <a class="user-link" href="">
        <img class="media-object img-thumbnail user-img" alt="User Picture" src="../../../img/user.gif">
        <span class="label label-danger user-label">16</span>
    </a>

    <div class="media-body">
    <?php
    $query="select auth_users.id, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) as employeeid, auth_users.username, auth_users.password, auth_levels.name as levelid, auth_users.status, auth_users.lastlogin, auth_users.createdby, auth_users.createdon, auth_users.lasteditedby, auth_users.lasteditedon from auth_users left join hrm_employees on auth_users.employeeid=hrm_employees.id  left join auth_levels on auth_users.levelid=auth_levels.id where auth_users.id='".$_SESSION['userid']."'";
    $row=mysql_fetch_object(mysql_query($query));
    ?>
        <h5 class="media-heading"><?php echo $row->username; ?></h5>
        <ul class="list-unstyled user-info">
            <li><a href=""><?php echo $row->levelid; ?></a></li>
            <li>Last Access : <br>
                <small><i class="fa fa-calendar"><?php echo $row->lastlogin; ?></i></small>
            </li>
        </ul>
    </div>
</div>
</div>

     
</div>-->
 
 
 
 </div><!-- sidebarEnd -->
<div class="container">


<?php
$query="select distinct crp_crps.id, crp_crps.crp_name name,crp_crps.crpno from crp_crpuser left join crp_crps on crp_crps.id=crp_crpuser.crp_id where userid='".$_SESSION['userid']."' order by crp_crps.crpno";
$res=mysql_query($query);
$rs=$res;
if(mysql_affected_rows()>1){
?>

<div style="padding:20px;margin-left:270px;">
<img src="images/lg.jpg" width="180" height="420" alt="" />
</div>

<div style="margin-left:200px;">
<form action="" method="post">
<table width="100%" align="center">
  <tr>
    <td align="right">CRPs</td>
    <td><select name='crpid' style="width:200px;">
      <option value="">Select...</option>
    <?php
    while($row=mysql_fetch_object($res)){
    ?>
	<option value='<?php echo $row->id; ?>'><?php echo $row->crpno." ".$row->name; ?></option>
    <?php
    }
    ?>
    </select>&nbsp;<input class="btn btn-warning" type="submit" name="action" value="Load"/></td>
  </tr>
</table>
</form>
</div>
<?php
}
else{
  $row=mysql_fetch_object($rs);
  $_SESSION['crpid']=$row->id;
  
  $query="select * from crp_crps where id='$row->id'";
    $crps = mysql_fetch_object(mysql_query($query));
    
    $_SESSION['crp']=$crps->crp_name;
  redirect("modules/crp/crp/");
}
?>
<ul class="modules">
<?php if(modularAuth(30,$_SESSION['level'])){?>
<li><a class="button icon fn" href="modules/prod/plantings/"><span>Modules</span></a></li>

<?php }if(true){?>
<?php
  if(!empty($_SESSION['crpid'])){
?>
<li><a class="button icon r" href="modules/crp/crp/"><span>Modules</span></a></li>
<?php }}if(modularAuth(3,$_SESSION['level'])){?>
<li><a class="button icon st" href="modules/sys/config/"><span>System Tools</span></a></li>
<?php }?>

</ul>

  
</div>
</div>
<div id="footer">
<div id="footer-inner">
<div id="footer-message">
<!--<p align="center">Licenced to: <strong><?php echo $_SESSION['companyname'];?></strong>
<p align="center">Copyright &copy; <?php echo date("Y"); ?> WiseDigits. All Rights Reserved.</p>-->
</div>
</div>
<div class="clearb"></div>
</div>
<div class="clearb"></div>
</div>
</div>
</div>
</body>
</html>
