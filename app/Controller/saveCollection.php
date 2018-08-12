<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/20/2016
 * Time: 2:34 PM
 */

include_once "../Common/DbConnection.php";
include_once "../Common/CommonFunction.php";
if(isset($_POST["total_transaction"]) && isset($_POST["total_collection"]) && isset($_POST["collection_date"])){

    $totalTransaction = addslashes($_POST["total_transaction"]);
    $totalCollection = addslashes($_POST["total_collection"]);
    $collectionDate = addslashes($_POST["collection_date"]);
    $agentId = getAgentId($conn);
    $checkQuery = "select *from collection_sas where collection_date = '$collectionDate' AND agent_id = $agentId";
    $checkResult = $conn->query($checkQuery);
    if($checkResult->num_rows!=0){
        $updateQuery = "UPDATE collection_sas set no_transaction=$totalTransaction,total_collection=$totalCollection
                     where collection_date='$collectionDate' and  agent_id = $agentId";

        if($conn->query($updateQuery)){
            echo json_encode(array("success"=>true));
        }else{
            echo json_encode(array("success"=>false));
        }

    }else{
        $insertQuery = "INSERT into collection_sas(no_transaction,total_collection,collection_date,agent_id)
                        VALUES ($totalTransaction,$totalCollection,'$collectionDate',$agentId)";
        if($conn->query($insertQuery)){
            echo json_encode(array("success"=>true));
        }else{
            echo json_encode(array("success"=>false));
        }
    }

}else{
    echo json_encode(array("success"=>false));
}