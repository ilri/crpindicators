<?
session_start();
require_once("lib.php");
require_once 'DB.php';

$db = new DB();

date_default_timezone_set('Africa/Nairobi');

if(empty($_SESSION['userid'])){
	redirect("modules/auth/users/login.php");
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
<title>WiseDigits</title>
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

<link href="css/bootstrap.css" rel="stylesheet">
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
        <ul class="nav">
          <li class="active"><a href="/estate">CRP Indicators</a></li>
          </ul>
          
          
           <div class="topnav">

        <div class="btn-toolbar" style="float:right;">
            
            <div class="btn-group">
                <!--<a data-placement="bottom" data-original-title="E-mail" data-toggle="tooltip" class="btn btn-default btn-sm">
                    <i class="fa fa-envelope"></i>
                    <span class="label label-warning">5</span>
                </a>-->
                <a data-placement="bottom" data-original-title="Messages" href="#" onclick="showPopWin('modules/pm/notificationrecipients/notificationrecipient.php',700,530);" data-toggle="tooltip" class="btn btn-default btn-sm">
                    <i class="fa fa-comments"></i>
    <?php
    $query ="select count(*) msg from pm_notificationrecipients where status='unread' and employeeid in(select employeeid from auth_users where id='".$_SESSION['userid']."')";
    $res=mysql_query($query);
    $notificationrecipients=mysql_fetch_object($res);
    ?>
                    <span class="label label-warning"><?php echo $notificationrecipients->msg; ?></span>
                </a>
            </div>
            <div class="btn-group">
               <!-- <a data-placement="bottom" data-original-title="Document" href="#" data-toggle="tooltip" class="btn btn-default btn-sm">
                    <i class="fa fa-file"></i>
                </a>-->
                <a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#helpModal">
                    <i class="fa fa-question"></i>
                </a>
            </div>
            <div class="btn-group">
                <a href="modules/auth/users/login.php" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
		  <i class="fa fa-power-off"></i>
                </a>
            </div>
        </div>
          
    </div>
      </div>
	 
    </div> 
	<div class="modal" id="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Modal Title Goes Here</h4>
        </div>
        <div class="modal-body">
          Load Data...
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
          <a href="#" class="btn btn-primary">Do Nothing</a>
        </div>
      </div><!-- /.modal-content -->
  </div><!--/.modal-dialog -->
</div><!-- /.modal -->

<div class="container-fluid">
   <div class="row-fluid">
     <div class="span3" style="margin-top:60px;">
<div id="left">
   <div class="media user-media">
    <a class="user-link" href="">
        <img class="media-object img-thumbnail user-img" alt="User Picture" src="img/user.gif">
        <span class="label label-danger user-label">16</span>
    </a>

    <div class="media-body">
    <?php
    $query="select auth_users.id, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) as employeeid, auth_users.username, auth_users.password, auth_levels.name as levelid, auth_users.status, auth_users.lastlogin, auth_users.createdby, auth_users.createdon, auth_users.lasteditedby, auth_users.lasteditedon, hrm_assignments.name assignmentid from auth_users left join hrm_employees on auth_users.employeeid=hrm_employees.id  left join auth_levels on auth_users.levelid=auth_levels.id left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid where auth_users.id='".$_SESSION['userid']."'";
    $row=mysql_fetch_object(mysql_query($query));
    ?>
        <h5 class="media-heading"><?php echo $row->username; ?></h5>
        <ul class="list-unstyled user-info">
            <li><a href=""><?php echo $row->levelid; ?></a></li>
            <li><a href=""><?php echo $row->assignmentid; ?></a></li>
            <li>Last Access : <br>
                <small><i class="fa fa-calendar"><?php echo $row->lastlogin; ?></i></small>
            </li>
        </ul>
    </div>
</div>
</div>
	<!--Sidebar content-->
  
	
     <ul class="nav nav-tabs nav-stacked">
	 	
<li><a href="">MODULES</a></li>
		<?php
		$query="select * from sys_modules where description!='' and id in(select distinct auth_roles.moduleid from auth_roles left join auth_rules on auth_roles.id=auth_rules.roleid where auth_rules.levelid=(select levelid from auth_users where id='".$_SESSION['userid']."')) ";
		$res=mysql_query($query);
		while($row=mysql_fetch_object($res)){
		?>
		<li><a href="modules/<?php echo $row->url; ?>"> <?php echo $row->description; ?></a></li>
		<?php
		}
		?>
	  </ul> 
     
</div>

<div class="container-fluid">
   <div class="row-fluid">
	<div class="span9">
      <!--Body content-->
	  <h2>....</h2>
	  <hr/>


<ul class="modules">

<li><a class="button icon fn" href="modules/tender/tenders/"><span>Tendering</span></a></li>
<li><a class="button icon fn" href="modules/con/projects/"><span>Construction</span></a></li>
<li><a class="button icon fn" href="modules/proc/suppliers/"><span>Procurement</span></a></li>
<li><a class="button icon fn" href="modules/inv/items/"><span>Inventory</span></a></li>
<li><a class="button icon fn" href="modules/fn/generaljournals/"><span>Finance</span></a></li>

<li><a class="button icon hrm" href="modules/hrm/employees/"><span>HRM</span></a></li>
<li><a class="button icon p" href="modules/hrm/employeepayments/"><span>Payroll</span></a></li>
<li><a class="button icon fn" href="modules/pos/sales/"><span>Invoicing</span></a></li>
<li><a class="button icon a" href="modules/auth/users/"><span>Administration</span></a></li>
<li><a class="button icon a" href="modules/dms/documentss/"><span>DMS</span></a></li>
<li><a class="button icon a" href="modules/pm/tasks/"><span>Project Mgt</span></a></li>
<li><a class="button icon wf" href="modules/wf/routes/"><span>Work Flow Mgt</span></a></li>
<li><a class="button icon a" href="modules/assets/assets/"><span>Assets Mgt</span></a></li>
<li><a class="button icon r" href="reports/"><span><u>R</u>eports</span></a></li>
<li><a class="button icon st" href="modules/sys/config/"><span>System Tools</span></a></li>
<li><a class="button icon q" href="modules/auth/users/"><span>Help</span></a></li>
<?php 
if($_SESSION['rentduedate']<=date("d")){
	?><!--<li><a  class="ba" href="modules/em/payables/invoicing.php"><span style="color: #f00;">Batch Invoice</span></a></li>--><?php 
}
?>
</ul>

  <div id="cur-user">
  <img align="left" name="" src="fsimage/default-user.jpg"   />
    <div class="info">
<span class="cur">Currently Logged in as:</span>
<span class="name"><?php echo $_SESSION['username']; ?> 
<?
			if($_SESSION['level']=="1")
            	$level="Administrator";
            elseif($_SESSION['level']=="2")
            	$level="Level 2";
            elseif($_SESSION['level']=="3")
            	$level="Level 3";
            if($_SESSION['level']=="4")
            	$level="Level 4";
        if(!empty($_SESSION['userid']))
		{
        	?>
            &nbsp;[<?php echo $level; ?>]&nbsp;</span>
           	 <div class="links">
             <a href="modules/auth/users/logout.php">Log Out</a></div>
             
             <div class="links">
             <a href="modules/hrm/employeeleaveapplications/addemployeeleaveapplications_proc.php">Leave Apply</a></div>
             <?php 
             $today=date("Y-m-d");
             $query=" select hrm_employeeclockings.* from hrm_employeeclockings  left join auth_users on  auth_users.employeeid=hrm_employeeclockings.employeeid where auth_users.id='".$_SESSION['userid']."' and today='$today' and endtime='00:00:00'";
            	$res=mysql_query($query);
            	if(mysql_affected_rows()>0){
             ?>
             <a href="modules/hrm/employeeclockings/addemployeeclockings_proc.php?clock=clockout"><font color="red">Clock Out</font></a></div>
             <?            
             }
             else{
				?>
             <a href="modules/hrm/employeeclockings/addemployeeclockings_proc.php?clock=clockin">Clock In</a></div>
             <?   
			}
			$query="select inv_issuance.* from inv_issuance left join auth_users on inv_issuance.employeeid=auth_users.employeeid where auth_users.id='".$_SESSION['userid']."'";
			$res=mysql_query($query);
			if(mysql_affected_rows()>0){
				?>
			             <a href="modules/inv/issuance/issuance.php?issued=1">Items Issued</a></div>
			             <?            
			             }
        }
        ?></span></div>
  </div>
  <div class="clearb"></div>
  </div><form name="ind">
  </form>
<div class="clearb"></div>
</div>
</div>
</div>
</div>
<div id="footer">
<div id="footer-inner">
<div id="footer-message">
<p align="center">Licenced to: <strong><?php echo $_SESSION['companyname'];?></strong>
<p align="center">Copyright &copy; <?php echo date("Y"); ?> WiseDigits. All Rights Reserved.</p>
</div>
</div>
<div class="clearb"></div>
</div>
<div class="clearb"></div>
</div>
</div>
</body>
</html>
