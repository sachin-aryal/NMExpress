<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 9:53 PM
 */
require "../Common/AdminDbConnection.php";
require "../Common/CommonFunction.php";
checkSession();
customerValidator();
if(isset($_POST["receiver_id"])){
    $receiver_id = addslashes($_POST["receiver_id"]);
    $receiverInfo = getReceiverInfo($conn,$receiver_id);

    if($conn->query("delete from payment_sas where receiver_id =$receiver_id")){
        if($conn->query("delete from receiver_sas where id=$receiver_id")){
            if($receiverInfo["bank_id"]!=null){
                $bank_id = $receiverInfo["bank_id"];
                if(!$conn->query("delete from bank_sas where id = $bank_id")){
                    $data = array("success"=>false);
                    echo json_encode($data);
                    return;
                }
            }
            $data = array("success"=>true);
            echo json_encode($data);
            return;
        }else{
            $data = array("success"=>false);
            echo json_encode($data);
            return;
        }
    }else{
        $data = array("success"=>false);
        echo json_encode($data);
        return;
    }
}
?>