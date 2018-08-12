<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/16/2016
 * Time: 11:40 AM
 */

include_once "../Common/DbConnection.php";
include_once "../Common/PaymentFunction.php";

$allData = getWholePayments($conn);


/*"id"=>$payment_id,
            "sender_name"=>$sender_name,
            "sender_id"=>$sender_id,
            "sender_contact"=>$sender_contact,
            "receiver_name"=>$receiver_name,
            "receiver_mob"=>$receiver_mob,
            "receiver_phone"=>$receiver_phone,
            "pin"=>$pin,
            "means"=>$means,
            "amount"=>$amount,
            "rate"=>$rate,
            "total"=>$total,
            "status"=>$status,
            "received"=>$received*/

$columns = array(
// datatable column index  => database column name
    0 =>'id',
    1 => 'sender_name',
    2=> 'sender_id',
    3=> 'sender_contact',
);


$json_data = array(
    "draw"            => intval( $_REQUEST['draw'] ),
    "recordsTotal"    => intval( $totaldata ),
    "recordsFiltered" => intval( $totalfiltered ),
    "data"            => $data
);
echo json_encode($json_data);