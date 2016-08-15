<!-- 	vital -->
<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" src="../../../js/jquery.dataTables.js"></script> 
<script src="../../../js/lib/datatables/DT_bootstrap.js"></script>
<script src="../../../js/tablesorter/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="../../../js/main.js"></script>

<link rel="stylesheet" href="../../../css/bootstrap/css/bootstrap.css">

<!-- <link href="../../../css/bootstrap.css" rel="stylesheet"> -->
<link rel="stylesheet" href="../../../js/lib/datatables/css/demo_page.css">
<link rel="stylesheet" href="../../../js/lib/datatables/css/DT_bootstrap.css">

<script>
$('#action').click(function() {
    location.reload(true);
});
</script>
<!-- vitalEnd -->
<script>
		jQuery(document).ready(function () {
			$('input.date_input').datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange:  '1930:2100',
					dateFormat: 'yy-mm-dd'
				});
			});
			
			$(document).ready(function(){
            $.getJSON('http://data.ilri.org/portal/api/ilri/1/action/list_countries', 
            function(data){
                var html = '';
                var len = data.length;
                //alert(len);
                for (var i = 0; i< len; i++) {
                    html += '<option value="' + data[i] + '" ';
                    if(data[i]=="<?php echo $obj->country; ?>")
		      html +=' selected ';
                    html +='>' + data[i] + '</option>';
                }
                $('#country').append(html);
            });
            
            $.getJSON('http://data.ilri.org/portal/api/ilri/1/action/list_regions', 
            function(data){
                var html = '';
                var len = data.length;
                for (var i = 0; i< len; i++) {
                    html += '<option value="' + data[i] + '" '
                    if(data[i]=="<?php echo $obj->region; ?>")
		      html +=' selected ';
                    html += '>' + data[i] + '</option>';
                }
                $('#region').append(html);
            });
        });
	</script>


<!--<script src="../../../js/jquery-1.9.1.js"></script>
<script>window.jQuery || document.write('<script src="../../../js/jquery.min.js"><\/script>')</script>-->
<!--<script src="../../../js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="../../../js/jquery-1.7.1.js" type="text/javascript"></script>-->
<script src="../../../js/ui/jquery-ui.js"></script>
<script src="../../../js/functions.js"></script>
<!-- <script src="../../../js/datatable.js"></script> -->
<script type="text/javascript" src="../../../js/bpops.js"></script>
<!-- <script type="text/javascript" src="../../../js/jquery.dataTables.js"></script> -->
<script type="text/javascript" language="javascript" src="../../../js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="../../../js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../../js/jquery-ui-timepicker-addon.css" />
<script src="../../../js/fullcalendar/fullcalendar.min.js"></script>
<!-- <script src="../../../js/sparkline/jquery.sparkline.min.js"></script> -->
<!-- <script src="../../../js/main.js"></script> -->
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
	
	<link href="../../../css/bootstrap.css" rel="stylesheet">
<!-- 	<link href="../../../css/datatable.css" rel="stylesheet"> -->
<!-- 	<link href="../../../css/bootstrap.min.css" rel="stylesheet"> -->
	<link href="../../../css/bootstrap/css/bootstrap.css" rel="stylesheet">  
<!-- 	<link href="../../../css/bootstrap.min.css" rel="stylesheet">  -->
	<link href="../../../css/datatableshack.css" rel="stylesheet"> 
	<link href="../../../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="../../../css/datepicker.css" rel="stylesheet">
	<link href="../../../css/fa/css/font-awesome.css" rel="stylesheet">
<!-- 	<link rel="stylesheet" href="../../../css/fa/datatables/demo_page.css">	 -->
	<link href="../../../lkimage/jquery.autocomplete.css" media="all" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" href="../../../js/fullcalendar/fullcalendar.css">
<!-- 	<link rel="stylesheet" href="../../../css/fa/datatables/css/DT_bootstrap.css"> -->
	<link rel="stylesheet" href="../../../css/lib/datepicker/css/datepicker.css">
	<link href="../../../css/main.css" rel="stylesheet">
	<link href="../../../fs-css/elements.css" media="all" type="text/css" rel="stylesheet" /> 
	<link href="../../../fs-css/html-elements.css" media="all" type="text/css" rel="stylesheet" /> 
	
<!-- <script type="text/javascript" language="javascript" src="../../../js/jquery.dataTables.min.js"></script> -->
<script type="text/javascript" language="javascript" src="../../../media/ZeroClipboard/ZeroClipboard.js"></script>
<!-- <script type="text/javascript" language="javascript" src="../../../media/js/TableTools.js"></script> -->


<style>
body{background-image:none !important;background-color:#fff !important;}
</style>
