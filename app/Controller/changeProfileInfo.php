<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/4/2016
 * Time: 12:05 AM
 */

if(isset($_POST["firstName"])){

    require "../Common/DbConnection.php";
    require "../Common/CommonFunction.php";

    $firstName = addslashes($_POST["firstName"]);
    $lastName = addslashes($_POST["lastName"]);
    $email = addslashes($_POST["email"]);
    $mobileNo = addslashes($_POST["mobileNo"]);

    if(isset($_POST["notifyRates"])){
        $notifyRates = addslashes($_POST["notifyRates"]);
    }else{
        $notifyRates = false;
    }

    $customerId = getCustomerId($conn);
    $customerInfo = getCustomerInfo($conn);
    $subscriberInfo = subscriberExist($conn);
    $updateProfile = "UPDATE customer_sas SET f_name=?,l_name=?,email=?,mobile_no=? where id=$customerId";
    $stmt = $conn->prepare($updateProfile);
    $stmt->bind_param("ssss",$firstName,$lastName,$email,$mobileNo);
    if($stmt->execute()){
        $userId = $customerInfo["user_id"];
        if($conn->query("UPDATE user_sas SET username='$email' where id=$userId")){
            $_SESSION["username"] = $email;
            if($notifyRates){
                if(!$subscriberInfo){;
                    $stmt3 = $conn->prepare('INSERT INTO subscriber_sas(customer_id) values(?)');
                    $stmt3->bind_param('i',$customerId);
                    if($stmt3->execute()){
                        $data = array("changed"=>true);
                    }else{
                        $data = array("changed"=>false);
                    }
                }
            }else{
                if($subscriberInfo){
                    $stmt3 = $conn->prepare('DELETE FROM subscriber_sas where customer_id=?');
                    $stmt3->bind_param('i',$customerId);
                    if($stmt3->execute()){
                        $data = array("changed"=>true);
                    }else{
                        $data = array("changed"=>false);
                    }
                }
            }
            $data = array("changed"=>true);
        }else{
            $data = array("changed"=>false);
        }

    }else{
        $data = array("changed"=>false);
    }

    echo json_encode($data);

}
