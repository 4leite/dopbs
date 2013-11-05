<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 1.7
* File                    : expresscheckout.php
* File Version            : 1.4
* Created / Last Modified : 03 June 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : PayPal Express Checkout script.
*/

    // ==================================
    // PayPal Express Checkout Module
    // ==================================
    
    $cID = $_POST['DOPBookingSystemPRO_ID'];
    
    require_once('../../../../../wp-load.php');  
    global $wpdb;
    
    $form = $wpdb->get_results('SELECT * FROM '.DOPBSP_Forms_Fields_table.' WHERE form_id="'.$_POST['DOPBookingSystemPRO_FormID'.$cID].'" ORDER BY position');
    $fields = array();
    $field_data = array();
    $i = 0;
    $email = '';
                
    foreach ($form as $field){
        $translation = json_decode(stripslashes($field->translation));
        $field->translation = $translation->$_POST['DOPBookingSystemPRO_Language'.$cID];
        
        $field_data[$i] = new stdClass();
        $field_data[$i]->id = $field->id;
        $field_data[$i]->name = $field->translation;
                            
        if ($field->type == 'select'){
            $selected_values = $_POST['DOPBookingSystemPRO_FormField'.$cID.'_'.$field->id];
            $field_data[$i]->value = array();
            $options = $wpdb->get_results('SELECT * FROM '.DOPBSP_Forms_Select_Options_table.' WHERE field_id='.$field->id.' ORDER BY field_id ASC');
            
            foreach ($options as $option){
                $option_translation = json_decode(stripslashes($option->translation));
                $option->translation = $option_translation->$_POST['DOPBookingSystemPRO_Language'.$cID];
                
                for ($o=0; $o<count($selected_values); $o++){
                    if ((int)$selected_values[$o] == $option->id){
                        array_push($field_data[$i]->value, $option);
                    }
                }
            }
        }
        else{
            if (isset($_POST['DOPBookingSystemPRO_FormField'.$cID.'_'.$field->id])){
                $field_data[$i]->value = $_POST['DOPBookingSystemPRO_FormField'.$cID.'_'.$field->id];
            }
            else{
                $field_data[$i]->value = '';
            }
        }
        
        if ($field->is_email == 'true' && $email == ''){
            $email = $_POST['DOPBookingSystemPRO_FormField'.$cID.'_'.$field->id];
        }
        
        array_push($fields, $field_data[$i]);
        
        $i++;
    }
    
    if (session_id() == ""){
        session_start();
    }
    
    $_SESSION['DOPBSP_Language'] = $_POST['DOPBookingSystemPRO_Language'.$cID];
    $_SESSION['DOPBSP_Page'] = $_POST['DOPBookingSystemPRO_Page'.$cID];
    $_SESSION['DOPBSP_PluginURL'] = $_POST['DOPBookingSystemPRO_PluginURL'.$cID];
    $_SESSION['DOPBSP_CalendarID'] = $cID;   
    $_SESSION['DOPBSP_PriceItemValue'] = $_POST['DOPBookingSystemPRO_PriceItemValue'.$cID]; 
    $_SESSION['DOPBSP_PriceValue'] = $_POST['DOPBookingSystemPRO_PriceValue'.$cID]; 
    $_SESSION['DOPBSP_DiscountValue'] = $_POST['DOPBookingSystemPRO_DiscountValue'.$cID]; 
    $_SESSION['DOPBSP_PriceToPayValue'] = $_POST['DOPBookingSystemPRO_PriceToPayValue'.$cID]; 
    $_SESSION['DOPBSP_PriceDepositValue'] = $_POST['DOPBookingSystemPRO_PriceDepositValue'.$cID]; 
    $_SESSION['Payment_Amount'] = $_POST['DOPBookingSystemPRO_PriceDepositValue'.$cID] != 0 ? $_POST['DOPBookingSystemPRO_PriceDepositValue'.$cID]:$_POST['DOPBookingSystemPRO_PriceToPayValue'.$cID];
    $_SESSION['DOPBSP_Currency'] = $_POST['DOPBookingSystemPRO_Currency'.$cID];
    $_SESSION['DOPBSP_CurrencyCode'] = $_POST['DOPBookingSystemPRO_CurrencyCode'.$cID];
    $_SESSION['DOPBSP_FormID'] = $_POST['DOPBookingSystemPRO_FormID'.$cID];
    $_SESSION['DOPBSP_Form'] = $fields;
        
    $_SESSION['DOPBSP_CheckIn'] = isset($_POST['DOPBookingSystemPRO_CheckIn'.$cID]) ? $_POST['DOPBookingSystemPRO_CheckIn'.$cID]:'';
    $_SESSION['DOPBSP_CheckOut'] = isset($_POST['DOPBookingSystemPRO_CheckOut'.$cID]) ? $_POST['DOPBookingSystemPRO_CheckOut'.$cID]:'';    
    $_SESSION['DOPBSP_StartHour'] = isset($_POST['DOPBookingSystemPRO_StartHour'.$cID]) ? $_POST['DOPBookingSystemPRO_StartHour'.$cID]:'';
    $_SESSION['DOPBSP_EndHour'] = isset($_POST['DOPBookingSystemPRO_EndHour'.$cID]) ? $_POST['DOPBookingSystemPRO_EndHour'.$cID]:'';
    $_SESSION['DOPBSP_NoItems'] = isset($_POST['DOPBookingSystemPRO_NoItems'.$cID]) ? $_POST['DOPBookingSystemPRO_NoItems'.$cID]:'';
    
    $_SESSION['DOPBSP_Email'] = $email;
    $_SESSION['DOPBSP_NoPeople'] = isset($_POST['DOPBookingSystemPRO_NoPeople'.$cID]) ? $_POST['DOPBookingSystemPRO_NoPeople'.$cID]:'';
    $_SESSION['DOPBSP_NoChildren'] = isset($_POST['DOPBookingSystemPRO_NoChildren'.$cID]) ? $_POST['DOPBookingSystemPRO_NoChildren'.$cID]:'';
    
    $_SESSION['DOPBSP_SkipPayPalRegistration'] = false;

    require_once("paypalfunctions.php");
    
    //'------------------------------------
    //' The paymentAmount is the total value of 
    //' the shopping cart, that was set 
    //' earlier in a session variable 
    //' by the shopping cart page
    //'------------------------------------
    $paymentAmount = $_SESSION["Payment_Amount"];
    
    //'------------------------------------
    //' The currencyCodeType and paymentType 
    //' are set to the selections made on the Integration Assistant 
    //'------------------------------------
    $currencyCodeType = $_SESSION["DOPBSP_CurrencyCode"];
    $paymentType = "Sale";

    //'------------------------------------
    //' The returnURL is the location where buyers return to when a
    //' payment has been succesfully authorized.
    //'
    //' This is set to the value entered on the Integration Assistant 
    //'------------------------------------
    $returnURL = $_SESSION['DOPBSP_PluginURL'].'assets/paypal/book-confirmation.php';

    //'------------------------------------
    //' The cancelURL is the location buyers are sent to when they hit the
    //' cancel button during authorization of payment during the PayPal flow
    //'
    //' This is set to the value entered on the Integration Assistant 
    //'------------------------------------
    $cancelURL = $_SESSION["DOPBSP_Page"];

    //'------------------------------------
    //' Calls the SetExpressCheckout API call
    //'
    //' The CallShortcutExpressCheckout function is defined in the file PayPalFunctions.php,
    //' it is included at the top of this file.
    //'-------------------------------------------------
    
    $resArray = CallShortcutExpressCheckout($paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL);
    $ack = strtoupper($resArray["ACK"]);
        
    if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING"){
	RedirectToPayPal($resArray["TOKEN"]);
    } 
    else{
	//Display a user friendly Error on the page using any of the following error information returned by PayPal
	$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
	$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
	$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
	$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
	
	echo "SetExpressCheckout API call failed.<br/>";
	echo "Detailed Error Message: ".$ErrorLongMsg."<br/>";
	echo "Short Error Message: ".$Error."<br/>";;
	echo "Error Severity Code: ".$ErrorSeverityCode."<br/>";
    }
    
?>