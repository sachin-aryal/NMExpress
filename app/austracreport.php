<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/16/2016
 * Time: 11:37 AM
 */
require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
require_once "Common/PaymentFunction.php";
checkSession();
adminValidator();
$rawData = getWholePayments($conn);

?>
<html>
<head>
    <title>
        NME
    </title>
    <?php include "Include/BootstrapCss.html" ?>
	<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            var table = $("#transactionReportTable").DataTable({
                dom: 'Blrtip',
                buttons: [
                    {
                        extend: 'excel',
                        "oSelectorOpts": { filter: 'applied'},
                        exportOptions: {
                            modifier: {
								selected: true
							}
                        }
                    }
                ],
				select: true
            });
			
        });
		
		
    </script>
</head>
<body>

<?php include "Include/header.php"; ?>

<h3 class="text-center">Transaction Report</h3>
<div id="transactionReportDiv" style="width: 95%;margin: 0 auto;">
    <table id="transactionReportTable" class="table table-bordered">
        <thead>
        <tr>
            <th>Date money</th>
            <th>Date money</th>
            <th>Currency code</th>
            <th>Total amount/value</th>
            <th>Type of transfer</th>
            <th>Pin No</th>
        </tr>
        </thead>
        <tbody>


        <?php
		$reportData = array();
      
        $i=1;
        foreach($rawData as $data){
            ?>
            <tr>
                <td><?php echo $data["payment_date"];?></td>
				<td><?php echo $data["delivered_date"];?></td>
				<td><?php echo "AUD"?></td>
				<td><?php echo $data["amount"];?></td>
				<td><?php echo "money";?></td>
				<td><?php echo $data["id"];?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
