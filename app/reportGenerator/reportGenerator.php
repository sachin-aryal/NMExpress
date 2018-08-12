<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/4/2016
 * Time: 11:38 AM
 */
//session_start();
require_once "../Common/DbConnection.php";
require_once "../Common/CommonFunction.php";
require_once "../Common/PaymentFunction.php";
require_once("class.export_excel.php");

if(isset($_GET["reportType"])){


    $reportType = $_GET["reportType"];
    if($_SESSION["role"]=="ROLE_ADMIN"){
        $reportName=$reportType.".xls";
        $rawData = getAustracReportData($conn);
        $excel_obj=new ExportExcel();
        $excel_obj->setFileName($reportName);
        $mainHeader = array(
            "Transaction Details","","","","","","","",
            "Ordering Customer","","","",
            "Ordering customer contact details","","","","","","","",
            "Ordering customer business details","","","","","",
            "Beneficiary customer","","","",
            "Beneficiary customer contact details","","","","","","","","",
            "Beneficiary customer account details","","","",
            "Person/organisation accepting the transfer instruction from the ordering customer","","","","","","","","","","","","","","","",
            "Reason","",
            "Person completing this report"

        );
        $reportHeader = array(
            "Date money/property received from the ordering customer",//Transaction Details
            "Date money/property made available to the beneficiary customer",
            "Currency code",
            "Total amount/value",
            "Type of transfer",
            "Description of property",
            "Transaction reference number","",

            "Full name",//Ordering Customer
            "If known by any other name",
            "Date of birth (if an individual)","",

            "Business/residential address (not a post box address))",//Ordering customer contact details
            "Unit",
            "State",
            "Street",
            "Country",
            "Postal address",
            "Email","",

            "Occupation, business or principal activity",//Ordering customer business details
            "ABN, ACN or ARBN",
            "Customer number (allocated by remitter)",
            "Account number",
            "Business structure (if not an individual)","",

            "Full name",//Beneficiary customer
            "Date of birth (if an individual)",
            "Any business name under which the beneficiary customer is operating","",

            "City/town/suburb",//Beneficiary customer contact details
            "Zone",
            "District",
            "Country",
            "Phone",
            "Postal address",
            "Occupation, business or principal activity",
            "ABN, ACN or ARBN","",

            "Account number",//Beneficiary customer account details
            "Name of institution (where account is held)",
            "Country","",

            "Full name",//Person/organisation accepting the transfer instruction from the ordering customer
            "If known by any other name",
            "Date of birth (if an individual)",
            "Business/residential address (not a post box address)",
            "City/town/suburb",
            "State",
            "Postcode",
            "Country",
            "Postal address",
            "Phone",
            "Email",
            "Occupation, business or principal activity",
            "Business structure (if not an individual)",
            "Is this person/organisation accepting the money or property?",
            "Is this person/organisation sending the transfer instruction?","",

            "Reason","",//Reason
            "Full Name",//Person completing this report
            "Job Title",
            "Phone",
            "Email"
        );

        $reportData = array();
        $j=0;
        foreach($reportHeader as $header){
            $reportData[0][$j++] = $header;
        }
        $i=1;
        foreach($rawData as $data){
            $j=0;
            foreach($data as $key=>$value){
                $reportData[$i][$j++] = $value;
            }
            $i++;
        }

        $excel_obj->setHeadersAndValues($mainHeader,$reportData);
        //now generate the excel file with the data and headers set
        $excel_obj->GenerateExcelFile();
    }else if($reportType=="ALL" && $_SESSION["role"]=="ROLE_ADMIN"){

    }else if($reportType=="SERVICE_CHARGE" && $_SESSION["role"]=="ROLE_ADMIN"){
        $reportName = $reportType.".xls";
        $serviceChargeData = getServiceChargeData($conn);
    }

}