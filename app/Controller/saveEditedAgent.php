<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/1/16
 * Time: 6:12 AM
 */

require_once '../Common/DbConnection.php';
require_once '../Common/CommonFunction.php';

$id = $_POST["id"];
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

$stmt2 = $conn->prepare('UPDATE agent_sas SET address = ?,agent_type = ?, company_address = ?, company_name = ?,company_phone = ?,email = ?,f_name = ?,identity_no = ?,identity_type = ?,l_name = ?,phone = ? WHERE id = ?');
$stmt2->bind_param('ssssssssssss', $address, $agentType, $compAddress, $compName, $compPhone, $email, $firstName, $idNo, $idType, $lastName, $phone, $id);
if($stmt2->execute())
    redirect('../editAgent.php?id=' . $id . '&msgSuccess=Agent successfully edited.');
else
    redirect('../editAgent.php?id=' . $id . '&msgError=Error editing agent.');