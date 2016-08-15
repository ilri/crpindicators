<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/varietys/Varietys_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/prod/varietys/Varietys_class.php");
require_once("../../../modules/prod/types/Types_class.php");
require_once("../../../modules/prod/colours/Colours_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Varietys";
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
	if(!empty($obj->shtypeid)  or empty($obj->action)){
		array_push($sColumns, 'typeid');
		array_push($aColumns, "prod_types.name as typeid");
		$rptjoin.=" left join prod_types on prod_types.id=prod_varietys.typeid ";
		$k++;
	}

	if(!empty($obj->shcolourid)  or empty($obj->action)){
		array_push($sColumns, 'colourid');
		array_push($aColumns, "prod_colours.name as colourid");
		$rptjoin.=" left join prod_colours on prod_colours.id=prod_varietys.colourid ";
		$k++;
	}

	if(!empty($obj->shduration)  or empty($obj->action)){
		array_push($sColumns, 'duration');
		array_push($aColumns, "prod_varietys.duration");
		$k++;
	}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "prod_varietys.quantity");
		$k++;
	}

	if(!empty($obj->shremarks)  or empty($obj->action)){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "prod_varietys.remarks");
		$k++;
	}



//processing filters
if(!empty($obj->fromname )){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietys.name >='$obj->fromname '";
	$track++;
}

if(!empty($obj->toname )){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietys.name <='$obj->toname '";
	$track++;
}

if(!empty($obj->name )){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietys.name ='$obj->name '";
	$track++;
}

if(!empty($obj->typeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietys.typeid='$obj->typeid'";
	$track++;
}

if(!empty($obj->colourid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietys.colourid='$obj->colourid'";
	$track++;
}

if(!empty($obj->fromduration)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietys.duration>='$obj->fromduration'";
	$track++;
}

if(!empty($obj->toduration)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietys.duration<='$obj->toduration'";
	$track++;
}

if(!empty($obj->fromquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietys.quantity>='$obj->fromquantity'";
	$track++;
}

if(!empty($obj->toquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietys.quantity<='$obj->toquantity'";
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietys.quantity='$obj->quantity'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grname)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" name ";
	$obj->shname=1;
	$track++;
}

if(!empty($obj->grcolourid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" colourid ";
	$obj->shcolourid=1;
	$track++;
}

if(!empty($obj->grtypeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" typeid ";
	$obj->shtypeid=1;
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
 $("#namname").autocomplete("../../../modules/server/server/search.php?main=prod&module=varietys&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#namname").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("namname").value=data[0];
     document.getElementById("name ").value=data[1];
   }
 });
 $("#typename").autocomplete("../../../modules/server/server/search.php?main=prod&module=types&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#typename").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("typename").value=data[0];
     document.getElementById("typeid").value=data[1];
   }
 });
});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="prod_varietys";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_varietys",
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
<form  action="varietys.php" method="post" name="varietys" class='forms'>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Name</td>
				<td><input type='text' size='20' name='namname' id='namname' value='<?php echo $obj->namname; ?>'>
					<input type="hidden" name='name ' id='name ' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Type</td>
				<td><input type='text' size='20' name='typename' id='typename' value='<?php echo $obj->typename; ?>'>
					<input type="hidden" name='typeid' id='typeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Colour</td>
				<td>
				<select name='colourid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$colours=new Colours();
				$where="  ";
				$fields="prod_colours.id, prod_colours.name, prod_colours.remarks, prod_colours.ipaddress, prod_colours.createdby, prod_colours.createdon, prod_colours.lasteditedby, prod_colours.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$colours->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($colours->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->colourid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Duration</td>
				<td><strong>From:</strong><input type='text' id='fromduration' size='16' name='fromduration' readonly class="date_input" value='<?php echo $obj->fromduration;?>'/>
							<br/><strong>To:</strong><input type='text' id='toduration' size='16' name='toduration' readonly class="date_input" value='<?php echo $obj->toduration;?>'/></td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><strong>From:</strong><input type='text' id='fromquantity' size='from20' name='fromquantity' value='<?php echo $obj->fromquantity;?>'/>
								<br/><strong>To:</strong><input type='text' id='toquantity' size='to20' name='toquantity' value='<?php echo $obj->toquantity;?>'></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grname' value='1' <?php if(isset($_POST['grname'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Name</td>
				<td><input type='checkbox' name='grcolourid' value='1' <?php if(isset($_POST['grcolourid']) ){echo"checked";}?>>&nbsp;Colour</td>
			<tr>
				<td><input type='checkbox' name='grtypeid' value='1' <?php if(isset($_POST['grtypeid']) ){echo"checked";}?>>&nbsp;Type</td>
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
				<td><input type='checkbox' name='shtypeid' value='1' <?php if(isset($_POST['shtypeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Type</td>
				<td><input type='checkbox' name='shcolourid' value='1' <?php if(isset($_POST['shcolourid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Colour</td>
			<tr>
				<td><input type='checkbox' name='shduration' value='1' <?php if(isset($_POST['shduration'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Duration</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Remarks</td>
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
			<?php if($obj->shtypeid==1  or empty($obj->action)){ ?>
				<th>Type </th>
			<?php } ?>
			<?php if($obj->shcolourid==1  or empty($obj->action)){ ?>
				<th>Colour </th>
			<?php } ?>
			<?php if($obj->shduration==1  or empty($obj->action)){ ?>
				<th>Expected Duration (Wks) </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shremarks==1  or empty($obj->action)){ ?>
				<th>Remarks </th>
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
