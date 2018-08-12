<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/14/16
 * Time: 10:01 PM
 */
require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
require_once "Common/PaymentFunction.php";
checkSession();
ausAgentAdminValidator();
$todayRate = getExchangeRate($conn);

if($_SESSION["role"] == "ROLE_AUSAGENT")
    $pendingPayments = getAllPayments($conn, getAusAgentUserId($conn));
else
    $pendingPayments = getAllPayments($conn, getUserIdAgent($conn, $_GET["id"]));
?>
<html>
<head>
    <title>
        NME
    </title>
    <?php include "Include/BootstrapCss.html" ?>
    <style>
        table, th, td{

            border: 1px solid black;
        }
    </style>
</head>
<body>
<?php include "Include/header.php" ?>

<h2>Due Status</h2>
<table>
    <thead>
        <th>Total</th>
        <th>Bank</th>
        <th>Due</th>
    </thead>
    <tbody>
        <tr>
            <?php
                $totalDue = 0;
                $totalBank = 0;
                $due = 0;
                for ($i = 0; $i < count($pendingPayments); $i++){

                    $totalDue += $pendingPayments[$i]["total"];
                    if($pendingPayments[$i]["received"] == "Bank")
                        $totalBank += $pendingPayments[$i]["total"];
                }
                $due = $totalDue - $totalBank;
            ?>
            <td><?php echo $totalDue?></td>
            <td><?php echo $totalBank?></td>
            <td><?php echo $due?></td>
        </tr>
    </tbody>
</table>
</body>
</html>