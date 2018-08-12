<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 8/17/16
 * Time: 5:49 PM
 */
include_once '../Common/DbConnection.php';
include_once '../Common/CommonFunction.php';
checkSession();
adminValidator();

$newUsername = addslashes($_POST["username"]);
$newPassword = addslashes($_POST["password"]);
$encodedPassword = encodePassword($newPassword);
$oldUsername = addslashes($_POST["oldUsername"]);
$role = 'ROLE_ADMIN';

$stmt = $conn->prepare("UPDATE user_sas SET username = ?, password = ? WHERE username = ? and role = ?");
$stmt->bind_param('ssss', $newUsername, $encodedPassword, $oldUsername, $role);

$stmt->execute();