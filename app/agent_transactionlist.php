<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/20/2016
 * Time: 1:30 PM
 */
?>
<div id="transactionListDiv" style="width: 100%;margin: 20px auto; padding-top:15px;" class="table-responsive display">
    <table id = "transactionList" class="table-responsive display" style="margin-top:20px;width:100%" >
        <thead>
        <tr>
            <th>Sender</th>
            <th>Payment Date</th>
            <th>Amount</th>
            <th>Fee</th>
            <th>Delivered on</th>
            <th>Rate</th>
            <th>Mobile</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($agent_transactionReport as $report) {
            ?>
            <tr>
                <td><?php echo $report["f_name"]; ?></td>
                <td><?php echo $report["payment_date"]; ?></td>
                <td><?php echo $report["amount"]; ?></td>
                <td><?php echo $report["fee"]; ?></td>
                <td><?php echo $report["delivered_date"]; ?></td>
                <td><?php echo $report["rate"]; ?></td>
                <td><?php echo $report["mobile_no"]; ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
