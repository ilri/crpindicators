<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/varietystocks/Varietystocks_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/prod/varietys/Varietys_class.php");
require_once("../../../modules/prod/areas/Areas_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Varietystocks";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8805";//Report View
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
if(!empty($obj->grdocumentno) or !empty($obj->grvarietyid) or !empty($obj->areaid) or !empty($obj->grtransaction) or !empty($obj->gractedon) ){
	$obj->shdocumentno='';
	$obj->shvarietyid='';
	$obj->shareaid='';
	$obj->shtransaction='';
	$obj->shquantity='';
	$obj->shremain='';
	$obj->shrecordedon='';
	$obj->shactedon='';
	$obj->shrecordedon='';
}


	$obj->sh=1;


if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
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

if(!empty($obj->areaid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" eaid ";
	$obj->sheaid=1;
	$track++;
}

if(!empty($obj->grtransaction)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" transaction ";
	$obj->shtransaction=1;
	$track++;
}

if(!empty($obj->gractedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" actedon ";
	$obj->shactedon=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shdocumentno) ){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "prod_varietystocks.documentno");
		$k++;
		}

	if(!empty($obj->shvarietyid) ){
		array_push($sColumns, 'varietyid');
		array_push($aColumns, "prod_varietys.name as varietyid");
		$rptjoin.=" left join prod_varietys on prod_varietys.id=prod_varietystocks.varietyid ";
		$k++;
		}

	if(!empty($obj->shareaid) ){
		array_push($sColumns, 'areaid');
		array_push($aColumns, "prod_areas.name as areaid");
		$rptjoin.=" left join prod_areas on prod_areas.id=prod_varietystocks.areaid ";
		$k++;
		}

	if(!empty($obj->shtransaction) ){
		array_push($sColumns, 'transaction');
		array_push($aColumns, "prod_varietystocks.transaction");
		$k++;
		}

	if(!empty($obj->shquantity) ){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "prod_varietystocks.quantity");
		$k++;
		}

	if(!empty($obj->shremain) ){
		array_push($sColumns, 'remain');
		array_push($aColumns, "prod_varietystocks.remain");
		$k++;
		}

	if(!empty($obj->shrecordedon) ){
		array_push($sColumns, 'recordedon');
		array_push($aColumns, "prod_varietystocks.recordedon");
		$k++;
		}

	if(!empty($obj->shactedon) ){
		array_push($sColumns, 'actedon');
		array_push($aColumns, "prod_varietystocks.actedon");
		$k++;
		}

	if(!empty($obj->grrecordedon) ){
		array_push($sColumns, 'recordedon');
		array_push($aColumns, "prod_varietystocks.recordedon");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->varietyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.varietyid='$obj->varietyid'";
		$join=" left join prod_varietys on prod_varietystocks.id=prod_varietys.varietystockid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->areaid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.areaid='$obj->areaid'";
		$join=" left join prod_areas on prod_varietystocks.id=prod_areas.varietystockid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->transaction)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.transaction='$obj->transaction'";
	$track++;
}

if(!empty($obj->fromquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.quantity>='$obj->fromquantity'";
	$track++;
}

if(!empty($obj->toquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.quantity<='$obj->toquantity'";
	$track++;
}

if(!empty($obj->fromrecordedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.recordedon>='$obj->fromrecordedon'";
	$track++;
}

if(!empty($obj->torecordedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.recordedon<='$obj->torecordedon'";
	$track++;
}

if(!empty($obj->fromactedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.actedon>='$obj->fromactedon'";
	$track++;
}

if(!empty($obj->toactedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.actedon<='$obj->toactedon'";
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="prod_varietystocks";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
	 TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
 	$('#tbl').dataTable( {
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_varietystocks",
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
<form  action="varietystocks.php" method="post" name="varietystocks" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Document No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
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
				<td>Transaction</td>
				<td><input type='text' id='transaction' size='20' name='transaction' value='<?php echo $obj->transaction;?>'></td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><strong>From:</strong><input type='text' id='fromquantity' size='from20' name='fromquantity' value='<?php echo $obj->fromquantity;?>'/>
								<br/><strong>To:</strong><input type='text' id='toquantity' size='to20' name='toquantity' value='<?php echo $obj->toquantity;?>'></td>
			</tr>
			<tr>
				<td>Date Recorded</td>
				<td><strong>From:</strong><input type='text' id='fromrecordedon' size='16' name='fromrecordedon' readonly class="date_input" value='<?php echo $obj->fromrecordedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='torecordedon' size='16' name='torecordedon' readonly class="date_input" value='<?php echo $obj->torecordedon;?>'/></td>
			</tr>
			<tr>
				<td>Acted On</td>
				<td><strong>From:</strong><input type='text' id='fromactedon' size='16' name='fromactedon' readonly class="date_input" value='<?php echo $obj->fromactedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toactedon' size='16' name='toactedon' readonly class="date_input" value='<?php echo $obj->toactedon;?>'/></td>
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
				<td><input type='checkbox' name='grvarietyid' value='1' <?php if(isset($_POST['grvarietyid']) ){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='areaid' value='1' <?php if(isset($_POST['areaid']) ){echo"checked";}?>>&nbsp;grareaid</td>
				<td><input type='checkbox' name='grtransaction' value='1' <?php if(isset($_POST['grtransaction']) ){echo"checked";}?>>&nbsp;Transaction</td>
			<tr>
				<td><input type='checkbox' name='gractedon' value='1' <?php if(isset($_POST['gractedon']) ){echo"checked";}?>>&nbsp;Acted On</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
				<td><input type='checkbox' name='shvarietyid' value='1' <?php if(isset($_POST['shvarietyid']) ){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='shareaid' value='1' <?php if(isset($_POST['shareaid']) ){echo"checked";}?>>&nbsp;Area</td>
				<td><input type='checkbox' name='shtransaction' value='1' <?php if(isset($_POST['shtransaction']) ){echo"checked";}?>>&nbsp;Transaction</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity']) ){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shremain' value='1' <?php if(isset($_POST['shremain']) ){echo"checked";}?>>&nbsp;Remains</td>
			<tr>
				<td><input type='checkbox' name='shrecordedon' value='1' <?php if(isset($_POST['shrecordedon']) ){echo"checked";}?>>&nbsp;Date Recorded</td>
				<td><input type='checkbox' name='shactedon' value='1' <?php if(isset($_POST['shactedon']) ){echo"checked";}?>>&nbsp;Acted On</td>
			<tr>
				<td><input type='checkbox' name='grrecordedon' value='1' <?php if(isset($_POST['grrecordedon']) ){echo"checked";}?>>&nbsp;Date Recorded</td>
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
			<?php if($obj->shdocumentno==1 ){ ?>
				<th>Document No </th>
			<?php } ?>
			<?php if($obj->shvarietyid==1 ){ ?>
				<th>Variety </th>
			<?php } ?>
			<?php if($obj->shareaid==1 ){ ?>
				<th>Area </th>
			<?php } ?>
			<?php if($obj->shtransaction==1 ){ ?>
				<th>Action </th>
			<?php } ?>
			<?php if($obj->shquantity==1 ){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shremain==1 ){ ?>
				<th>Remain </th>
			<?php } ?>
			<?php if($obj->shrecordedon==1 ){ ?>
				<th>Date Recorded </th>
			<?php } ?>
			<?php if($obj->shactedon==1 ){ ?>
				<th>Date Of Action </th>
			<?php } ?>
			<?php if($obj->grrecordedon==1 ){ ?>
				<th>Date Recorded </th>
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
