<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/2/2016
 * Time: 9:33 AM
 */

require "../Common/DbConnection.php";
require "../Common/CommonFunction.php";

$receiverList = getReceiverList($conn);


echo "<option value='not'>Choose Receiver</option>";

foreach($receiverList as $value){
    if($value["bank_id"]==null){
        $paymentType = "Cash";
    }else{
        $paymentType = "Bank";
    }
    ?>
        <option value="<?php echo $value['id']?>"><?php echo $value['f_name']." ".$value['m_name']." ".$value['l_name']."(".$paymentType.")"?></option>
    <?php

}
?>

