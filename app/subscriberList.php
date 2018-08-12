<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/19/2016
 * Time: 8:36 PM
 */
require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
checkSession();
adminValidator();
$subscriberList = getSubscriberList($conn);
?>
<html>
<head>
    <?php include "Include/BootstrapCss.html" ?>
    <title>
        NME
    </title>
    <script type="text/javascript">
        $(document).ready(function(){
            var table = $("#subscriberList").DataTable({
                dom: 'Blrtip',
                orderClasses: false,
                buttons: [
                    {
                        extend: 'excel',
                        "oSelectorOpts": { filter: 'applied'}
                    }
                ]
            });
            $("#checkAll").change(function () {
                $("input[name=subscribesCheck]").prop('checked', $(this).prop("checked"));
            });
            $("input[name=subscribesCheck]").change(function(){
                var totalCheckbox = $('input[name=subscribesCheck]').length;
                var totalCheckedBox = $('input[name=subscribesCheck]:checked').length;
                if(totalCheckbox==totalCheckedBox){
                    $("#checkAll").prop("checked",true);
                }else{
                    $("#checkAll").prop("checked",false);
                }
            });
        });
    </script>
</head>
<body>
<?php include "Include/header.php" ?>
<div class="container">
        <div class="row no-pad">            <div class="col-md-8 no-pad">

            <div id="subscriberListDiv">

        <table id = "subscriberList" class="table table-bordered">
            <thead>
            <tr>
                <th><p><label><input type="checkbox" id="checkAll"/> Check all</label></p></th>
                <th>Email</th>
                <th>Added Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($subscriberList as $perUser) {
                ?>
                <tr>
                    <td><input type="checkbox" name="subscribesCheck" value="<?php echo $perUser['id'] ?>" </td>
                    <td><?php echo $perUser["email"]; ?></td>
                    <td><?php echo $perUser["added_date"]; ?></td>
                    <td>
                        <a href="#" data-toggle="modal" data-target="#editSubscriberDiv"
                        onclick="setValueToField('<?php echo $perUser["id"]?>','<?php echo $perUser["email"]?>')"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></button></a>
                        <a href="#" onclick="deleteSubscriber('<?php echo $perUser["id"]?>')"><button class="btn btn-danger btn-xs" ><span class="glyphicon glyphicon-trash"></span></button></a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
                </div>
            <div class="col-md-4">
    <div id="sendMessageDiv" style="float: right;margin-top:25px">
        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject"/><br><br>
        <textarea name="message" class="form-control" id="message" rows="5" cols="40" placeholder="Enter the message"></textarea><br>
        <button class="btn btn-primary" onclick="sendEmailSubs()">Send</button>
    </div>
                </div>
</div>
<?php include "editSubscriber.php"?>
</body>
</html>
