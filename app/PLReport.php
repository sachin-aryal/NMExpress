<?php
/**
 * Created by IntelliJ IDEA.
 * User: iam
 * Date: 8/2/16
 * Time: 3:48 PM
 */

require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
checkSession();
adminValidator();
?>

<html>
<head>
    <title>
        NME
    </title>
    <?php include_once "Include/BootstrapCss.html" ?>
    <script type="text/javascript">
        $(function(){
            $("#profitLossReport").DataTable();
        })
    </script>
</head>
<body>
<?php include_once "Include/header.php"; ?>
<?php
$profitLossData = getProfitLossData($conn);
?>

<div id="profitLossReportDiv" style="width: 80%;margin: 0 auto">
    <table id="profitLossReport" class="table table-bordered">
        <thead>
        <tr>
            <th>S.N</th>
            <th>Date</th>
            <th>No. of Transactions</th>
            <th>Total Collection(AUD)</th>
            <th>Profit(AUD)</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i=1;
        foreach($profitLossData as $perDay){
            echo '<tr>';
            echo '<td>'.$i++;'</td>';
            echo '<td>'.$perDay["profit_date"].'</td>';
            echo '<td>'.$perDay["no_of_transactions"].'</td>';
            echo '<td>'.$perDay["collection"].'</td>';
            echo '<td>'.$perDay["profit"].'</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
