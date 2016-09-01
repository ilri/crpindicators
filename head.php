<?php
require_once("../../../DB.php");
require_once("../../../modules/pm/notificationrecipients/Notificationrecipients_class.php");

$db = new DB();

$per = $_POST['periodid'];
if(!empty($per)){
	$_SESSION['periodid']=$per;
	$obj->periodid=$per;
	$period = mysql_fetch_object(mysql_query("select * from crp_periods where id='$per'"));
	$_SESSION['rec_period']=$period->name;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<script language="javascript" type="text/javascript" src="../../../js/jquery-1.3.2.min.js"></script>
<script src="../../../js/jquery-1.9.1.js"></script>
<script src="../../../js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="../../../js/jquery-1.7.1.js" type="text/javascript"></script>-->
<script type="text/javascript" language="javascript" src="../../../js/jquery.js"></script>
<script src="../../../js/ui/jquery-ui.js"></script>
<script src="../../../js/functions.js"></script>


<script type="text/javascript" language="javascript" src="../../../js/jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" type="text/css" href="../../../js/jquery-ui-timepicker-addon.css" />

<script type="text/javascript" src="../../../js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="../../../js/bootstrap-datetimepicker.min.js"></script>


<script language="javascript" src="../../../j-modal/js/jqmodal.js" type="text/javascript" ></script>
<script language="javascript" src="../../../j-modal/js/jqDnR.js" type="text/javascript"></script>
<script language="javascript" src="../../../js/tabIndex.js" type="text/javascript"></script> 
<script language="javascript" type="text/javascript" src="../../../js/jquery.ifixpng.js"></script>
<script language="javascript" type="text/javascript" src="../../../lkimage/jquery.autocomplete.js"></script>
<script language="javascript" type="text/javascript" src="../../../js/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="../../../js/cal.js"></script>
<script type="text/javascript" src="../../../js/shortcut.js"></script>
<script type="text/javascript" src="../../../js/womon.js"></script>
<link rel="stylesheet" type="text/css" href="../../../dmodal/style.css" />
<link rel="stylesheet" type="text/css" href="../../../dmodal/subModal.css" />
<script type="text/javascript" src="../../../dmodal/common.js"></script>
<script type="text/javascript" src="../../../dmodal/subModal.js"></script>  
	
	<script src="../../../js/jquery.bgiframe-2.1.2.js"></script>

	<script src="../../../js/ui/jquery.ui.core.js"></script>
	<script src="../../../js/ui/jquery.ui.widget.js"></script>
	<script src="../../../js/ui/jquery.ui.mouse.js"></script>
	<script src="../../../js/ui/jquery.ui.button.js"></script>
	<script src="../../../js/ui/jquery.ui.draggable.js"></script>
	<script src="../../../js/ui/jquery.ui.position.js"></script>
	<script src="../../../js/ui/jquery.ui.resizable.js"></script>
	<script src="../../../js/ui/jquery.ui.dialog.js"></script>
	<script src="../../../js/ui/jquery.effects.core.js"></script>
	<script src="../../../js/ui/jquery.ui.tabs.js"></script>
	
	<!-- validation -->
<script src="../../../js/tobechanged.js"></script>
<link rel="stylesheet" href="../../../js/validationengine/css/validationEngine.jquery.css">

<script src="../../../js/validationengine/js/jquery.validationEngine.js"></script>
<script src="../../../js/validationengine/js/languages/jquery.validationEngine-en.js"></script>
<script src="../../../js/jquery-validation-1.11.1/dist/jquery.validate.min.js"></script>
<script src="../../../js/jquery-validation-1.11.1/localization/messages_ja.js"></script>
<script src="../../../js/jquery.popupwindow.js"></script>

<script>
   $(function() { formValidation(); });
</script>
<!-- validationEnd -->
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
<title>CRP Indicators</title>
<!-- TemplateEnd<img src="../edit.png" alt="edit" title="edit" />able -->

<link href="../../../css/bootstrap.css" rel="stylesheet">
<link href="../../../css/bootstrap.min.css" rel="stylesheet">
	<link href="../../../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="../../../css/datepicker.css" rel="stylesheet">
	<link href="../../../css/fa/css/font-awesome.css" rel="stylesheet">
<!-- 	<link rel="stylesheet" href="../../../css/fa/datatables/demo_page.css">	 -->
	<link href="../../../lkimage/jquery.autocomplete.css" media="all" type="text/css" rel="stylesheet" />
<!-- 	<link rel="stylesheet" href="../../../css/fa/datatables/css/DT_bootstrap.css"> -->
	<link rel="stylesheet" href="../../../css/lib/datepicker/css/datepicker.css">
	<link href="../../../css/main.css" rel="stylesheet">
	<link href="../../../fs-css/elements.css" media="all" type="text/css" rel="stylesheet" />
	<link href="../../../fs-css/html-elements.css" media="all" type="text/css" rel="stylesheet" />
	<style type="text/css" title="currentStyle">
@import "../../../css/demo_page.css";
@import "../../../css/demo_table_jui.css";
@import "../../../css/demo_table.css";
@import "../../../css/jquery-ui-1.8.4.custom.css";
@import "../../../media/css/TableTools.css";
</style>

<script type="text/javascript" language="javascript" src="../../../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../../media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" language="javascript" src="../../../media/js/TableTools.js"></script>
<script src="../../../js/bootstrap.js"></script>

<!-- <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"> -->
<link rel="stylesheet" type="text/css" href="../../../css/jquery-ui.css.css">
		<link rel="stylesheet" type="text/css" href="../../../css/dataTables.jqueryui.css">
<!-- TemplateBegin<img src="../edit.png" alt="edit" title="edit" />able name="head" -->
<script type="text/javascript" charset="utf-8">
var tbl;
$(document).ready(function() {
	TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
	tbl = $('#example').DataTable( {	
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"sScrollY": 500,
		"bJQueryUI": true,
		"iDisplayLength":300,
		"sScrollX": true,
		"sPaginationType": "full_numbers",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
		    $('td:eq(0)', nRow).html(iDisplayIndex+1);
		}
	} );
	
	
} );


</script> 
<!-- TemplateEnd<img src="../edit.png" alt="edit" title="edit" />able -->
<style media="all" type="text/css">
.markrow { background-color:#CCCCFF !important; }
#navamenu
{
visibility:hidden;
}
.container{
  width:90%;
}

table.dataTable tbody td {
  vertical-align: top;
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

<div class='navbar' style="">

      <div class='navbar-inner nav-collapse' style="height: auto;">

    <div class="topnav">

        <div class="btn-toolbar">
            <div class="btn-group">
            <a data-placement="bottom" data-original-title="Document" href="#" onclick="showPopWin('../../crp/users/addusers_proc.php?id=<?php echo $_SESSION['userid'];?>&edit=1',600,430);" data-toggle="tooltip" class="btn btn-default btn-sm"><?php echo $_SESSION['user_name']; ?>
                    
                </a>
                <a data-placement="bottom" data-original-title="Back" data-toggle="tooltip" class="btn btn-success btn-sm" href="./">
                    <i class="fa fa-resize-horizontal"></i>
                </a>
            </div>

            <div class="btn-group">
                <a href="../../crp/users/logout.php" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
		  <i class="fa fa-power-off"></i>
                </a>
            </div>
        </div>

    </div>
<!-- /.topnav -->
        <!-- .nav -->
        <ul class="nav navbar-nav">
            <li><a href="../../../">CRP Indicators</a></li>
            <li><a href="../targets/targets.php">CRP Targets</a></li>
            <li><a href="#">CRP:&nbsp;<?php echo $_SESSION['crp'];?></a></li>
            <li><a href="#">Period: <?php echo $_SESSION['rec_period'];?></a> </li>
		
		
		<li>
		<form action="" method="post">
		<select name="periodid" id="periodid" placeholder="Period" class="form-control" onChange="this.form.submit();">
		<?php
		$query="select * from crp_periods";
		if(!supervisor(0)){
			$query.=" where status='active' ";
		} 
		$res=mysql_query($query);
		while($row=mysql_fetch_object($res)){
		?>
		<option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->periodid)echo "selected"; ?>><?php echo $row->name; ?></option>
		<?php
		}
		?>
		</select>
		</form></li>
		
            
        </ul>
        <!-- /.nav -->
 
    </div>
    
    </div>
</div>

<div class="container">

<div style="height:80px;"></div>
