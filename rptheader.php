<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/poptasticv.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
  <script src="../../../js/jquery-1.7.1.js" type="text/javascript"></script>
  <script type="text/javascript" src="../../../js/validate.min.js"></script>
	
  <link rel="stylesheet" href="../../../css/base/jquery.ui.all.css">
<link href="../../../fs-css/printable.css" media="print" type="text/css" rel="stylesheet" />
<link href="../../../fs-css/layout.css" media="all" type="text/css" rel="stylesheet" /> 
<link href="../../../fs-css/cont.css" media="all" type="text/css" rel="stylesheet" /> 
<link href="../../../fs-css/html-elements.css" media="all" type="text/css" rel="stylesheet" />
<link href="../../../fs-css/elements.css" media="all" type="text/css" rel="stylesheet" />
<link href="../../../j-modal/jqmodal.css" media="all" type="text/css" rel="stylesheet" />
<link href="../../../lkimage/jquery.autocomplete.css" media="all" type="text/css" rel="stylesheet" />
<link href="../../../css/calendar.css" media="all" type="text/css" rel="stylesheet" />
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

<script type="text/javascript" language="javascript" src="../../../js/jquery.formatCurrency-1.4.0.js"></script>

  <link href="../../../popup/style/style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../../../popup/js/script.js"></script>

	<script src="../../../js/jquery.ui.core.js" type="text/javascript"></script>
	<script src="../../../js/jquery.ui.widget.js" type="text/javascript"></script>
	<script src="../../../js/ui/jquery.ui.accordion.js"></script>
	<script src="../../../js/ui/jquery.ui.button.js"></script>
    <script src="../../../js/ui/jquery.ui.mouse.js"></script>
	<script src="../../../js/ui/jquery.ui.draggable.js"></script>
	<script src="../../../js/ui/jquery.ui.position.js"></script>
	<script src="../../../js/ui/jquery.ui.resizable.js"></script>
	<script src="../../../js/ui/jquery.ui.dialog.js"></script>
		<script src="../../../js/jquery.ui.datepicker.js" type="text/javascript"></script>
	
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
	newwindow=window.open(url,'name','height='+ht+',width='+wd+',scrollbars=yes,left=250,top=150');
	if (window.focus) {newwindow.focus()}
}
function placeCursorOnPageLoad()
{
	document.cashsales.itemName.focus();
		
}
</script>
<!-- InstanceBeginEditable name="doctitle" -->
<title>WiseDigits: <?php echo $page_title; ?></title>
<style media="all" type="text/css">
#over {background:  url(/i/shadowlight.gif) repeat;
	 position: absolute; 
	 left: 0;
	 top: 0;
	 z-index: 100;
	 width: 100%; 
	 height: 100%;
	 margin: 0;
	 filter:progid:DXImageTransform.Microsoft.Alpha(opacity=80);
	 -moz-opacity:0.80;
	 -khtml-opacity:0.80;
	 }
#box, #box2 {
	overflow: none;
	border: 5px ridge #ccc;
	z-index: 150;
	background-color: #D2E1F0;
	position: relative;
	padding: 10px;
	top: -5px; /* these two define the shadow 'offset'*/
	left: -5px; /*...*/
	  }
.sh	{position: absolute;
	top:100px;	
	 z-index: 1000;	 
	width: 1000px; 
	 right: 30%;
	 background: url(/i/shadow.png) repeat !important;
	  background: url(/i/shadowlight.gif) repeat;
	  }
div.sh form	{
	clear:both;
	padding:10px 0px 0px;
	  }
.bar {
	background-color: #B9B973;
	text-align: right;
	margin: -5px;
	padding: 5px
} 
  h1 { color: #006;}
	.bar2 {
	background: #FFC66F url(/i/dragbar.gif) no-repeat center left;
	text-align: right;
	margin: -5px;cursor:crosshair;
	padding: 5px;
} 
.bar2 span{
	float:left; display:block;
}
.bar a {border: 1px solid #777; 
	color: #777; 
	text-decoration: none; 
	font-size: 10px; 
	padding: 0 5px; }
</style>
<script type="text/javascript">
//<![CDATA[
	 function expandCollapse() {
	for (var i=0; i<expandCollapse.arguments.length; i++) {
		var element = document.getElementById(expandCollapse.arguments[i]);
		element.style.display = (element.style.display == "none") ? "block" : "none";
	}
}
//]]>

</script>
<script language="javascript" src="../../../js/dragg.js" type="text/javascript"></script>
<!-- InstanceEndEditable -->
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
	<script>
	$(function() {
		$( "#dialog-modal" ).dialog({
			autoOpen: false,
			modal: true
		});
			$( "#create-user" )
			.button()
			.click(function() {
				$( "#dialog-modal" ).dialog( "open" );
			});
	});
	</script>
<style type="text/css" title="currentStyle">
@import "../../../css/demo_page.css";
@import "../../../css/demo_table_jui.css";
@import "../../../css/demo_table.css";
@import "../../../css/jquery-ui-1.8.4.custom.css";
@import "../../../media/css/TableTools.css";
</style>
<script type="text/javascript" language="javascript" src="../../../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="../../../media/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" language="javascript" src="../../../media/js/TableTools.js"></script>

<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
	$('#example').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"sScrollY": 400,
		"iDisplayLength": 200,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	} );
} );
</script>


<!-- InstanceEndEditable -->
<style media="all" type="text/css">
#navamenu
{
visibility:hidden;
}
</style>

</head>
<body onload="placeCursorOnPageLoad();loadBanks();">
<div id="console" style=""><div id="header">
<div id="header-inner">

<div id="header-right">

</div>
<div class="clearb"></div>
</div>
</div>
<div id="console-inner" style=" width:auto; margin:0px 20px;">