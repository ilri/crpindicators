<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>wisedigits</title>
<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<link href="../../fs-css/printable.css" media="print" type="text/css" rel="stylesheet" />
<link href="../../fs-css/layout.css" media="all" type="text/css" rel="stylesheet" /> 
<link href="../../fs-css/html-elements.css" media="all" type="text/css" rel="stylesheet" />
<link href="../../fs-css/elements.css" media="all" type="text/css" rel="stylesheet" />
<link href="../../j-modal/jqmodal.css" media="all" type="text/css" rel="stylesheet" />
<link href="../../lkimage/jquery.autocomplete.css" media="all" type="text/css" rel="stylesheet" />
<link href="../../css/calendar.css" media="all" type="text/css" rel="stylesheet" />
<script language="javascript" type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script language="javascript" src="../../j-modal/js/jqmodal.js" type="text/javascript" ></script>
<script language="javascript" src="../../j-modal/js/jqDnR.js" type="text/javascript"></script>
<script language="javascript" src="../../js/tabIndex.js" type="text/javascript"></script> 
<script language="javascript" type="text/javascript" src="../../js/jquery.ifixpng.js"></script>
<script language="javascript" type="text/javascript" src="../../lkimage/jquery.autocomplete.js"></script>
<script language="javascript" type="text/javascript" src="../../js/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="../../js/cal.js"></script>
<script type="text/javascript" src="../../js/shortcut.js"></script>
<script type="text/javascript" src="../../js/womon.js"></script>
<link rel="stylesheet" type="text/css" href="../../dmodal/style.css" />
<link rel="stylesheet" type="text/css" href="../../dmodal/subModal.css" />
<script type="text/javascript" src="../../dmodal/common.js"></script>
<script type="text/javascript" src="../../dmodal/subModal.js"></script>  
<link rel="stylesheet" type="text/css" href="../../css/style.css" />

<script type="text/javascript">   
jQuery(document).ready(function () {
	$('input.date_input').simpleDatepicker();
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
<script type="text/javascript" language="javascript">
var newwindow;
function poptastic(url)
{
	newwindow=window.open(url,'name','height=700,width=850,scrollbars=yes,left=90');
	if (window.focus) {newwindow.focus()}
}
</script>
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
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	$('#example').dataTable( {
		"sScrollY": 300,
		"bJQueryUI": true,
		"bSort":true,
		"sPaginationType": "full_numbers"
	} );
} );
</script>
<style type="text/css" title="currentStyle">
@import "../../css/demo_page.css";
@import "../../css/demo_table_jui.css";
@import "../../css/demo_table.css";
@import "../../css/jquery-ui-1.8.4.custom.css";
@import "../../media/css/TableTools.css";
</style>
<script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="../../media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" language="javascript" src="../../media/js/TableTools.js"></script>

<script src="../../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>


<link href="../../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<style media="all" type="text/css">
#navamenu
{
visibility:hidden;
}
</style>
</head>

<body>

<div id="header">
        <div class="content">
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
<div id="uselog">
      <div class="use-container"><strong style="color:#FF9900;">Hi,</strong>&nbsp;<span><?php echo $_SESSION['username']; ?></span> &nbsp;[<?php echo $level; ?>]&nbsp; </div>
     <a href="javascript:;" onclick="showPopWin('../users/addusers_proc.php?id=<?php echo $_SESSION['userid'];?>',400,350);" >edit</a>&nbsp;<a href="../../auth/users/logout.php" style="">Log Out</a>&nbsp;</div>
		 <? 
         }
         ?></div><!-- logon -->
            <div class="logo">
                <h1 id="logo"></h1>
				
			
            </div>

			
            <ul id="nav">
             <li><a href="#">Help</a></li>             
             <li><a href="../reports/">Reports/Analysis</a></li>
             <li><a href="../auth/users/">Administration</a></li>
             <li><a href="../hrm/employees/">HRM</a></li>
             <li><a href="#">Finance</a></li>
             <li><a href="#">Time Table</a></li>
             <li><a href="../sch/exams/">Exams</a></li>
             <li><a href="../sys/systemtools/">System Tools</a></li>
             <li><a href="../inv/items/">Inventory</a></li>
             <li><a href="../sch/fees/">Fees</a></li>
             <li><a href="../sch/students/students.php">Students</a></li>   		
            </ul><!-- nav -->
            <div class="cb"></div>
        </div><!-- content -->
    
    
    <div id="content">
    
