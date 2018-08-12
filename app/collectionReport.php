<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/21/2016
 * Time: 12:31 PM
 */
require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";

checkSession();
adminValidator();

$agentId = getAgentId($conn);
$ajakoDate = date("Y-m-d");
?>

<html>
<head>
    <title>NME</title>
    <?php include "Include/BootstrapCss.html" ?>
    <script type="text/javascript" language="javascript" src="Assets/Js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.sandbox-container').datepicker({
                format: "yyyy/mm/dd"
            });

            printCollectionDate("<?php echo $ajakoDate ?>");

        });

    </script>
    <link href="Assets/Css/bootstrap-datepicker.min.css" rel="stylesheet"/>
</head>
<body>
<?php include_once "Include/header.php"; ?>
<div id="filter" style="margin:0px auto;width: 50%">
    <div class="form-group">
        <div class="row">
            <div class="col-xs-4">
                <label class="control-label">Collection Date</label>
                <input type="text" class="form-control sandbox-container" name="collection_date" id="collection_date"
                       onchange="printCollectionDate($('#collection_date').val())" placeholder="Collection Date"/>
            </div>
            <div class="col-xs-3">
                <label class="control-label">All Collection</label><br>
                <button onclick="printCollectionDate('all')" class="btn btn-primary">All</button>
           </div>
        </div>
    </div>
</div>

<div id="collectionData" style="width: 80%;margin:0 auto;">

</div>
</body>
</html>
