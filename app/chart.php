<?php
ob_start("ob_gzhandler");
require "Common/DbConnection.php";
require "Common/CommonFunction.php";
$rates=getExchangeRateForGraph($conn);
$chart_data = array();
foreach($rates as $result)
{
 $chart_data[] = array($result['last_updated'], (float)$result['nrs']);
}

echo $chart_data = json_encode(array_reverse($chart_data));

?>


