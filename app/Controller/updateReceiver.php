<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/18/16
 * Time: 11:50 PM
 */
require '../Common/DbConnection.php';
require '../Common/CommonFunction.php';
if(isset($_POST["f_name"])){
    $id = addslashes($_POST["id"]);
    $firstName = addslashes($_POST["f_name"]);
    $middleName = addslashes($_POST["m_name"]);
    $lastName = addslashes($_POST["l_name"]);
    $phoneNo = addslashes($_POST["phone_no"]);
    $city = addslashes($_POST["city"]);
    $zone = addslashes($_POST["zone"]);
    $district = addslashes($_POST["district"]);
    $country= "Nepal";
    $paymentType = addslashes($_POST['payment_type']);
    $bankId = addslashes($_POST["bank_id"]);
    if($paymentType=="Bank" && empty($bankId)){
        $accountName = addslashes($_POST['account_name']);
        $bankName = addslashes($_POST["bank_name"]);
        $bankBranch = addslashes($_POST["branch_name"]);
        $accountNumber = addslashes($_POST['account_number']);
        $bankQuery = "INSERT INTO bank_sas(account_name,account_no,bank_name,branch_name) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($bankQuery);
        $stmt->bind_param("ssss",$accountName,$accountNumber,$bankName,$bankBranch);
        $stmt->execute();
        $bankId = mysqli_stmt_insert_id($stmt);
    }else if($paymentType == "Bank" && !empty($bankId)){

        $accountName = addslashes($_POST['account_name']);
        $bankName = addslashes($_POST["bank_name"]);
        $bankBranch = addslashes($_POST["branch_name"]);
        $accountNumber = addslashes($_POST['account_number']);
        $bankQuery = "UPDATE bank_sas SET account_name = ?,account_no = ?,bank_name = ?,branch_name = ? WHERE id = ?";
        $stmt = $conn->prepare($bankQuery);
        $stmt->bind_param("ssssi",$accountName,$accountNumber,$bankName,$bankBranch, $bankId);
        $stmt->execute();
    }else{
        $bankId = null;
    }
//    $customerId = getCustomerId($conn);

    $insertNewReceiver = "UPDATE receiver_sas SET f_name = ?,m_name = ?,l_name = ?,payment_type = ?, phone_no = ?, city = ?, zone = ?, district = ?, 
country = ?, bank_id = ? WHERE id = ?";

    $stmt = $conn->prepare($insertNewReceiver);
    $stmt->bind_param("sssssssssii",$firstName,$middleName,$lastName,$paymentType,$phoneNo,$city,$zone,$district,$country,$bankId, $id);
    if($stmt->execute()){
        $data = array("success"=>true);
        echo json_encode($data);
    }else{
        $data = array("success"=>false);
        echo json_encode($data);
    }
}