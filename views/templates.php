<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 1.7
* File                    : templates.php
* File Version            : 1.7
* Created / Last Modified : 31 July 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Templates Class.
*/

    if (!class_exists("DOPBSPTemplates")){
        class DOPBSPTemplates{
            function DOPBSPTemplates(){// Constructor.
            }
            
            function returnTranslations(){// Add translation to JavaScript variables for AJAX usage.
                //echo $_GET['post_type']; 
              //  die();
                if (!isset($_GET['post_type']) && !isset($_GET['action'])){
                    $current_page = $_GET['page'];

                    switch($current_page){
                        case "dopbsp-settings":
                            $DOPBSP_curr_page = "Settings";
                            break;
                        case "dopbsp-booking-forms":
                            $DOPBSP_curr_page = "Forms List";
                            break;
                        default:
                            $DOPBSP_curr_page = "Calendars List";
                            break;
                    }
                }
                else{
                    $DOPBSP_curr_page = "Calendars List";
                }
                
                if (!is_super_admin()){
                    $DOPBSP_user_role = wp_get_current_user()->roles[0];
                }
                else{
                    $DOPBSP_user_role = "administrator";
                }
?>          
            <script type="text/JavaScript">
                var DOPBSP_curr_page = "<?php echo $DOPBSP_curr_page?>",
                DOPBSP_user_role = "<?php echo $DOPBSP_user_role?>",
                DOPBSP_plugin_url = "<?php echo DOPBSP_Plugin_URL?>",
                DOPBSP_plugin_abs = "<?php echo DOPBSP_Plugin_AbsPath?>",

                DOPBSP_TITLE = "<?php echo DOPBSP_TITLE?>",

                // Loading ...
                DOPBSP_LOAD = "<?php echo DOPBSP_LOAD?>",

                // Save ...
                DOPBSP_SAVE = "<?php echo DOPBSP_SAVE?>",
                DOPBSP_SAVE_SUCCESS = "<?php echo DOPBSP_SAVE_SUCCESS?>",

                // Months & Week Days
                DOPBSP_month_names = [<?php            
                    global $DOPBSP_month_names;

                    for ($i=0; $i<count($DOPBSP_month_names); $i++){
                        if ($i == 0){
                            echo '"'.$DOPBSP_month_names[$i].'"';
                        }
                        else{
                            echo ', "'.$DOPBSP_month_names[$i].'"';                
                        }
                    }?>],     
                DOPBSP_day_names = [<?php            
                    global $DOPBSP_day_names;

                    for ($i=0; $i<count($DOPBSP_day_names); $i++){
                        if ($i == 0){
                            echo '"'.$DOPBSP_day_names[$i].'"';
                        }
                        else{
                            echo ', "'.$DOPBSP_day_names[$i].'"';                
                        }
                    }?>],

                // Help
                DOPBSP_CALENDARS_HELP = "<?php echo DOPBSP_CALENDARS_HELP?>",
                DOPBSP_CALENDARS_NO_ADD_HELP = "<?php echo DOPBSP_CALENDARS_NO_ADD_HELP?>",
                DOPBSP_CALENDAR_EDIT_HELP = "<?php echo DOPBSP_CALENDAR_EDIT_HELP?>",
                DOPBSP_CALENDAR_EDIT_ADMINISTRATOR_HELP = "<?php echo DOPBSP_CALENDAR_EDIT_ADMINISTRATOR_HELP?>",
                DOPBSP_CALENDAR_EDIT_SETTINGS_HELP = "<?php echo DOPBSP_CALENDAR_EDIT_SETTINGS_HELP?>",

                // Form
                DOPBSP_SUBMIT = "<?php echo DOPBSP_SUBMIT?>",
                DOPBSP_DELETE = "<?php echo DOPBSP_DELETE?>",
                DOPBSP_BACK = "<?php echo DOPBSP_BACK?>",
                DOPBSP_BACK_SUBMIT = "<?php echo DOPBSP_BACK_SUBMIT?>",
                DOPBSP_ENABLED = "<?php echo DOPBSP_ENABLED?>",
                DOPBSP_DISABLED = "<?php echo DOPBSP_DISABLED?>",
                DOPBSP_DATE_TYPE_AMERICAN = "<?php echo DOPBSP_DATE_TYPE_AMERICAN?>",
                DOPBSP_DATE_TYPE_EUROPEAN = "<?php echo DOPBSP_DATE_TYPE_EUROPEAN?>",

                // Calendars    
                DOPBSP_SHOW_CALENDARS = "<?php echo DOPBSP_SHOW_CALENDARS?>",
                DOPBSP_CALENDARS_LOADED = "<?php echo DOPBSP_CALENDARS_LOADED?>",
                DOPBSP_CALENDAR_LOADED = "<?php echo DOPBSP_CALENDAR_LOADED?>",
                DOPBSP_NO_CALENDARS = "<?php echo DOPBSP_NO_CALENDARS?>",

                // Calendar 
                DOPBSP_ADD_MONTH_VIEW = "<?php echo DOPBSP_ADD_MONTH_VIEW?>",
                DOPBSP_REMOVE_MONTH_VIEW = "<?php echo DOPBSP_REMOVE_MONTH_VIEW?>",
                DOPBSP_PREVIOUS_MONTH = "<?php echo DOPBSP_PREVIOUS_MONTH?>",
                DOPBSP_NEXT_MONTH = "<?php echo DOPBSP_NEXT_MONTH?>",
                DOPBSP_AVAILABLE_ONE_TEXT = "<?php echo DOPBSP_AVAILABLE_ONE_TEXT?>",
                DOPBSP_AVAILABLE_TEXT = "<?php echo DOPBSP_AVAILABLE_TEXT?>",
                DOPBSP_BOOKED_TEXT = "<?php echo DOPBSP_BOOKED_TEXT?>",
                DOPBSP_UNAVAILABLE_TEXT = "<?php echo DOPBSP_UNAVAILABLE_TEXT?>",

                // Calendar Form 
                DOPBSP_DATE_START_LABEL = "<?php echo DOPBSP_DATE_START_LABEL?>",
                DOPBSP_DATE_START_LABEL = "<?php echo DOPBSP_DATE_START_LABEL?>",
                DOPBSP_DATE_END_LABEL = "<?php echo DOPBSP_DATE_END_LABEL?>",
                DOPBSP_STATUS_LABEL = "<?php echo DOPBSP_STATUS_LABEL?>",
                DOPBSP_STATUS_AVAILABLE_TEXT = "<?php echo DOPBSP_STATUS_AVAILABLE_TEXT?>",
                DOPBSP_STATUS_BOOKED_TEXT = "<?php echo DOPBSP_STATUS_BOOKED_TEXT?>",
                DOPBSP_STATUS_SPECIAL_TEXT = "<?php echo DOPBSP_STATUS_SPECIAL_TEXT?>",
                DOPBSP_STATUS_UNAVAILABLE_TEXT = "<?php echo DOPBSP_STATUS_UNAVAILABLE_TEXT?>",
                DOPBSP_PRICE_LABEL = "<?php echo DOPBSP_PRICE_LABEL?>",
                DOPBSP_PROMO_LABEL = "<?php echo DOPBSP_PROMO_LABEL?>",
                DOPBSP_AVAILABLE_LABEL = "<?php echo DOPBSP_AVAILABLE_LABEL?>",
                DOPBSP_HOURS_DEFINITIONS_CHANGE_LABEL = "<?php echo DOPBSP_HOURS_DEFINITIONS_CHANGE_LABEL?>",
                DOPBSP_HOURS_DEFINITIONS_LABEL = "<?php echo DOPBSP_HOURS_DEFINITIONS_LABEL?>",
                DOPBSP_HOURS_SET_DEFAULT_DATA_LABEL = "<?php echo DOPBSP_HOURS_SET_DEFAULT_DATA_LABEL?>",
                DOPBSP_HOURS_START_LABEL = "<?php echo DOPBSP_HOURS_START_LABEL?>",
                DOPBSP_HOURS_END_LABEL = "<?php echo DOPBSP_HOURS_END_LABEL?>",
                DOPBSP_HOURS_INFO_LABEL = "<?php echo DOPBSP_HOURS_INFO_LABEL?>",
                DOPBSP_HOURS_NOTES_LABEL = "<?php echo DOPBSP_HOURS_NOTES_LABEL?>",
                DOPBSP_GROUP_DAYS_LABEL = "<?php echo DOPBSP_GROUP_DAYS_LABEL?>",
                DOPBSP_GROUP_HOURS_LABEL = "<?php echo DOPBSP_GROUP_HOURS_LABEL?>",
                DOPBSP_RESET_CONFIRMATION = "<?php echo DOPBSP_RESET_CONFIRMATION?>",

                // Add Calendar
                DOPBSP_ADD_CALENDAR_NAME = "<?php echo DOPBSP_ADD_CALENDAR_NAME?>",
                DOPBSP_ADD_CALENDAR_SUBMIT = "<?php echo DOPBSP_ADD_CALENDAR_SUBMIT?>",
                DOPBSP_ADD_CALENDAR_SUBMITED = "<?php echo DOPBSP_ADD_CALENDAR_SUBMITED?>",
                DOPBSP_ADD_CALENDAR_SUCCESS = "<?php echo DOPBSP_ADD_CALENDAR_SUCCESS?>",

                // Edit Calendar
                DOPBSP_EDIT_CALENDAR_SUBMIT = "<?php echo DOPBSP_EDIT_CALENDAR_SUBMIT?>",
                DOPBSP_EDIT_CALENDAR_SUCCESS = "<?php echo DOPBSP_EDIT_CALENDAR_SUCCESS?>",
                DOPBSP_EDIT_CALENDAR_USERS_PERMISSIONS = "<?php echo DOPBSP_EDIT_CALENDAR_USERS_PERMISSIONS?>",

                // Delete Calendar
                DOPBSP_DELETE_CALENDAR_CONFIRMATION = "<?php echo DOPBSP_DELETE_CALENDAR_CONFIRMATION?>",
                DOPBSP_DELETE_CALENDAR_SUBMIT = "<?php echo DOPBSP_DELETE_CALENDAR_SUBMIT?>",
                DOPBSP_DELETE_CALENDAR_SUBMITED = "<?php echo DOPBSP_DELETE_CALENDAR_SUBMITED?>",
                DOPBSP_DELETE_CALENDAR_SUCCESS = "<?php echo DOPBSP_DELETE_CALENDAR_SUCCESS?>",

                // Reservations
                DOPBSP_SHOW_RESERVATIONS = "<?php echo DOPBSP_SHOW_RESERVATIONS?>",
                DOPBSP_NO_RESERVATIONS = "<?php echo DOPBSP_NO_RESERVATIONS?>",

                DOPBSP_RESERVATIONS_ID = "<?php echo DOPBSP_RESERVATIONS_ID?>",

                DOPBSP_RESERVATIONS_CHECK_IN_LABEL = "<?php echo DOPBSP_RESERVATIONS_CHECK_IN_LABEL?>",
                DOPBSP_RESERVATIONS_CHECK_OUT_LABEL = "<?php echo DOPBSP_RESERVATIONS_CHECK_OUT_LABEL?>",
                DOPBSP_RESERVATIONS_START_HOURS_LABEL = "<?php echo DOPBSP_RESERVATIONS_START_HOURS_LABEL?>",
                DOPBSP_RESERVATIONS_END_HOURS_LABEL = "<?php echo DOPBSP_RESERVATIONS_END_HOURS_LABEL?>",

                DOPBSP_RESERVATIONS_FIRST_NAME_LABEL = "<?php echo DOPBSP_RESERVATIONS_FIRST_NAME_LABEL?>",
                DOPBSP_RESERVATIONS_LAST_NAME_LABEL = "<?php echo DOPBSP_RESERVATIONS_LAST_NAME_LABEL?>",
                DOPBSP_RESERVATIONS_STATUS_LABEL = "<?php echo DOPBSP_RESERVATIONS_STATUS_LABEL?>",
                DOPBSP_RESERVATIONS_STATUS_PENDING = "<?php echo DOPBSP_RESERVATIONS_STATUS_PENDING?>",
                DOPBSP_RESERVATIONS_STATUS_APPROVED = "<?php echo DOPBSP_RESERVATIONS_STATUS_APPROVED?>",
                DOPBSP_RESERVATIONS_DATE_CREATED_LABEL = "<?php echo DOPBSP_RESERVATIONS_DATE_CREATED_LABEL?>",
                DOPBSP_RESERVATIONS_PAYMENT_METHOD_LABEL = "<?php echo DOPBSP_RESERVATIONS_PAYMENT_METHOD_LABEL?>",
                DOPBSP_RESERVATIONS_PAYMENT_METHOD_ARRIVAL = "<?php echo DOPBSP_RESERVATIONS_PAYMENT_METHOD_ARRIVAL?>",
                DOPBSP_RESERVATIONS_PAYMENT_METHOD_PAYPAL = "<?php echo DOPBSP_RESERVATIONS_PAYMENT_METHOD_PAYPAL?>",
                DOPBSP_RESERVATIONS_PAYMENT_METHOD_PAYPAL_TRANSACTION_ID_LABEL = "<?php echo DOPBSP_RESERVATIONS_PAYMENT_METHOD_PAYPAL_TRANSACTION_ID_LABEL?>",
                DOPBSP_RESERVATIONS_TOTAL_PRICE_LABEL = "<?php echo DOPBSP_RESERVATIONS_TOTAL_PRICE_LABEL?>",   
                DOPBSP_RESERVATIONS_NO_ITEMS_LABEL = "<?php echo DOPBSP_RESERVATIONS_NO_ITEMS_LABEL?>",
                DOPBSP_RESERVATIONS_PRICE_LABEL = "<?php echo DOPBSP_RESERVATIONS_PRICE_LABEL?>",
                DOPBSP_RESERVATIONS_EMAIL_LABEL = "<?php echo DOPBSP_RESERVATIONS_EMAIL_LABEL?>",
                DOPBSP_RESERVATIONS_PHONE_LABEL = "<?php echo DOPBSP_RESERVATIONS_PHONE_LABEL?>",
                DOPBSP_RESERVATIONS_NO_PEOPLE_LABEL = "<?php echo DOPBSP_RESERVATIONS_NO_PEOPLE_LABEL?>",
                DOPBSP_RESERVATIONS_NO_CHILDREN_LABEL = "<?php echo DOPBSP_RESERVATIONS_NO_CHILDREN_LABEL?>",
                DOPBSP_RESERVATIONS_MESSAGE_LABEL = "<?php echo DOPBSP_RESERVATIONS_MESSAGE_LABEL?>",

                DOPBSP_RESERVATIONS_JUMP_TO_DAY_LABEL = "<?php echo DOPBSP_RESERVATIONS_JUMP_TO_DAY_LABEL?>",
                DOPBSP_RESERVATIONS_APPROVE_LABEL = "<?php echo DOPBSP_RESERVATIONS_APPROVE_LABEL?>",
                DOPBSP_RESERVATIONS_REJECT_LABEL = "<?php echo DOPBSP_RESERVATIONS_REJECT_LABEL?>",
                DOPBSP_RESERVATIONS_CANCEL_LABEL = "<?php echo DOPBSP_RESERVATIONS_CANCEL_LABEL?>",

                DOPBSP_RESERVATIONS_APPROVE_CONFIRMATION = "<?php echo DOPBSP_RESERVATIONS_APPROVE_CONFIRMATION?>",
                DOPBSP_RESERVATIONS_APPROVE_SUCCESS = "<?php echo DOPBSP_RESERVATIONS_APPROVE_SUCCESS?>",
                DOPBSP_RESERVATIONS_REJECT_CONFIRMATION = "<?php echo DOPBSP_RESERVATIONS_REJECT_CONFIRMATION?>",
                DOPBSP_RESERVATIONS_REJECT_SUCCESS = "<?php echo DOPBSP_RESERVATIONS_REJECT_SUCCESS?>",
                DOPBSP_RESERVATIONS_CANCEL_CONFIRMATION = "<?php echo DOPBSP_RESERVATIONS_CANCEL_CONFIRMATION?>",
                DOPBSP_RESERVATIONS_CANCEL_SUCCESS = "<?php echo DOPBSP_RESERVATIONS_CANCEL_SUCCESS?>",

                // TinyMCE
                DOPBSP_TINYMCE_ADD = "<?php echo DOPBSP_TINYMCE_ADD?>",

                // Settings
                DOPBSP_GENERAL_STYLES_SETTINGS = "<?php echo DOPBSP_GENERAL_STYLES_SETTINGS?>",
                DOPBSP_CALENDAR_NAME = "<?php echo DOPBSP_CALENDAR_NAME?>",
                DOPBSP_AVAILABLE_DAYS = "<?php echo DOPBSP_AVAILABLE_DAYS?>",
                DOPBSP_FIRST_DAY = "<?php echo DOPBSP_FIRST_DAY?>",
                DOPBSP_CURRENCY = "<?php echo DOPBSP_CURRENCY?>",
                DOPBSP_DATE_TYPE = "<?php echo DOPBSP_DATE_TYPE?>",
                DOPBSP_PREDEFINED = "<?php echo DOPBSP_PREDEFINED?>",
                DOPBSP_TEMPLATE = "<?php echo DOPBSP_TEMPLATE?>",
                DOPBSP_MIN_STAY = "<?php echo DOPBSP_MIN_STAY?>",
                DOPBSP_MAX_STAY = "<?php echo DOPBSP_MAX_STAY?>",
                DOPBSP_NO_ITEMS_ENABLED = "<?php echo DOPBSP_NO_ITEMS_ENABLED?>",
                DOPBSP_VIEW_ONLY = "<?php echo DOPBSP_VIEW_ONLY?>",
                DOPBSP_PAGE_URL = "<?php echo DOPBSP_PAGE_URL?>",

                DOPBSP_NOTIFICATIONS_STYLES_SETTINGS = "<?php echo DOPBSP_NOTIFICATIONS_STYLES_SETTINGS?>",
                DOPBSP_NOTIFICATIONS_TEMPLATE = "<?php echo DOPBSP_NOTIFICATIONS_TEMPLATE?>",
                DOPBSP_NOTIFICATIONS_EMAIL = "<?php echo DOPBSP_NOTIFICATIONS_EMAIL?>",
                DOPBSP_NOTIFICATIONS_SMTP_ENABLED = "<?php echo DOPBSP_NOTIFICATIONS_SMTP_ENABLED?>",
                DOPBSP_NOTIFICATIONS_SMTP_HOST_NAME = "<?php echo DOPBSP_NOTIFICATIONS_SMTP_HOST_NAME?>",
                DOPBSP_NOTIFICATIONS_SMTP_HOST_PORT = "<?php echo DOPBSP_NOTIFICATIONS_SMTP_HOST_PORT?>",
                DOPBSP_NOTIFICATIONS_SMTP_SSL = "<?php echo DOPBSP_NOTIFICATIONS_SMTP_SSL?>",
                DOPBSP_NOTIFICATIONS_SMTP_USER = "<?php echo DOPBSP_NOTIFICATIONS_SMTP_USER?>",
                DOPBSP_NOTIFICATIONS_SMTP_PASSWORD = "<?php echo DOPBSP_NOTIFICATIONS_SMTP_PASSWORD?>",

                DOPBSP_DAYS_STYLES_SETTINGS = "<?php echo DOPBSP_DAYS_STYLES_SETTINGS?>",
                DOPBSP_MULTIPLE_DAYS_SELECT = "<?php echo DOPBSP_MULTIPLE_DAYS_SELECT?>",
                DOPBSP_MORNING_CHECK_OUT = "<?php echo DOPBSP_MORNING_CHECK_OUT?>",
                DOPBSP_DETAILS_FROM_HOURS = "<?php echo DOPBSP_DETAILS_FROM_HOURS?>",
                
                DOPBSP_HOURS_STYLES_SETTINGS = "<?php echo DOPBSP_HOURS_STYLES_SETTINGS?>",
                DOPBSP_HOURS_ENABLED = "<?php echo DOPBSP_HOURS_ENABLED?>",
                DOPBSP_HOURS_INFO_ENABLED = "<?php echo DOPBSP_HOURS_INFO_ENABLED?>",
                DOPBSP_HOURS_DEFINITIONS = "<?php echo DOPBSP_HOURS_DEFINITIONS?>",
                DOPBSP_MULTIPLE_HOURS_SELECT = "<?php echo DOPBSP_MULTIPLE_HOURS_SELECT?>",
                DOPBSP_HOURS_AMPM = "<?php echo DOPBSP_HOURS_AMPM?>",
                DOPBSP_LAST_HOUR_TO_TOTAL_PRICE = "<?php echo DOPBSP_LAST_HOUR_TO_TOTAL_PRICE?>",
                DOPBSP_HOURS_INTERVAL_ENABLED = "<?php echo DOPBSP_HOURS_INTERVAL_ENABLED?>",

                DOPBSP_DISCOUNTS_NO_DAYS_SETTINGS = "<?php echo DOPBSP_DISCOUNTS_NO_DAYS_SETTINGS?>",
                DOPBSP_DISCOUNTS_NO_DAYS = "<?php echo DOPBSP_DISCOUNTS_NO_DAYS?>",
                DOPBSP_DISCOUNTS_NO_DAYS_DAYS = "<?php echo DOPBSP_DISCOUNTS_NO_DAYS_DAYS?>",

                DOPBSP_DEPOSIT_SETTINGS = "<?php echo DOPBSP_DEPOSIT_SETTINGS?>",
                DOPBSP_DEPOSIT = "<?php echo DOPBSP_DEPOSIT?>",

                DOPBSP_FORM_STYLES_SETTINGS = "<?php echo DOPBSP_FORM_STYLES_SETTINGS?>",
                DOPBSP_FORM = "<?php echo DOPBSP_FORM?>",
                DOPBSP_INSTANT_BOOKING_ENABLED = "<?php echo DOPBSP_INSTANT_BOOKING_ENABLED?>",
                DOPBSP_NO_PEOPLE_ENABLED = "<?php echo DOPBSP_NO_PEOPLE_ENABLED?>",
                DOPBSP_MIN_NO_PEOPLE = "<?php echo DOPBSP_MIN_NO_PEOPLE?>",
                DOPBSP_MAX_NO_PEOPLE = "<?php echo DOPBSP_MAX_NO_PEOPLE?>",
                DOPBSP_NO_CHILDREN_ENABLED = "<?php echo DOPBSP_NO_CHILDREN_ENABLED?>",
                DOPBSP_MIN_NO_CHILDREN = "<?php echo DOPBSP_MIN_NO_CHILDREN?>",
                DOPBSP_MAX_NO_CHILDREN = "<?php echo DOPBSP_MAX_NO_CHILDREN?>",
                DOPBSP_PAYMENT_ARRIVAL_ENABLED = "<?php echo DOPBSP_PAYMENT_ARRIVAL_ENABLED?>",

                DOPBSP_PAYMENT_PAYPAL_STYLES_SETTINGS = "<?php echo DOPBSP_PAYMENT_PAYPAL_STYLES_SETTINGS?>",
                DOPBSP_PAYMENT_PAYPAL_ENABLED = "<?php echo DOPBSP_PAYMENT_PAYPAL_ENABLED?>",
                DOPBSP_PAYMENT_PAYPAL_USERNAME = "<?php echo DOPBSP_PAYMENT_PAYPAL_USERNAME?>",
                DOPBSP_PAYMENT_PAYPAL_PASSWORD = "<?php echo DOPBSP_PAYMENT_PAYPAL_PASSWORD?>",
                DOPBSP_PAYMENT_PAYPAL_SIGNATURE = "<?php echo DOPBSP_PAYMENT_PAYPAL_SIGNATURE?>",
                DOPBSP_PAYMENT_PAYPAL_CREDIT_CARD = "<?php echo DOPBSP_PAYMENT_PAYPAL_CREDIT_CARD?>",
                DOPBSP_PAYMENT_PAYPAL_SANDBOX_ENABLED = "<?php echo DOPBSP_PAYMENT_PAYPAL_SANDBOX_ENABLED?>",

                DOPBSP_TERMS_AND_CONDITIONS_ENABLED = "<?php echo DOPBSP_TERMS_AND_CONDITIONS_ENABLED?>",
                DOPBSP_TERMS_AND_CONDITIONS_LINK = "<?php echo DOPBSP_TERMS_AND_CONDITIONS_LINK?>",

                DOPBSP_GO_TOP = "<?php echo DOPBSP_GO_TOP?>",
                DOPBSP_SHOW = "<?php echo DOPBSP_SHOW?>",
                DOPBSP_HIDE = "<?php echo DOPBSP_HIDE?>",

                // Settings Info
                DOPBSP_CALENDAR_NAME_INFO = "<?php echo DOPBSP_CALENDAR_NAME_INFO?>",
                DOPBSP_AVAILABLE_DAYS_INFO = "<?php echo DOPBSP_AVAILABLE_DAYS_INFO?>",
                DOPBSP_FIRST_DAY_INFO = "<?php echo DOPBSP_FIRST_DAY_INFO?>",
                DOPBSP_CURRENCY_INFO = "<?php echo DOPBSP_CURRENCY_INFO?>",
                DOPBSP_DATE_TYPE_INFO = "<?php echo DOPBSP_DATE_TYPE_INFO?>",
                DOPBSP_PREDEFINED_INFO = "<?php echo DOPBSP_PREDEFINED_INFO?>",
                DOPBSP_TEMPLATE_INFO = "<?php echo DOPBSP_TEMPLATE_INFO?>",
                DOPBSP_MIN_STAY_INFO = "<?php echo DOPBSP_MIN_STAY_INFO?>",
                DOPBSP_MAX_STAY_INFO = "<?php echo DOPBSP_MAX_STAY_INFO?>",
                DOPBSP_NO_ITEMS_ENABLED_INFO = "<?php echo DOPBSP_NO_ITEMS_ENABLED_INFO?>",
                DOPBSP_VIEW_ONLY_INFO = "<?php echo DOPBSP_VIEW_ONLY_INFO?>",
                DOPBSP_PAGE_URL_INFO = "<?php echo DOPBSP_PAGE_URL_INFO?>",

                DOPBSP_NOTIFICATIONS_TEMPLATE_INFO = "<?php echo DOPBSP_NOTIFICATIONS_TEMPLATE_INFO?>",
                DOPBSP_NOTIFICATIONS_EMAIL_INFO = "<?php echo DOPBSP_NOTIFICATIONS_EMAIL_INFO?>",
                DOPBSP_NOTIFICATIONS_SMTP_ENABLED_INFO = "<?php echo DOPBSP_NOTIFICATIONS_SMTP_ENABLED_INFO?>",
                DOPBSP_NOTIFICATIONS_SMTP_HOST_NAME_INFO = "<?php echo DOPBSP_NOTIFICATIONS_SMTP_HOST_NAME_INFO?>",
                DOPBSP_NOTIFICATIONS_SMTP_HOST_PORT_INFO = "<?php echo DOPBSP_NOTIFICATIONS_SMTP_HOST_PORT_INFO?>",
                DOPBSP_NOTIFICATIONS_SMTP_SSL_INFO = "<?php echo DOPBSP_NOTIFICATIONS_SMTP_SSL_INFO?>",
                DOPBSP_NOTIFICATIONS_SMTP_USER_INFO = "<?php echo DOPBSP_NOTIFICATIONS_SMTP_USER_INFO?>",
                DOPBSP_NOTIFICATIONS_SMTP_PASSWORD_INFO = "<?php echo DOPBSP_NOTIFICATIONS_SMTP_PASSWORD_INFO?>",

                DOPBSP_MULTIPLE_DAYS_SELECT_INFO = "<?php echo DOPBSP_MULTIPLE_DAYS_SELECT_INFO?>",
                DOPBSP_MORNING_CHECK_OUT_INFO = "<?php echo DOPBSP_MORNING_CHECK_OUT_INFO?>",
                DOPBSP_DETAILS_FROM_HOURS_INFO = "<?php echo DOPBSP_DETAILS_FROM_HOURS_INFO?>",
                
                DOPBSP_HOURS_ENABLED_INFO = "<?php echo DOPBSP_HOURS_ENABLED_INFO?>",
                DOPBSP_HOURS_INFO_ENABLED_INFO = "<?php echo DOPBSP_HOURS_INFO_ENABLED_INFO?>",
                DOPBSP_HOURS_DEFINITIONS_INFO = "<?php echo DOPBSP_HOURS_DEFINITIONS_INFO?>",
                DOPBSP_MULTIPLE_HOURS_SELECT_INFO = "<?php echo DOPBSP_MULTIPLE_HOURS_SELECT_INFO?>",
                DOPBSP_HOURS_AMPM_INFO = "<?php echo DOPBSP_HOURS_AMPM_INFO?>",
                DOPBSP_LAST_HOUR_TO_TOTAL_PRICE_INFO = "<?php echo DOPBSP_LAST_HOUR_TO_TOTAL_PRICE_INFO?>",
                DOPBSP_HOURS_INTERVAL_ENABLED_INFO = "<?php echo DOPBSP_HOURS_INTERVAL_ENABLED_INFO?>",

                DOPBSP_DISCOUNTS_NO_DAYS_INFO = "<?php echo DOPBSP_DISCOUNTS_NO_DAYS_INFO?>",
                DOPBSP_DISCOUNTS_NO_DAYS_DAYS_INFO = "<?php echo DOPBSP_DISCOUNTS_NO_DAYS_DAYS_INFO?>",

                DOPBSP_DEPOSIT_INFO = "<?php echo DOPBSP_DEPOSIT_INFO?>",

                DOPBSP_FORM_INFO = "<?php echo DOPBSP_FORM_INFO?>",
                DOPBSP_INSTANT_BOOKING_ENABLED_INFO = "<?php echo DOPBSP_INSTANT_BOOKING_ENABLED_INFO?>",
                DOPBSP_NO_PEOPLE_ENABLED_INFO = "<?php echo DOPBSP_NO_PEOPLE_ENABLED_INFO?>",
                DOPBSP_MIN_NO_PEOPLE_INFO = "<?php echo DOPBSP_MIN_NO_PEOPLE_INFO?>",
                DOPBSP_MAX_NO_PEOPLE_INFO = "<?php echo DOPBSP_MAX_NO_PEOPLE_INFO?>",
                DOPBSP_NO_CHILDREN_ENABLED_INFO = "<?php echo DOPBSP_NO_CHILDREN_ENABLED_INFO?>",
                DOPBSP_MIN_NO_CHILDREN_INFO = "<?php echo DOPBSP_MIN_NO_CHILDREN_INFO?>",
                DOPBSP_MAX_NO_CHILDREN_INFO = "<?php echo DOPBSP_MAX_NO_CHILDREN_INFO?>",
                DOPBSP_PAYMENT_ARRIVAL_ENABLED_INFO = "<?php echo DOPBSP_PAYMENT_ARRIVAL_ENABLED_INFO?>",

                DOPBSP_PAYMENT_PAYPAL_ENABLED_INFO = "<?php echo DOPBSP_PAYMENT_PAYPAL_ENABLED_INFO?>",   
                DOPBSP_PAYMENT_PAYPAL_USERNAME_INFO = "<?php echo DOPBSP_PAYMENT_PAYPAL_USERNAME_INFO?>",
                DOPBSP_PAYMENT_PAYPAL_PASSWORD_INFO = "<?php echo DOPBSP_PAYMENT_PAYPAL_PASSWORD_INFO?>",  
                DOPBSP_PAYMENT_PAYPAL_SIGNATURE_INFO = "<?php echo DOPBSP_PAYMENT_PAYPAL_SIGNATURE_INFO?>",
                DOPBSP_PAYMENT_PAYPAL_CREDIT_CARD_INFO = "<?php echo DOPBSP_PAYMENT_PAYPAL_CREDIT_CARD_INFO?>",
                DOPBSP_PAYMENT_PAYPAL_SANDBOX_ENABLED_INFO = "<?php echo DOPBSP_PAYMENT_PAYPAL_SANDBOX_ENABLED_INFO?>",

                DOPBSP_TERMS_AND_CONDITIONS_ENABLED_INFO = "<?php echo DOPBSP_TERMS_AND_CONDITIONS_ENABLED_INFO?>",
                DOPBSP_TERMS_AND_CONDITIONS_LINK_INFO = "<?php echo DOPBSP_TERMS_AND_CONDITIONS_LINK_INFO?>",
    
                // Booking Forms
                DOPBSP_TITLE_BOOKING_FORMS = "<?php echo DOPBSP_TITLE_BOOKING_FORMS?>",
                DOPBSP_BOOKING_FORMS_HELP = "<?php echo DOPBSP_BOOKING_FORMS_HELP?>",
                DOPBSP_BOOKING_FORMS_LOADED = "<?php echo DOPBSP_BOOKING_FORMS_LOADED?>",
                DOPBSP_BOOKING_FORM_SETTINGS_HELP = "<?php echo DOPBSP_BOOKING_FORM_SETTINGS_HELP?>",
                DOPBSP_BOOKING_FORM_LOADED = "<?php echo DOPBSP_BOOKING_FORM_LOADED?>",
                DOPBSP_NO_BOOKING_FORMS = "<?php echo DOPBSP_NO_BOOKING_FORMS?>",

                // Add Booking Form
                DOPBSP_ADD_BOOKING_FORM_NAME = "<?php echo DOPBSP_ADD_BOOKING_FORM_NAME?>",
                DOPBSP_ADD_BOOKING_FORM_SUBMIT = "<?php echo DOPBSP_ADD_BOOKING_FORM_SUBMIT?>",
                DOPBSP_ADD_BOOKING_FORM_SUBMITED = "<?php echo DOPBSP_ADD_BOOKING_FORM_SUBMITED?>",
                DOPBSP_ADD_BOOKING_FORM_SUCCESS = "<?php echo DOPBSP_ADD_BOOKING_FORM_SUCCESS?>",

                // Edit Booking Form
                DOPBSP_EDIT_BOOKING_FORM_SUBMIT = "<?php echo DOPBSP_EDIT_BOOKING_FORM_SUBMIT?>",
                DOPBSP_EDIT_BOOKING_FORM_SUCCESS = "<?php echo DOPBSP_EDIT_BOOKING_FORM_SUCCESS?>",

                // Delete Booking Form
                DOPBSP_DELETE_BOOKING_FORM_CONFIRMATION = "<?php echo DOPBSP_DELETE_BOOKING_FORM_CONFIRMATION?>",
                DOPBSP_DELETE_BOOKING_FORM_SUBMIT = "<?php echo DOPBSP_DELETE_BOOKING_FORM_SUBMIT?>",
                DOPBSP_DELETE_BOOKING_FORM_SUBMITED = "<?php echo DOPBSP_DELETE_BOOKING_FORM_SUBMITED?>",
                DOPBSP_DELETE_BOOKING_FORM_SUCCESS = "<?php echo DOPBSP_DELETE_BOOKING_FORM_SUCCESS?>",

                // Booking Form Fields
                DOPBSP_BOOKING_FORM_NAME = "<?php echo DOPBSP_BOOKING_FORM_NAME?>",
                DOPBSP_BOOKING_FORM_NAME_DEFAULT = "<?php echo DOPBSP_BOOKING_FORM_NAME_DEFAULT?>",
                DOPBSP_BOOKING_FORM_FIELDS_TITLE = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_TITLE?>",
                DOPBSP_BOOKING_FORM_FIELDS_SHOW_SETTINGS = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_SHOW_SETTINGS?>",
                DOPBSP_BOOKING_FORM_FIELDS_HIDE_SETTINGS = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_HIDE_SETTINGS?>",
                DOPBSP_BOOKING_FORM_FIELDS_TYPE_TEXT_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_TYPE_TEXT_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_TYPE_TEXTAREA_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_TYPE_TEXTAREA_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_TYPE_CHECKBOX_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_TYPE_CHECKBOX_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_TYPE_SELECT_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_TYPE_SELECT_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_LANGUAGE_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_LANGUAGE_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_NAME_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_NAME_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_TEXT_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_TEXT_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_TEXTAREA_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_TEXTAREA_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_CHECKBOX_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_CHECKBOX_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_SELECT_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_SELECT_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_ALLOWED_CHARACTERS_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_ALLOWED_CHARACTERS_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_SIZE_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_SIZE_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_EMAIL_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_EMAIL_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_REQUIRED_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_REQUIRED_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_SELECT_OPTIONS_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_SELECT_OPTIONS_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_SELECT_ADD_OPTION = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_SELECT_ADD_OPTION?>",
                DOPBSP_BOOKING_FORM_FIELDS_SELECT_NEW_OPTION_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_SELECT_NEW_OPTION_LABEL?>",
                DOPBSP_BOOKING_FORM_FIELDS_SELECT_DELETE_OPTION = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_SELECT_DELETE_OPTION?>",
                DOPBSP_BOOKING_FORM_FIELDS_SELECT_MULTIPLE_SELECT_LABEL = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_SELECT_MULTIPLE_SELECT_LABEL?>",

                // Booking Form Fields Info
                DOPBSP_BOOKING_FORM_NAME_INFO = "<?php echo DOPBSP_BOOKING_FORM_NAME_INFO?>",
                DOPBSP_BOOKING_FORM_FIELDS_LANGUAGE_INFO = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_LANGUAGE_INFO?>",
                DOPBSP_BOOKING_FORM_FIELDS_NAME_INFO = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_NAME_INFO?>",
                DOPBSP_BOOKING_FORM_FIELDS_ALLOWED_CHARACTERS_INFO = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_ALLOWED_CHARACTERS_INFO?>",
                DOPBSP_BOOKING_FORM_FIELDS_SIZE_INFO = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_SIZE_INFO?>",
                DOPBSP_BOOKING_FORM_FIELDS_EMAIL_INFO = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_EMAIL_INFO?>",
                DOPBSP_BOOKING_FORM_FIELDS_REQUIRED_INFO = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_REQUIRED_INFO?>",
                DOPBSP_BOOKING_FORM_FIELDS_SELECT_OPTIONS_INFO = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_SELECT_OPTIONS_INFO?>",
                DOPBSP_BOOKING_FORM_FIELDS_SELECT_MULTIPLE_SELECT_INFO = "<?php echo DOPBSP_BOOKING_FORM_FIELDS_SELECT_MULTIPLE_SELECT_INFO?>",
    
                // Settings
                DOPBSP_TITLE_SETTINGS = "<?php echo DOPBSP_TITLE_SETTINGS?>",

                DOPBSP_USERS_PERMISSIONS = "<?php echo DOPBSP_USERS_PERMISSIONS?>",
                DOPBSP_USERS_CUSTOM_POSTS_TYPE_PERMISSIONS = "<?php echo DOPBSP_USERS_CUSTOM_POSTS_TYPE_PERMISSIONS?>",
                DOPBSP_USERS_SHOW = "<?php echo DOPBSP_USERS_SHOW?>",
                DOPBSP_USERS_HIDE = "<?php echo DOPBSP_USERS_HIDE?>",
                DOPBSP_USERS_NO_ADMINISTRATORS = "<?php echo DOPBSP_USERS_NO_ADMINISTRATORS?>",
                DOPBSP_USERS_NO_AUTHORS = "<?php echo DOPBSP_USERS_NO_AUTHORS?>",
                DOPBSP_USERS_NO_CONTRIBUTORS = "<?php echo DOPBSP_USERS_NO_CONTRIBUTORS?>",
                DOPBSP_USERS_NO_EDITORS = "<?php echo DOPBSP_USERS_NO_EDITORS?>",
                DOPBSP_USERS_NO_SUBSCRIBERS = "<?php echo DOPBSP_USERS_NO_SUBSCRIBERS?>",
                DOPBSP_USERS_ADMINISTRATORS = "<?php echo DOPBSP_USERS_ADMINISTRATORS?>",
                DOPSBP_USERS_ADMINISTRATORS_BULK_PERMISSIONS_INFO = "<?php echo DOPSBP_USERS_ADMINISTRATORS_BULK_PERMISSIONS_INFO?>",
                DOPSBP_USERS_ADMINISTRATORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO = "<?php echo DOPSBP_USERS_ADMINISTRATORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?>",
                DOPBSP_USERS_AUTHORS = "<?php echo DOPBSP_USERS_AUTHORS?>",
                DOPSBP_USERS_AUTHORS_BULK_PERMISSIONS_INFO = "<?php echo DOPSBP_USERS_AUTHORS_BULK_PERMISSIONS_INFO?>",
                DOPSBP_USERS_AUTHORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO = "<?php echo DOPSBP_USERS_AUTHORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?>",
                DOPBSP_USERS_CONTRIBUTORS = "<?php echo DOPBSP_USERS_CONTRIBUTORS?>",
                DOPBSP_USERS_CONTRIBUTORS_BULK_PERMISSIONS_INFO = "<?php echo DOPBSP_USERS_CONTRIBUTORS_BULK_PERMISSIONS_INFO?>",
                DOPBSP_USERS_CONTRIBUTORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO = "<?php echo DOPBSP_USERS_CONTRIBUTORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?>",
                DOPBSP_USERS_EDITORS = "<?php echo DOPBSP_USERS_EDITORS?>",
                DOPSBP_USERS_EDITORS_BULK_PERMISSIONS_INFO = "<?php echo DOPSBP_USERS_EDITORS_BULK_PERMISSIONS_INFO?>",
                DOPSBP_USERS_EDITORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO = "<?php echo DOPSBP_USERS_EDITORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?>",
                DOPBSP_USERS_SUBSCRIBERS = "<?php echo DOPBSP_USERS_SUBSCRIBERS?>",
                DOPBSP_USERS_SUBSCRIBERS_BULK_PERMISSIONS_INFO = "<?php echo DOPBSP_USERS_SUBSCRIBERS_BULK_PERMISSIONS_INFO?>",
                DOPBSP_USERS_SUBSCRIBERS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO = "<?php echo DOPBSP_USERS_SUBSCRIBERS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?>",
                DOPBSP_USERS_PERMISSIONS_HELP = "<?php echo DOPBSP_USERS_PERMISSIONS_HELP?>",
                DOPBSP_USERS_CUSTOM_POSTS_TYPE_PERMISSIONS_HELP = "<?php echo DOPBSP_USERS_CUSTOM_POSTS_TYPE_PERMISSIONS_HELP?>",
                
                // Custom Post Type
                DOPBSP_CUSTOM_POSTS_TYPE = "<?php echo DOPBSP_CUSTOM_POSTS_TYPE?>",
                DOPBSP_CUSTOM_POSTS_TYPE_ADD_NEW_ITEM_ALL_ITEMS = "<?php echo DOPBSP_CUSTOM_POSTS_TYPE_ADD_NEW_ITEM_ALL_ITEMS?>",
                DOPBSP_CUSTOM_POSTS_TYPE_ADD_NEW_ITEM = "<?php echo DOPBSP_CUSTOM_POSTS_TYPE_ADD_NEW_ITEM?>",
                DOPBSP_CUSTOM_POSTS_TYPE_EDIT_ITEM = "<?php echo DOPBSP_CUSTOM_POSTS_TYPE_EDIT_ITEM?>",
                DOPBSP_CUSTOM_POSTS_TYPE_BOOKING_SYSTEM = "<?php echo DOPBSP_CUSTOM_POSTS_TYPE_BOOKING_SYSTEM?>",
    
                // Widget
                DOPBSP_WIDGET_TITLE = "<?php echo DOPBSP_WIDGET_TITLE?>",
                DOPBSP_WIDGET_DESCRIPTION = "<?php echo DOPBSP_WIDGET_DESCRIPTION?>",
                DOPBSP_WIDGET_LABEL_TITLE = "<?php echo DOPBSP_WIDGET_LABEL_TITLE?>",
                DOPBSP_WIDGET_LABEL_SELECTION = "<?php echo DOPBSP_WIDGET_LABEL_SELECTION?>",
                DOPBSP_WIDGET_SELECTION_SIDEBAR = "<?php echo DOPBSP_WIDGET_SELECTION_SIDEBAR?>",
                DOPBSP_WIDGET_LABEL_ID = "<?php echo DOPBSP_WIDGET_LABEL_ID?>",
                DOPBSP_WIDGET_NO_CALENDARS = "<?php echo DOPBSP_WIDGET_NO_CALENDARS?>",

                // Help
                DOPBSP_HELP_DOCUMENTATION = "<?php echo DOPBSP_HELP_DOCUMENTATION?>",
                DOPBSP_HELP_FAQ = "<?php echo DOPBSP_HELP_FAQ?>";
            </script>
<?php  
            }
            
            function returnLanguages(){ // List languages select.
                $current_backend_language = get_option('DOPBSP_backend_language_'.wp_get_current_user()->ID);
                
                if ($current_backend_language == ''){
                    $current_backend_language = 'en';
                    add_option('DOPBSP_backend_language_'.wp_get_current_user()->ID, 'en');
                }
?>
                <select id="DOPBSP-admin-translation" onchange="dopbspChangeTranslation()">
                    <option value="af"<?php echo $current_backend_language == 'af' ? ' selected="selected"':''?>>Afrikaans (Afrikaans)</option>
                    <option value="al"<?php echo $current_backend_language == 'al' ? ' selected="selected"':''?>>Albanian (Shqiptar)</option>
                    <option value="ar"<?php echo $current_backend_language == 'ar' ? ' selected="selected"':''?>>Arabic (>العربية)</option>
                    <option value="az"<?php echo $current_backend_language == 'az' ? ' selected="selected"':''?>>Azerbaijani (Azərbaycan)</option>
                    <option value="bs"<?php echo $current_backend_language == 'bs' ? ' selected="selected"':''?>>Basque (Euskal)</option>
                    <option value="by"<?php echo $current_backend_language == 'by' ? ' selected="selected"':''?>>Belarusian (Беларускай)</option>
                    <option value="bg"<?php echo $current_backend_language == 'bg' ? ' selected="selected"':''?>>Bulgarian (Български)</option>
                    <option value="ca"<?php echo $current_backend_language == 'ca' ? ' selected="selected"':''?>>Catalan (Català)</option>
                    <option value="cn"<?php echo $current_backend_language == 'cn' ? ' selected="selected"':''?>>Chinese (中国的)</option>
                    <option value="cr"<?php echo $current_backend_language == 'cr' ? ' selected="selected"':''?>>Croatian (Hrvatski)</option>
                    <option value="cz"<?php echo $current_backend_language == 'cz' ? ' selected="selected"':''?>>Czech (Český)</option>
                    <option value="dk"<?php echo $current_backend_language == 'dk' ? ' selected="selected"':''?>>Danish (Dansk)</option>
                    <option value="du"<?php echo $current_backend_language == 'du' ? ' selected="selected"':''?>>Dutch (Nederlands)</option>
                    <option value="en"<?php echo $current_backend_language == 'en' ? ' selected="selected"':''?>>English</option>
                    <option value="eo"<?php echo $current_backend_language == 'eo' ? ' selected="selected"':''?>>Esperanto (Esperanto)</option>
                    <option value="et"<?php echo $current_backend_language == 'et' ? ' selected="selected"':''?>>Estonian (Eesti)</option>
                    <option value="fl"<?php echo $current_backend_language == 'fl' ? ' selected="selected"':''?>>Filipino (na Filipino)</option>
                    <option value="fi"<?php echo $current_backend_language == 'fi' ? ' selected="selected"':''?>>Finnish (Suomi)</option>
                    <option value="fr"<?php echo $current_backend_language == 'fr' ? ' selected="selected"':''?>>French (Français)</option>
                    <option value="gl"<?php echo $current_backend_language == 'gl' ? ' selected="selected"':''?>>Galician (Galego)</option>
                    <option value="de"<?php echo $current_backend_language == 'de' ? ' selected="selected"':''?>>German (Deutsch)</option>
                    <option value="gr"<?php echo $current_backend_language == 'gr' ? ' selected="selected"':''?>>Greek (Ɛλληνικά)</option>
                    <option value="ha"<?php echo $current_backend_language == 'ha' ? ' selected="selected"':''?>>Haitian Creole (Kreyòl Ayisyen)</option>
                    <option value="he"<?php echo $current_backend_language == 'he' ? ' selected="selected"':''?>>Hebrew (עברית)</option>
                    <option value="hi"<?php echo $current_backend_language == 'hi' ? ' selected="selected"':''?>>Hindi (हिंदी)</option>
                    <option value="hu"<?php echo $current_backend_language == 'hu' ? ' selected="selected"':''?>>Hungarian (Magyar)</option>
                    <option value="is"<?php echo $current_backend_language == 'is' ? ' selected="selected"':''?>>Icelandic (Íslenska)</option>
                    <option value="id"<?php echo $current_backend_language == 'id' ? ' selected="selected"':''?>>Indonesian (Indonesia)</option>
                    <option value="ir"<?php echo $current_backend_language == 'ir' ? ' selected="selected"':''?>>Irish (Gaeilge)</option>
                    <option value="it"<?php echo $current_backend_language == 'it' ? ' selected="selected"':''?>>Italian (Italiano)</option>
                    <option value="ja"<?php echo $current_backend_language == 'ja' ? ' selected="selected"':''?>>Japanese (日本の)</option>
                    <option value="ko"<?php echo $current_backend_language == 'ko' ? ' selected="selected"':''?>>Korean (한국의)</option>            
                    <option value="lv"<?php echo $current_backend_language == 'lv' ? ' selected="selected"':''?>>Latvian (Latvijas)</option>
                    <option value="lt"<?php echo $current_backend_language == 'lt' ? ' selected="selected"':''?>>Lithuanian (Lietuvos)</option>            
                    <option value="mk"<?php echo $current_backend_language == 'mk' ? ' selected="selected"':''?>>Macedonian (македонски)</option>
                    <option value="mg"<?php echo $current_backend_language == 'mg' ? ' selected="selected"':''?>>Malay (Melayu)</option>
                    <option value="ma"<?php echo $current_backend_language == 'ma' ? ' selected="selected"':''?>>Maltese (Maltija)</option>
                    <option value="no"<?php echo $current_backend_language == 'no' ? ' selected="selected"':''?>>Norwegian (Norske)</option>            
                    <option value="pe"<?php echo $current_backend_language == 'pe' ? ' selected="selected"':''?>>Persian (فارسی)</option>
                    <option value="pl"<?php echo $current_backend_language == 'pl' ? ' selected="selected"':''?>>Polish (Polski)</option>
                    <option value="pt"<?php echo $current_backend_language == 'pt' ? ' selected="selected"':''?>>Portuguese (Português)</option>
                    <option value="ro"<?php echo $current_backend_language == 'ro' ? ' selected="selected"':''?>>Romanian (Română)</option>
                    <option value="ru"<?php echo $current_backend_language == 'ru' ? ' selected="selected"':''?>>Russian (Pусский)</option>
                    <option value="sr"<?php echo $current_backend_language == 'sr' ? ' selected="selected"':''?>>Serbian (Cрпски)</option>
                    <option value="sk"<?php echo $current_backend_language == 'sk' ? ' selected="selected"':''?>>Slovak (Slovenských)</option>
                    <option value="sl"<?php echo $current_backend_language == 'sl' ? ' selected="selected"':''?>>Slovenian (Slovenski)</option>
                    <option value="sp"<?php echo $current_backend_language == 'sp' ? ' selected="selected"':''?>>Spanish (Español)</option>
                    <option value="sw"<?php echo $current_backend_language == 'sw' ? ' selected="selected"':''?>>Swahili (Kiswahili)</option>
                    <option value="se"<?php echo $current_backend_language == 'se' ? ' selected="selected"':''?>>Swedish (Svenskt)</option>
                    <option value="th"<?php echo $current_backend_language == 'th' ? ' selected="selected"':''?>>Thai (ภาษาไทย)</option>
                    <option value="tr"<?php echo $current_backend_language == 'tr' ? ' selected="selected"':''?>>Turkish (Türk)</option>
                    <option value="uk"<?php echo $current_backend_language == 'uk' ? ' selected="selected"':''?>>Ukrainian (Український)</option>
                    <option value="ur"<?php echo $current_backend_language == 'ur' ? ' selected="selected"':''?>>Urdu (اردو)</option>
                    <option value="vi"<?php echo $current_backend_language == 'vi' ? ' selected="selected"':''?>>Vietnamese (Việt)</option>
                    <option value="we"<?php echo $current_backend_language == 'we' ? ' selected="selected"':''?>>Welsh (Cymraeg)</option>
                    <option value="yi"<?php echo $current_backend_language == 'yi' ? ' selected="selected"':''?>>Yiddish (ייִדיש)</option>
                </select>                    
<?php  
            }
            
            function returnBookingFormLanguages(){ // List languages select.
                $current_backend_language = get_option('DOPBSP_backend_language_'.wp_get_current_user()->ID);
                
                if ($current_backend_language == ''){
                    $current_backend_language = 'en';
                }
?>
                <select id="DOPBSP-admin-form-field-language-<?=$field_id?>" onchange="dopbspTranslationBookingFormField(this.value)">
                    <option value="af"<?php echo $current_backend_language == 'af' ? ' selected="selected"':''?>>Afrikaans (Afrikaans)</option>
                    <option value="al"<?php echo $current_backend_language == 'al' ? ' selected="selected"':''?>>Albanian (Shqiptar)</option>
                    <option value="ar"<?php echo $current_backend_language == 'ar' ? ' selected="selected"':''?>>Arabic (>العربية)</option>
                    <option value="az"<?php echo $current_backend_language == 'az' ? ' selected="selected"':''?>>Azerbaijani (Azərbaycan)</option>
                    <option value="bs"<?php echo $current_backend_language == 'bs' ? ' selected="selected"':''?>>Basque (Euskal)</option>
                    <option value="by"<?php echo $current_backend_language == 'by' ? ' selected="selected"':''?>>Belarusian (Беларускай)</option>
                    <option value="bg"<?php echo $current_backend_language == 'bg' ? ' selected="selected"':''?>>Bulgarian (Български)</option>
                    <option value="ca"<?php echo $current_backend_language == 'ca' ? ' selected="selected"':''?>>Catalan (Català)</option>
                    <option value="cn"<?php echo $current_backend_language == 'cn' ? ' selected="selected"':''?>>Chinese (中国的)</option>
                    <option value="cr"<?php echo $current_backend_language == 'cr' ? ' selected="selected"':''?>>Croatian (Hrvatski)</option>
                    <option value="cz"<?php echo $current_backend_language == 'cz' ? ' selected="selected"':''?>>Czech (Český)</option>
                    <option value="dk"<?php echo $current_backend_language == 'dk' ? ' selected="selected"':''?>>Danish (Dansk)</option>
                    <option value="du"<?php echo $current_backend_language == 'du' ? ' selected="selected"':''?>>Dutch (Nederlands)</option>
                    <option value="en"<?php echo $current_backend_language == 'en' ? ' selected="selected"':''?>>English</option>
                    <option value="eo"<?php echo $current_backend_language == 'eo' ? ' selected="selected"':''?>>Esperanto (Esperanto)</option>
                    <option value="et"<?php echo $current_backend_language == 'et' ? ' selected="selected"':''?>>Estonian (Eesti)</option>
                    <option value="fl"<?php echo $current_backend_language == 'fl' ? ' selected="selected"':''?>>Filipino (na Filipino)</option>
                    <option value="fi"<?php echo $current_backend_language == 'fi' ? ' selected="selected"':''?>>Finnish (Suomi)</option>
                    <option value="fr"<?php echo $current_backend_language == 'fr' ? ' selected="selected"':''?>>French (Français)</option>
                    <option value="gl"<?php echo $current_backend_language == 'gl' ? ' selected="selected"':''?>>Galician (Galego)</option>
                    <option value="de"<?php echo $current_backend_language == 'de' ? ' selected="selected"':''?>>German (Deutsch)</option>
                    <option value="gr"<?php echo $current_backend_language == 'gr' ? ' selected="selected"':''?>>Greek (Ɛλληνικά)</option>
                    <option value="ha"<?php echo $current_backend_language == 'ha' ? ' selected="selected"':''?>>Haitian Creole (Kreyòl Ayisyen)</option>
                    <option value="he"<?php echo $current_backend_language == 'he' ? ' selected="selected"':''?>>Hebrew (עברית)</option>
                    <option value="hi"<?php echo $current_backend_language == 'hi' ? ' selected="selected"':''?>>Hindi (हिंदी)</option>
                    <option value="hu"<?php echo $current_backend_language == 'hu' ? ' selected="selected"':''?>>Hungarian (Magyar)</option>
                    <option value="is"<?php echo $current_backend_language == 'is' ? ' selected="selected"':''?>>Icelandic (Íslenska)</option>
                    <option value="id"<?php echo $current_backend_language == 'id' ? ' selected="selected"':''?>>Indonesian (Indonesia)</option>
                    <option value="ir"<?php echo $current_backend_language == 'ir' ? ' selected="selected"':''?>>Irish (Gaeilge)</option>
                    <option value="it"<?php echo $current_backend_language == 'it' ? ' selected="selected"':''?>>Italian (Italiano)</option>
                    <option value="ja"<?php echo $current_backend_language == 'ja' ? ' selected="selected"':''?>>Japanese (日本の)</option>
                    <option value="ko"<?php echo $current_backend_language == 'ko' ? ' selected="selected"':''?>>Korean (한국의)</option>            
                    <option value="lv"<?php echo $current_backend_language == 'lv' ? ' selected="selected"':''?>>Latvian (Latvijas)</option>
                    <option value="lt"<?php echo $current_backend_language == 'lt' ? ' selected="selected"':''?>>Lithuanian (Lietuvos)</option>            
                    <option value="mk"<?php echo $current_backend_language == 'mk' ? ' selected="selected"':''?>>Macedonian (македонски)</option>
                    <option value="mg"<?php echo $current_backend_language == 'mg' ? ' selected="selected"':''?>>Malay (Melayu)</option>
                    <option value="ma"<?php echo $current_backend_language == 'ma' ? ' selected="selected"':''?>>Maltese (Maltija)</option>
                    <option value="no"<?php echo $current_backend_language == 'no' ? ' selected="selected"':''?>>Norwegian (Norske)</option>            
                    <option value="pe"<?php echo $current_backend_language == 'pe' ? ' selected="selected"':''?>>Persian (فارسی)</option>
                    <option value="pl"<?php echo $current_backend_language == 'pl' ? ' selected="selected"':''?>>Polish (Polski)</option>
                    <option value="pt"<?php echo $current_backend_language == 'pt' ? ' selected="selected"':''?>>Portuguese (Português)</option>
                    <option value="ro"<?php echo $current_backend_language == 'ro' ? ' selected="selected"':''?>>Romanian (Română)</option>
                    <option value="ru"<?php echo $current_backend_language == 'ru' ? ' selected="selected"':''?>>Russian (Pусский)</option>
                    <option value="sr"<?php echo $current_backend_language == 'sr' ? ' selected="selected"':''?>>Serbian (Cрпски)</option>
                    <option value="sk"<?php echo $current_backend_language == 'sk' ? ' selected="selected"':''?>>Slovak (Slovenských)</option>
                    <option value="sl"<?php echo $current_backend_language == 'sl' ? ' selected="selected"':''?>>Slovenian (Slovenski)</option>
                    <option value="sp"<?php echo $current_backend_language == 'sp' ? ' selected="selected"':''?>>Spanish (Español)</option>
                    <option value="sw"<?php echo $current_backend_language == 'sw' ? ' selected="selected"':''?>>Swahili (Kiswahili)</option>
                    <option value="se"<?php echo $current_backend_language == 'se' ? ' selected="selected"':''?>>Swedish (Svenskt)</option>
                    <option value="th"<?php echo $current_backend_language == 'th' ? ' selected="selected"':''?>>Thai (ภาษาไทย)</option>
                    <option value="tr"<?php echo $current_backend_language == 'tr' ? ' selected="selected"':''?>>Turkish (Türk)</option>
                    <option value="uk"<?php echo $current_backend_language == 'uk' ? ' selected="selected"':''?>>Ukrainian (Український)</option>
                    <option value="ur"<?php echo $current_backend_language == 'ur' ? ' selected="selected"':''?>>Urdu (اردو)</option>
                    <option value="vi"<?php echo $current_backend_language == 'vi' ? ' selected="selected"':''?>>Vietnamese (Việt)</option>
                    <option value="we"<?php echo $current_backend_language == 'we' ? ' selected="selected"':''?>>Welsh (Cymraeg)</option>
                    <option value="yi"<?php echo $current_backend_language == 'yi' ? ' selected="selected"':''?>>Yiddish (ייִדיש)</option>
                </select>                    
<?php
            }

            function calendarsList(){// Return Template              
                if (class_exists("DOPBookingSystemPROBackEnd")){
                    $DOPBSP_pluginSeries = new DOPBookingSystemPROBackEnd();
                }
                $this->returnTranslations();
?>            
    <div class="wrap DOPBSP-admin">
<!-- Header -->
        <h2><?php echo DOPBSP_TITLE?></h2>
        <div id="DOPBSP-admin-message"></div>
        <?php $this->returnLanguages(); ?>
        <a href="http://envato-help.dotonpaper.net/booking-system-pro-wordpress-plugin.html#faq" target="_blank" class="DOPBSP-help"><?php echo DOPBSP_HELP_FAQ ?></a>
        <a href="http://envato-help.dotonpaper.net/booking-system-pro-wordpress-plugin.html" target="_blank" class="DOPBSP-help"><?php echo DOPBSP_HELP_DOCUMENTATION ?></a>
        <input type="hidden" id="calendar_id" value="" />
        <br class="DOPBSP-clear" />

<!-- Content -->        
        <div class="main">
            
            <div class="column column1">
                <div class="column-header">
                <?php if (!isset($_GET['post_type']) && !isset($_GET['action'])){ ?>
<?php 
                    if($DOPBSP_pluginSeries->userHasPermissions(wp_get_current_user()->ID)){ 
    ?>                  

                        <div class="add-button" id="DOPBSP-add-calendar-btn">
                            <a href="javascript:dopbspAddCalendar()" title="<?php echo DOPBSP_ADD_CALENDAR_SUBMIT?>"></a>
                        </div>

                        <a href="javascript:void()" class="header-help"><span><?php echo DOPBSP_CALENDARS_HELP?>"</span></a>
    <?php
                    }
                    else{
    ?>           
                        <a href="javascript:void()" class="header-help"><span><?php echo DOPBSP_CALENDARS_NO_ADD_HELP?>"</span></a>
    <?php
                    }
                }
?>                               
                </div>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="column-separator"></div>
            <div class="column column2">
                <div class="column-header"></div>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="column-separator"></div>
            <div class="column column3">
                <div class="column-header"></div>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
        <br class="DOPBSP-clear" />
    </div>
<?php
            }

            function settings(){// Settings Template
                $this->returnTranslations();
?>  
    <div class="wrap DOPBSP-admin">
<!-- Header -->        
        <h2><?php echo DOPBSP_TITLE.' - '.DOPBSP_TITLE_SETTINGS?></h2>
        <div id="DOPBSP-admin-message"></div>
        <?php $this->returnLanguages(); ?>
        <a href="http://envato-help.dotonpaper.net/booking-system-pro-wordpress-plugin.html#faq" target="_blank" class="DOPBSP-help"><?php echo DOPBSP_HELP_FAQ ?></a>
        <a href="http://envato-help.dotonpaper.net/booking-system-pro-wordpress-plugin.html" target="_blank" class="DOPBSP-help"><?php echo DOPBSP_HELP_DOCUMENTATION ?></a>
        <br class="DOPBSP-clear" />
        
<!-- Content -->        
        <div class="main">
            <form method="post" class="DOPBSP-form" action="" style="padding:0;"></form>
            <div class="column column1">
                <div class="column-content-container">
                    <div class="column-content">
                        <ul>
                            <li class="item item-selected" id="dopbsp-user-permissions" onclick="dopbspShowUsersPermissions();"><?php echo DOPBSP_USERS_PERMISSIONS?></li>
                            <li class="item" id="dopbsp-user-post-permissions" onclick="dopbspShowUsersCustomPostsPermissions();"><?php echo DOPBSP_USERS_CUSTOM_POSTS_TYPE_PERMISSIONS?></li>
                        </ul>                            
                    </div>
                </div>
            </div>
            <div class="column-separator"></div>
            <div class="column column2">
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="column column3">
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
        <br class="DOPBSP-clear" />
    </div>
<?php
            }
            
            function settingsUsersPermissions(){
                global $wpdb; 
?>
            
<!-- *************************************************************************** Administrators -->

<?php 
    $users_administrators = $wpdb->get_results('SELECT * FROM '.DOPBSP_Users_table.' WHERE type="administrator"');
    $users_admins = $wpdb->num_rows;
?>

                <a href="javascript:void(0)" id="dopbsp-administrators-show-hide" class="show-hide first"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_ADMINISTRATORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_administrators_permissions" id="dopbsp_administrators_permissions" onclick="dopbspEditGeneralUserPermissions('administrator');" <?php if (get_option('DOPBSP_administrators_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_administrators_permissions"><?=DOPSBP_USERS_ADMINISTRATORS_BULK_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-administrators-list">
<?php
    if($users_admins < 1){
        echo DOPBSP_USERS_NO_ADMINISTRATORS;
    }
    else{
        foreach ($users_administrators as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->user_id);
            $user_name = get_user_by( 'id', $user->user_id );
            
?>     
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->user_id?>" value="true" id="user<?php echo $user->user_id?>" class="DOPSBP-chk-all-admin DOPSBP-check-all" onclick="dopbspEditUserPermissions(<?php echo $user->user_id?>, '2', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view_all == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->user_id?>"><?php echo $user_name->user_login?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?>                        
                </div>

<!-- *************************************************************************** Authors -->                

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_authors = get_users('orderby=nicename&role=author');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-authors-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_AUTHORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_authors_permissions" id="dopbsp_authors_permissions" onclick="dopbspEditGeneralUserPermissions('author');" <?php if (get_option('DOPBSP_authors_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_authors_permissions"><?=DOPSBP_USERS_AUTHORS_BULK_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-authors-list">
<?php  
    if(!$users_authors){
        echo DOPBSP_USERS_NO_AUTHORS;
    }
    else{                  
        foreach ($users_authors as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
        
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-author DOPSBP-check-all" onclick="dopbspEditUserPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
                    
<!-- *************************************************************************** Contributors -->

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_contributors = get_users('orderby=nicename&role=contributor');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-contributors-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_CONTRIBUTORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_contributors_permissions" id="dopbsp_contributors_permissions" onclick="dopbspEditGeneralUserPermissions('contributor');" <?php if (get_option('DOPBSP_contributors_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_contributors_permissions"><?=DOPBSP_USERS_CONTRIBUTORS_BULK_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-contributors-list">
<?php 
    if(!$users_contributors){
        echo DOPBSP_USERS_NO_CONTRIBUTORS;
    } 
    else {
        foreach ($users_contributors as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
        
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-contributor DOPSBP-check-all" onclick="dopbspEditUserPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
         
<!-- *************************************************************************** Editors -->

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_editors = get_users('orderby=nicename&role=editor');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-editors-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_EDITORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_editors_permissions" id="dopbsp_editors_permissions" onclick="dopbspEditGeneralUserPermissions('editor');" <?php if (get_option('DOPBSP_editors_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_editors_permissions"><?=DOPSBP_USERS_EDITORS_BULK_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-editors-list">
<?php  
    if(!$users_editors){
        echo DOPBSP_USERS_NO_EDITORS;
    }
    else{ 
        foreach ($users_editors as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);        
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-editor DOPSBP-check-all" onclick="dopbspEditUserPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
         
<!-- *************************************************************************** Subscribers -->

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_subscribers = get_users('orderby=nicename&role=subscriber');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-subscribers-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_SUBSCRIBERS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_subscribers_permissions" id="dopbsp_subscribers_permissions" onclick="dopbspEditGeneralUserPermissions('subscriber');" <?php if (get_option('DOPBSP_subscribers_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_subscribers_permissions"><?=DOPBSP_USERS_SUBSCRIBERS_BULK_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-subscribers-list">
<?php
    if(!$users_subscribers){
        echo DOPBSP_USERS_NO_SUBSCRIBERS;
    }
    else{
        foreach ($users_subscribers as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-subscriber DOPSBP-check-all" onclick="dopbspEditUserPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
<?php            
            }
            
            function settingsUsersCustomPostsPermissions(){
                global $wpdb; 
?>
            
<!-- *************************************************************************** Administrators -->

<?php 
    $users_administrators = $wpdb->get_results('SELECT * FROM '.DOPBSP_Users_table.' WHERE type="administrator"');
    $users_admins = $wpdb->num_rows;
?>
                <a href="javascript:void(0)" id="dopbsp-administrators-show-hide" class="show-hide first"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_ADMINISTRATORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_administrators_permissions" id="dopbsp_administrators_permissions" onclick="dopbspEditGeneralUserCustomPostsPermissions('administrator');" <?php if (get_option('DOPBSP_administrators_custom_posts_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_administrators_permissions"><?=DOPSBP_USERS_ADMINISTRATORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-administrators-list">
<?php
    if($users_admins < 1){
        echo DOPBSP_USERS_NO_ADMINISTRATORS; echo $wpdb->num_rows;
    }
    else{
        foreach ($users_administrators as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->user_id);
            $user_name = get_user_by( 'id', $user->user_id );
            
?>     
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->user_id?>" value="true" id="user<?php echo $user->user_id?>" class="DOPSBP-chk-all-admin DOPSBP-check-all" onclick="dopbspEditUserCustomPostsPermissions(<?php echo $user->user_id?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view_custom_posts == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->user_id?>"><?php echo $user_name->user_login?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?>                        
                </div>

<!-- *************************************************************************** Authors -->                

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_authors = get_users('orderby=nicename&role=author');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-authors-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_AUTHORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_authors_permissions" id="dopbsp_authors_permissions" onclick="dopbspEditGeneralUserCustomPostsPermissions('author');" <?php if (get_option('DOPBSP_authors_custom_posts_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_authors_permissions"><?=DOPSBP_USERS_AUTHORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-authors-list">
<?php  
    if(!$users_authors){
        echo DOPBSP_USERS_NO_AUTHORS;
    }
    else{                  
        foreach ($users_authors as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
        
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-author DOPSBP-check-all" onclick="dopbspEditUserCustomPostsPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view_custom_posts == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
                    
<!-- *************************************************************************** Contributors -->

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_contributors = get_users('orderby=nicename&role=contributor');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-contributors-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_CONTRIBUTORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_contributors_permissions" id="dopbsp_contributors_permissions" onclick="dopbspEditGeneralUserCustomPostsPermissions('contributor');" <?php if (get_option('DOPBSP_contributors_custom_posts_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_contributors_permissions"><?=DOPBSP_USERS_CONTRIBUTORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-contributors-list">
<?php  
    if(!$users_contributors){
        echo DOPBSP_USERS_NO_CONTRIBUTORS;
    } 
    else {
        foreach ($users_contributors as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
        
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-contributor DOPSBP-check-all" onclick="dopbspEditUserCustomPostsPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view_custom_posts == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
         
<!-- *************************************************************************** Editors -->

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_editors = get_users('orderby=nicename&role=editor');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-editors-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_EDITORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_editors_permissions" id="dopbsp_editors_permissions" onclick="dopbspEditGeneralUserCustomPostsPermissions('editor');" <?php if (get_option('DOPBSP_editors_custom_posts_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_editors_permissions"><?=DOPSBP_USERS_EDITORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-editors-list">
<?php  
    if(!$users_editors){
        echo DOPBSP_USERS_NO_EDITORS;
    }
    else{ 
        foreach ($users_editors as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);        
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-editor DOPSBP-check-all" onclick="dopbspEditUserCustomPostsPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view_custom_posts == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
         
<!-- *************************************************************************** Subscribers -->

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_subscribers = get_users('orderby=nicename&role=subscriber');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-subscribers-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_SUBSCRIBERS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_subscribers_permissions" id="dopbsp_subscribers_permissions" onclick="dopbspEditGeneralUserCustomPostsPermissions('subscriber');" <?php if (get_option('DOPBSP_subscribers_custom_posts_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_subscribers_permissions"><?=DOPBSP_USERS_SUBSCRIBERS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-subscribers-list">
<?php
    if(!$users_subscribers){
        echo DOPBSP_USERS_NO_SUBSCRIBERS;
    }
    else{
        foreach ($users_subscribers as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-subscriber DOPSBP-check-all" onclick="dopbspEditUserCustomPostsPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view_custom_posts == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
<?php            
            }
            
            function bookingForms(){// Return Template              
                if (class_exists("DOPBookingSystemPROBackEnd")){
                    $DOPBSP_pluginSeries = new DOPBookingSystemPROBackEnd();
                }
                $this->returnTranslations();
?>            
    <div class="wrap DOPBSP-admin">
        <h2><?php echo DOPBSP_TITLE_BOOKING_FORMS?></h2>
        <div id="DOPBSP-admin-message"></div>
        <?php $this->returnLanguages(); ?>
        <a href="http://envato-help.dotonpaper.net/booking-system-pro-wordpress-plugin.html#faq" target="_blank" class="DOPBSP-help"><?php echo DOPBSP_HELP_FAQ ?></a>
        <a href="http://envato-help.dotonpaper.net/booking-system-pro-wordpress-plugin.html" target="_blank" class="DOPBSP-help"><?php echo DOPBSP_HELP_DOCUMENTATION ?></a>
        <input type="hidden" id="booking_form_id" value="" />
        <br class="DOPBSP-clear" />
        <div class="main">
            <div class="column column1">
                <?php if($DOPBSP_pluginSeries->userHasPermissions(wp_get_current_user()->ID)) { ?>
                <div class="column-header">
                    <div class="add-button" id="DOPBSP-add-booking-form-btn">
                        <a href="javascript:dopbspAddBookingForm()" title="<?php echo DOPBSP_ADD_BOOKING_FORM_SUBMIT ?>"></a>
                    </div>
                    <a href="javascript:void()" class="header-help"><span><?php echo DOPBSP_BOOKING_FORMS_HELP?>"</span></a>                    
                </div>
                <?php } ?>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="column-separator"></div>
            <div class="column column2">
                <div class="column-header"></div>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="column-separator"></div>
            <div class="column column3">
                <div class="column-header"></div>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
        <br class="DOPBSP-clear" />
    </div>
<?php
            }
        }
    }
?>