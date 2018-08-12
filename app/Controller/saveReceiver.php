<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/1/2016
 * Time: 12:08 PM
 */

require '../Common/DbConnection.php';
require '../Common/CommonFunction.php';
if(isset($_POST["f_name"])){
    $firstName = addslashes($_POST["f_name"]);
    $middleName = addslashes($_POST["m_name"]);
    $lastName = addslashes($_POST["l_name"]);
    $phoneNo = addslashes($_POST["phone_no"]);
    $city = addslashes($_POST["city"]);
    $zone = addslashes($_POST["zone"]);
    $district = addslashes($_POST["district"]);
    $country= "Nepal";
    $paymentType = addslashes($_POST['payment_type']);
    $bankId = null;
    if($_SESSION["role"] == "ROLE_CUSTOMER")
        $customerId = getCustomerId($conn);
    else
        $customerId = $_POST["senderId2"];
    if($paymentType=="Bank"){
        $accountName = addslashes($_POST['account_name']);
        $bankName = addslashes($_POST["bank_name"]);
        $bankBranch = addslashes($_POST["branch_name"]);
        $accountNumber = addslashes($_POST['account_number']);
        $bankQuery = "INSERT INTO bank_sas(account_name,account_no,bank_name,branch_name) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($bankQuery);
        $stmt->bind_param("ssss",$accountName,$accountNumber,$bankName,$bankBranch);
        $stmt->execute();
        $bankId = mysqli_stmt_insert_id($stmt);
    }

        /*INSERT into receiver_sas(f_name,l_name,mobile_no,phone_no,city,zone,district,
    country,customer_id,bank_id) VALUES ("s", "asf", "sdf", "asf", "s", "asf", "sdf", "s", 8, NULL)*/

    $stmt = $conn->prepare("INSERT INTO receiver_sas(f_name,m_name,l_name,payment_type,phone_no,city,zone,district,
      country,customer_id,bank_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssii",$firstName,$middleName,$lastName,$paymentType,$phoneNo,$city,$zone,$district,$country,
        $customerId,$bankId);
    if($stmt->execute()){
        $data = array("success"=>true,
                        "receiverId"=>mysqli_stmt_insert_id($stmt),
                        "receiverName"=>$firstName . " " . $lastName
        );
        echo json_encode($data);
    }else{
        $data = array("success"=>false);
        echo json_encode($data);
    }
}