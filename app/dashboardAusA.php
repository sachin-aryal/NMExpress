<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/12/16
 * Time: 7:03 AM
 */
require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";

checkSession();

ausAgentValidator();


$agentId = getAgentId($conn);
$collectionReport = getCollectionForAgent($conn,$agentId);
$agent_transactionReport = agent_transactionReport($conn,$agentId);
?>
<html>
<head>
    <title>NME</title>
    <?php include "Include/BootstrapCss.html" ?>
    <script type="text/javascript" language="javascript" src="Assets/Js/bootstrap-datepicker.min.js">
    </script>
    <script type="text/javascript">

        $(document).ready(function(){

            $('.sandbox-container').datepicker({
                format: "yyyy/mm/dd"
            });

            var table = $("#collectionList").DataTable({
                dom: 'Blrtip',
                orderClasses: false,
                buttons: [
                    {
                        extend: 'excel',
                        "oSelectorOpts": { filter: 'applied'}
                    }
                ],
            });

           
            var table = $('#transactionList').DataTable( {
                    "bProcessing"   :   true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'pdfHtml5',
                            customize: function ( doc ) {
                                doc.content.splice( 0, 0, {
                                    text: "Customer Transaction"
                                } );
                            }
                        },
                        'excelHtml5',
                    ],
            } );

        })
    </script>
    <link href="Assets/Css/bootstrap-datepicker.min.css" rel="stylesheet"/>
</head>
<body>
<?php include "Include/header.php" ?>
<div class="container row">
    <div class="col-md-10 style="width: 50%; margin: 0 auto"">
        <ul class="nav nav-tabs" id="myTab">
              <li class="active"><a data-target="#home" data-toggle="tab">Collection List</a></li>
              <li><a data-target="#profile" data-toggle="tab">Transaction List</a></li>
        </ul>
        
        <div class="tab-content">
            <div class="tab-pane active" id="home"><?php include "collectionList.php" ?></div>
            <div class="tab-pane" id="profile"><?php include "agent_transactionlist.php" ?></div>
        </div>
    </div>
</div>
 



</body>

</html>