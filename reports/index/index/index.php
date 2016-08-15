<?php
session_start();
require_once "../../../lib.php";
require_once '../../../DB.php';

$db = new DB();

if(empty($_SESSION['userid'])){;
redirect("../../../modules/auth/users/login.php");
}

$page_title="Reports";

include"../../../head.php";
?>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">PRODUCTION</a></li>
		<li><a href="#tabs-2">POST HARVEST</a></li>
		<li><a href="#tabs-3">SALES</a></li>
       	
	</ul>
	<div id="tabs-1" style="min-height:420px;">
			<ul>
				<li><a class="button icon chat" href="javascript:poptastic('../../prod/plantings/plantings.php',700,1020);">Plantings</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../prod/breederdeliverys/breederdeliverys.php',700,1020);">Breeder Deliveries</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../prod/qualitychecks/qualitychecks.php',700,1020);">Quality Checks</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../prod/rejects/rejects.php',700,1020);">Rejects</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../prod/uproots/uproots.php',700,1020);">Uproots</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../prod/varietys/varietys.php',700,1020);">Pre-cool Stocks</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../prod/varietystocks/varietystocks.php',700,1020);">Aging Stocks</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../prod/forecastings/forecastings.php',700,1020);">Forecastings</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../prod/sprayprogrammes/sprayprogrammes.php',700,1020);">Spray Programmes</a></li>
			</ul>
            		<div style="clear:both;"></div>
    </div><!-- TEnd -->
    <div id="tabs-2" style="min-height:420px;">
    <ul>
				<li><a class="button icon chat" href="javascript:poptastic('../../prod/harvests/harvests.php',700,1020);">Harvests</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../post/graded/graded.php',700,1020);">Graded</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/items/items.php',700,1020);">Cold Store Stocks</a></li>
			</ul>
    		<div style="clear:both;"></div>
    </div><!-- TEnd -->
    <div id="tabs-3" style="min-height:420px;">
    <ul>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/orders/orders.php',700,1020);">Orders</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/confirmedorders/confirmedorders.php',700,1020);">Confirmed Orders</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/packinglists/packinglists.php',700,1020);">Packing Lists</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/invoices/invoices.php',700,1020);">Invoices</a></li>
			</ul>
    		<div style="clear:both;"></div>
    </div><!-- TEnd -->
 
     		<div style="clear:both;"></div>
<?php
include"../../../foot.php";
?>
