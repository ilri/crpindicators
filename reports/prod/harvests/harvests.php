<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/harvests/Harvests_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/prod/varietys/Varietys_class.php");
require_once("../../../modules/prod/sizes/Sizes_class.php");
require_once("../../../modules/prod/plantingdetails/Plantingdetails_class.php");
require_once("../../../modules/prod/areas/Areas_class.php");
require_once("../../../modules/prod/types/Types_class.php");
require_once("../../../modules/prod/types/Types_class.php");
require_once("../../../modules/prod/colours/Colours_class.php");
require_once("../../../modules/prod/colours/Colours_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Harvests";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8800";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../rptheader.php";

$rptwhere='';
$rptjoin='';
$track=0;
$k=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//Processing Groupings
$rptgroup='';
$track=0;
if(!empty($obj->grtypeid) or !empty($obj->grvarietyid) or !empty($obj->grareaid) or !empty($obj->grharvestedon) or !empty($obj->grcolourid) or !empty($obj->gremployeeid) ){
	$obj->shvarietyid='';
	$obj->shsizeid='';
	$obj->shplantingdetailid='';
	$obj->shareaid='';
	$obj->shquantity='';
	$obj->shharvestedon='';
	$obj->shbarcode='';
	$obj->shremarks='';
	$obj->shtypeid='';
	$obj->shcolourid='';
	$obj->shemployeeid='';
}


	$obj->shquantity=1;


if(!empty($obj->grtypeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" typeid ";
	$obj->shtypeid=1;
	$track++;
}

if(!empty($obj->grvarietyid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" varietyid ";
	$obj->shvarietyid=1;
	$track++;
}

if(!empty($obj->grareaid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" areaid ";
	$obj->shareaid=1;
	$track++;
}

if(!empty($obj->grharvestedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" harvestedon ";
	$obj->shharvestedon=1;
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

if(!empty($obj->gremployeeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" employeeid ";
	$obj->shemployeeid=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shvarietyid)  or empty($obj->action)){
		array_push($sColumns, 'varietyid');
		array_push($aColumns, "prod_varietys.name as varietyid");
		$rptjoin.=" left join prod_varietys on prod_varietys.id=prod_harvests.varietyid ";
		$k++;
		}

	if(!empty($obj->shsizeid)  or empty($obj->action)){
		array_push($sColumns, 'sizeid');
		array_push($aColumns, "prod_sizes.name as sizeid");
		$rptjoin.=" left join prod_sizes on prod_sizes.id=prod_harvests.sizeid ";
		$k++;
		}

	if(!empty($obj->shplantingdetailid)  or empty($obj->action)){
		array_push($sColumns, 'plantingdetailid');
		array_push($aColumns, "prod_harvests.remarks as plantingdetailid");
		$rptjoin.=" left join prod_plantingdetails on prod_plantingdetails.id=prod_harvests.plantingdetailid ";
		$k++;
		}

	if(!empty($obj->shareaid)  or empty($obj->action)){
		array_push($sColumns, 'areaid');
		array_push($aColumns, "prod_areas.name as areaid");
		$rptjoin.=" left join prod_areas on prod_areas.id=prod_harvests.areaid ";
		$k++;
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(prod_harvests.quantity) quantity");
		}else{
		array_push($aColumns, "prod_harvests.quantity");
		}

		$k++;
		}

	if(!empty($obj->shharvestedon) ){
		array_push($sColumns, 'harvestedon');
		array_push($aColumns, "prod_harvests.harvestedon");
		$k++;
		}

	if(!empty($obj->shbarcode) ){
		array_push($sColumns, 'barcode');
		array_push($aColumns, "prod_harvests.barcode");
		$k++;
		}

	if(!empty($obj->shremarks)  or empty($obj->action)){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "prod_harvests.remarks");
		$k++;
		}

	if(!empty($obj->shtypeid)  or empty($obj->action)){
		array_push($sColumns, 'typeid');
		array_push($aColumns, "prod_types.name as typeid");
		$k++;
		$join=" left join prod_varietys on prod_varietys.id=prod_harvests.varietyid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join prod_types on prod_types.id=prod_varietys.typeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shcolourid) ){
		array_push($sColumns, 'colourid');
		array_push($aColumns, "prod_colours.name as colourid");
		$k++;
		$join=" left join prod_varietys on prod_varietys.id=prod_harvests.varietyid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join prod_colours on prod_colours.id=prod_varietys.colourid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shemployeeid) ){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=prod_harvests.employeeid ";
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->varietyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_harvests.varietyid='$obj->varietyid'";
	$track++;
}

if(!empty($obj->sizeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_harvests.sizeid='$obj->sizeid'";
	$track++;
}

if(!empty($obj->plantingdetailid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_harvests.plantingdetailid='$obj->plantingdetailid'";
	$track++;
}

if(!empty($obj->areaid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_harvests.areaid='$obj->areaid'";
	$track++;
}

if(!empty($obj->fromquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_harvests.quantity>='$obj->fromquantity'";
	$track++;
}

if(!empty($obj->toquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_harvests.quantity<='$obj->toquantity'";
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_harvests.quantity='$obj->quantity'";
	$track++;
}

if(!empty($obj->fromharvestedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_harvests.harvestedon>='$obj->fromharvestedon'";
	$track++;
}

if(!empty($obj->toharvestedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_harvests.harvestedon<='$obj->toharvestedon'";
	$track++;
}

if(!empty($obj->barcode)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_harvests.barcode='$obj->barcode'";
	$track++;
}

if(!empty($obj->typeid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_types.id='$obj->typeid' ";
	$join=" left join prod_varietys on prod_varietys.id=prod_harvests.varietyid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join prod_types on prod_types.id=prod_varietys.typeid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->colourid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_colours.id='$obj->colourid' ";
	$join=" left join prod_varietys on prod_varietys.id=prod_harvests.varietyid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join prod_colours on prod_colours.id=prod_varietys.colourid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_harvests.employeeid='$obj->employeeid'";
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
if(!empty($obj->shplantingdetailid)){
	$fd.=" ,prod_harvests.remarks ";
}
if(!empty($obj->shtypeid)){
	$fd.=" ,prod_types.name ";
}
if(!empty($obj->shcolourid)){
	$fd.=" ,prod_colours.name ";
}
if(!empty($obj->shemployeeid)){
	$fd.=" ,concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) ";
}
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
 $("#employeename").autocomplete("../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))", {
 	width: 260,
 	selectFirst: false
 });
 $("#employeename").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("employeename").value=data[0];
     document.getElementById("employeeid").value=data[1];
   }
 });
});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="prod_harvests";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_harvests",
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
<form  action="harvests.php" method="post" name="harvests" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Variety</td>
				<td>
				<select name='varietyid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$varietys=new Varietys();
				$where="  ";
				$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($varietys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->varietyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Size</td>
				<td>
				<select name='sizeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$sizes=new Sizes();
				$where="  ";
				$fields="prod_sizes.id, prod_sizes.name, prod_sizes.remarks, prod_sizes.ipaddress, prod_sizes.createdby, prod_sizes.createdon, prod_sizes.lasteditedby, prod_sizes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($sizes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->sizeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Planting Details</td>
				<td>
				<select name='plantingdetailid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$plantingdetails=new Plantingdetails();
				$where="  ";
				$fields="prod_plantingdetails.id, prod_plantingdetails.plantingid, prod_plantingdetails.varietyid, prod_plantingdetails.areaid, prod_plantingdetails.quantity, prod_plantingdetails.memo, prod_plantingdetails.ipaddress, prod_plantingdetails.createdby, prod_plantingdetails.createdon, prod_plantingdetails.lasteditedby, prod_plantingdetails.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$plantingdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($plantingdetails->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->plantingdetailid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Area</td>
				<td>
				<select name='areaid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$areas=new Areas();
				$where="  ";
				$fields="prod_areas.id, prod_areas.name, prod_areas.size, prod_areas.blockid, prod_areas.status, prod_areas.remarks, prod_areas.ipaddress, prod_areas.createdby, prod_areas.createdon, prod_areas.lasteditedby, prod_areas.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($areas->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->areaid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><strong>From:</strong><input type='text' id='fromquantity' size='from16' name='fromquantity' value='<?php echo $obj->fromquantity;?>'/>
								<br/><strong>To:</strong><input type='text' id='toquantity' size='to16' name='toquantity' value='<?php echo $obj->toquantity;?>'></td>
			</tr>
			<tr>
				<td>Harvest Date</td>
				<td><strong>From:</strong><input type='text' id='fromharvestedon' size='16' name='fromharvestedon' readonly class="date_input" value='<?php echo $obj->fromharvestedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toharvestedon' size='16' name='toharvestedon' readonly class="date_input" value='<?php echo $obj->toharvestedon;?>'/></td>
			</tr>
			<tr>
				<td>Barcode</td>
				<td><input type='text' id='barcode' size='20' name='barcode' value='<?php echo $obj->barcode;?>'></td>
			</tr>
			<tr>
				<td>Variety Type</td>
				<td>
				<select name='typeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$types=new Types();
				$where="  ";
				$fields="prod_types.id, prod_types.name, prod_types.remarks, prod_types.ipaddress, prod_types.createdby, prod_types.createdon, prod_types.lasteditedby, prod_types.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$types->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($types->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->typeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Variety Colour</td>
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
				<td>Employee</td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grtypeid' value='1' <?php if(isset($_POST['grtypeid']) ){echo"checked";}?>>&nbsp;Variety Type</td>
				<td><input type='checkbox' name='grvarietyid' value='1' <?php if(isset($_POST['grvarietyid']) ){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='grareaid' value='1' <?php if(isset($_POST['grareaid']) ){echo"checked";}?>>&nbsp;Area</td>
				<td><input type='checkbox' name='grharvestedon' value='1' <?php if(isset($_POST['grharvestedon']) ){echo"checked";}?>>&nbsp;Harvest Date</td>
			<tr>
				<td><input type='checkbox' name='grcolourid' value='1' <?php if(isset($_POST['grcolourid']) ){echo"checked";}?>>&nbsp;Variety Colour</td>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
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
				<td><input type='checkbox' name='shvarietyid' value='1' <?php if(isset($_POST['shvarietyid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Variety</td>
				<td><input type='checkbox' name='shsizeid' value='1' <?php if(isset($_POST['shsizeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Size</td>
			<tr>
				<td><input type='checkbox' name='shplantingdetailid' value='1' <?php if(isset($_POST['shplantingdetailid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Planting Details</td>
				<td><input type='checkbox' name='shareaid' value='1' <?php if(isset($_POST['shareaid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Area</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shharvestedon' value='1' <?php if(isset($_POST['shharvestedon']) ){echo"checked";}?>>&nbsp;Harvest Date</td>
			<tr>
				<td><input type='checkbox' name='shbarcode' value='1' <?php if(isset($_POST['shbarcode']) ){echo"checked";}?>>&nbsp;Barcode</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shtypeid' value='1' <?php if(isset($_POST['shtypeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Variety Type</td>
				<td><input type='checkbox' name='shcolourid' value='1' <?php if(isset($_POST['shcolourid']) ){echo"checked";}?>>&nbsp;Variety Colour</td>
			<tr>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align='center'><input type="submit" class="btn" name="action" id="action" value="Filter" /></td>
	</tr>
</table>
</form>
</div>
</div>
<table style="clear:both;"  class="tgrid display" id="tbl" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<?php if($obj->shvarietyid==1  or empty($obj->action)){ ?>
				<th>Variety </th>
			<?php } ?>
			<?php if($obj->shsizeid==1  or empty($obj->action)){ ?>
				<th>Sizes </th>
			<?php } ?>
			<?php if($obj->shplantingdetailid==1  or empty($obj->action)){ ?>
				<th>Planting Detail </th>
			<?php } ?>
			<?php if($obj->shareaid==1  or empty($obj->action)){ ?>
				<th>Area </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shharvestedon==1 ){ ?>
				<th>Date Harvested </th>
			<?php } ?>
			<?php if($obj->shbarcode==1 ){ ?>
				<th>BarCode </th>
			<?php } ?>
			<?php if($obj->shremarks==1  or empty($obj->action)){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shtypeid==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcolourid==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1 ){ ?>
				<th>Employee </th>
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
