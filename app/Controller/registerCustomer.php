<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 4/30/16
 * Time: 5:15 PM
 */

require_once "../Common/DbConnection.php";
require_once "../Common/CommonFunction.php";
require_once "../Common/verifiedMailSender.php";

$firstName = addslashes($_POST["firstName"]);
$lastName = addslashes($_POST["lastName"]);

$email = addslashes($_POST["email"]);
if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){

    redirect('../index.php?msgError=' . "Invalid Request");
    return;
}

$stmt = $conn->query("SELECT id FROM user_sas WHERE username = '$email'");
if ($stmt->num_rows != 0) {

    redirect('index.php?msgError=User with supplied email already exists. Please login.');
    return;
}

$password = addslashes($_POST["password"]);
$encodedPassword = encodePassword($password);
$role = "ROLE_CUSTOMER";
//insert data into user_sas i.e user table
$stmt1 = $conn->prepare('INSERT INTO user_sas(password, role, username) values(?, ?, ?)');
$stmt1->bind_param('sss', $encodedPassword, $role, $email);
$stmt1->execute();
$user_id = mysqli_stmt_insert_id($stmt1);

$mobileNo = addslashes($_POST["mobileNo"]);

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

    //inert business data into business_sas table
    $stmt = $conn->prepare("INSERT INTO business_sas(name, established_date, registration_no) VALUES (?, ?, ?);");
    $stmt->bind_param("sss", $name, $established_date, $registration_no);
    $stmt->execute();
    print_r(mysqli_error_list($conn));
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
            $result = $conn->query("DELETE FROM user_sas WHERE id = " . $user_id);
            $result = $conn->query("DELETE FROM business_sas WHERE id = " . $business_id);
            redirect('../index.php?msgError=' . "Error Registering. Please try again.");
            return;
        }
    } else {
        $uploadOk = 0;
        $result = $conn->query("DELETE FROM user_sas WHERE id = " . $user_id);
        $result = $conn->query("DELETE FROM business_sas WHERE id = " . $business_id);
        redirect('../index.php?msgError=' . "Error Registering. Please try again.");
        return;
    }
}else{
    $result = $conn->query("DELETE FROM user_sas WHERE id = " . $user_id);
    $result = $conn->query("DELETE FROM business_sas WHERE id = " . $business_id);
    redirect('../index.php?msgError=' . "Error Registering. Please try again.");
    return;
}

$result = $conn->query("SELECT id, role FROM user_sas WHERE username = '$email'");
$user_row = $result->fetch_assoc();
$lastId = $user_row["id"];
$stmt2 = $conn->prepare('INSERT INTO customer_sas(email, f_name, l_name, mobile_no, user_id, id_front_url, dob, expiry_date, identity_no, identity_type, unit, street, street_no, middle_name, post_code, city, state, type, business_id) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$stmt2->bind_param('ssssisssssssssssssi', $email, $firstName, $lastName, $mobileNo, $lastId, $target_file, $dob, $expiryDate, $idNo, $idType, $unit, $street, $streetNo, $middleName, $postCode, $city, $state, $type, $business_id);

if($stmt2->execute()){
    $last_id = $conn->insert_id;
    send_verified_email($email);
    send_new_registration_to_admin($last_id,$firstName,$email);
    // session_start();
    // $_SESSION["username"] = $email;
    // $_SESSION["role"] = $user_row["role"];
    // goToDashBoard("../");
    redirect('../index.php?msgError=' . "Registered Successfully, Please Login with your username and password.");
}
else{

     $conn->query("DELETE FROM user_sas WHERE id = " . $lastId);
	 $conn->query("DELETE FROM customer_sas WHERE user_id = " . $lastId);
    redirect('../index.php?msgError=' . "Error Registering. Please try again.");
}