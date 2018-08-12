<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/16/2016
 * Time: 7:48 PM
 */
require_once "Common/DbConnection.php";
require_once "Common/PaymentFunction.php";
require_once "Common/CommonFunction.php";
checkSession();
adminValidator();
$reportByDate = getServiceChargeData($conn)

?>
<html>
<head>
    <?php include "Include/BootstrapCss.html" ?>
    <title>
        NME
    </title>
    <script type="text/javascript">
        $(document).ready(function(){
            var table = $("#serviceChargeReport").DataTable({
                dom: 'Blrtip',
                orderClasses: false,
                buttons: [
                    {
                        extend: 'excel',
                        "oSelectorOpts": { filter: 'applied'}
                    }
                ]
            });

        })
    </script>
</head>
<body>
<?php include "Include/header.php" ?>
<div id="serviceChargeReportDiv" style="width: 50%;margin: 0 auto" class="table-responsive display">
    <table id = "serviceChargeReport" class="table table-bordered">
        <thead>
        <tr>
            <th>Payment Date</th>
            <th>Total Transaction</th>
            <th>Total Collection</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($reportByDate as $perDay) {
            ?>
            <tr>
                <td><?php echo $perDay["payment_date"]; ?></td>
                <td><?php echo $perDay["totalTransaction"]; ?></td>
                <td>$<?php echo $perDay["totalCollection"]; ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
