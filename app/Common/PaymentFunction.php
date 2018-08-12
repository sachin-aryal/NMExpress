<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/3/16
 * Time: 12:57 PM
 */
function getAllPayments($conn, $user_id){

    $result = $conn->query("SELECT * FROM payment_sas WHERE added_by_id = " . $user_id);
    return getPayments($conn, $result, "All");
}

function getCustomerTransactionHistory($conn,$customer_id){
    $result = $conn->query("SELECT * FROM payment_sas WHERE sender_id = " . $customer_id);
    return getPayments($conn, $result, "Both");
}

function getWholePayments($conn){
    $result = $conn->query("SELECT * FROM payment_sas");
    return getPayments($conn, $result, "Both");
}

function getPendingPayments($conn){

    $result = $conn->query("SELECT * FROM payment_sas WHERE status = 'Pending'");
    return getPayments($conn, $result, "Pending");
}

function getProcessingPayments($conn, $agentId){

    $result = $conn->query("SELECT * FROM payment_sas WHERE status = 'Processing' and agent_id = " . $agentId);
    return getPayments($conn, $result, "Processing");
}

function getDeliveredPayments($conn){

    $result = $conn->query("SELECT * FROM payment_sas WHERE status = 'Delivered'");
    return getPayments($conn, $result, "Delivered");
}

function getDeliveredPaymentsOfNepaliAgent($conn){

    $result = $conn->query("SELECT * FROM payment_sas WHERE status = 'Delivered' and agent_id = " . getAgentId($conn));
    return getPayments($conn, $result, "Delivered");
}

function getPayments($conn, $result, $type){

    $payments = array();
    if($result) {
        for ($i = 0; $payment_row = $result->fetch_assoc(); $i++) {

            $payment_id = $payment_row["id"];
            $received = $payment_row["received"];
            $sender = getSender($payment_row["sender_id"], $conn);
            $sender_name = $sender["name"];
            $sender_email = $sender["email"];
            $sender_id = $payment_row["sender_id"];
            $sender_contact = $sender["contact"];
            $receiver = getReceiver($payment_row["receiver_id"], $conn);
            $receiver_name = $receiver["name"];
            $receiver_phone = $receiver["phone"];
            $pin = $payment_row["pin_no"];
            $account_name = "";
            $account_no = "";
            $bank_name = "";
            $branch_name = "";
            if ($receiver["bank"]) {
                $means = "Bank";

                $bank_result = $conn->query("SELECT * FROM bank_sas WHERE id = " . $receiver["bank_id"]);
                $bank_row = $bank_result->fetch_assoc();

                $account_name = $bank_row["account_name"];
                $account_no = $bank_row["account_no"];
                $bank_name = $bank_row["bank_name"];
                $branch_name = $bank_row["branch_name"];
            } else {

                $means = "Cash";
            }
            $amount = $payment_row["amount"];
            $rate = $payment_row["rate"];
            $total = doubleval($amount) * doubleval($rate);
            $status = $payment_row["status"];

            $payment = array(
                "id" => $payment_id,
                "sender_name" => $sender_name,
                "sender_email" => $sender_email,
                "sender_id" => $sender_id,
                "sender_contact" => $sender_contact,
                "receiver_name" => $receiver_name,
                "receiver_phone" => $receiver_phone,
                "added_by_id" => $payment_row["added_by_id"],
                "payment_date" => $payment_row["payment_date"],
                "delivered_date" => $payment_row["delivered_date"],
                "pin" => $pin,
                "means" => $means,
                "amount" => $amount,
                "rate" => $rate,
                "total" => $total,
                "status" => $status,
                "received" => $received,
                "account_name" => $account_name,
                "account_no" => $account_no,
                "bank_name" => $bank_name,
                "branch_name" => $branch_name
            );
            if ($type == "Processing" || $type == "Delivered" || $type == "Both") {

                $payment["agent_name"] = getAgent($payment_row["agent_id"], $conn);
                $payment["agent_id"] = $payment_row["agent_id"];
            }
            $payments[$i] = $payment;
        }
    }

    return $payments;
}

function getSender($senderId, $conn){

    $stmt = $conn->prepare("SELECT f_name, middle_name, l_name,mobile_no, email FROM customer_sas WHERE id = ?");
    $stmt->bind_param('i', $senderId);
    $stmt->execute();

    mysqli_stmt_bind_result($stmt, $f_name, $middleName, $l_name,$mobile_no, $email);

    $sender = array();
    if(mysqli_stmt_fetch($stmt)){

        $sender["name"] = trim($f_name . " " . $middleName . " " . $l_name);
        $sender["contact"] = $mobile_no;
        $sender["email"] = $email;
    }

    return $sender;
}

function getReceiver($receiverId, $conn){

    $stmt = $conn->prepare("SELECT f_name,l_name,phone_no,bank_id FROM receiver_sas WHERE id = ?");
    $stmt->bind_param('i', $receiverId);
    $stmt->execute();

    mysqli_stmt_bind_result($stmt, $f_name,$l_name,$phone_no,$bank_id);

    $receiver = array();

    if(mysqli_stmt_fetch($stmt)){

        $receiver["name"] = $f_name . " " . $l_name;
        $receiver["phone"] = $phone_no;
        $receiver["bank"] = !is_null($bank_id);
        $receiver["bank_id"] = $bank_id;
    }

    return $receiver;
}

function getAgent($agentId, $conn){

    $stmt = $conn->prepare("SELECT CONCAT(f_name, \" \", l_name) as full_name FROM agent_sas WHERE id = ?");

    $stmt->bind_param('i', $agentId);
    $stmt->execute();
    mysqli_stmt_bind_result($stmt, $fullname);
    if(mysqli_stmt_fetch($stmt)){
        return $fullname;
    }
    return false;
}

function assignAgentToPayment($agentId, $paymentId, $conn){

    $stmt = $conn->prepare("UPDATE payment_sas SET agent_id = ? WHERE id = ?");
    $stmt->bind_param('ii', $agentId, $paymentId);
    $stmt->execute();
    $status = "Processing";
    $stmt = $conn->prepare("UPDATE payment_sas SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $status, $paymentId);

    return $stmt->execute();
}

function deliverPayment($paymentId, $conn){

    $current_date = date('Y-m-d');
    if($conn->query("UPDATE payment_sas SET status = 'Delivered', delivered_date = '$current_date' WHERE id = $paymentId"))
        return true;
    return false;
}

function getServiceChargeData($conn){
    $distinctDate = "select distinct(payment_date) from payment_sas";
    $result = $conn->query($distinctDate);
    $serviceChargeData = array();
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
        $perDay = array();
        $dDate = $row["payment_date"];
        $perDay["payment_date"]=$dDate;

        $countD = "select count(*) from payment_sas where payment_date='$dDate'";
        $resultCount = mysqli_query($conn,$countD);
        $rowD = mysqli_fetch_row($resultCount);
        $perDay["totalTransaction"]=$rowD[0];

        $sumQuery = "SELECT SUM(fee) FROM payment_sas where payment_date='$dDate'";
        $resultS = mysqli_query($conn,$sumQuery);
        $rowS = mysqli_fetch_row($resultS);
        $sumVal = $rowS[0];
        $perDay["totalCollection"]=$sumVal;
        $serviceChargeData[$i] = $perDay;
        $i++;
    }
    return $serviceChargeData;
}

function getAustracReportData($conn){
    $paymentQuery = "SELECT * FROM payment_sas";
    $result = $conn->query($paymentQuery);
    $rawData = array();
    $i=0;
    if($result->num_rows>0){
        while($row = mysqli_fetch_assoc($result)){
            $eachRow = array();
            $eachRow["payment_date"]=$row["payment_date"];
            $eachRow["delivered_date"]=$row["delivered_date"];
            $eachRow["currency_code"]="AUD";
            $eachRow["total_amount"]=$row["amount"];
            $eachRow["type_transfer"]="Money";
            $eachRow["description_property"]="";
            $eachRow["pin_no"]=$row["id"];
            $eachRow["nokey1"]="";

            $sender_details = getCustomerInfoFromId($row["sender_id"],$conn);
            $eachRow["customer_name"]=$sender_details["f_name"]." ".$sender_details["l_name"];
            $eachRow["customer_name_other"]="";
            if(isset($sender_details["dob"])){
                $eachRow["customer_dob"]=$sender_details["dob"];
            }else{
                $eachRow["customer_dob"]="";
            }
            $eachRow["nokey2"]="";


            $eachRow["customer_business_residential_address"]="";//TODO Unknown
            $eachRow["customer_city"]=$sender_details["unit"];
            $eachRow["customer_state"]=$sender_details["state"];
            $eachRow["customer_post_code"]=$sender_details["street"];
            $eachRow["customer_country"]=$sender_details["country"];
            $eachRow["customer_postal_address"]="";
            $eachRow["customer_email"]=$sender_details["email"];
            $eachRow["nokey3"]="";


            if (isset($sender_details["business_id"])) {
                $eachRow["customer_business_name"] = $sender_details["business_name"];
                $eachRow["customer_registration_no"] = $sender_details["registration_no"];
            } else {
                $eachRow["customer_business_name"] = "";
                $eachRow["customer_business_registration_no"] = "";
            }
            $eachRow["customer_number"] = $sender_details["id"];
            $eachRow["customer_account"] = "";
            $eachRow["customer_business_structure"] = "";
            $eachRow["nokey4"]="";


            $receiver_info = getReceiverInfoFromCusId($conn,$row["receiver_id"],$row["sender_id"]);

            $eachRow["receiver_name"] = $receiver_info["f_name"]." ".$receiver_info["l_name"];
            $eachRow["receiver_dob"] = "";
            $eachRow["receiver_business_residential_address"] = "";
            $eachRow["nokey5"]="";


            $eachRow["receiver_city"] = $receiver_info["city"];
            $eachRow["receiver_zone"] = $receiver_info["zone"];
            $eachRow["receiver_district"] = $receiver_info["district"];
            $eachRow["receiver_country"] = $receiver_info["country"];
            $eachRow["receiver_phone"] = $receiver_info["phone_no"];
            $eachRow["receiver_postal_address"] = "";
            $eachRow["receiver_business"] = "";
            $eachRow["receiver_business_number"] = "";
            $eachRow["nokey6"]="";


            if(isset($receiver_info["bank_id"])){
                $bank_details = getBankInfo($conn,$receiver_info["bank_id"]);
                $eachRow["receiver_account_number"] = $bank_details["account_no"];
                $eachRow["receiver_bank_name"] = $bank_details["bank_name"];
            }else{
                $eachRow["receiver_account_number"] = "";
                $eachRow["receiver_bank_name"] = "";
            }

            $eachRow["receiver_bank_country"] = $receiver_info["country"];
            $eachRow["nokey7"]="";

            $eachRow["accepter_name"] = "NME";
            $eachRow["accepter_name_other"] = "";
            $eachRow["accepter_dob"] = "";
            $eachRow["accepter_business_residental"] = "";
            $eachRow["accepter_city"]="Strathfield";
            $eachRow["accepter_state"]="NSW";
            $eachRow["accepter_postcode"]="";
            $eachRow["accepter_country"]="Australia";
            $eachRow["accepter_postal address"]="17/17 Everton Road,Strathfield, NSW";
            $eachRow["accepter_phone"]="0426602903";
            $eachRow["accepter_email"]="info@nepalexpress.com.au";
            $eachRow["accepter_business_activity"]="Money transfer Company";
            $eachRow["accepter_business_structure"]="";
            $eachRow["sending_customer_type"]=$sender_details["type"];
            $eachRow["sending_transfer_type"]="Organization";
            $eachRow["nokey8"]="";

            $eachRow["reason"]=$row["reason"];
            $eachRow["nokey9"]="";

            $eachRow["person_report"]=$_SESSION["username"];
            $eachRow["person_job_title"]="ADMIN";
            $eachRow["person_phone"]="0426602903";
            $eachRow["person_email"]=$_SESSION["username"];
            $rawData[$i++] = $eachRow;
        }
    }
    return $rawData;
}

function getPinAndSenderEmail($conn,$paymentId){
    $paymentId = addslashes($paymentId);
    $query = "select pin_no,sender_id from payment_sas where id=$paymentId";
    $result = $conn->query($query);

    if($result->num_rows!=0){
        $row = mysqli_fetch_assoc($result);
        $data = array();
        $data["pin_no"]=$row["pin_no"];
        $data["sender_id"]=$row["sender_id"];
        return $data;
    }
    return null;
}
