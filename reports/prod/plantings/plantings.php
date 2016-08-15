<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/plantings/Plantings_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/prod/breederdeliverys/Breederdeliverys_class.php");
require_once("../../../modules/prod/breeders/Breeders_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/prod/varietys/Varietys_class.php");
require_once("../../../modules/prod/colours/Colours_class.php");
require_once("../../../modules/prod/plantingdetails/Plantingdetails_class.php");
require_once("../../../modules/prod/varietys/Varietys_class.php");
require_once("../../../modules/prod/colours/Colours_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Plantings";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8793";//Report View
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
if(!empty($obj->grdocumentno) or !empty($obj->grbreederdeliveryid) or !empty($obj->grbreederid) or !empty($obj->grplantedon) or !empty($obj->grweek) or !empty($obj->gremployeeid) or !empty($obj->grcreatedon) or !empty($obj->grcreatedby) or !empty($obj->grvarietyid) or !empty($obj->grcolourid) ){
	$obj->shdocumentno='';
	$obj->shbreederdeliveryid='';
	$obj->shbreederid='';
	$obj->shplantedon='';
	$obj->shweek='';
	$obj->shemployeeid='';
	$obj->shremarks='';
	$obj->shcreatedon='';
	$obj->shcreatedby='';
	$obj->shipaddress='';
	$obj->shquantity='';
	$obj->shvarietyid='';
	$obj->shcolourid='';
}


	$obj->shquantity=1;


if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
	$track++;
}

if(!empty($obj->grbreederdeliveryid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" breederdeliveryid ";
	$obj->shbreederdeliveryid=1;
	$track++;
}

if(!empty($obj->grbreederid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" breederid ";
	$obj->shbreederid=1;
	$track++;
}

if(!empty($obj->grplantedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" plantedon ";
	$obj->shplantedon=1;
	$track++;
}

if(!empty($obj->grweek)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" week ";
	$obj->shweek=1;
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

if(!empty($obj->grcreatedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdon ";
	$obj->shcreatedon=1;
	$track++;
}

if(!empty($obj->grcreatedby)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdby ";
	$obj->shcreatedby=1;
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

if(!empty($obj->grcolourid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" colourid ";
	$obj->shcolourid=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "prod_plantings.documentno");
		$k++;
		}

	if(!empty($obj->shbreederdeliveryid)  or empty($obj->action)){
		array_push($sColumns, 'breederdeliveryid');
		array_push($aColumns, "concat(prod_breederdeliverys.documentno,' ',prod_breederdeliverys.week) as breederdeliveryid");
		$rptjoin.=" left join prod_breederdeliverys on prod_breederdeliverys.id=prod_plantings.breederdeliveryid ";
		$k++;
		}

	if(!empty($obj->shbreederid)  or empty($obj->action)){
		array_push($sColumns, 'breederid');
		array_push($aColumns, "prod_breeders.name as breederid");
		$rptjoin.=" left join prod_breeders on prod_breeders.id=prod_plantings.breederid ";
		$k++;
		}

	if(!empty($obj->shplantedon)  or empty($obj->action)){
		array_push($sColumns, 'plantedon');
		array_push($aColumns, "prod_plantings.plantedon");
		$k++;
		}

	if(!empty($obj->shweek)  or empty($obj->action)){
		array_push($sColumns, 'week');
		array_push($aColumns, "prod_plantings.week");
		$k++;
		}

	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=prod_plantings.employeeid ";
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "prod_plantings.remarks");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "prod_plantings.createdon");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "prod_plantings.createdby");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "prod_plantings.ipaddress");
		$k++;
		}

	if(!empty($obj->shquantity) ){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(prod_plantingdetails.quantity) as quantity");
		}else{
			array_push($aColumns, "prod_plantingdetails.quantity as quantity");
		}

		$join=" left join prod_plantingdetails on prod_plantings.id=prod_plantingdetails.plantingid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}

	if(!empty($obj->shvarietyid) ){
		array_push($sColumns, 'varietyid');
		array_push($aColumns, "prod_varietys.name as varietyid");
		$join=" left join prod_plantingdetails on prod_plantings.id=prod_plantingdetails.plantingid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		$join=" left join prod_plantingdetails on prod_plantings.id=prod_plantingdetails.plantingid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join prod_varietys on prod_varietys.id=prod_plantingdetails.varietyid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shcolourid) ){
		array_push($sColumns, 'colourid');
		array_push($aColumns, "prod_colours.name as colourid");
		$k++;
		$join=" left join prod_plantingdetails on prod_plantings.id=prod_plantingdetails.plantingid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join prod_varietys on prod_varietys.id=prod_plantingdetails.varietyid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join prod_colours on prod_colours.id=prod_varietys.colourid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}



$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_plantings.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->breederdeliveryid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_plantings.breederdeliveryid='$obj->breederdeliveryid'";
		$join=" left join prod_breederdeliverys on prod_plantings.id=prod_breederdeliverys.plantingid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->breederid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_plantings.breederid='$obj->breederid'";
		$join=" left join prod_breeders on prod_plantings.id=prod_breeders.plantingid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->fromplantedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_plantings.plantedon>='$obj->fromplantedon'";
	$track++;
}

if(!empty($obj->toplantedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_plantings.plantedon<='$obj->toplantedon'";
	$track++;
}

if(!empty($obj->week)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_plantings.week='$obj->week'";
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_plantings.employeeid='$obj->employeeid'";
		$join=" left join hrm_employees on prod_plantings.id=hrm_employees.plantingid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_plantings.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_plantings.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_plantings.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->varietyid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_varietys.id='$obj->varietyid' ";
	$join=" left join prod_plantingdetails on prod_plantings.id=prod_plantingdetails.plantingid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join prod_varietys on prod_varietys.id=prod_plantingdetails.varietyid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->colourid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_colours.id='$obj->colourid' ";
	$join=" left join prod_plantingdetails on prod_plantings.id=prod_plantingdetails.plantingid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join prod_varietys on prod_varietys.id=prod_plantingdetails.varietyid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join prod_colours on prod_colours.id=prod_varietys.colourid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_plantings.quantity='$obj->quantity'";
		$join=" left join prod_plantingdetails on prod_plantings.id=prod_plantingdetails.plantingid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
if(!empty($obj->shbreederdeliveryid)){
	$fd.=" ,concat(prod_breederdeliverys.documentno,' ',prod_breederdeliverys.week) ";
}
if(!empty($obj->shemployeeid)){
	$fd.=" ,concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) ";
}
if(!empty($obj->shquantity)){
	$fd.=" ,prod_plantingdetails.quantity ";
}
if(!empty($obj->shvarietyid)){
	$fd.=" ,prod_varietys.name ";
}
if(!empty($obj->shcolourid)){
	$fd.=" ,prod_colours.name ";
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
 <?php $_SESSION['sTable']="prod_plantings";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_plantings",
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
<form  action="plantings.php" method="post" name="plantings" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Document No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Breed Delivery</td>
				<td>
				<select name='breederdeliveryid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$breederdeliverys=new Breederdeliverys();
				$where="  ";
				$fields="prod_breederdeliverys.id, prod_breederdeliverys.documentno, prod_breederdeliverys.breederid, prod_breederdeliverys.deliveredon, prod_breederdeliverys.week, prod_breederdeliverys.remarks, prod_breederdeliverys.ipaddress, prod_breederdeliverys.createdby, prod_breederdeliverys.createdon, prod_breederdeliverys.lasteditedby, prod_breederdeliverys.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$breederdeliverys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($breederdeliverys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->breederdeliveryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Breeder</td>
				<td>
				<select name='breederid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$breeders=new Breeders();
				$where="  ";
				$fields="prod_breeders.id, prod_breeders.code, prod_breeders.name, prod_breeders.contact, prod_breeders.physicaladdress, prod_breeders.tel, prod_breeders.fax, prod_breeders.email, prod_breeders.cellphone, prod_breeders.status, prod_breeders.createdby, prod_breeders.createdon, prod_breeders.lasteditedby, prod_breeders.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$breeders->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($breeders->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->breederid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Planted On</td>
				<td><strong>From:</strong><input type='text' id='fromplantedon' size='12' name='fromplantedon' readonly class="date_input" value='<?php echo $obj->fromplantedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toplantedon' size='12' name='toplantedon' readonly class="date_input" value='<?php echo $obj->toplantedon;?>'/></td>
			</tr>
			<tr>
				<td>Week</td>
				<td><input type='text' id='week' size='20' name='week' value='<?php echo $obj->week;?>'></td>
			</tr>
			<tr>
				<td>Employee</td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Created On</td>
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="*";
				$where="";
				$join="   ";
				$having="";
				$groupby="";
				$orderby="";
				$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($users->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->createdby==$rw->id){echo "selected";}?>><?php echo $rw->username;?></option>
				<?php
				}
				?>
			</td>
			</tr>
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
				<td>Quantity</td>
				<td><input type='text' id='quantity' size='4' name='quantity' value='<?php echo $obj->quantity;?>'></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
				<td><input type='checkbox' name='grbreederdeliveryid' value='1' <?php if(isset($_POST['grbreederdeliveryid']) ){echo"checked";}?>>&nbsp;Breed Delivery</td>
			<tr>
				<td><input type='checkbox' name='grbreederid' value='1' <?php if(isset($_POST['grbreederid']) ){echo"checked";}?>>&nbsp;Breeder</td>
				<td><input type='checkbox' name='grplantedon' value='1' <?php if(isset($_POST['grplantedon']) ){echo"checked";}?>>&nbsp;Planted On</td>
			<tr>
				<td><input type='checkbox' name='grweek' value='1' <?php if(isset($_POST['grweek']) ){echo"checked";}?>>&nbsp;Week</td>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grvarietyid' value='1' <?php if(isset($_POST['grvarietyid']) ){echo"checked";}?>>&nbsp;Variety</td>
				<td><input type='checkbox' name='grcolourid' value='1' <?php if(isset($_POST['grcolourid']) ){echo"checked";}?>>&nbsp;Variety Colour</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document No</td>
				<td><input type='checkbox' name='shbreederdeliveryid' value='1' <?php if(isset($_POST['shbreederdeliveryid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Breed Delivery</td>
			<tr>
				<td><input type='checkbox' name='shbreederid' value='1' <?php if(isset($_POST['shbreederid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Breeder</td>
				<td><input type='checkbox' name='shplantedon' value='1' <?php if(isset($_POST['shplantedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Planted On</td>
			<tr>
				<td><input type='checkbox' name='shweek' value='1' <?php if(isset($_POST['shweek'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Week</td>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity']) ){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shvarietyid' value='1' <?php if(isset($_POST['shvarietyid']) ){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='shcolourid' value='1' <?php if(isset($_POST['shcolourid']) ){echo"checked";}?>>&nbsp;Variety Colour</td>
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
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Planting No </th>
			<?php } ?>
			<?php if($obj->shbreederdeliveryid==1  or empty($obj->action)){ ?>
				<th>Breeder Delivery </th>
			<?php } ?>
			<?php if($obj->shbreederid==1  or empty($obj->action)){ ?>
				<th>Breeder </th>
			<?php } ?>
			<?php if($obj->shplantedon==1  or empty($obj->action)){ ?>
				<th>Planting Date </th>
			<?php } ?>
			<?php if($obj->shweek==1  or empty($obj->action)){ ?>
				<th>Calendar Week </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Person In-Charge </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
			<?php } ?>
			<?php if($obj->shquantity==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shvarietyid==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcolourid==1 ){ ?>
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
