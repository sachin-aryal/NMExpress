/**
 * Created by sachin on 4/30/2016.
 */
//TODO: Change the loginUrl in the Production
var loginPageUrl = "http://nepalexpress.com.au/app/index.php";
function setSelectOption(){
    $.ajax({
        url:"Controller/getReceiverList.php",
        type:"POST",
        success:function(data){
            $("#receiverId").html(data)
        }
    });
    return false;
}

function setSelectOptionWithSelected(selectedVal){
    $.ajax({
        url:"Controller/getReceiverList.php",
        type:"POST",
        success:function(data){
            $("#receiverId").html(data);
            $("#receiverId").val(selectedVal);

        }
    });
    return false;
}

function addReceiver(){
    var data = $("#newReceiverForm").serialize();
    $.ajax({
        url:"Controller/addNewReceiver.php",
        type:"POST",
        data:data,
        success:function(data){
            var jsonData = JSON.parse(data);
            setSelectOption();
            if(jsonData.success){

                notify("success", "Receiver added successfully. Choose the added receiver.");
                $("#receiverId").empty();
                $("#collapseNewReceiver").hide();
                $("#newReceiverForm").reset();
            }else{

                notify("error", "Receiver could not be added.");
            }
        }
    });

    return false;
}

function updateReceiver(){

    var data = $("#newReceiverForm").serialize();
    $.ajax({
        url:"Controller/updateReceiver.php",
        type:"POST",
        data:data,
        success:function(data){
            try {
                var jsonData = JSON.parse(data);
                if (jsonData.success) {

                    notify("success", "Update Successful.");
                } else {

                    notify("error", "Error updating.");
                }
                setTimeout(function () {
                    location.reload();
                }, 2000);
            }catch (e){

                console.log(e);
                notify("error", "Error updating");
            }
        }
    });

    return false;
}


function updateCustomer(){
    $("#addSenderModal").modal("toggle");
    blockUi();
    var fd = new FormData(document.querySelector("#newCustomerForm"));
    $.ajax({
        url: "Controller/saveProfile.php",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        success:function(data){
            unBlockUi();
            var responseJSON = JSON.parse(data);
            if(responseJSON.success){
                notify("success", "Sender Saved.");
                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
        }
    });
    //document.getElementById("newCustomerForm").reset();
    return false;

}

function assignAgent(optionValue, paymentId){

    var agentId = $(optionValue).children(":selected").attr("id");
    if(agentId=="none"){
        noty({layout:'topRight', type: 'error', text: "Please assign an agent.", timeout: 6000});
        return false;
    }
    $.ajax({
        type: "POST",
        url: 'Controller/assignAgent.php',
        data: 'agentId=' + agentId + "&paymentId=" + paymentId
    }).done(function(result){

        if(result){

            noty({layout:'topRight', type: 'success', text: "Agent successfully assigned.", timeout: 6000});
        }else{

            noty({layout:'topRight', type: 'error', text: "Agent could not be assigned.", timeout: 6000});
        }
        setTimeout(function() { location.reload(); }, 2000);
    })
}

function saveReceiver(){

    $("#newReceiverFormDIV").hide();
    blockUi();
    var data = $("#newReceiverForm").serialize();
    $.ajax({
        url:"Controller/saveReceiver.php",
        type:"POST",
        data:data,
        success:function(data){
            unBlockUi();
            var responseJSON = JSON.parse(data);
            if(responseJSON.success) {
                notify("success", "Receiver Saved.");
                $("#receiverName").val(responseJSON.receiverName);
                $("#receiverInfoDiv").show();
                $("#receiverName").prop('disabled', true);
                $("#addReceiverButton").hide();
                $("#receiverId").val(responseJSON.receiverId);
                document.getElementById("newReceiverForm").reset();
            }else{

                notify("error", "Could not save receiver.");
            }
        }
    });
    return false;
}

function addCustomer(){
    $("#closeAddSenderButton").click();
    blockUi();

    var fd = new FormData(document.querySelector("#newCustomerForm"));
    $.ajax({
        url: "Controller/saveCustomer.php",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        success:function(data){
            var responseJSON = JSON.parse(data);
            unBlockUi();
            notify("success", "Sender Saved.");
            $("#senderName").val(responseJSON.fullname);
            $("#senderInfoDiv").show();
            $("#senderName").prop('disabled', true);
            $("#addSenderButton").hide();
            $("#senderId1").val(responseJSON.senderId);
            $("#senderId2").val(responseJSON.senderId);
            $("#newCustomerFormDIV").hide();
            $("#addReceiverButton").prop("disabled", false);
        }
    });

    /*var formData = new FormData(document.forms.namedItem(""));
    var request = new XMLHttpRequest();
    request.open("POST", "Controller/saveCustomer.php");
    request.onload = function(oEvent) {
        if (request.status == 200) {
            var responseJSON = JSON.parse(request.responseText);
            if(responseJSON.success){

                unBlockUi();
                notify("success", "Sender Saved.");
                $("#senderName").val(responseJSON.fullname);
                $("#senderInfoDiv").show();
                $("#senderName").prop('disabled', true);
                $("#addSenderButton").hide();
                $("#senderId1").val(responseJSON.senderId);
                $("#senderId2").val(responseJSON.senderId);
                $("#newCustomerFormDIV").hide();
                $("#addReceiverButton").prop("disabled", false);
            }
        } else {
            notify("error", "Error " + request.status + " occurred when trying to upload your file.<br \/>");
        }
    };
    request.send(formData);*/
    //document.getElementById("newCustomerForm").reset();
    return false;
}

function showAddSender(){

    $("#newCustomerFormDIV").show();
}

function showAddReceiver(){

    if($("#newReceiverFormDIV").is(":visible")){
        $("#newReceiverFormDIV").hide();
    }else{
        $("#newReceiverFormDIV").show();
    }

}

function changeText(){
    var text = $("#newReceiverButton").text().trim();
    console.log(text);
    if(text=="Add New Receiver"){
        $("#newReceiverButton").text("Remove Receiver")
    }else{
        $("#newReceiverButton").text("Add New Receiver")
    }
}

function confirmTransaction(){
    var n = noty({
        layout: 'center',
        text: 'Confirm Transaction?',
        killer: true,
        buttons: [
            {
                addClass: 'btn btn-primary', text: 'Ok', onClick: function ($noty) {
                n.close();
                $("#transactionForm").submit();
                return true;
            }
            },
            {
                addClass: 'btn btn-danger', text: 'Cancel', onClick: function ($noty) {
                n.close();
                return false;
            }
            }
        ]
    });
}

function validateDashboardC() {

    var pin_no = document.getElementById("pin_no").value;
    if(checkEmpty('Pin No',pin_no)) return false;
    else return true;

}

function fetchTrackOrder(){
    //var sender_email = $("#sender_email").val();
    blockUi();
    var pin_no = $("#pin_no").val();
    if(validateDashboardC()){
        $.ajax({
            url:"Controller/fetchPaymentList.php",
            type:"POST",
            data:{pin_no:pin_no,whichRequest:"withPin"},
            success:function(html){
                $("#trackRecordResult").html(html);
            },
            complete:function(com){
                unBlockUi();
            }

        })
    }
    else {
        return false;
    }

}

function hideDisplayEditReceiver(){
    if($("#receiverDetails").hasClass("hide")){
        $("#receiverDetails").removeClass("hide")
    }else{
        $("#receiverDetails").addClass("hide")
    }
}

function editReceiver(){
    var data = $("#editReceiverForm").serialize();
    $.ajax({
        url:"Controller/editReceiver.php",
        type:"POST",
        data:data,
        success:function(data){
            var parsedData = JSON.parse(data);
            if(parsedData.success==true){
                window.location.reload();
            }
            else{
                alert("Error while editing")
            }
        }
    });
    return false;
}

function changePassword(){
    var oldPassword = $("#oldPassword").val();
    var newPassword = $("#newPassword").val();
    var repeatPassword = $("#repeatPassword").val();
    if(repeatPassword!=newPassword){
        noty({layout:'topRight', type: 'error', text: "New Password and Repeat Passwod did not match.", timeout: 10000});
        return false;
    }
    $("#changePasswordClose").click();
    blockUi();
    $.ajax({
        url:"Controller/changeMyPassword.php",
        type:"POST",
        data:{oldPassword:oldPassword,newPassword:newPassword},
        success:function(data){
            unBlockUi();
            var parsedJson = JSON.parse(data);
            if(parsedJson.change){
                noty({layout: 'topRight', type: 'success', text: "Password Changed Successfully", timeout: 10000});
                $("#oldPassword").val("");
                $("#newPassword").val("");
                $("#repeatPassword").val("");
            }else{
                noty({layout:'topRight', type: 'error', text: parsedJson.message, timeout: 10000});
            }
        },
        error:function(err){
            unBlockUi();
        }

    });
}

function editProfile(){
    var data = $("#editProfileForm").serialize();
    console.log(data);
    $.ajax({
        url:"Controller/changeProfileInfo.php",
        type:"POST",
        data:data,
        success:function(data){
            var parsedData = JSON.parse(data);
            if(parsedData.changed){
                alert("Edited Successfully");
                window.location.reload(true)
            }else{
                alert("Some error while editing.")
            }
        }
    })
    return false;
}

function resetPassword(){
    var user_email = $("#user_email").val();
    var password = $("#newPassword").val();
    $.ajax({
        url:"Controller/resetMyPassword.php",
        type:"POST",
        data:{user_email:user_email,password:password},
        success:function(data){
            var parsedJson = JSON.parse(data);
            if(parsedJson.changed){
                alert("Please login with new password.");
                window.location.replace(loginPageUrl);
            }else{
                alert("Error while resetting password. Contact system people")
            }
        }

    })
}

function blockUi(){
    $.blockUI({ css: {
        border: 'none',
        padding: '15px',
        backgroundColor: '#000',
        '-webkit-border-radius': '10px',
        '-moz-border-radius': '10px',
        opacity: .5,
        color: '#fff'
    } });
}

function unBlockUi(){
    $.unblockUI()
}

function changeReceived(optionValue, paymentId){

    $.ajax({
        type: "POST",
        url: 'Controller/receivePayment.php',
        data: "paymentId=" + paymentId + "&value=" + optionValue.value
    }).done(function(result){

        if(result){

            noty({layout:'topRight', type: 'success', text: "Payment successfully received.", timeout: 6000});
        }else{

            noty({layout:'topRight', type: 'error', text: "Payment could not be received.", timeout: 6000});
        }
        setTimeout(function() { location.reload(); }, 2000);
    })
}

function activateCustomer(){
    var id = document.getElementById("activate_button").getAttribute("user_id");
    var name = document.getElementById("firstName").value;
    var email = document.getElementById("email").value;
   
     $.ajax({
        url:"Controller/customerStatus.php",
        type:"POST",
        data:{activate:1,id:id,name:name,email:email},
        success:function(data){
            noty({layout:'topRight', type: 'success', text: "Successfully Activated.", timeout: 6000});
            window.location.reload(true);
        },
        error:function(err){
            
        }

    });
     window.location.reload(true);
}

function deactivateCustomer(){
    var id = document.getElementById("deactivate_button").getAttribute("user_id");
     $.ajax({
        url:"Controller/customerStatus.php",
        type:"POST",
        data:{deactivate:1,id:id},
        success:function(data){
            noty({layout:'topRight', type: 'success', text: "Successfully Deactivated.", timeout: 6000});
        },
        error:function(err){
            
        }

    });
     window.location.reload(true);
}

function deleteReceiver(id){
   var n = noty({
       layout: 'center',
       text: 'Are you sure you want to delete?',
       killer: true,
       buttons: [
           {
               addClass: 'btn btn-primary', text: 'Ok', onClick: function ($noty) {
               $.ajax({
                  url:"Controller/deleteReceiver.php",
                   type:"POST",
                   data:{receiver_id:id},
                   success:function(data){
                       var parsedData = JSON.parse(data);

                       if(parsedData.success){
                           notify("success", "Receiver deleted.");
                           setTimeout(function() { location.reload(); }, 3000);
                       }
                       else{
                           notify("error", "Could not delete receiver.");
                       }
                   }
               });
               n.close();
           }
           },
           {
               addClass: 'btn btn-danger', text: 'Cancel', onClick: function ($noty) {
               n.close();
               return false;
           }
           }
       ]
   });
   n.show();
}

function deleteCustomer(id){

    var n = noty({
        layout: 'center',
        text: 'Are you sure you want to delete?',
        killer: true,
        buttons: [
            {
                addClass: 'btn btn-primary', text: 'Ok', onClick: function ($noty) {
                $.ajax({
                    url:"Controller/deleteCustomer.php",
                    type:"POST",
                    data:{customer_id:id},
                    success:function(data){
                        var parsedData = JSON.parse(data);

                        if(parsedData.success){
                            notify("success", "Customer deleted.");
                            setTimeout(function() { alert("Deleted"); }, 2000);
                            window.location = 'customers.php';
                        }
                        else{
                            notify("error", "Could not delete customer.");
                        }
                    }
                });
                n.close();
            }
            },
            {
                addClass: 'btn btn-danger', text: 'Cancel', onClick: function ($noty) {
                n.close();
                return false;
            }
            }
        ]
    });
    n.show();
}

function deleteTransaction(paymentId){

    var n = noty({
        layout: 'center',
        text: 'Are you sure you want to delete?',
        killer: true,
        buttons: [
            {
                addClass: 'btn btn-primary', text: 'Ok', onClick: function ($noty) {
                $.ajax({
                    url:"Controller/deleteTransaction.php",
                    type:"POST",
                    data:{paymentId:paymentId},
                    success:function(data){
                        var parsedData = JSON.parse(data);

                        if(parsedData.success){
                            notify("success", "Transaction deleted.");
                            setTimeout(function() { location.reload(); }, 2000);
                        }
                        else{
                            notify("error", "Could not delete transaction.");
                        }
                    }
                });
                n.close();
            }
            },
            {
                addClass: 'btn btn-danger', text: 'Cancel', onClick: function ($noty) {
                n.close();
                return false;
            }
            }
        ]
    });
    n.show();
}

function editManualTransaction(){
    $("#transactionForm").attr("action","editSendMoneyAusAd.php")
    $("#transactionForm").submit();
}


function sendEmailSubs(){
    var subscriberList = new Array();
    $.each($('input[name="subscribesCheck"]:checked'),function(){
        subscriberList.push($(this).val());
    });

    if(subscriberList.length==0){
        alert("No Any Check box selected")
    }else{
        var subject = $("#subject").val();
        var message = $("#message").val();
        $.ajax({
            type: "POST",
            url: "Controller/sendEmailSubscriber.php",
            data: {subscriberList: subscriberList, subject: subject, message: message},
            success: function (data) {


                }
        });
setTimeout(function () {
noty({
                    layout: 'topRight',
                    type: 'success',
                    text: "Email Sent Successfully to all the subscribers.",
                    timeout: 10000
                });
                }, 2000);
    }
}

function emailExists(email){

    var exists = false;
    $.ajax({
        type:"POST",
        url:"Controller/emailExists.php",
        data:{email:email},
        success:function(data){
            var parseData = JSON.parse(data);
            if(parseData.exists){

                notify("error", "User with supplied email already exists");
            }else{
                $("#registerForm").submit();
            }
        }
    });
}


function setValueToField(id,email){
    $("#subscriberId").val(id);
    $("#emailAddress").val(email);
}

function editSubscriber(){
    var id = $("#subscriberId").val();
    var email = $("#emailAddress").val();
    $("#editSubscriberDiv").modal("toggle");
    blockUi();
    $.ajax({
        type:"POST",
        url:"Controller/editSubscriber.php",
        data:{id:id,email:email},
        success:function(data){
            var parsedData = JSON.parse(data);
            if(parsedData.success){
                notify("success","Subscriber Edited Successfully.")
            }else{
                notify("error","Error while editing subscriber.")
            }
        },complete:function(com){
            unBlockUi();
            setTimeout(function(){location.reload()},2000)
        }
    })
}

function deleteSubscriber(id){
    var n = noty({
        layout: 'center',
        text: 'Are you sure you want to delete?',
        killer: true,
        buttons: [
            {
                addClass: 'btn btn-primary', text: 'Ok', onClick: function ($noty) {
                blockUi();
                $.ajax({
                    type: "POST",
                    url: "Controller/deleteSubscriber.php",
                    data: {id: id},
                    success: function (data) {
                        var parsedData = JSON.parse(data);
                        if (parsedData.success) {
                            notify("success", "Subscriber Deleted Successfully.")
                        } else {
                            notify("error", "Error while deleting subscriber.")
                        }
                    }, complete: function (com) {
                        unBlockUi();
                        setTimeout(function () {
                            location.reload()
                        }, 2000)
                    }
                });
                n.close();
            }
            },
            {
                addClass: 'btn btn-danger', text: 'Cancel', onClick: function ($noty) {
                n.close();
                return false;
            }
            }
        ]
    });
    n.show();
}


function saveCollectionReport(){
    $("#addCollectionReport").modal("toggle");
    blockUi();
    var data = $("#collectionForm").serialize();
    $.ajax({
        type:"POST",
        url:"Controller/saveCollection.php",
        data:data,
        success:function(data){
            var parsedData = JSON.parse(data);
            if(parsedData.success){
                notify("success","Collection Updated Successfully");
                setTimeout(function(){location.reload()},2000);
            }else{
                notify("error","Error while updating the collection");
            }
        },complete:function(com){
            unBlockUi();
        }
    });
}



function onlyAmount(e, t) {
    try {
        if (window.event) {
            var intCode = window.event.keyCode;
        }
        else if (e) {
            var intCode = e.which;
        }
        else { return true; }
        if (((intCode >=48   && intCode <= 57) || intCode == 46)){
            return true;
        }

        else{
            notify('error', 'Invalid Amount');
            $("#pages").val('');
            return false;
        }

    }
    catch (err) {
        //alert(err.Description);
    }
}

function validateDate(date,which){
    var curDate = new Date();
    if (new Date(date.val()) >= curDate ){
        notify('error',which+' must be less than current date.');
        date.val("");
        return false;
    }
    else return true;
}


function printCollectionDate(collection_date){
    if(collection_date=="all"){
        $("#collection_date").val("");
    }
    blockUi();
    $.ajax({
        type:"POST",
        url:"Controller/printCollectionByDate.php",
        data:{collection_date:collection_date},
        success:function(data){
            $("#collectionData").html(data);
        },
        complete:function(com){
            unBlockUi();
        }
    })
}
function changeAdmin(){

    if($("#newAdminPassword").val() != $("#repeatAdminPassword").val()){

        notify('error', 'New Password and Repeat Password do not match');
        return false;
    }
    $("#changeAdminClose").click();
    blockUi();
    $.ajax({
        type:"POST",
        url:"Controller/changeAdmin.php",
        data:{username:$("#newAdminUsername").val(), password:$("#newAdminPassword").val(), oldUsername:$("#oldUsername").val()},
        success:function(com){
            unBlockUi();
            notify('success', 'Admin Changed');
        },
        error:function () {
            unBlockUi();
            notify('error', 'Admin Not Changed');
        }
    });
    return false;
}

function fetchOrder(el, orderType){
    blockUi();
    $.ajax({
        type:"POST",
        url:"Controller/fetchOrder.php",
        data:{orderType:orderType},
        success:function(data){
            unBlockUi();
            $(".active-order-nav").removeClass('active-order-nav');
            $("#orders-display").empty();
            $("#orders-display").html(data);
            $(el).addClass('active-order-nav');
        },
        error:function () {
            unBlockUi();
        }
    });
    return false;
}