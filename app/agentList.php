<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/17/2016
 * Time: 8:48 AM
 */
require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
require_once "Common/PaymentFunction.php";
checkSession();
adminValidator();
$agents = getAllAgents($conn);
$nepaleseAgents = getAllNepaliAgents($conn);
?>
<html>
<head>
    <title>
        NME
    </title>
    <?php include "Include/BootstrapCss.html" ?>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".agentClass").html($(".agentClass").html() + $("#agentsDiv").html());
            $("#dTab").DataTable({
                dom: 'Blfrtip',
                orderClasses: false,
                buttons: [
                    {
                        extend: 'excel',
                        "oSelectorOpts": { filter: 'applied'}
                    }
                ]
            });
        });
    </script>
</head>
<body>
<?php include "Include/header.php"; ?>
<div id="agentList" class="container">
    <a class="btn btn-primary" href="createAgent.php">Create Agent</a>
    <h3 class="text-center">Agent List</h3>
    <table id="dTab" class="table table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>address</th>
            <th>Phone</th>
            <th>Company Name</th>
            <th>Company Address</th>
            <th>Company Phone</th>
            <th>Identity Type</th>
            <th>Identity No</th>
            <th>Agent Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for($i = 0; $i < count($agents); $i++){
            $agent = $agents[$i];
            ?>
            <tr>
                <td><?php echo $agent["id"];?></td>
                <td><a href="editAgent.php?id=<?php echo $agent["id"]?>"><?php echo $agent["name"];?></a></td>
                <td><?php echo $agent["email"];?></td>
                <td><?php echo $agent["address"];?></td>
                <td><?php echo $agent["phone"];?></td>
                <td><?php echo $agent["company_name"];?></td>
                <td><?php echo $agent["company_address"];?></td>
                <td><?php echo $agent["company_phone"];?></td>
                <td><?php echo $agent["id_type"];?></td>
                <td><?php echo $agent["id_no"];?></td>
                <td><?php echo $agent["agent_type"];?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>

