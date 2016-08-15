<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/breederdeliverys/Breederdeliverys_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/prod/breeders/Breeders_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Breederdeliverys";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include"../../../rptheader.php";

$rptwhere='';
$rptjoin='';
$track=0;
$k=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//processing columns to show
	if(!empty($obj->shdocumentno) ){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "prod_breederdeliverys.documentno");
		$k++;
	}

	if(!empty($obj->shbreederid)  or empty($obj->action)){
		array_push($sColumns, 'breederid');
		array_push($aColumns, "prod_breeders.name as breederid");
		$rptjoin.=" left join prod_breeders on prod_breeders.id=prod_breederdeliverys.breederid ";
		$k++;
	}

	if(!empty($obj->shdeliveredon)  or empty($obj->action)){
		array_push($sColumns, 'deliveredon');
		array_push($aColumns, "prod_breederdeliverys.deliveredon");
		$k++;
	}

	if(!empty($obj->shweek)  or empty($obj->action)){
		array_push($sColumns, 'week');
		array_push($aColumns, "prod_breederdeliverys.week");
		$k++;
	}

	if(!empty($obj->shremarks)  or empty($obj->action)){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "prod_breederdeliverys.remarks");
		$k++;
	}

	if(!empty($obj->shplanted)  or empty($obj->action)){
		array_push($sColumns, 'planted');
		array_push($aColumns, "prod_breederdeliverys.planted");
		$k++;
	}



//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_breederdeliverys.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->breederid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_breederdeliverys.breederid='$obj->breederid'";
	$track++;
}

if(!empty($obj->fromdeliveredon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_breederdeliverys.deliveredon>='$obj->fromdeliveredon'";
	$track++;
}

if(!empty($obj->todeliveredon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_breederdeliverys.deliveredon<='$obj->todeliveredon'";
	$track++;
}

if(!empty($obj->week)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_breederdeliverys.week='$obj->week'";
	$track++;
}

if(!empty($obj->planted)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_breederdeliverys.planted='$obj->planted'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
 $("#breedername").autocomplete("../../../modules/server/server/search.php?main=prod&module=breeders&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#breedername").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("breedername").value=data[0];
     document.getElementById("breederid").value=data[1];
   }
 });
});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="prod_breederdeliverys";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $$(document).ready(function() {
	 TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_breederdeliverys",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				$('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
 	} );
 } );
 </script>

<div id="main">
<div id="main-inner">
<div id="content">
<div id="content-inner">
<div id="content-header">
	<div class="page-title"><?php echo $page_title; ?></div>
	<div class="clearb"></div>
</div>
<div id="content-flex">
<button id="create-user">Filter</button>
<div id="toPopup" >
<div class="close"></div>
<span class="ecs_tooltip">Press Esc to close <span class="arrow"></span>
<div id="dialog-modal" title="Filter" style="font:tahoma;font-size:10px;">
<form  action="breederdeliverys.php" method="post" name="breederdeliverys" class='forms'>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Invoice No</td>
				<td><input type='text' id='documentno' size='16' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Breeder </td>
				<td><input type='text' size='20' name='breedername' id='breedername' value='<?php echo $obj->breedername; ?>'>
					<input type="hidden" name='breederid' id='breederid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Date Delivered</td>
				<td><strong>From:</strong><input type='text' id='fromdeliveredon' size='16' name='fromdeliveredon' readonly class="date_input" value='<?php echo $obj->fromdeliveredon;?>'/>
							<br/><strong>To:</strong><input type='text' id='todeliveredon' size='16' name='todeliveredon' readonly class="date_input" value='<?php echo $obj->todeliveredon;?>'/></td>
			</tr>
			<tr>
				<td>Week</td>
				<td><input type='text' id='week' size='16' name='week' value='<?php echo $obj->week;?>'></td>
			</tr>
			<tr>
				<td>Planted</td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
				<th colspan="3"><div align="left"><strong>Fields to Show (For Detailed Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno']) ){echo"checked";}?>>&nbsp;Invoice No</td>
				<td><input type='checkbox' name='shbreederid' value='1' <?php if(isset($_POST['shbreederid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Breeder </td>
			<tr>
				<td><input type='checkbox' name='shdeliveredon' value='1' <?php if(isset($_POST['shdeliveredon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Date Delivered</td>
				<td><input type='checkbox' name='shweek' value='1' <?php if(isset($_POST['shweek'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Week</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shplanted' value='1' <?php if(isset($_POST['shplanted'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Planted</td>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align='center'><input type="submit" name="action" id="action" value="Filter" /></td>
	</tr>
</table>
</form>
</div>
</div>
<table style="clear:both;"  class="tgrid display" id="tbl" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<?php if($obj->shdocumentno==1 ){ ?>
				<th>Delivery No </th>
			<?php } ?>
			<?php if($obj->shbreederid==1  or empty($obj->action)){ ?>
				<th>Breeder </th>
			<?php } ?>
			<?php if($obj->shdeliveredon==1  or empty($obj->action)){ ?>
				<th>Date Delivered </th>
			<?php } ?>
			<?php if($obj->shweek==1  or empty($obj->action)){ ?>
				<th>Calendar Week </th>
			<?php } ?>
			<?php if($obj->shremarks==1  or empty($obj->action)){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shplanted==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
</div>
</div>
</div>
</div>
</div>
