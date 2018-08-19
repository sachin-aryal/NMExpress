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

            $sender_details = getCustomerInfoFromId($row["sender_id"],$conn);
            $eachRow["customer_name"]=$sender_details["f_name"]." ".$sender_details["l_name"];
            $eachRow["customer_name_other"]="";
            if(isset($sender_details["dob"])){
                $eachRow["customer_dob"]=$sender_details["dob"];
            }else{
                $eachRow["customer_dob"]="";
            }
            $eachRow["customer_business_residential_address"]="";//TODO Unknown
            $eachRow["suburb"]="";//TODO Unknown
            $eachRow["customer_state"]=$sender_details["state"];
            $eachRow["customer_post_code"]=$sender_details["post_code"];
//            $eachRow["customer_city"]=$sender_details["unit"];
            $eachRow["customer_country"]=$sender_details["country"];
            $eachRow["customer_postal_address"]="";
            $eachRow["customer_postal_suburb"]="";
            $eachRow["customer_postal_state"]="";
            $eachRow["customer_postal_postcode"]="";
            $eachRow["customer_postal_country"]="";
            $eachRow["customer_phone"]=$sender_details["mobile_no"];
            $eachRow["customer_email"]=$sender_details["email"];


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
            $eachRow["id_type"] = $sender_details["identity_type"];
            $eachRow["id_type_if_other"] = "";
            $eachRow["id_number"] = $sender_details["identity_no"];
            $eachRow["id_issuer"] = "";
            $eachRow["id_type_2"] = "";
            $eachRow["id_type_2_if_other"] = "";
            $eachRow["id_type_2_number"] = "";
            $eachRow["id_type_2_issuer"] = "";
            $eachRow["electronic_data_source"] = "";


            $receiver_info = getReceiverInfoFromCusId($conn,$row["receiver_id"],$row["sender_id"]);

            $eachRow["receiver_name"] = $receiver_info["f_name"]." ".$receiver_info["l_name"];
            $eachRow["receiver_dob"] = "";
            $eachRow["receiver_business_residential_address"] = $receiver_info["city"]." ".$receiver_info["district"].",".$receiver_info["country"];
            $eachRow["receiver_city"] = $receiver_info["city"];
            $eachRow["receiver_state"] = $receiver_info["zone"];
            $eachRow["receiver_postcode"] = "";
            $eachRow["receiver_country"] = $receiver_info["country"];
            $eachRow["receiver_postal_address"] = "";
            $eachRow["receiver_postal_city"] = "";
            $eachRow["receiver_postal_state"] = "";
            $eachRow["receiver_postal_postcode"] = "";
            $eachRow["receiver_postal_country"] = "";
            $eachRow["receiver_phone"] = $receiver_info["phone_no"];
            $eachRow["receiver_email"] = "";
            $eachRow["receiver_occupation"] = "";
            $eachRow["receiver_acn"] = "";
            $eachRow["receiver_business_structure"] = "";
            if(isset($receiver_info["bank_id"])){
                $bank_details = getBankInfo($conn,$receiver_info["bank_id"]);
                $eachRow["receiver_account_number"] = $bank_details["account_no"];
                $eachRow["receiver_bank_name"] = $bank_details["bank_name"];
                $eachRow["receiver_bank_city"] = $receiver_info["branch_name"];
                $eachRow["receiver_bank_country"] = $receiver_info["country"];
            }else{
                $eachRow["receiver_account_number"] = "";
                $eachRow["receiver_bank_name"] = "";
                $eachRow["receiver_bank_city"] = "";
                $eachRow["receiver_bank_country"] = "";
            }


            $eachRow["organization_id_no"] = "Sydney";
            $eachRow["organization_full_name"] = "Nepal Money Express Pty Ltd";
            $eachRow["organization_address"] = "Suite 12, 3A Railway Pde";
            $eachRow["organization_city"] = "Kogarah";
            $eachRow["organization_state"] = "NSW";
            $eachRow["organization_post_code"] = "2217";
            $eachRow["organisation_accepting_the_money"] = "yes";
            $eachRow["organisation_sending_the_transfer_instruction"] = "yes";

            $eachRow["organisation_accepting_the_money_if_different_name"] = "";
            $eachRow["organisation_accepting_the_money_if_different_address"] = "";
            $eachRow["organisation_accepting_the_money_if_different_city"] = "";
            $eachRow["organisation_accepting_the_money_if_different_state"] = "";
            $eachRow["organisation_accepting_the_money_if_different_postcode"] = "";

            $eachRow["sti_if_different_name"] = "";
            $eachRow["sti_if_different_other_name"] = "";
            $eachRow["sti_if_different_dob"] = "";
            $eachRow["sti_if_different_address"] = "";
            $eachRow["sti_if_different_state"] = "";
            $eachRow["sti_if_different_city"] = "";
            $eachRow["sti_if_different_postcode"] = "";
            $eachRow["sti_if_different_p_address"] = "";
            $eachRow["sti_if_different_p_city"] = "";
            $eachRow["sti_if_different_p_state"] = "";
            $eachRow["sti_if_different_p_postcode"] = "";
            $eachRow["sti_if_different_p_phone"] = "";
            $eachRow["sti_if_different_p_email"] = "";
            $eachRow["sti_if_different_p_occupation"] = "";
            $eachRow["sti_if_different_p_abn"] = "";
            $eachRow["sti_if_different_p_business_structure"] = "";

            $eachRow["rti_full_name"] = "Agrima Western Union Money Transfer";
            $eachRow["rti_city"] = "Sunsari";
            $eachRow["rti_address"] = "Ithari -1";
            $eachRow["rti_state"] = "Kosi";
            $eachRow["rti_post_code"] = "977";
            $eachRow["rti_post_country"] = "Nepal";
            $eachRow["is_organization_distributing_money"] = "Yes";
            $eachRow["is_there_seperate_Retail_Outlet"] = "No";

            $eachRow["distributed_if_different_full_name"] = "";
            $eachRow["distributed_if_different_address"] = "";
            $eachRow["distributed_if_different_city"] = "";
            $eachRow["distributed_if_different_state"] = "";
            $eachRow["distributed_if_different_postcode"] = "";
            $eachRow["distributed_if_different_country"] = "";
            $eachRow["ro_different_fullname"] = "";
            $eachRow["ro_different_address"] = "";
            $eachRow["ro_different_city"] = "";
            $eachRow["ro_different_state"] = "";
            $eachRow["ro_different_postcode"] = "";
            $eachRow["ro_different_country"] = "";
            $eachRow["reason_for_transfer"] = $row["reason"];

            $eachRow["person_report"]="KAMAL BISTA";
            $eachRow["person_job_title"]="DIRECTOR";
            $eachRow["person_phone"]="61426602903";
            $eachRow["person_email"]="bistakamal07@gmail.com";
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
