<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules///_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include"../../../rptheader.php";

//processing filters
$rptwhere='';
$track=0;
if(!empty($obj->name)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" pms_projects.name='$obj->name'";
	$track++;
}

if(!empty($obj->deliverymethodid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" pms_projects.deliverymethodid='$obj->deliverymethodid'";
	$track++;
}

if(!empty($obj->roadid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" pms_projects.roadid='$obj->roadid'";
	$track++;
}

if(!empty($obj->contractorid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" pms_projects.contractorid='$obj->contractorid'";
	$track++;
}

if(!empty($obj->contractno)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" pms_projects.contractno='$obj->contractno'";
	$track++;
}

if(!empty($obj->contractsum)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" pms_projects.contractsum='$obj->contractsum'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
?>
<title><?php echo $page_title; ?></title>
<div id="main">
<div id="main-inner">
<div id="content">
<div id="content-inner">
<div id="content-header">
	<div class="page-title"><?php echo $page_title; ?></div>
	<div class="clearb"></div>
</div>
<div id="content-flex">
<div class="buttons"><a class="positive" href="javascript: expandCollapse('boxB','over');" style="vertical-align:text-top;">Open Popup To Filter</a></div>
<div id="boxB" class="sh" style="left: 100px; top: 63px; display: none; z-index: 500;">
<div id="box2"><div class="bar2" onmousedown="dragStart(event, 'boxB')"><span><strong>Choose Criteria</strong></span>
<a href="#" onclick="expandCollapse('boxB','over')">Close</a></div>
<form  action=".php" method="post" name="">
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Project Name</td>
				<td><input type='text' id='name' size='32' name='name' value='<?php echo $obj->name;?>'></td>
			</tr>
			<tr>
				<td>Delivery Method</td>
				<td>
				<select name='deliverymethodid'>
				<option value="">Select...</option>
				<?php
				$deliverymethods=new Deliverymethods();
				$where="  ";
				$fields="pms_deliverymethods.id, pms_deliverymethods.name, pms_deliverymethods.remarks, pms_deliverymethods.createdby, pms_deliverymethods.createdon, pms_deliverymethods.lasteditedby, pms_deliverymethods.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$deliverymethods->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($deliverymethods->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->deliverymethodid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Road</td>
				<td>
				<select name='roadid'>
				<option value="">Select...</option>
				<?php
				$roads=new Roads();
				$where="  ";
				$fields="pms_roads.id, pms_roads.name, pms_roads.roadno, pms_roads.length, pms_roads.Remarks, pms_roads.createdby, pms_roads.createdon, pms_roads.lasteditedby, pms_roads.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$roads->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($roads->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->roadid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Contractor</td>
				<td>
				<select name='contractorid'>
				<option value="">Select...</option>
				<?php
				$contractors=new Contractors();
				$where="  ";
				$fields="pms_contractors.id, pms_contractors.name, pms_contractors.address, pms_contractors.tel, pms_contractors.physicaladdress, pms_contractors.contactperson, pms_contractors.contacttel, pms_contractors.createdby, pms_contractors.createdon, pms_contractors.lasteditedby, pms_contractors.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$contractors->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($contractors->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->contractorid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Contract No</td>
				<td><input type='text' id='contractno' size='12' name='contractno' value='<?php echo $obj->contractno;?>'></td>
			</tr>
			<tr>
				<td>Contract Sum</td>
				<td><input type='text' id='contractsum' size='4' name='contractsum' value='<?php echo $obj->contractsum;?>'></td>
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
				<td><input type='checkbox' name='shname' value='1'>&nbsp;Project Name</td>
			<tr>
				<td><input type='checkbox' name='shdeliverymethodid' value='1'>&nbsp;Delivery Method</td>
				<td><input type='checkbox' name='shroadid' value='1'>&nbsp;Road</td>
			<tr>
				<td><input type='checkbox' name='shcontractorid' value='1'>&nbsp;Contrator</td>
			<tr>
				<td><input type='checkbox' name='shcontractno' value='1'>&nbsp;Contract No</td>
				<td><input type='checkbox' name='shscope' value='1'>&nbsp;Scope</td>
			<tr>
				<td><input type='checkbox' name='shcontractsum' value='1'>&nbsp;Contract Sum</td>
			<tr>
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
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$=new  ();
		$fields="";
		$join="";
		$having="";
		$where= " $rptwhere";
		$groupby= " $rptgroup";
		$orderby="";
		$->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</div>
</div>
</div>
</div>
</div>
