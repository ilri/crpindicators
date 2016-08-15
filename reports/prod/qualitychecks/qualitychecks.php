<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/qualitychecks/Qualitychecks_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/prod/checkitems/Checkitems_class.php");
require_once("../../../modules/prod/breederdeliverydetails/Breederdeliverydetails_class.php");
require_once("../../../modules/prod/breeders/Breeders_class.php");
require_once("../../../modules/prod/varietys/Varietys_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Qualitychecks";
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
	if(!empty($obj->shcheckitemid)  or empty($obj->action)){
		array_push($sColumns, 'checkitemid');
		array_push($aColumns, "prod_checkitems.name as checkitemid");
		$rptjoin.=" left join prod_checkitems on prod_checkitems.id=prod_qualitychecks.checkitemid ";
		$k++;
	}

	if(!empty($obj->shbreederdeliverydetailid)  or empty($obj->action)){
		array_push($sColumns, 'breederdeliverydetailid');
		array_push($aColumns, "prod_breederdeliverydetails.breederdeliveryid as breederdeliverydetailid");
		$rptjoin.=" left join prod_breederdeliverydetails on prod_breederdeliverydetails.id=prod_qualitychecks.breederdeliverydetailid ";
		$k++;
	}

	if(!empty($obj->shbreederid)  or empty($obj->action)){
		array_push($sColumns, 'breederid');
		array_push($aColumns, "prod_breeders.name as breederid");
		$rptjoin.=" left join prod_breeders on prod_breeders.id=prod_qualitychecks.breederid ";
		$k++;
	}

	if(!empty($obj->shvarietyid)  or empty($obj->action)){
		array_push($sColumns, 'varietyid');
		array_push($aColumns, "prod_varietys.name as varietyid");
		$rptjoin.=" left join prod_varietys on prod_varietys.id=prod_qualitychecks.varietyid ";
		$k++;
	}

	if(!empty($obj->shcheckedon)  or empty($obj->action)){
		array_push($sColumns, 'checkedon');
		array_push($aColumns, "prod_qualitychecks.checkedon");
		$k++;
	}

	if(!empty($obj->shfindings) ){
		array_push($sColumns, 'findings');
		array_push($aColumns, "prod_qualitychecks.findings");
		$k++;
	}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "prod_qualitychecks.remarks");
		$k++;
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "prod_qualitychecks.createdby");
		$k++;
	}

	if(!empty($obj->shcheckedon)  or empty($obj->action)){
		array_push($sColumns, 'checkedon');
		array_push($aColumns, "prod_qualitychecks.checkedon");
		$k++;
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "prod_qualitychecks.ipaddress");
		$k++;
	}



//processing filters
if(!empty($obj->checkitemid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_qualitychecks.checkitemid='$obj->checkitemid'";
	$track++;
}

if(!empty($obj->breederdeliverydetailid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_qualitychecks.breederdeliverydetailid='$obj->breederdeliverydetailid'";
	$track++;
}

if(!empty($obj->breederid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_qualitychecks.breederid='$obj->breederid'";
	$track++;
}

if(!empty($obj->varietyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_qualitychecks.varietyid='$obj->varietyid'";
	$track++;
}

if(!empty($obj->fromcheckedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_qualitychecks.checkedon>='$obj->fromcheckedon'";
	$track++;
}

if(!empty($obj->tocheckedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_qualitychecks.checkedon<='$obj->tocheckedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_qualitychecks.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_qualitychecks.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_qualitychecks.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grcheckitemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" checkitemid ";
	$obj->shcheckitemid=1;
	$track++;
}

if(!empty($obj->grbreederdeliverydetailid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" breederdeliverydetailid ";
	$obj->shbreederdeliverydetailid=1;
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

if(!empty($obj->grvarietyid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" varietyid ";
	$obj->shvarietyid=1;
	$track++;
}

if(!empty($obj->grcheckedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" checkedon ";
	$obj->shcheckedon=1;
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

if(!empty($obj->grcreatedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdon ";
	$obj->shcreatedon=1;
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
 <?php $_SESSION['sTable']="prod_qualitychecks";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_qualitychecks",
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
<form  action="qualitychecks.php" method="post" name="qualitychecks" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Check Item</td>
				<td>
				<select name='checkitemid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$checkitems=new Checkitems();
				$where="  ";
				$fields="prod_checkitems.id, prod_checkitems.name, prod_checkitems.remarks, prod_checkitems.ipaddress, prod_checkitems.createdby, prod_checkitems.createdon, prod_checkitems.lasteditedby, prod_checkitems.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$checkitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($checkitems->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->checkitemid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Breeder Delivery Details</td>
				<td>
				<select name='breederdeliverydetailid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$breederdeliverydetails=new Breederdeliverydetails();
				$where="  ";
				$fields="prod_breederdeliverydetails.id, prod_breederdeliverydetails.breederdeliveryid, prod_breederdeliverydetails.varietyid, prod_breederdeliverydetails.quantity, prod_breederdeliverydetails.memo, prod_breederdeliverydetails.ipaddress, prod_breederdeliverydetails.createdby, prod_breederdeliverydetails.createdon, prod_breederdeliverydetails.lasteditedby, prod_breederdeliverydetails.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$breederdeliverydetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($breederdeliverydetails->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->breederdeliverydetailid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td>Checked On</td>
				<td><strong>From:</strong><input type='text' id='fromcheckedon' size='12' name='fromcheckedon' readonly class="date_input" value='<?php echo $obj->fromcheckedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocheckedon' size='12' name='tocheckedon' readonly class="date_input" value='<?php echo $obj->tocheckedon;?>'/></td>
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
				<td>Created On</td>
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grcheckitemid' value='1' <?php if(isset($_POST['grcheckitemid']) ){echo"checked";}?>>&nbsp;Check Item</td>
				<td><input type='checkbox' name='grbreederdeliverydetailid' value='1' <?php if(isset($_POST['grbreederdeliverydetailid']) ){echo"checked";}?>>&nbsp;Breeder Delivery Detail</td>
			<tr>
				<td><input type='checkbox' name='grbreederid' value='1' <?php if(isset($_POST['grbreederid']) ){echo"checked";}?>>&nbsp;Breeder</td>
				<td><input type='checkbox' name='grvarietyid' value='1' <?php if(isset($_POST['grvarietyid']) ){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='grcheckedon' value='1' <?php if(isset($_POST['grcheckedon']) ){echo"checked";}?>>&nbsp;Checked On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
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
				<td><input type='checkbox' name='shcheckitemid' value='1' <?php if(isset($_POST['shcheckitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Check Item</td>
				<td><input type='checkbox' name='shbreederdeliverydetailid' value='1' <?php if(isset($_POST['shbreederdeliverydetailid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Breeder Delivery Detail</td>
			<tr>
				<td><input type='checkbox' name='shbreederid' value='1' <?php if(isset($_POST['shbreederid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Breeder</td>
				<td><input type='checkbox' name='shvarietyid' value='1' <?php if(isset($_POST['shvarietyid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='shcheckedon' value='1' <?php if(isset($_POST['shcheckedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Checked On</td>
				<td><input type='checkbox' name='shfindings' value='1' <?php if(isset($_POST['shfindings']) ){echo"checked";}?>>&nbsp;Findings</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcheckedon' value='1' <?php if(isset($_POST['shcheckedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
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
			<?php if($obj->shcheckitemid==1  or empty($obj->action)){ ?>
				<th>Check Item </th>
			<?php } ?>
			<?php if($obj->shbreederdeliverydetailid==1  or empty($obj->action)){ ?>
				<th>Delivery </th>
			<?php } ?>
			<?php if($obj->shbreederid==1  or empty($obj->action)){ ?>
				<th>Breeder </th>
			<?php } ?>
			<?php if($obj->shvarietyid==1  or empty($obj->action)){ ?>
				<th>Variety </th>
			<?php } ?>
			<?php if($obj->shcheckedon==1  or empty($obj->action)){ ?>
				<th>Check Date </th>
			<?php } ?>
			<?php if($obj->shfindings==1 ){ ?>
				<th>Findings </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcheckedon==1  or empty($obj->action)){ ?>
				<th>Check Date </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
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
