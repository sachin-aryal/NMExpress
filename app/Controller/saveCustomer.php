<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 4/30/16
 * Time: 5:15 PM
 */

require_once "../Common/DbConnection.php";
require_once "../Common/CommonFunction.php";

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];

$email = $_POST["email"];
if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){

    echo "failure1";
    return;
}

$mobileNo = $_POST["mobileNo"];

$dob = addslashes($_POST["dob"]);
$dob = date_format(new DateTime($dob),'Y-m-d');
$idNo = addslashes($_POST["idNo"]);
$idType = addslashes($_POST["idType"]);
$expiryDate = addslashes($_POST["expiryDate"]);
$expiryDate = date_format(new DateTime($expiryDate),'Y-m-d');
$unit = addslashes($_POST["unit"]);
$street = addslashes($_POST["street"]);
$streetNo = addslashes($_POST["streetNo"]);
$state = addslashes($_POST["state"]);
$type = addslashes($_POST["type"]);
$middleName = addslashes($_POST["middleName"]);
$city = addslashes($_POST["city"]);
$postCode = addslashes($_POST["postCode"]);
$business_id = null;
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

$target_dir = "customerIds/";

// Check if image file is a actual image or fake image
if(isset($_FILES["idFront"])) {
    $uploadOk = 1;
    $imageFileType = pathinfo(basename($_FILES["idFront"]["name"]),PATHINFO_EXTENSION);
    $target_file = $target_dir.$email.'.'.$imageFileType;

    $check1 = getimagesize($_FILES["idFront"]["tmp_name"]);
    if(($check1) !== false) {
        $uploadOk = 1;

        if (!move_uploaded_file($_FILES["idFront"]["tmp_name"], '../' . $target_file)) {
            echo json_encode(array(
                "success"=>false));
            return;
        }
    } else {
        $uploadOk = 0;
        echo json_encode(array(
            "success"=>false));
        return;
    }
}else{

    echo json_encode(array(
        "success"=>false));
    return;
}
$role = "ROLE_CUSTOMER";

$is_subscriber = false;
$user_id = null;
$stmt2 = $conn->prepare('INSERT INTO customer_sas(email, f_name, l_name, user_id, mobile_no, id_front_url, dob, expiry_date, identity_no, identity_type, unit, street, street_no, middle_name, post_code, city, state, type, business_id) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$stmt2->bind_param('ssssssssssssssssssi', $email, $firstName, $lastName, $user_id, $mobileNo, $target_file, $dob, $expiryDate, $idNo, $idType, $unit, $street, $streetNo, $middleName, $postCode, $city, $state, $type, $business_id);

if($stmt2->execute()){
    echo json_encode(array(
        "success"=>true,
        "fullname"=>$firstName . " " . $lastName,
        "senderId"=>mysqli_stmt_insert_id($stmt2)
    ));
}
else{
    echo json_encode(array(
        "success"=>false));
}
return;
?>