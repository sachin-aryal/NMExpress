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
error_reporting(0);
if(isset($_GET["reportType"])){


    $reportType = $_GET["reportType"];
    if($_SESSION["role"]=="ROLE_ADMIN"){
        $reportName=$reportType.".xls";
        $rawData = getAustracReportData($conn);
        $excel_obj=new ExportExcel();
        $excel_obj->setFileName($reportName);
        $mainHeader = array(
        );
        $reportHeader = array(
            "Date money received from the ordering customer",
            "Date money received from the ordering customer",
            "Currency code",
            "Total amount",
            "Type of transfer",
            "Description of property",
            "Transaction reference number",
            "Ordering customer Full name",
            "Ordering customer If known by any other name",
            "Ordering customer Date of birth",
            "Ordering customer address",
            "Ordering customer suburb",
            "Ordering customer State",
            "Ordering customer Postcode",
            "Ordering customer Country",
            "Ordering customer Postal address",
            "Ordering customer Postal suburb",
            "Ordering customer Postal State",
            "Ordering customer Postal Postcode",
            "Ordering customerPostal Country",
            "Ordering customer Phone",
            "Ordering customer Email",
            "Ordering customer Occupation",
            "Ordering customer ABN ACN or ARBN",
            "Ordering customer Customer number",
            "Ordering customer Account number",
            "Ordering customer Business structure",
            "Ordering customer ID type",
            "Ordering customer ID type if Other",
            "Ordering customer ID Number",
            "Ordering customer ID Issuer",
            "Ordering customer ID type 2",
            "Ordering customer ID type 2 if Other",
            "Ordering customer ID type 2 Number",
            "Ordering customer ID type 2 Issuer",
            "Electronic data source",
            "Beneficiary customer Full name",
            "Beneficiary customer Date of birth",
            "Beneficiary customer address",
            "Beneficiary customer City",
            "Beneficiary customer State",
            "Beneficiary customer Postcode",
            "Beneficiary customer Country",
            "Beneficiary customer Postal address",
            "Beneficiary customer Postal City",
            "Beneficiary customer Postal State",
            "Beneficiary customer Postal Postcode",
            "Beneficiary customer Postal Country",
            "Beneficiary customer Phone",
            "Beneficiary customer Email",
            "Beneficiary customer Occupation",
            "Beneficiary customer ABN ACN or ARBN",
            "Beneficiary customer Business structure",
            "Beneficiary customer Account Number",
            "Beneficiary customer Name of institution account held",
            "Beneficiary customer bank City",
            "Beneficiary customer bank Country",
            "organisation accepting the transfer identification no",
            "organisation accepting the transfer Full Name",
            "organisation accepting the transfer Address",
            "organisation accepting the transfer City",
            "organisation accepting the transfer State",
            "organisation accepting the transfer Post Code",
            "is organisation accepting the money",
            "is organisation sending the transfer instruction",
            "organisation accepting money if different Full name",
            "organisation accepting money if different address",
            "organisation accepting money if different city",
            "organisation accepting money if different state",
            "organisation accepting money if different postcode",
            "sending transfer instruction if different Full Name",
            "sending transfer instruction if different other name",
            "sending transfer instruction if different DOB",
            "sending transfer instruction if different address",
            "sending transfer instruction if different State",
            "sending transfer instruction if different City",
            "sending transfer instruction if different Postcode",
            "sending transfer instruction if different P address",
            "sending transfer instruction if different P city",
            "sending transfer instruction if different P state",
            "sending transfer instruction if different P postcode",
            "sending transfer instruction if different phone",
            "sending transfer instruction if different email",
            "sending transfer instruction if different Occupation",
            "sending transfer instruction if different ABN ACN or ARBN",
            "sending transfer instruction if different Business structure",
            "receiving transfer instruction Full Name",
            "receiving transfer instruction City",
            "receiving transfer instruction Address",
            "receiving transfer instruction State",
            "receiving transfer instruction Postcode",
            "receiving transfer instruction Country",
            "is organisation distributing money",
            "is there seperate Retail Outlet",
            "distributed if different Full name",
            "distributed if different address",
            "distributed if different City",
            "distributed if different State",
            "distributed if different Postcode",
            "distributed if different Country",
            "Retail outlet if different Full name",
            "Retail outlet if different address",
            "Retail outlet if different City",
            "Retail outlet if different State",
            "Retail outlet if different Postcode",
            "Retail outlet if different Country",
            "Reason for the transfer",
            "Person completing this report Full name",
            "Person completing this report Job Title",
            "Person completing this report Phone",
            "Person completing this report Email"
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

        $excel_obj->setHeadersAndValues(null,$reportData);
        //now generate the excel file with the data and headers set
        $excel_obj->GenerateExcelFile();
    }else if($reportType=="ALL" && $_SESSION["role"]=="ROLE_ADMIN"){

    }else if($reportType=="SERVICE_CHARGE" && $_SESSION["role"]=="ROLE_ADMIN"){
        $reportName = $reportType.".xls";
        $serviceChargeData = getServiceChargeData($conn);
    }

}