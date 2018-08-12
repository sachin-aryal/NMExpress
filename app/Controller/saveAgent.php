<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/1/16
 * Time: 6:12 AM
 */

require_once '../Common/DbConnection.php';
require_once '../Common/CommonFunction.php';

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$email = $_POST["email"];
$compName = $_POST["companyName"];
$compPhone = $_POST["companyPhone"];
$compAddress = $_POST["companyAddress"];

$agentType = $_POST["agentType"];

$idType = $_POST["idType"];
$idNo = $_POST["idNo"];

$password = $_POST["password"];
$encodedPassword = encodePassword($password);

$mes = $firstName . $lastName . $phone . $address . $email . $compName . $compPhone . $compAddress . $idType . $idNo . $password . $agentType;

if($agentType == "Australian")
    $role = "ROLE_AUSAGENT";
else if($agentType == "Nepalese")
    $role = "ROLE_NEPAGENT";

$stmt1 = $conn->prepare('INSERT INTO user_sas(password, role, username) values(?, ?, ?)');
$stmt1->bind_param('sss', $encodedPassword, $role, $email);
$stmt1->execute();

$stmt2 = $conn->prepare('INSERT INTO agent_sas(address,agent_type, company_address, company_name,company_phone,email,f_name,identity_no,identity_type,l_name,phone,user_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$stmt2->bind_param('ssssssssssss', $address, $agentType, $compAddress, $compName, $compPhone, $email, $firstName, $idNo, $idType, $lastName, $phone, mysqli_stmt_insert_id($stmt1));
if($stmt2->execute())
    redirect('../agentList.php?successMessage=Agent successfully created.');
else
    redirect('../agentList.php?failedMessage=Error while creating agent.' . $mes . mysqli_stmt_error($stmt2) . $user_id);