<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 1.7
* File                    : du.php
* File Version            : 1.5
* Created / Last Modified : 31 July 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Dutch Back End Translation.
* Translated by           : Dot on Paper
*/

    define('DOPBSP_TITLE', "Booking System PRO");

    // Loading ...
    define('DOPBSP_LOAD', "Load data ...");

    // Save ...
    define('DOPBSP_SAVE', "Save data ...");
    define('DOPBSP_SAVE_SUCCESS', "Data has been saved.");
    
    // Months & Week Days
    global $DOPBSP_month_names;
    $DOPBSP_month_names = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    
    global $DOPBSP_day_names;
    $DOPBSP_day_names = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    
    // Help
    define('DOPBSP_CALENDARS_HELP', "Click on the 'Plus' icon to add a calendar. Click on a calendar item to open the editing area.");
    define('DOPBSP_CALENDARS_NO_ADD_HELP', "Click on a calendar item to open the editing area.");
    define('DOPBSP_CALENDAR_EDIT_HELP', "Select the days and hours to edit them. Click on the 'pencil' icon to edit calendar settings. Click on the 'mail' icon to see if you have reservations. Read documentation for more information.");
    define('DOPBSP_CALENDAR_EDIT_ADMINISTRATOR_HELP', "Select the days and hours to edit them. Click on the 'pencil' icon to edit calendar settings. Click on the 'mail' icon to see if you have reservations. Click on the 'users' icon to allow acces to this calendar to other users. Read documentation for more information.");
    define('DOPBSP_CALENDAR_EDIT_SETTINGS_HELP', "Click 'Submit Button' to save changes. Click 'Delete Button' to delete the calendar. Click 'Back Button' to return to the calendar.");
    
    // Form
    define('DOPBSP_SUBMIT', "Submit");
    define('DOPBSP_DELETE', "Delete");
    define('DOPBSP_BACK', "Back");
    define('DOPBSP_BACK_SUBMIT', "Back to calendar.");
    define('DOPBSP_ENABLED', "Enabled");
    define('DOPBSP_DISABLED', "Disabled");
    define('DOPBSP_DATE_TYPE_AMERICAN', "American (mm dd, yyyy)");
    define('DOPBSP_DATE_TYPE_EUROPEAN', "European (dd mm yyyy)");

    // Calendars    
    define('DOPBSP_SHOW_CALENDARS', "Calendars");
    define('DOPBSP_CALENDARS_LOADED', "Calendars list loaded.");
    define('DOPBSP_CALENDAR_LOADED', "Calendar loaded.");
    define('DOPBSP_NO_CALENDARS', "No calendars.");    
    
    // Calendar 
    define('DOPBSP_ADD_MONTH_VIEW', "Add Month View");
    define('DOPBSP_REMOVE_MONTH_VIEW', "Remove Month View");
    define('DOPBSP_PREVIOUS_MONTH', "Previous Month");
    define('DOPBSP_NEXT_MONTH', "Next Month");
    define('DOPBSP_AVAILABLE_ONE_TEXT', "available");
    define('DOPBSP_AVAILABLE_TEXT', "available");
    define('DOPBSP_BOOKED_TEXT', "booked");
    define('DOPBSP_UNAVAILABLE_TEXT', "unavailable");
                            
    // Calendar Form 
    define('DOPBSP_DATE_START_LABEL', "Start Date");
    define('DOPBSP_DATE_END_LABEL', "End Date");    
    define('DOPBSP_STATUS_LABEL', "Status");
    define('DOPBSP_STATUS_AVAILABLE_TEXT', "Available");
    define('DOPBSP_STATUS_BOOKED_TEXT', "Booked");
    define('DOPBSP_STATUS_SPECIAL_TEXT', "Special");
    define('DOPBSP_STATUS_UNAVAILABLE_TEXT', "Unavailable");
    define('DOPBSP_PRICE_LABEL', "Price");    
    define('DOPBSP_PROMO_LABEL', "Promo Price");               
    define('DOPBSP_AVAILABLE_LABEL', "No. Available");         
    define('DOPBSP_HOURS_DEFINITIONS_CHANGE_LABEL', "Change Hours Definitions (changing the definitions will overwrite any previous hours data)");
    define('DOPBSP_HOURS_DEFINITIONS_LABEL', "Hours Definitions (hh:mm add one per line). Use only 24 hours format.");  
    define('DOPBSP_HOURS_SET_DEFAULT_DATA_LABEL', "Set default hours values for this day(s). This will overwrite any existing data.)"); 
    define('DOPBSP_HOURS_START_LABEL', "Start Hour"); 
    define('DOPBSP_HOURS_END_LABEL', "End Hour");
    define('DOPBSP_HOURS_INFO_LABEL', "Information (users will see this message)");
    define('DOPBSP_HOURS_NOTES_LABEL', "Notes (only you will see this message)");
    define('DOPBSP_GROUP_DAYS_LABEL', "Group Days");
    define('DOPBSP_GROUP_HOURS_LABEL', "Group Hours");
    define('DOPBSP_RESET_CONFIRMATION', "Are you sure you want to reset data? If you reset days, hours data from those days will be reset to.");
    
    // Add Calendar
    define('DOPBSP_ADD_CALENDAR_NAME', "New Calendar");
    define('DOPBSP_ADD_CALENDAR_SUBMIT', "Add Calendar");
    define('DOPBSP_ADD_CALENDAR_SUBMITED', "Adding calendar ...");
    define('DOPBSP_ADD_CALENDAR_SUCCESS', "You have succesfully added a new calendar.");

    // Edit Calendar
    define('DOPBSP_EDIT_CALENDAR_SUBMIT', "Edit Calendar");
    define('DOPBSP_EDIT_CALENDAR_USERS_PERMISSIONS', "Users Permissions");
    define('DOPBSP_EDIT_CALENDAR_SUCCESS', "You have succesfully edited the calendar.");

    // Delete Calendar
    define('DOPBSP_DELETE_CALENDAR_CONFIRMATION', "Are you sure you want to delete this calendar?");
    define('DOPBSP_DELETE_CALENDAR_SUBMIT', "Delete Calendar");
    define('DOPBSP_DELETE_CALENDAR_SUBMITED', "Deleting calendar ...");
    define('DOPBSP_DELETE_CALENDAR_SUCCESS', "You have succesfully deleted the calendar.");
    
    // Reservations
    define('DOPBSP_SHOW_RESERVATIONS', "Show Reservations");    
    define('DOPBSP_NO_RESERVATIONS', "There are no reservations.");
    
    define('DOPBSP_RESERVATIONS_ID', "Reservation ID");
    
    define('DOPBSP_RESERVATIONS_CHECK_IN_LABEL', "Check In");
    define('DOPBSP_RESERVATIONS_CHECK_OUT_LABEL', "Check Out");
    define('DOPBSP_RESERVATIONS_START_HOURS_LABEL', "Start at"); 
    define('DOPBSP_RESERVATIONS_END_HOURS_LABEL', "Finish at");
    
    define('DOPBSP_RESERVATIONS_FIRST_NAME_LABEL', "First Name");
    define('DOPBSP_RESERVATIONS_LAST_NAME_LABEL', "Last Name");
    define('DOPBSP_RESERVATIONS_STATUS_LABEL', "Status");
    define('DOPBSP_RESERVATIONS_STATUS_PENDING', "Pending");
    define('DOPBSP_RESERVATIONS_STATUS_APPROVED', "Approved");        
    define('DOPBSP_RESERVATIONS_DATE_CREATED_LABEL', "Date Created");    
    define('DOPBSP_RESERVATIONS_PAYMENT_METHOD_LABEL', 'Payment Method');
    define('DOPBSP_RESERVATIONS_PAYMENT_METHOD_ARRIVAL', 'On Arrival');
    define('DOPBSP_RESERVATIONS_PAYMENT_METHOD_PAYPAL', 'PayPal');
    define('DOPBSP_RESERVATIONS_PAYMENT_METHOD_PAYPAL_TRANSACTION_ID_LABEL', 'PayPal Transaction ID');   
    define('DOPBSP_RESERVATIONS_TOTAL_PRICE_LABEL', "Total:"); 
    define('DOPBSP_RESERVATIONS_NO_ITEMS_LABEL', "No Booked Items"); 
    define('DOPBSP_RESERVATIONS_PRICE_LABEL', "Price"); 
    define('DOPBSP_RESERVATIONS_DEPOSIT_PRICE_LABEL', "Deposit");
    define('DOPBSP_RESERVATIONS_DEPOSIT_PRICE_LEFT_LABEL', " Left to Pay");
    define('DOPBSP_RESERVATIONS_DISCOUNT_PRICE_LABEL', "Actual Price");
    define('DOPBSP_RESERVATIONS_DISCOUNT_PRICE_TEXT', "discount");
    define('DOPBSP_RESERVATIONS_EMAIL_LABEL', "Email"); 
    define('DOPBSP_RESERVATIONS_PHONE_LABEL', "Phone"); 
    define('DOPBSP_RESERVATIONS_NO_PEOPLE_LABEL', "No People"); 
    define('DOPBSP_RESERVATIONS_NO_ADULTS_LABEL', "No Adults"); 
    define('DOPBSP_RESERVATIONS_NO_CHILDREN_LABEL', "No Children"); 
    define('DOPBSP_RESERVATIONS_MESSAGE_LABEL', "Message");
    
    define('DOPBSP_RESERVATIONS_JUMP_TO_DAY_LABEL', 'Jump to day');
    define('DOPBSP_RESERVATIONS_APPROVE_LABEL', 'Approve');
    define('DOPBSP_RESERVATIONS_REJECT_LABEL', 'Reject');
    define('DOPBSP_RESERVATIONS_CANCEL_LABEL', 'Cancel');
    
    define('DOPBSP_RESERVATIONS_APPROVE_CONFIRMATION', 'Are you sure you want to approve this reservation?');
    define('DOPBSP_RESERVATIONS_APPROVE_SUCCESS', 'The reservation has been approved.');
    define('DOPBSP_RESERVATIONS_REJECT_CONFIRMATION', 'Are you sure you want to reject this reservation?');
    define('DOPBSP_RESERVATIONS_REJECT_SUCCESS', 'The reservation has been rejected.');
    define('DOPBSP_RESERVATIONS_CANCEL_CONFIRMATION', 'Are you sure you want to cancel this reservation?');
    define('DOPBSP_RESERVATIONS_CANCEL_SUCCESS', 'The reservation has been canceled.');
    
    // TinyMCE
    define('DOPBSP_TINYMCE_ADD', 'Add Calendar');
    
    // Settings
    define('DOPBSP_GENERAL_STYLES_SETTINGS', "General Settings");
    define('DOPBSP_CALENDAR_NAME', "Name");
    define('DOPBSP_AVAILABLE_DAYS', "Available Days");
    define('DOPBSP_FIRST_DAY', "First Day");
    define('DOPBSP_CURRENCY', "Currency");
    define('DOPBSP_DATE_TYPE', "Date Type");
    define('DOPBSP_PREDEFINED', "Select Predefined Settings");
    define('DOPBSP_TEMPLATE', "Style Template");
    define('DOPBSP_MIN_STAY', "Minimum Stay");
    define('DOPBSP_MAX_STAY', "Maximum Stay");
    define('DOPBSP_NO_ITEMS_ENABLED', "Enable Number of Items Select");
    define('DOPBSP_VIEW_ONLY', "View Only Info");
    define('DOPBSP_PAGE_URL', "Page URL");
    
    define('DOPBSP_NOTIFICATIONS_STYLES_SETTINGS', "Notifications Settings");
    define('DOPBSP_NOTIFICATIONS_TEMPLATE', "Email Template");
    define('DOPBSP_NOTIFICATIONS_EMAIL', "Notifications Email");
    define('DOPBSP_NOTIFICATIONS_SMTP_ENABLED', "Enable SMTP");
    define('DOPBSP_NOTIFICATIONS_SMTP_HOST_NAME', "SMTP Host Name");
    define('DOPBSP_NOTIFICATIONS_SMTP_HOST_PORT', "SMTP Host Port");
    define('DOPBSP_NOTIFICATIONS_SMTP_SSL', "SMTP SSL Conenction");
    define('DOPBSP_NOTIFICATIONS_SMTP_USER', "SMTP Host User");
    define('DOPBSP_NOTIFICATIONS_SMTP_PASSWORD', "SMTP Host Password");
                                              
    define('DOPBSP_DAYS_STYLES_SETTINGS', "Days Settings");
    define('DOPBSP_MULTIPLE_DAYS_SELECT', "Use Check In/Check Out");
    define('DOPBSP_MORNING_CHECK_OUT', "Morning Check Out");
    define('DOPBSP_DETAILS_FROM_HOURS', "Use hours details to set day details");
    
    define('DOPBSP_HOURS_STYLES_SETTINGS', "Hours Settings");
    define('DOPBSP_HOURS_ENABLED', "Use Hours");
    define('DOPBSP_HOURS_INFO_ENABLED', "Enable Hours Info");
    define('DOPBSP_HOURS_DEFINITIONS', "Define Hours");
    define('DOPBSP_MULTIPLE_HOURS_SELECT', "Use Start/Finish Hours");
    define('DOPBSP_HOURS_AMPM', "Enable AM/PM format");
    define('DOPBSP_LAST_HOUR_TO_TOTAL_PRICE', "Add last selected hour price to total price");
    define('DOPBSP_HOURS_INTERVAL_ENABLED', "Enable hours interval");
    
    define('DOPBSP_DISCOUNTS_NO_DAYS_SETTINGS', "Discounts by Number of Days");
    define('DOPBSP_DISCOUNTS_NO_DAYS', "Number of Days");
    define('DOPBSP_DISCOUNTS_NO_DAYS_DAYS', "days booking");
    
    define('DOPBSP_DEPOSIT_SETTINGS', "Deposit");
    define('DOPBSP_DEPOSIT', "Deposit value");
    
    define('DOPBSP_FORM_STYLES_SETTINGS', "Contact Form Settings");
    define('DOPBSP_FORM', "Select Form");
    define('DOPBSP_INSTANT_BOOKING_ENABLED', "Instant Booking");
    define('DOPBSP_NO_PEOPLE_ENABLED', "Enable Number of People Allowed");
    define('DOPBSP_MIN_NO_PEOPLE', "Minimum number of allowed people");
    define('DOPBSP_MAX_NO_PEOPLE', "Maximum number of allowed people");
    define('DOPBSP_NO_CHILDREN_ENABLED', "Enable Number of Children Allowed");
    define('DOPBSP_MIN_NO_CHILDREN', "Minimum number of allowed children");
    define('DOPBSP_MAX_NO_CHILDREN', "Maximum number of allowed children");
    define('DOPBSP_PAYMENT_ARRIVAL_ENABLED', "Enable Payment on Arrival");
    
    define('DOPBSP_PAYMENT_PAYPAL_STYLES_SETTINGS', "PayPal Settings");
    define('DOPBSP_PAYMENT_PAYPAL_ENABLED', "Enable PayPal Payment");
    define('DOPBSP_PAYMENT_PAYPAL_USERNAME', "PayPal API User Name");
    define('DOPBSP_PAYMENT_PAYPAL_PASSWORD', "PayPal API Password");
    define('DOPBSP_PAYMENT_PAYPAL_SIGNATURE', "PayPal API Signature");
    define('DOPBSP_PAYMENT_PAYPAL_CREDIT_CARD', "Enable Credit Card Payment");
    define('DOPBSP_PAYMENT_PAYPAL_SANDBOX_ENABLED', "Enable PayPal Sandbox");
    
    define('DOPBSP_TERMS_AND_CONDITIONS_ENABLED', "Enable Terms & Conditions");
    define('DOPBSP_TERMS_AND_CONDITIONS_LINK', "Terms & Conditions Link");
    
    define('DOPBSP_GO_TOP', "go top");
    define('DOPBSP_SHOW', "show");
    define('DOPBSP_HIDE', "hide");
    
    // Settings Info
    define('DOPBSP_CALENDAR_NAME_INFO', "Change calendar name.");
    define('DOPBSP_AVAILABLE_DAYS_INFO', "Default value: all available. Select available days.");
    define('DOPBSP_FIRST_DAY_INFO', "Default value: Monday. Select calendar first day.");
    define('DOPBSP_CURRENCY_INFO', "Default value: USD. Select calendar currency.");
    define('DOPBSP_DATE_TYPE_INFO', "Default value: American. Select date format: American (mm dd, yyyy) or European (dd mm yyyy).");
    define('DOPBSP_PREDEFINED_INFO', "If selected on Submit the below settings will be changed.");
    define('DOPBSP_TEMPLATE_INFO', "Default value: default. Select styles template.");
    define('DOPBSP_MIN_STAY_INFO', "Default value: 1. Set minimum amount of days that can be selected.");
    define('DOPBSP_MAX_STAY_INFO', "Default value: 0. Set maximum amount of days that can be selected. If you set 0 the number is unlimited.");
    define('DOPBSP_NO_ITEMS_ENABLED_INFO', "Default value: Enabled. Set to display only booking information in Front End.");
    define('DOPBSP_VIEW_ONLY_INFO', "Default value: Enabled. Set to display only booking information in Front End.");
    define('DOPBSP_PAGE_URL_INFO', "Set page URL were the calendar will be added. It is mandatory if you create a searching system through some calendars.");
    
    define('DOPBSP_NOTIFICATIONS_TEMPLATE_INFO', "Default value: default. Select email template.");
    define('DOPBSP_NOTIFICATIONS_EMAIL_INFO', "Enter the email were you will notified about booking requests or you will use to notify users.");
    define('DOPBSP_NOTIFICATIONS_SMTP_ENABLED_INFO', "Use SMTP to send emails.");
    define('DOPBSP_NOTIFICATIONS_SMTP_HOST_NAME_INFO', "Enter SMTP host name.");
    define('DOPBSP_NOTIFICATIONS_SMTP_HOST_PORT_INFO', "Enter SMTP host port.");
    define('DOPBSP_NOTIFICATIONS_SMTP_SSL_INFO', "Use a  SSL conenction.");
    define('DOPBSP_NOTIFICATIONS_SMTP_USER_INFO', "Enter SMTP host username.");
    define('DOPBSP_NOTIFICATIONS_SMTP_PASSWORD_INFO', "Enter SMTP host password.");
    
    define('DOPBSP_MULTIPLE_DAYS_SELECT_INFO', "Default value: Enabled. Use Check In/Check Out or select only one day.");
    define('DOPBSP_MORNING_CHECK_OUT_INFO', "Default value: Disabled. This option enables Check In in the afternoon of first day and Check Out in the morning of the day after last day.");
    define('DOPBSP_DETAILS_FROM_HOURS_INFO', "Default value: Enabled. Check this option, when hours are enabled, if you want for days details to be updated (calculated) from hours details or disable it if you want to have complete control of day derails.");
    
    define('DOPBSP_HOURS_ENABLED_INFO', "Default value: Disabled. Enable hours for the calendar.");
    define('DOPBSP_HOURS_INFO_ENABLED_INFO', "Default value: Enabled. Display hours info when you hover a day in calendar.");
    define('DOPBSP_HOURS_DEFINITIONS_INFO', "Enter hh:mm ... add one per line. Changing the definitions will overwrite any previous hours data. Use only 24 hours format.");
    define('DOPBSP_MULTIPLE_HOURS_SELECT_INFO', "Default value: Enabled. Use Start/Finish Hours or select only one hour.");
    define('DOPBSP_HOURS_AMPM_INFO', "Default value: Disabled. Display hours in AM/PM format. NOTE: Hours definitions still need to be in 24 hours format.");
    define('DOPBSP_LAST_HOUR_TO_TOTAL_PRICE_INFO', "Default value: Enabled. It calculates the total price before the last hours selected if Disabled. It calculates the total price including the last hour selected if Enabled. <br /><br /><strong>Warning: </strong> In administration area the last hours from your definitions list will not be displayed.");
    define('DOPBSP_HOURS_INTERVAL_ENABLED_INFO', "Default value: Disabled. Show hours interval from the current hour to the next one.");
    
    define('DOPBSP_DISCOUNTS_NO_DAYS_INFO', "Select the number of days to which you want to add a discount (up to 31 days).");
    define('DOPBSP_DISCOUNTS_NO_DAYS_DAYS_INFO', "Default value 0. Set the discount percent that a user will get when booking this number of days.");
    
    define('DOPBSP_DEPOSIT_INFO', "Default value: 0. Set the percent value for the deposit. The Deposit is available only if you have a Payment Service activated.");
    
    define('DOPBSP_FORM_INFO', "Select the form for Booking Form.");
    define('DOPBSP_INSTANT_BOOKING_ENABLED_INFO', "Default value: Disabled. Instantly book the data in a calendar once the request has been submitted.");
    define('DOPBSP_NO_PEOPLE_ENABLED_INFO', "Default value: Enabled. Request number of people that will use the booked item.");
    define('DOPBSP_MIN_NO_PEOPLE_INFO', "Default value: 1. Set minimum number of allowed people per booked item.");
    define('DOPBSP_MAX_NO_PEOPLE_INFO', "Default value: 4. Set maximum number of allowed people per booked item.");
    define('DOPBSP_NO_CHILDREN_ENABLED_INFO', "Default value: Enabled. Request number of children that will use the booked item.");
    define('DOPBSP_MIN_NO_CHILDREN_INFO', "Default value: 0. Set minimum number of allowed children per booked item.");
    define('DOPBSP_MAX_NO_CHILDREN_INFO', "Default value: 2. Set maximum number of allowed children per booked item.");
    define('DOPBSP_PAYMENT_ARRIVAL_ENABLED_INFO', "Default value: Enabled. Allow user to pay on arrival. Need approval.");
    define('DOPBSP_TERMS_AND_CONDITIONS_ENABLED_INFO', "Default value: Disabled. Enable Terms & Conditions check box.");
    define('DOPBSP_TERMS_AND_CONDITIONS_LINK_INFO', "Enter the link to Terms & Conditions page.");
    
    define('DOPBSP_PAYMENT_PAYPAL_ENABLED_INFO', "Default value: Disabled. Allow user to pay with PayPal. The period is instantly booked.");
    define('DOPBSP_PAYMENT_PAYPAL_USERNAME_INFO', "Enter PayPal API Credentials User Name. View Help section to see from were you can get them.");
    define('DOPBSP_PAYMENT_PAYPAL_PASSWORD_INFO', "Enter PayPal API Credentials Password. View Help section to see from were you can get them.");
    define('DOPBSP_PAYMENT_PAYPAL_SIGNATURE_INFO', "Enter PayPal API Credentials Signature. View Help section to see from were you can get them.");
    define('DOPBSP_PAYMENT_PAYPAL_CREDIT_CARD_INFO', "Default value: Disabled. Enable so that users can pay directly with their Credit Card.");
    define('DOPBSP_PAYMENT_PAYPAL_SANDBOX_ENABLED_INFO', "Default value: Disabled. Enable to use PayPal Sandbox features.");
    
    // Booking Forms
    define('DOPBSP_TITLE_BOOKING_FORMS', "Booking Forms");
    define('DOPBSP_BOOKING_FORMS_HELP', "Click on the 'Plus' icon to add a booking form. Click on a booking form item to open the editing area.");
    define('DOPBSP_BOOKING_FORMS_LOADED', "Booking forms list loaded.");
    define('DOPBSP_BOOKING_FORM_SETTINGS_HELP', "Click 'Submit Button' to save changes. Click 'Delete Button' to delete the form.");
    define('DOPBSP_BOOKING_FORM_LOADED', "Booking form loaded.");
    define('DOPBSP_NO_BOOKING_FORMS', "No booking forms.");
    
    // Add Booking Form
    define('DOPBSP_ADD_BOOKING_FORM_NAME', "New booking form");
    define('DOPBSP_ADD_BOOKING_FORM_SUBMIT', "Add Form");
    define('DOPBSP_ADD_BOOKING_FORM_SUBMITED', "Adding form ...");
    define('DOPBSP_ADD_BOOKING_FORM_SUCCESS', "You have succesfully added a new form.");
    
    // Edit Booking Form
    define('DOPBSP_EDIT_BOOKING_FORM_SUBMIT', "Submit");
    define('DOPBSP_EDIT_BOOKING_FORM_SUCCESS', "You have succesfully edited the form.");
    
    // Delete Booking Form
    define('DOPBSP_DELETE_BOOKING_FORM_CONFIRMATION', "Are you sure you want to delete this form?");
    define('DOPBSP_DELETE_BOOKING_FORM_SUBMIT', "Delete Form");
    define('DOPBSP_DELETE_BOOKING_FORM_SUBMITED', "Deleting form ...");
    define('DOPBSP_DELETE_BOOKING_FORM_SUCCESS', "You have succesfully deleted the form.");
    
    // Booking Form Fields
    define('DOPBSP_BOOKING_FORM_NAME', "Form Name");
    define('DOPBSP_BOOKING_FORM_NAME_DEFAULT', "Default Form");
    define('DOPBSP_BOOKING_FORM_FIELDS_TITLE', "Form Fields");
    define('DOPBSP_BOOKING_FORM_FIELDS_SHOW_SETTINGS', "Show Settings");
    define('DOPBSP_BOOKING_FORM_FIELDS_HIDE_SETTINGS', "Hide Settings");
    define('DOPBSP_BOOKING_FORM_FIELDS_TYPE_TEXT_LABEL', "Text");
    define('DOPBSP_BOOKING_FORM_FIELDS_TYPE_TEXTAREA_LABEL', "Textarea");
    define('DOPBSP_BOOKING_FORM_FIELDS_TYPE_CHECKBOX_LABEL', "Checkbox");
    define('DOPBSP_BOOKING_FORM_FIELDS_TYPE_SELECT_LABEL', "Drop Down");
    define('DOPBSP_BOOKING_FORM_FIELDS_LANGUAGE_LABEL', "Language");
    define('DOPBSP_BOOKING_FORM_FIELDS_NAME_LABEL', "Label");
    define('DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_TEXT_LABEL', "New Text Field");
    define('DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_TEXTAREA_LABEL', "New Textarea Field");
    define('DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_CHECKBOX_LABEL', "New Checkbox Field");
    define('DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_SELECT_LABEL', "New Drop Down Field");
    define('DOPBSP_BOOKING_FORM_FIELDS_ALLOWED_CHARACTERS_LABEL', "Allowed Characters");
    define('DOPBSP_BOOKING_FORM_FIELDS_SIZE_LABEL', "Size");
    define('DOPBSP_BOOKING_FORM_FIELDS_EMAIL_LABEL', "Is Email");
    define('DOPBSP_BOOKING_FORM_FIELDS_REQUIRED_LABEL', "Required");
    define('DOPBSP_BOOKING_FORM_FIELDS_SELECT_OPTIONS_LABEL', "Options");
    define('DOPBSP_BOOKING_FORM_FIELDS_SELECT_ADD_OPTION', "Add Option");
    define('DOPBSP_BOOKING_FORM_FIELDS_SELECT_NEW_OPTION_LABEL', "New Option");
    define('DOPBSP_BOOKING_FORM_FIELDS_SELECT_DELETE_OPTION', "Delete Option");
    define('DOPBSP_BOOKING_FORM_FIELDS_SELECT_MULTIPLE_SELECT_LABEL', "Multiple Select");
    define('DOPBSP_BOOKING_FORM_CHECKED', "Checked");
    define('DOPBSP_BOOKING_FORM_UNCHECKED', "Unchecked");
    
    // Booking Form Fields Info
    define('DOPBSP_BOOKING_FORM_NAME_INFO', "Change form name and click Submit.");
    define('DOPBSP_BOOKING_FORM_FIELDS_INFO', "Drag the Field Type from right to left to create a new Field. Drag a created Field to trash to delete. Click Show Settings to edit a created Field.");
    define('DOPBSP_BOOKING_FORM_FIELDS_LANGUAGE_INFO', "Select the language for which you want to change the names (labels).");
    define('DOPBSP_BOOKING_FORM_FIELDS_NAME_INFO', "Enter field name (label).");
    define('DOPBSP_BOOKING_FORM_FIELDS_ALLOWED_CHARACTERS_INFO', "Enter the caracters allowed in this field. Leave it blank if all characters are allowed.");
    define('DOPBSP_BOOKING_FORM_FIELDS_SIZE_INFO', "Enter the maximum number of characters allowed. Leave it blank for unlimited.");
    define('DOPBSP_BOOKING_FORM_FIELDS_EMAIL_INFO', "Check it if you want this field to be verified if an email has been added or not.");
    define('DOPBSP_BOOKING_FORM_FIELDS_REQUIRED_INFO', "Check it if you want the field to be mandatory.");
    define('DOPBSP_BOOKING_FORM_FIELDS_SELECT_OPTIONS_INFO', "Add the Plus Icon to add another option and enter the name. Click on the Delete Icon to remove the option.");
    define('DOPBSP_BOOKING_FORM_FIELDS_SELECT_MULTIPLE_SELECT_INFO', "Check it if you want a multiple select Drop Down.");
    
    // General Settings
    define('DOPBSP_TITLE_SETTINGS', "Settings");
    
    define('DOPBSP_USERS_PERMISSIONS', "Users Permissions");
    define('DOPBSP_USERS_CUSTOM_POSTS_TYPE_PERMISSIONS', "Custom Posts Permissions");
    define('DOPBSP_USERS_SHOW', "show users");
    define('DOPBSP_USERS_HIDE', "hide users");
    define('DOPBSP_USERS_NO_ADMINISTRATORS', "There are no administrators!");
    define('DOPBSP_USERS_NO_AUTHORS', "There are no authors!");
    define('DOPBSP_USERS_NO_CONTRIBUTORS', "There are no contributors!");
    define('DOPBSP_USERS_NO_EDITORS', "There are no editors!");
    define('DOPBSP_USERS_NO_SUBSCRIBERS', "There are no subscribers!");
    define('DOPBSP_USERS_ADMINISTRATORS', "Administrators");
    define('DOPSBP_USERS_ADMINISTRATORS_BULK_PERMISSIONS_INFO', "Check for administrators to view all the calendars from all the users and/or individually add/edit them.");
    define('DOPSBP_USERS_ADMINISTRATORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO', "Check for administrators to use Booking System PRO Custom Posts.");
    define('DOPBSP_USERS_AUTHORS', "Authors");
    define('DOPSBP_USERS_AUTHORS_BULK_PERMISSIONS_INFO', "Check for authors to view the plugin and individually edit only their own calendars.");
    define('DOPSBP_USERS_AUTHORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO', "Check for authors to use Booking System PRO Custom Posts.");
    define('DOPBSP_USERS_CONTRIBUTORS', "Contributors");
    define('DOPBSP_USERS_CONTRIBUTORS_BULK_PERMISSIONS_INFO', "Check for contributors to view the plugin and individually edit only their own calendars.");
    define('DOPBSP_USERS_CONTRIBUTORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO', "Check for contributors to use Booking System PRO Custom Posts.");
    define('DOPBSP_USERS_EDITORS', "Editors");
    define('DOPSBP_USERS_EDITORS_BULK_PERMISSIONS_INFO', "Check for editors to view the plugin and individually edit only their own calendars.");
    define('DOPSBP_USERS_EDITORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO', "Check for editors to use Booking System PRO Custom Posts.");
    define('DOPBSP_USERS_SUBSCRIBERS', "Subscribers");
    define('DOPBSP_USERS_SUBSCRIBERS_BULK_PERMISSIONS_INFO', "Check for subscribers to view the plugin and individually edit only their own calendars.");
    define('DOPBSP_USERS_SUBSCRIBERS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO', "Check for subscribers to use Booking System PRO Custom Posts.");
    define('DOPBSP_USERS_PERMISSIONS_HELP', "Check the users that will use this calendar.");
    define('DOPBSP_USERS_CUSTOM_POSTS_TYPE_PERMISSIONS_HELP', "Check the users that will use this calendar in custom post.");
    
    // Custom Post Type
    define('DOPBSP_CUSTOM_POSTS_TYPE', 'Booking System PRO Cutom Posts');
    define('DOPBSP_CUSTOM_POSTS_TYPE_ADD_NEW_ITEM_ALL_ITEMS', 'Posts');
    define('DOPBSP_CUSTOM_POSTS_TYPE_ADD_NEW_ITEM', 'Add New Booking System PRO Cutom Post');
    define('DOPBSP_CUSTOM_POSTS_TYPE_EDIT_ITEM', 'Edit Booking System PRO Cutom Post');
    define('DOPBSP_CUSTOM_POSTS_TYPE_BOOKING_SYSTEM', "Booking System PRO");
    
    // Widget    
    define('DOPBSP_WIDGET_TITLE', "Booking System PRO");
    define('DOPBSP_WIDGET_DESCRIPTION', "Select option you want to appear in the widget and ID(s) of the Calendar(s).");
    define('DOPBSP_WIDGET_LABEL_TITLE', "Title:");
    define('DOPBSP_WIDGET_LABEL_SELECTION', "Select Action");
    define('DOPBSP_WIDGET_SELECTION_CALENDAR', "Add Calendar");
    define('DOPBSP_WIDGET_SELECTION_SIDEBAR', "Add Calendar Sidebar");
    define('DOPBSP_WIDGET_LABEL_ID', "Select Calendar ID:");
    define('DOPBSP_WIDGET_NO_CALENDARS', "No calendars.");
    define('DOPBSP_WIDGET_LABEL_LANGUAGE', "Select Language:");
    
    // Help
    define('DOPBSP_HELP_DOCUMENTATION', "Documentation");
    define('DOPBSP_HELP_FAQ', "FAQ");

?>