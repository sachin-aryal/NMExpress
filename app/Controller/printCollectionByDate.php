<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/21/2016
 * Time: 12:48 PM
 */
require_once "../Common/DbConnection.php";
require_once "../Common/CommonFunction.php";
require_once "../Common/PaymentFunction.php";
if(isset($_POST["collection_date"])){
    $date = addslashes($_POST["collection_date"]);
    $collectionData = getDateByCollection($conn,$date);
?>
    <script type="text/javascript">
        $(function(){
            $("#collectionList").DataTable({
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

<table id = "collectionList" style="margin: 0 auto" class="display">
    <thead>
    <tr>
        <th>Agent Name</th>
        <th>Total Transaction</th>
        <th>Total Collection($)</th>
        <th>Collection Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($collectionData as $perDay) {
        ?>
        <tr>
            <td><?php echo $perDay["agent_name"] ?></td>
            <td><?php echo $perDay["no_transaction"]; ?></td>
            <td><?php echo $perDay["total_collection"]; ?></td>
            <td><?php echo $perDay["collection_date"]; ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
<?php
}else{
    goToDashBoard("../");
}
    ?>