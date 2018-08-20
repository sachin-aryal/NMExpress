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
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $customerList = getUnactivatedCustomerList($conn);
        foreach($customerList as $customer){
            ?>
            <tr>
                <td><?php echo $customer["id"];?></td>
                <td><?php echo $customer["username"]?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>

