<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 11:21 AM
 */
require 'Common/CommonFunction.php';
require 'Common/DbConnection.php';
$receiverList = getReceiverList($conn);
?>
<html>
<head>
    <title>NME</title>
    <?php include "Include/BootstrapCss.html" ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#receiverListTable').DataTable({

            })
        });
    </script>
</head>
<body>
<?php include "Include/headerCustomer.php" ?>

<div id="receiverListDiv" style="width: 90%;margin: 0 auto">
    <table id="receiverListTable" class="table table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>City</th>
            <th>District</th>
            <th>Zone</th>
            <th>Country</th>
            <th>Payment Type</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($receiverList as $eachRow) {
            ?>
            <tr>
                <td><?php echo $eachRow['f_name']." ".$eachRow['m_name']." ".$eachRow['l_name']?></td>
                <td><?php echo $eachRow['phone_no']?></td>
                <td><?php echo $eachRow['city']?></td>
                <td><?php echo $eachRow['district']?></td>
                <td><?php echo $eachRow['zone']?></td>
                <td><?php echo $eachRow['country']?></td>
                <td><?php echo $eachRow['payment_type']?></td>
                <td>
                    <a href="editReceiverDetails.php?receiver_id=<?php echo $eachRow['id']?>">View Details</a>
                    |
                    <a href="#" onclick="deleteReceiver('<?php echo $eachRow['id'];?>');">Delete</a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
<?php include "Include/footer.php" ?>
</body>
</html>
