<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/20/2016
 * Time: 1:30 PM
 */
?>
<div id="addCol" style="width: 100%;margin: 0 auto">
    <button data-target="#addCollectionReport" data-toggle="modal" class="btn" style="margin: 0 auto">Add Collection</button>
</div>
<div id="collectionListDiv" style="width: 50%;margin: 20px auto; padding-top:15px;" class="table-responsive display">
    <table id = "collectionList" class="table-responsive display" style="width:75%" >
        <thead>
        <tr>
            <th>Collection Date</th>
            <th>Total Transaction</th>
            <th>Total Collection($)</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($collectionReport as $perDay) {
            ?>
            <tr >
                <td><?php echo $perDay["date"]; ?></td>
                <td><?php echo $perDay["count"]; ?></td>
                <td><?php echo round($perDay["amount"],2); ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>



<div id="addCollectionReport" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id = "addCollectionClose" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Collection</h4>
            </div>
            <div class="modal-body">
                <form id="collectionForm" onsubmit="return false;">
                    <div class="col-lg-8">
                        <label for="total_transaction">Total Transaction</label>
                        <input type="text" name="total_transaction" id="total_transaction" placeholder="Total Transaction"
                               class="form-control" onkeypress="return onlyAmount(event,this)"/>
                    </div>
                    <div class="col-lg-8" style="margin-top: 10px">
                        <label for="total_collection">Total Collection</label>
                        <input type="text" name="total_collection" id="total_collection" placeholder="Total Collection"
                               onkeypress="return onlyAmount(event,this)" class="form-control"/>
                    </div>
                    <div class="col-lg-8" style="margin-top: 10px">
                        <label class="control-label">Collection Date</label>
                        <input type="text" class="form-control sandbox-container" name="collection_date" id="collection_date"
                               onchange="return validateDate($('#collection_date'),'Collection Date')" placeholder="Collection Date"/>
                    </div>
                    <div class="col-lg-8" style="margin-top: 10px">
                        <input type="submit" value="Save"  class="btn btn-primary" onclick="saveCollectionReport()"/>
                    </div>
            </div>
            <br><br><br>
            <br><br><br>
            <br><br><br>
            <br><br><br>
            </form>
        </div>
    </div>
</div>
