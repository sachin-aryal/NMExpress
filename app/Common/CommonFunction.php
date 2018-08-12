<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 4/30/2016
 * Time: 5:04 PM
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$headers = 'From: info@nepalexpress.com.au' . "\r\n";
$headers .='Reply-To: info@nepalexpress.com.au' . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
define('header', $headers);

//TODO: Change the Reset URL in the Production
define("resetPasswordUrl","http://nepalexpress.com.au/app/resetPassword.php?");

session_start();

function checkSession(){
    if(!isset($_SESSION["username"])) {
        redirect("index.php");
    }
}

function checkReturnUrl($returnUrl){
    if(!isset($_SESSION["username"])) {
       $_SESSION["returnUrl"] = $returnUrl;
    }
}

function redirect($redirectionUrl){
    header("Location:".$redirectionUrl);
}

function adminValidator(){
    if($_SESSION["role"]!="ROLE_ADMIN"){

        if(isset($_SESSION["username"])) {
            goToDashBoard("");
        }else
            redirect("index.php");
    }
}

function nepAgentValidator(){
    if($_SESSION["role"]!="ROLE_NEPAGENT"){

        if(isset($_SESSION["username"])) {
            goToDashBoard("");
        }else
            redirect("index.php");
    }
}

function ausAgentAdminValidator(){

    if(!($_SESSION["role"]!="ROLE_AUSAGENT" || $_SESSION["role"] != "ROLE_ADMIN")){

        if(isset($_SESSION["username"])) {
            goToDashBoard("");
        }else
            redirect("index.php");
    }
}

function ausAgentValidator(){
    if($_SESSION["role"]!="ROLE_AUSAGENT"){

        if(isset($_SESSION["username"])) {
            goToDashBoard("");
        }else
            redirect("index.php");
    }
}

function customerValidator(){
    if($_SESSION["role"]!="ROLE_CUSTOMER"){

        if(isset($_SESSION["username"])) {
            goToDashBoard("");
        }else
            redirect("index.php");
    }
}

function goToDashBoard($url){
    if($_SESSION["role"] == "ROLE_CUSTOMER"){
        redirect($url."dashboardC.php");
    }else if($_SESSION["role"] == "ROLE_ADMIN"){
        redirect($url."dashboardAd.php");
    }else if($_SESSION["role"] == "ROLE_NEPAGENT"){
        redirect($url."dashboardNepA.php");
    }else if($_SESSION["role"] == "ROLE_AUSAGENT"){
        redirect($url."dashboardAusA.php");
    }
}

function getExchangeRate($conn)
{
    $sql = "Select *from rate_sas ORDER BY id DESC LIMIT 1;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    mysqli_stmt_bind_result($stmt, $id, $aus, $last_updated, $nrs, $updated_by_id);
    $todayRate=null;
    if(mysqli_stmt_fetch($stmt)){
        $todayRate = array("aus"=>$aus,"nrs"=>$nrs,"last_updated"=>$last_updated,
            "updated_by_id"=>$updated_by_id);
    }
    return $todayRate;
}

function getExchangeRateForGraph($conn){

    $sql = "Select nrs,last_updated from rate_sas ORDER BY id DESC LIMIT 7";
    $result = $conn->query($sql);
    $data = array();
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
    }
    return $data;
  
}

function getBuyerRate($conn){

    $sql = "Select *from buyer_rate_sas ORDER BY id DESC LIMIT 1;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    mysqli_stmt_bind_result($stmt, $id, $aus, $last_updated, $nrs, $updated_by_id);
    $todayRate=null;
    if(mysqli_stmt_fetch($stmt)){
        $todayRate = array("aus"=>$aus,"nrs"=>$nrs,"last_updated"=>$last_updated,
            "updated_by_id"=>$updated_by_id);
    }
    return $todayRate;
}

function encodePassword($password){

    $options = [

        'cost' => 12
    ];

    return password_hash($password, PASSWORD_BCRYPT, $options);
}

function getOptimalBcryptCostParameter($min_ms = 250)
{
    for ($i = 4; $i < 31; $i++) {
        for ($i = 4; $i < 31; $i++) {
            $options = ['cost' => $i, 'salt' => 'My Name Is Gandu Gandu'];
            $time_start = microtime(true);
            password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options);
            $time_end = microtime(true);
            if (($time_end - $time_start) * 1000 > $min_ms) {
                echo $i;
                break;
            }
        }
    }
}

function getReceiverList($conn){
    $id = getCustomerId($conn);
    $receiverQuery = "select *from receiver_sas where customer_id=$id";

    $result = $conn->query($receiverQuery);

    $data=array();

    if($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = array(
                "id" => $row['id'], "bank_id" => $row['bank_id'], "payment_type" => $row['payment_type'],
                "city" => $row['city'], "country" => $row['country'], "customer_id" => $row['customer_id'],
                "district" => $row['district'], "f_name" => $row['f_name'], "m_name" => $row['m_name'],"l_name" => $row['l_name'],
                "phone_no" => $row['phone_no'], "zone" => $row['zone']);
        }
    }

    return $data;
}

function getCustomerId($conn){
    $customerId = $_SESSION["username"];
    $sql = "select id from customer_sas where email='$customerId'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if($row){
        $id = $row["id"];
    }else{
        $id = null;
    }
    return $id;
}

function getCustomerIdByEmail($conn,$emailAddress){
    $sql = "select id from customer_sas where email='$emailAddress'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if($row){
        $id = $row["id"];
    }else{
        $id = null;
    }
    return $id;
}

function checkCustomerStatus($conn,$id){
    $result = $conn->query("SELECT activated FROM user_sas WHERE id = " . $id);
    $res = $result->fetch_assoc();
    return $res["activated"];
}

function activateCustomer($conn,$id){
    $sql = "UPDATE user_sas SET activated='1' WHERE id='$id' ";
    $result = $conn->query($sql);
    if($result){
        return true;
    }else{
       return false;
    }
}

function getReceiverInfo($conn,$receiverId){
    $customerID = getCustomerId($conn);

    $sql = "select *from receiver_sas where id=$receiverId AND customer_id=$customerID";

    $result = $conn->query($sql);

    $data = array();

    if($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data = array(
                "id" => $row['id'], "bank_id" => $row['bank_id'], "payment_type" => $row['payment_type'],
                "city" => $row['city'], "country" => $row['country'], "customer_id" => $row['customer_id'],
                "district" => $row['district'], "f_name" => $row['f_name'], "m_name"=>$row['m_name'],"l_name" => $row['l_name'],
                "phone_no" => $row['phone_no'], "zone" => $row['zone']);
        }
    }
    return $data;
}

function getCustomerInfo($conn){
    $customerID = getCustomerId($conn);
    $sql = "select * from customer_sas where id=$customerID";

    $result = $conn->query($sql);
    if($row = mysqli_fetch_assoc($result)){
        $customer = array();
        $customer["id"] = $row["id"];
        $customer["dob"] = $row["dob"];
        $customer["type"] = $row["type"];
        $customer["email"] = $row["email"];
        $customer["expiry_date"] = $row["expiry_date"];
        $customer["name"] = $row["f_name"]." ".$row["l_name"];
        $customer["f_name"] = $row["f_name"];
        $customer["l_name"] = $row["l_name"];
        $customer["identity_no"] = $row["identity_no"];
        $customer["identity_type"] = $row["identity_type"];
        $customer["id_front_url"] = $row["id_front_url"];
        $customer["unit"] = $row["unit"];
        $customer["state"] = $row["state"];
        $customer["street"] = $row["street"];
        $customer["mobile_no"] = $row["mobile_no"];
        $customer["reward_point"] = $row["reward_point"];
        $customer["user_id"] = $row["user_id"];
        $customer["business_id"] = $row["business_id"];

        if(isset($customer["business_id"])){

            $result2 = $conn->query("SELECT * FROM business_sas WHERE id = " . $customer["business_id"]);
            $business_row = $result2->fetch_assoc();

            $customer["business_id"] = $business_row["id"];
            $customer["business_name"] = $business_row["name"];
            $customer["registration_no"] = $business_row["registration_no"];
            $customer["established_date"] = $business_row["established_date"];
        }
    }else{
        $customer = false;
    }

    return $customer;
}

function getCustomerInfoFromId($customerID, $conn){

    $sql = "select *from customer_sas where id=$customerID";

    $customer = array();
    $result = $conn->query($sql);
    if($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            $customer["id"] = $row["id"];
            $customer["dob"] = $row["dob"];
            $customer["type"] = $row["type"];
            $customer["email"] = $row["email"];
            $customer["expiry_date"] = $row["expiry_date"];
            $customer["name"] = $row["f_name"] . " " . $row["l_name"];
            $customer["f_name"] = $row["f_name"];
            $customer["l_name"] = $row["l_name"];
            $customer["identity_no"] = $row["identity_no"];
            $customer["identity_type"] = $row["identity_type"];
            $customer["id_front_url"] = $row["id_front_url"];
            $customer["unit"] = $row["unit"];
            $customer["state"] = $row["state"];
            $customer["street"] = $row["street"];
            $customer["post_code"] = $row["post_code"];
            $customer["city"] = $row["city"];
            $customer["middle_name"] = $row["middle_name"];
            $customer["street_no"] = $row["street_no"];
            $customer["mobile_no"] = $row["mobile_no"];
            $customer["reward_point"] = $row["reward_point"];
            $customer["user_id"] = $row["user_id"];
            $customer["business_id"] = $row["business_id"];
            $customer["country"] = $row["country"];

            if (isset($customer["business_id"])) {

                $result2 = $conn->query("SELECT * FROM business_sas WHERE id = " . $customer["business_id"]);
                $business_row = $result2->fetch_assoc();

                $customer["business_id"] = $business_row["id"];
                $customer["business_name"] = $business_row["name"];
                $customer["registration_no"] = $business_row["registration_no"];
                $customer["established_date"] = $business_row["established_date"];
            }
        } else {
            $customer = false;
        }
    }
    return $customer;
}

function getReceiverInfoFromCusId($conn,$receiverId, $customerID){

    $sql = "select *from receiver_sas where id=$receiverId AND customer_id=$customerID";

    $result = $conn->query($sql);
    $data = array();
    while($row = mysqli_fetch_assoc($result)){
        $data = array(
            "id"=>$row['id'],"bank_id"=>$row['bank_id'],"payment_type"=>$row['payment_type'],
            "city"=>$row['city'], "country"=>$row['country'],"customer_id"=>$row['customer_id'],
            "district"=>$row['district'], "f_name"=>$row['f_name'],"m_name"=>$row['m_name'],"l_name"=>$row['l_name'],
            "phone_no"=>$row['phone_no'],"zone"=>$row['zone']);
    }
    return $data;
}

function getBankInfo($conn,$bank_id){
    $stmt = $conn->prepare("select id,account_name,account_no,bank_name,branch_name from bank_sas where id = ?");
    $stmt->bind_param("i",$bank_id);
    $stmt->execute();
    mysqli_stmt_bind_result($stmt, $id, $account_name, $account_no, $bank_name, $branch_name);

    $data = array();
    if(mysqli_stmt_fetch($stmt)){

        $data = array("id"=>$id, "account_name"=>$account_name, "account_no"=>$account_no,
            "bank_name"=>$bank_name, "branch_name"=>$branch_name);
    }

    return $data;
}

function getAllAgents($conn){

    $result = $conn->query("SELECT * FROM agent_sas");

    $agents = array();
    for($i = 0; $agent_row = $result->fetch_assoc(); $i++){

        $agent = array(
            "id"=>$agent_row["id"],
            "address"=>$agent_row["address"],
            "company_address"=>$agent_row["company_address"],
            "company_name"=>$agent_row["company_name"],
            "company_phone"=>$agent_row["company_phone"],
            "email"=>$agent_row["email"],
            "name"=>$agent_row["f_name"] . " " . $agent_row["l_name"],
            "id_no"=>$agent_row["identity_no"],
            "id_type"=>$agent_row["identity_type"],
            "phone"=>$agent_row["phone"],
            "agent_type"=>$agent_row["agent_type"]
        );
        $agents[$i] = $agent;
    }

    return $agents;
}

function getUserIdAgent($conn,$agentId){

    $result = $conn->query("SELECT email FROM agent_sas WHERE id = " . $agentId);
    $agent_row = $result->fetch_assoc();
    $result = $conn->query("SELECT id FROM user_sas WHERE username = '" . $agent_row["email"] . "'");
    $user_row = $result->fetch_assoc();
    return $user_row["id"];
}

function getAllNepaliAgents($conn){

    $result = $conn->query("SELECT * FROM agent_sas WHERE agent_type = 'Nepalese'");

    $agents = array();
    for($i = 0; $agent_row = $result->fetch_assoc(); $i++){

        $agent = array(
            "id"=>$agent_row["id"],
            "address"=>$agent_row["address"],
            "company_address"=>$agent_row["company_address"],
            "company_name"=>$agent_row["company_name"],
            "company_phone"=>$agent_row["company_phone"],
            "email"=>$agent_row["email"],
            "name"=>$agent_row["f_name"] . " " . $agent_row["l_name"],
            "id_no"=>$agent_row["identity_no"],
            "id_type"=>$agent_row["identity_type"],
            "phone"=>$agent_row["phone"]
        );
        $agents[$i] = $agent;
    }

    return $agents;
}

function getRandomPin($conn){
    while(true){
        $pin = getRandomString();
        $customerId = getCustomerId($conn);
        $checkPinQuery = "select pin_no from payment_sas where pin_no=? AND sender_id=?";
        $stmt = $conn->prepare($checkPinQuery);
        $stmt->bind_param("si",$pin,$customerId);
        $stmt->execute();
        mysqli_stmt_bind_result($stmt, $pin_no);
        if(!mysqli_stmt_fetch($stmt)){
            return $pin;
        }
    }
}

function getRandomString(){
    return bin2hex(openssl_random_pseudo_bytes(3));
}

function getAgentInfo($conn,$agent_id){
    $result = $conn->query("SELECT * FROM agent_sas where user_id = $agent_id");
    $agent_row = $result->fetch_assoc();
    return $agent_row;
}

function getAgentId($conn){

    $stmt = $conn->prepare("SELECT user_id FROM agent_sas WHERE email = ?");
    $stmt->bind_param('s', $_SESSION["username"]);
    $stmt->execute();

    mysqli_stmt_bind_result($stmt, $id);

    if(mysqli_stmt_fetch($stmt)){

        return $id;
    }else{

        return false;
    }
}

function getAgentMainId($conn){

    $stmt = $conn->prepare("SELECT id FROM agent_sas WHERE email = ?");
    $stmt->bind_param('s', $_SESSION["username"]);
    $stmt->execute();

    mysqli_stmt_bind_result($stmt, $id);

    if(mysqli_stmt_fetch($stmt)){

        return $id;
    }else{

        return false;
    }
}

function getAusAgentUserId($conn){

    $stmt = $conn->prepare("SELECT id FROM user_sas WHERE username = ?");
    $stmt->bind_param('s', $_SESSION["username"]);
    $stmt->execute();

    mysqli_stmt_bind_result($stmt, $id);

    if(mysqli_stmt_fetch($stmt)){

        return $id;
    }else{

        return false;
    }
}

function getCustomerList($conn){

    $customerList = array();
    $i=0;
    $result = $conn->query("select *from customer_sas");

    while($row = mysqli_fetch_assoc($result)){
        $customer = array();
        $customer["id"] = $row["id"];
        $customer["dob"] = $row["dob"];
        $customer["type"] = $row["type"];
        $customer["email"] = $row["email"];
        $customer["expiry_date"] = $row["expiry_date"];
        $customer["name"] = $row["f_name"]." ".$row["l_name"];
        $customer["f_name"] = $row["f_name"];
        $customer["l_name"] = $row["l_name"];
        $customer["identity_no"] = $row["identity_no"];
        $customer["identity_type"] = $row["identity_type"];
        $customer["id_front_url"] = $row["id_front_url"];
        $customer["unit"] = $row["unit"];
        $customer["state"] = $row["state"];
        $customer["street"] = $row["street"];
        $customer["mobile_no"] = $row["mobile_no"];
        $customer["reward_point"] = $row["reward_point"];
        $customer["user_id"] = $row["user_id"];
        $customer["business_id"] = $row["business_id"];
        $result2 = $conn->query("SELECT SUM(amount) as total_amount FROM payment_sas WHERE sender_id = " . $row["id"]);
        $payment_row = $result2->fetch_assoc();
        $customer["total_transaction"] = $payment_row["total_amount"];
        $customerList[$i] = $customer;
        $i++;
    }
    return $customerList;
}

function getUnactivatedCustomerList($conn){

     $customerList = array();
    $i=0;
    $result = $conn->query("SELECT b.id as uid,b.email as email,b.f_name as f_name,b.l_name as l_name FROM user_sas a, customer_sas b WHERE a.id=b.user_id AND a.activated = 0");
   while($row = mysqli_fetch_assoc($result)){
    $customerList[]= $row;
    }
    return $customerList ;
    
}

function getUnactiveCustomer($conn){

    $result = $conn->query("select * from user_sas where activated=0");
    return $result->num_rows;
}


function getAdminEmail($conn){

    $result = $conn->query("SELECT username from user_sas WHERE role = 'ROLE_ADMIN'");

    $admin_email = $result->fetch_assoc();

    return $admin_email["email"];
}


function getSubscriberList($conn){
    $subscriberQuery = "SELECT *from subscriber_sas";
    $result = $conn->query($subscriberQuery);
    $data = array();
    $i=0;
    if($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $eachData["id"] = $row["id"];
            $eachData["email"] = $row["email"];
            $eachData["added_date"] = $row["added_date"];
            $data[$i++] = $eachData;
        }
    }
    return $data;
}


function getSubscriberEmail($conn,$id){
    $emailQuery = "SELECT email from subscriber_sas where id = $id";
    $result = $conn->query($emailQuery);
    $row = mysqli_fetch_assoc($result);
    if(isset($row["email"])){
        return $row["email"];
    }else{
        return null;
    }
}


function getCollectionForAgent($conn,$agentId){
    $sql = "select DATE_FORMAT(payment_date, '%Y-%m-%d') as date,count(fee),sum(amount) from payment_sas WHERE added_by_id = $agentId group by payment_date ORDER BY date desc";
    $result = $conn->query($sql);
    $data = array();
    $i=0;
   while($row = mysqli_fetch_assoc($result)){
        $eachRow = array(
            "date"=>$row['date'],
            "count"=>$row['count(fee)'],
            "amount"=>$row['sum(amount)']
        );
        $data[$i++] = $eachRow;
    }
    return $data;
}

function getpaymentByid($conn,$pID){
    $sql = "select * from payment_sas where id=$pID";
    $data = array();
    $result = $conn->query($sql);
    if($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            $payment["id"] = $row["id"];
            $payment["payment_date"] = $row["payment_date"];
            $payment["pin_no"] = $row["pin_no"];
            $payment["fee"] = $row["fee"];
            $payment["rate"] = $row["rate"];
            $payment["reason"] = $row["reason"];
            $payment["amount"] = $row["amount"];

        }
    }
    return $payment;
}

function agent_transactionReport($conn,$agentId){
    $sql ="SELECT a.fee, a.amount,a.payment_date,a.delivered_date,a.rate,b.f_name,b.mobile_no FROM payment_sas a, customer_sas b WHERE a.sender_id = b.id AND a.added_by_id = $agentId";
    $result = $conn->query($sql);
    $data = array();
    $i=0;
   while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
    }
    return $data;
}

function getDateByCollection($conn,$date){
    if($date=="all"){
        $sql = "SELECT *FROM collection_sas order by collection_date desc";
    }else{
        $sql = "SELECT *FROM collection_sas WHERE collection_date='$date'";
    }
    $result = $conn->query($sql);
    $data = array();
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
        $agent_id = $row["agent_id"];
        $agent_name = getAgent($agent_id,$conn);
        $eachRow = array(
            "id"=>$row["id"],
            "no_transaction"=>$row["no_transaction"],
            "total_collection"=>$row["total_collection"],
            "collection_date"=>$row["collection_date"],
            "agent_name"=>$agent_name,
            "agent_id"=>$agent_id
        );
        $data[$i++] = $eachRow;
    }
    return $data;
}

function getProfitLossData($conn){
    $sql = "SELECT * FROM profit_sas order by profit_date desc LIMIT 500";
    $result = $conn->query($sql);
    $all = array();
    for($i = 0; $row = mysqli_fetch_assoc($result); $i++){
        $eachRow = array();
        $eachRow["collection"]=$row["collection"];
        $eachRow["profit_date"]=$row["profit_date"];
        $eachRow["no_of_transactions"]=$row["no_of_transactions"];
        $eachRow["profit"]=$row["profit"];
        $all[$i++] = $eachRow;
    }
    return $all;
}

function getPLData($conn,$perDay){

    $data = array();
    $payment_date = $perDay["payment_date"];
    $sellingRate = "select nrs from rate_sas where last_updated='$payment_date' order by last_updated desc limit 1";
    $buyerRate = "select nrs from buyer_rate_sas where last_updated='$payment_date' order by last_updated desc limit 1";

    $sellResult = $conn->query($sellingRate);
    $buyResult = $conn->query($buyerRate);


    if($sellResult->num_rows!=0){
        $saleRate = mysqli_fetch_assoc($sellResult)["nrs"];
    }else{
        $saleRate = "N/A";
    }

    if($buyResult->num_rows!=0){
        $buyRate = mysqli_fetch_assoc($buyResult)["nrs"];
    }else{
        $buyRate = "N/A";
    }

    $data["payment_date"] = $payment_date;
    $data["amount"] = $perDay["amount"];
    $data["saleRate"] = $saleRate;
    $data["buyRate"] = $buyRate;

    
    if($saleRate!="N/A" && $buyRate!="N/A"){

        $saleRateAmount = $saleRate*$perDay["amount"];
        $buyRateAmount = $buyRate*$perDay["amount"];

        if($saleRateAmount>$buyRateAmount){
            $data["PL"] = $saleRateAmount-$buyRateAmount." (Loss)";
        }else if($buyRateAmount>$saleRateAmount){
            $data["PL"] = $buyRateAmount-$saleRateAmount." (Profit)";
        }else{
            $data["PL"] = "0 (Neutral)";
        }

    }else{
        $data["PL"] = "N/A";
    }

    return $data;
}

function searchSenderByName($conn, $query){

    $result = $conn->query("SELECT id, CONCAT(f_name, ' ', middle_name,' ', l_name, ',', email, ',' , mobile_no) as detail " .
                      "FROM customer_sas WHERE CONCAT(f_name, ' ', middle_name,' ', l_name, ',', email, ',' , mobile_no) LIKE '" . $query . "%' LIMIT 10");

    $response = array();
    for($i = 0; $row = mysqli_fetch_assoc($result); $i++){

       $response[$row["id"]] = $row["detail"];
    }

    return $response;
}

function searchReceiverByName($conn, $query, $senderId){

    $result = $conn->query("SELECT id, CONCAT(f_name, ' ', m_name,' ', l_name, ',', phone_no, ',', district) as detail " .
        "FROM receiver_sas WHERE CONCAT(f_name, ' ', m_name,' ', l_name, ',', phone_no, ',', district) LIKE '" . $query . "%' and customer_id =". $senderId . " LIMIT 10");
    $response = array();
    for($i = 0; $row = mysqli_fetch_assoc($result); $i++){

        $response[$row["id"]] = $row["detail"];
    }


    return $response;
}

function getServiceCharge($conn){

    $result = $conn->query("SELECT value FROM service_charge");

    $row = mysqli_fetch_assoc($result);

    return $row["value"];
}