<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 8:26 PM
 */
require '../Common/DbConnection.php';
require '../Common/CommonFunction.php';
$firstName = addslashes($_POST["f_name"]);
$lastName = addslashes($_POST["l_name"]);
$phoneNo = addslashes($_POST["phone_no"]);
$city = addslashes($_POST["city"]);
$zone = addslashes($_POST["zone"]);
$district = addslashes($_POST["district"]);
$country= addslashes($_POST["country"]);
$paymentType = addslashes($_POST['payment_type']);
$bankId = addslashes($_POST["bank_id"]);
$receiver_id = addslashes($_POST["receiver_id"]);
$previousBankId = null;
if($paymentType=="Bank"){
    $accountName = addslashes($_POST['account_name']);
    $bankName = addslashes($_POST["bank_name"]);
    $bankBranch = addslashes($_POST["branch_name"]);
    $accountNumber = addslashes($_POST['account_number']);
    if($bankId!=null){
        $bankQuery = "update bank_sas set account_name=?,account_no=?,bank_name=?,branch_name=? where id=$bankId";
        $stmt = $conn->prepare($bankQuery);
        $stmt->bind_param("ssss",$accountName,$accountNumber,$bankName,$bankBranch);
        $stmt->execute();
    }else{
        $bankQuery = "INSERT INTO bank_sas(account_name,account_no,bank_name,branch_name) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($bankQuery);
        $stmt->bind_param("ssss",$accountName,$accountNumber,$bankName,$bankBranch);
        $stmt->execute();
        $bankId = mysqli_stmt_insert_id($stmt);
    }
    $updateReceiver = "update receiver_sas set f_name='$firstName',l_name='$lastName',
                  phone_no='$phoneNo',city='$city',
                  zone='$zone',district='$district',country='$country',payment_type='$paymentType',
                  bank_id=$bankId where id=$receiver_id";

}else{
    if($bankId != null){
        $previousBankId = $bankId;
    }
    $updateReceiver = "update receiver_sas set f_name='$firstName',l_name='$lastName',
                  phone_no='$phoneNo',city='$city',
                  zone='$zone',district='$district',country='$country',payment_type='$paymentType',
                  bank_id=NULL where id=$receiver_id";
}

if($conn->query($updateReceiver)){
    if($previousBankId!=null){
        $conn->query("delete from bank_sas where id = $previousBankId");
    }
    $data = array("success"=>true);
    echo json_encode($data);
}else{
    $data = array("success"=>false);
    echo json_encode($data);
}