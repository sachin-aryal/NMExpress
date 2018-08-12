<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/13/2016
 * Time: 1:04 PM
 */
include_once "Common/CommonFunction.php";
include_once "Common/DbConnection.php";
adminValidator();
?>
<html>
<head>
    <title>NME</title>
    <?php include "Include/BootstrapCss.html" ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#memberListTable").DataTable({
                dom: 'Blfrtip',
                orderClasses: false,
                buttons: [
                    {
                        extend: 'excel',
                        "oSelectorOpts": { filter: 'applied'}
                    }
                ]
            })
        })
    </script>
</head>

<body>

<?php include "Include/header.php"; ?>

<span style="z-index: 5;position: absolute;top:137px;left:118px;color:#ffffff" class="glyphicon glyphicon-download-alt"></span>
<div class="container">
    <table id="memberListTable" class="table table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Is a/an</th>
            <th>Email</th>
            <th>Mobile Number</th>
            <th>Unit</th>
            <th>Street</th>
            <th>State</th>
            <th>Reward Point</th>
            <th>Total Transaction(NPR.)</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $customerList = getCustomerList($conn);
        foreach($customerList as $customer){
            ?>
            <tr>
                <td><?php echo $customer["id"];?></td>
                <td><a href = "customerProfile.php?id=<?php echo $customer["id"];?>"><?php echo $customer["name"]?></a></td>
                <td><?php echo $customer["type"]?></td>
                <td><?php echo $customer["email"]?></td>
                <td><?php echo $customer["mobile_no"]?></td>
                <td><?php echo $customer["unit"]?></td>
                <td><?php echo $customer["street"]?></td>
                <td><?php echo $customer["state"]?></td>
                <td><?php echo $customer["reward_point"]?></td>
                <td><?php echo $customer["total_transaction"] ?: 0?></td>
                    <td><a target="_blank" style="cursor: pointer" onclick="deleteCustomer('<?php echo $customer["id"];?>')">Delete</a></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
