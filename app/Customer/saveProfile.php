<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/14/16
 * Time: 3:39 PM
 */
require_once "../Common/DbConnection.php";
require_once "../Common/CommonFunction.php";
checkSession();
adminValidator();

$customerId = $_POST["id"];
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$mobileNo = $_POST["mobileNo"];
$dob = addslashes($_POST["dob"]);
$dob = date_format(new DateTime($dob),'Y-m-d');
$idNo = addslashes($_POST["idNo"]);
$idType = addslashes($_POST["idType"]);
$expiryDate = addslashes($_POST["expiryDate"]);
$expiryDate = date_format(new DateTime($expiryDate),'Y-m-d');
$unit = addslashes($_POST["unit"]);
$street = addslashes($_POST["street"]);
$state = addslashes($_POST["state"]);
$type = addslashes($_POST["type"]);
$middleName = addslashes($_POST["middleName"]);
$city = addslashes($_POST["city"]);
$postCode = addslashes($_POST["postCode"]);
$role = "ROLE_CUSTOMER";
$customerInfo = getCustomerInfoFromId($customerId,$conn);
$business_id = null;

if(isset($_FILES["idFront"])) {
    $uploadOk = 1;
    $email = $customerInfo["email"];
    $target_dir = "customerIds/";
    $imageFileType = pathinfo(basename($_FILES["idFront"]["name"]),PATHINFO_EXTENSION);
    if($imageFileType!="") {
        $target_file = $target_dir . $email . '.' . $imageFileType;
        $check1 = getimagesize($_FILES["idFront"]["tmp_name"]);
        if (($check1) !== false) {
            $uploadOk = 1;
            move_uploaded_file($_FILES["idFront"]["tmp_name"], '../' . $target_file);
        }
    }else{
        $target_file = $customerInfo["id_front_url"];
    }
}else{
    $target_file = $customerInfo["id_front_url"];
}

if($type == "Business"){

    $name = addslashes($_POST["business_name"]);
    $established_date = addslashes($_POST["established_date"]);
    $established_date = date_format(new DateTime($established_date),'Y-m-d');
    $registration_no = addslashes($_POST["registration_no"]);

    $stmt = $conn->prepare("INSERT INTO business_sas(name, established_date, registration_no) VALUES (?, ?, ?);");
    $stmt->bind_param("sss", $name, $established_date, $registration_no);
    $stmt->execute();
    $business_id = mysqli_stmt_insert_id($stmt);

    $dob = null;
    $idNo = null;
    $idType = null;
    $expiryDate = null;
}

$stmt2 = $conn->prepare('UPDATE customer_sas SET f_name = ? , l_name = ?,id_front_url=?, mobile_no = ?
                    , dob = ? , expiry_date = ? , identity_no = ? , identity_type = ? , unit = ?, street = ?, middle_name = ?, post_code = ?, city = ?, state = ?,
                     type = ? , business_id = ? WHERE id = ?');
$stmt2->bind_param('sssssssssssssssii', $firstName, $lastName,$target_file, $mobileNo, $dob, $expiryDate, $idNo, $idType,
    $unit, $street, $middleName, $postCode, $city, $state, $type, $business_id, $customerId);

if($stmt2->execute()){

    if(isset($_POST["isAjax"])){
        echo json_encode(array(
            "success"=>true
        ));
    }else{
        echo json_encode(array(
            "success"=>true
        ));
        redirect('../customerProfile.php?id='.$customerId . '&msgSuccess=Customer Successfully Edited');
    }
}
else{
    redirect('../customerProfile.php?id='.$customerId . '&msgError=Customer Couldn\'t be saved');
}
?>