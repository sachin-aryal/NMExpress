function notify(notytype, notymessage) {
    noty({layout:'topRight', type: notytype, text: notymessage, timeout: 6000});
}

function validateLoginField(){
    var username = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();

    if(checkEmpty('Username',username)) return false;
    if(checkEmpty('Password',password)) return false;

}

function validateSenderInformation(which) {
    var fName = document.getElementById('firstName').value.trim();
    var lName = document.getElementById('lastName').value.trim();
    var mobNo = document.getElementById('mobileNo').value.trim();
    var email = document.getElementById('email').value.trim();
    var dob = document.getElementById('dob').value.trim();
    var idType = document.getElementById('idType').value.trim();
    var idNo = document.getElementById('idNo').value.trim();
    var expDate = document.getElementById('expiryDate').value.trim();
    var unit = document.getElementById('unit').value.trim();
    var street = document.getElementById('street').value.trim();
    var streetNo = document.getElementById('streetNo').value.trim();
    var postCode = document.getElementById('postCode').value.trim();
    var city = document.getElementById('senderCity').value.trim();
    var state = document.getElementById('state').value.trim();
    var type = document.getElementById('type').value.trim();
    var idFront = document.getElementById('idFront').value.trim();

    var businessName = document.getElementById('business_name').value.trim();
    var registrationNo = document.getElementById('registrationNo').value.trim();
    var establishedDate = document.getElementById('established_date').value.trim();

    if(checkEmpty('FirstName',fName)) return false;
    if(checkEmpty('LastName',lName)) return false;
    if(checkEmpty('Phone',mobNo)) return false;
    if(checkEmpty('Unit',unit)) return false;
    if(checkEmpty('Street No.',streetNo)) return false;
    if(checkEmpty('Street Name',street)) return false;
    if(checkEmpty('State',state)) return false;
    if(checkEmpty('Post Code',postCode)) return false;
    if(checkEmpty('City/Town',city)) return false;

    if(type === "Individual") {
        if (checkEmpty('Date Of Birth', dob)) return false;
        if (checkEmpty('Identity Number', idNo)) return false;
        if (checkEmpty('Expiry Date', expDate)) return false;

        if(!validateDOB(dob)) return false;
        if(!validateSelect('Identity Type',idType)) return false;
        if(!validateExpDate(expDate)) return false;
    }else if(type === "Business"){

        if (checkEmpty('Business Name', businessName)) return false;
        if (checkEmpty('Registration Number', registrationNo)) return false;
        if (checkEmpty('Established Date', establishedDate)) return false;

        if(!validateEstablishedDate(establishedDate)) return false;
    }
    if(checkEmpty('Email',email)) return false;
    if(which!="editMoney"){
        if(checkEmpty('Identity Photo',idFront)) return false;
    }

    if(!validateAlphabets('First Name',fName)) return false;
    if(!validateAlphabets('Last Name',lName)) return false;
    if(!validateNumbers('Phone',mobNo)) return false;
    if(!validateEmail(email)) return false;
    if(!validateAlphaNumeric('Unit',unit)) return false;
    if(!validateSelect('State',state)) return false;
    if(!validateSelect('I\'m a/an field',type)) return false;
}

function validateCustomerProfile(){

    var fName = document.getElementById('firstName').value.trim();
    var lName = document.getElementById('lastName').value.trim();
    var mobNo = document.getElementById('mobileNo').value.trim();
    var dob = document.getElementById('dob').value.trim();
    var idType = document.getElementById('idType').value.trim();
    var idNo = document.getElementById('idNo').value.trim();
    var expDate = document.getElementById('expiryDate').value.trim();
    var address = document.getElementById('location').value.trim();
    var type = document.getElementById('type').value.trim();

    var businessName = document.getElementById('business_name').value.trim();
    var registrationNo = document.getElementById('registrationNo').value.trim();
    var establishedDate = document.getElementById('established_date').value.trim();

    if(checkEmpty('FirstName',fName)) return false;
    if(checkEmpty('LastName',lName)) return false;
    if(checkEmpty('Phone',mobNo)) return false;
    if(checkEmpty('Address',address)) return false;

    if(type === "Individual") {
        if (checkEmpty('Date Of Birth', dob)) return false;
        if (checkEmpty('Identity Number', idNo)) return false;
        if (checkEmpty('Expiry Date', expDate)) return false;

        if(!validateDOB(dob)) return false;
        if(!validateSelect('Identity Type',idType)) return false;
        if(!validateExpDate(expDate)) return false;
    }else if(type === "Business"){

        if (checkEmpty('Business Name', businessName)) return false;
        if (checkEmpty('Registration Number', registrationNo)) return false;
        if (checkEmpty('Established Date', establishedDate)) return false;

        if(!validateEstablishedDate(establishedDate)) return false;
    }

    if(!validateAlphabets('FirstName',fName)) return false;
    if(!validateAlphabets('LastName',lName)) return false;
    if(!validateNumbers('Phone',mobNo)) return false;
    if(!validateAlphaNumeric('Address',address)) return false;
    if(!validateSelect('I\'m a/an field',type)) return false;
}

function validateReceiverInformation() {
    var fName = document.getElementById('f_name').value.trim();
    var lName = document.getElementById('l_name').value.trim();
    var phnNo = document.getElementById('phone_no').value.trim();
    var city = document.getElementById('city').value.trim();
    var zone = document.getElementById('zone').value.trim();
    var district = document.getElementById('district').value.trim();
    var account_number = document.getElementById('account_number').value.trim();
    var account_name = document.getElementById('account_name').value.trim();
    var bank_name = document.getElementById('bank_name').value.trim();
    var branch_name = document.getElementById('branch_name').value.trim();

    if(checkEmpty('FirstName',fName)) return false;
    if(checkEmpty('LastName',lName)) return false;
    if(checkEmpty('Phone',phnNo)) return false;
    if(checkEmpty('City/Town',city)) return false;
    if($('input[name="payment_type"]:checked').val() == "Bank"){

        if(checkEmpty('Account Number', account_number)) return false;
        if(checkEmpty('Account Name', account_name)) return false;
        if(checkEmpty('Bank Name', bank_name)) return false;
        if(checkEmpty('Branch Name', branch_name)) return false;
    }
    if(!validateAlphabets('FirstName',fName)) return false;
    if(!validateAlphabets('LastName',lName)) return false;
    if(!validateNumbers('Phone',phnNo)) return false;
    if(!validateAlphabets('City/Town',city)) return false;
    if(!validateSelect('Zone',zone)) return false;
    if(!validateSelect('District',district)) return false;
}

function validateDashboardAd(){
    var nrs = document.getElementById("nrs").value.trim();

    if(!validateMoney(nrs)) return false;

}

function validateProcessTransaction() {
    var receiver =  document.getElementById("receiverId").value.trim();
    var amount =  document.getElementById("sendingAmount").value.trim();
    var receiptId = document.getElementById("idFront").value.trim();

    if(!validateSelect('receiver',receiver)) return false;
    if(receiptId == ""){
        notify('error', 'Attach a receipt');

        return false;
    }
    if(!validateMoney(amount)) return false;
}

function validateNewUser() {
    var fName = document.getElementById('f_name').value.trim();
    var lName = document.getElementById('l_name').value.trim();
    var email = document.getElementById('email_address').value.trim();
    var phnNo = document.getElementById('phone_no').value.trim();
    var city = document.getElementById('city').value.trim();
    var zone = document.getElementById('zone').value.trim();
    var district = document.getElementById('district').value.trim();
    var account_number = document.getElementById('account_number').value.trim();
    var account_name = document.getElementById('account_name').value.trim();
    var bank_name = document.getElementById('bank_name').value.trim();
    var branch_name = document.getElementById('branch_name').value.trim();

    if(checkEmpty('FirstName',fName)) return false;
    if(checkEmpty('LastName',lName)) return false;
    if(checkEmpty('Phone',phnNo)) return false;
    if(checkEmpty('City/Town',city)) return false;

    if($('input[name="payment_type"]:checked').val() == "Bank"){

        if(checkEmpty('Account Number', account_number)) return false;
        if(checkEmpty('Account Name', account_name)) return false;
        if(checkEmpty('Bank Name', bank_name)) return false;
        if(checkEmpty('Branch Name', branch_name)) return false;
    }

    if(!validateAlphabets('FirstName',fName)) return false;
    if(!validateAlphabets('LastName',lName)) return false;
    if(email != '')if(!validateEmail(email)) return false;
    if(!validateNumbers('Phone',phnNo)) return false;
    if(!validateAlphabets('City/Town',city)) return false;
    if(!validateSelect('Zone',zone)) return false;
    if(!validateSelect('District',district)) return false;
}

function validateSendMoneyAusAd() {

    var sender =  document.getElementById("senderName").value.trim();
    var receiver =  document.getElementById("receiverName").value.trim();
    var reasonForSending = document.getElementById("reasonForSending").value.trim();
    var sendingAmount = document.getElementById("sendingAmount").value.trim();
    var rate = document.getElementById("rate").value.trim();

    //if(checkEmpty('Add Sender. Sender',sender)) return false;
    //if(checkEmpty('Add Receiver. Receiver',receiver)) return false;

    if($("#senderId1").val() == ""){

        notify('error','Please add/select a sender');
        return false;
    }

    if($("#receiverId").val() == ""){

        notify('error','Please add/select a receiver');
        return false;
    }

    if(checkEmpty('Sending Amount',sendingAmount)) return false;
    if(!validateSelect('Reason For Sending',reasonForSending)) return false;
    if(!validateSelect('Payment Through',received)) return false;
    if(!validateMoney(sendingAmount)) return false;
    if(!validateMoney(rate)) return false;

}

function validateRegisterField(){
    var fName = document.getElementById('firstName').value.trim();
    var lName = document.getElementById('lastName').value.trim();
    var mobNo = document.getElementById('mobileNo').value.trim();
    var email = document.getElementById('email').value.trim();
    var password = document.getElementById('rpassword').value.trim();
    var repassword = document.getElementById('repassword').value.trim();
    //var captcha = document.getElementById('captcha').value.trim();

    if(checkEmpty('Firstname',fName)) return false;
    if(checkEmpty('Lastname',lName)) return false;
    if(checkEmpty('Mobile Number',mobNo)) return false;
    if(checkEmpty('Email',email)) return false;
    if(checkEmpty('Password',password)) return false;
    if(checkEmpty('Repeat Password',repassword)) return false;
    //if(checkEmpty('Captcha',captcha)) return false;

    if(!validateAlphabets('Firstname',fName)) return false;
    if(!validateAlphabets('Lastname',lName)) return false;
    if(!validateNumbers('Mobile Number',mobNo)) return false;
    if(!validateEmail(email)) return false;
    if(!matchPassword(password,repassword)) return false;

    if(email)
        emailExists(email);
}

function validateCreateAgent() {
    var fName = document.getElementById('firstName').value.trim();
    var lName = document.getElementById('lastName').value.trim();
    var mobNo = document.getElementById('phone').value.trim();
    var address = document.getElementById('address').value.trim();
    var email = document.getElementById('email').value.trim();
    var agentType = document.getElementById('agentType').value.trim();
    var companyName = document.getElementById('companyName').value.trim();
    var companyPhone = document.getElementById('companyPhone').value.trim();
    var companyAddress = document.getElementById('companyAddress').value.trim();
    var idType = document.getElementById('idType').value.trim();
    var idNo = document.getElementById('idNo').value.trim();
    var password = document.getElementById('password').value.trim();
    var repassword = document.getElementById('repassword').value.trim();

    if(checkEmpty('Firstname',fName)) return false;
    if(checkEmpty('Lastname',lName)) return false;
    if(checkEmpty('Phone',mobNo)) return false;
    if(checkEmpty('Address',address)) return false;
    if(checkEmpty('Email',email)) return false;
    if(checkEmpty('Company Name',companyName)) return false;
    if(checkEmpty('Company Phone',companyPhone)) return false;
    if(checkEmpty('Company Address',companyAddress)) return false;
    if(checkEmpty('Identity Number',idNo)) return false;
    if(checkEmpty('Password',password)) return false;
    if(checkEmpty('Repeat Password',repassword)) return false;

    if(!validateAlphabets('Firstname',fName)) return false;
    if(!validateAlphabets('Lastname',lName)) return false;
    if(!validateNumbers('Phone',mobNo)) return false;
    if(!validateAlphaNumeric('Address',address)) return false;
    if(!validateEmail(email)) return false;
    if(!validateSelect('Agent Type',agentType)) return false;
    if(!validateAlphaNumeric('Company Name',companyName)) return false;
    if(!validateNumbers('Company Phone',companyPhone)) return false;
    if(!validateAlphaNumeric('Company Address',companyAddress)) return false;
    if(!validateSelect('Identity Type',idType)) return false;
    if(!matchPassword(password,repassword)) return false;
}

function validateVerifyCustomerField(){
    var fName = document.getElementById('firstName').value.trim();
    var lName = document.getElementById('lastName').value.trim();
    var mobNo = document.getElementById('mobileNo').value.trim();
    var dob = document.getElementById('dob').value.trim();
    var idType = document.getElementById('idType').value.trim();
    var idNo = document.getElementById('idNo').value.trim();
    var expDate = document.getElementById('expiryDate').value.trim();
    var unit = document.getElementById('unit').value.trim();
    var street = document.getElementById('street').value.trim();
    var streetNo = document.getElementById('streetNo').value.trim();
    var postCode = document.getElementById('postCode').value.trim();
    var city = document.getElementById('city').value.trim();
    var state = document.getElementById('state').value.trim();
    var type = document.getElementById('type').value.trim();
    var idFront = document.getElementById('idFront').value.trim();

    var businessName = document.getElementById('business_name').value.trim();
    var registrationNo = document.getElementById('registrationNo').value.trim();
    var establishedDate = document.getElementById('established_date').value.trim();

    if(checkEmpty('FirstName',fName)) return false;
    if(checkEmpty('LastName',lName)) return false;
    if(checkEmpty('Mobile Number',mobNo)) return false;
    if(type === "Individual") {
        if (checkEmpty('Date Of Birth', dob)) return false;
        if (checkEmpty('Identity Number', idNo)) return false;
        if (checkEmpty('Expiry Date', expDate)) return false;

        if(!validateDOB(dob)) return false;
        if(!validateSelect('Identity Type',idType)) return false;
        if(!validateExpDate(expDate)) return false;
    }else if(type === "Business"){

        if (checkEmpty('Business Name', businessName)) return false;
        if (checkEmpty('Registration Number', registrationNo)) return false;
        if (checkEmpty('Established Date', establishedDate)) return false;

        if(!validateEstablishedDate(establishedDate)) return false;
    }

    if(checkEmpty('Unit',unit)) return false;
    if(checkEmpty('Street No.',streetNo)) return false;
    if(checkEmpty('Street Name',street)) return false;
    if(checkEmpty('Post Code',postCode)) return false;
    if(checkEmpty('City/Town',city)) return false;
    if(checkEmpty('State',state)) return false;
    if(checkEmpty('Id Photo',idFront)) return false;

    if(!validateAlphabets('First Name',fName)) return false;
    if(!validateAlphabets('Last Name',lName)) return false;
    if(!validateNumbers('Mobile Number',mobNo)) return false;
    if(!validateAlphaNumeric('Unit',unit)) return false;
    if(!validateSelect('State',state)) return false;
    if(!validateSelect('I\'m a/an field',type)) return false;

}

function validateDOB(date){
    var curDate = new Date();

    

    if (new Date(date) >= curDate ){
        notify('error','Date of Birth must be less than current date.');
        return false;
    }
    else return true;
}

function validateEstablishedDate(date){

    var curDate = new Date();

    if (new Date(date) >= curDate ){
        notify('error',' Established Date must be less than current date.');
        return false;
    }
    else return true;
}

function validateSelect(selectLabel,selectOption) {
    if (selectOption == 'Select'||selectOption == 'not'){
        notify('error','Please add/select a '+selectLabel);
        return false;
    }
    else return true;
}

function validateExpDate(date) {
    var curDate = new Date();

    if (new Date(date) <= curDate ){
        notify('error',' Expiry must be more than current date.');
        return false;
    }
    else return true;
}

function validateAlphaNumeric(fieldname,fieldvalue) {
    var  pat = /^[A-Za-z0-9\.\-\s]+$/;
    if(!fieldvalue.match(pat)) {
        notify('error',fieldname+' must be Alphanumeric.');
        return false;
    }
    else return true;
}

function validateMoney(amount){
    var  pat = /^[0-9]+[\.]?[0-9]+$/;
    if(!amount.match(pat)) {
        notify('error','Sending Amount is invalid');
        return false;
    }
    else return true;
}

function validateAlphabets(fieldname,fieldvalue){
    var pat = /^[A-Za-z]+$/;
    if(!fieldvalue.match(pat)) {
        notify('error',fieldname+' must only be Alphabets.');
        return false;
    }
    else return true;
}

function validateNumbers(fieldname,fieldvalue){
    var pat = /^[0-9]+$/;
    if(!fieldvalue.match(pat)) {
        notify('error',fieldname+' must only be Numbers.');
        return false;
    }
    else return true;
}

function validateEmail(email){
    var pat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(!email.match(pat)) {
        notify('error','Invalid Email Address.');
        return false;
    }
    else return true;
}

function matchPassword(password,repassword){
    if(password != repassword) {
        notify('error','Passwords do not match.');
        return false;
    }
    else return true;
}

function checkEmpty(fieldname,fieldvalue){
    if(fieldvalue==''){
        notify('error',fieldname+' cannot be empty');
        return true;
    }
    else return false;
}

function validateMobile(mob){

    if(mob.length != 9){

        notify("error", "Mobile Number must be 9 digits");
        return false;
    }
    else return true;
}