<?php
/*
Plugin Name: Booking System PRO (WordPress Plugin)
Version: 1.7
Plugin URI: http://codecanyon.net/item/booking-system-pro-wordpress-plugin/2675936?ref=DOTonPAPER
Description: You will be able to insert it in any page or post you want with an inbuilt short code generator.<br /><br />If you like this plugin, feel free to rate it five stars at <a href="http://codecanyon.net/item/booking-system-pro-wordpress-plugin/2675936?ref=DOTonPAPER" target="_blank">CodeCanyon</a> in your downloads section. If you encounter any problems please do not give a low rating but <a href="http://envato-support.dotonpaper.net">visit</a> our <a href="http://envato-support.dotonpaper.net">Support Forums</a> first so we can help you.
Author: Dot on Paper
Author URI: http://www.dotonpaper.net

Change log:

        1.8 (2013-08-31)
                
                * Back End CSS bugs fixed.
                * Custom Post Types bugs fixed.
                * Front End CSS bugs fixed.
                * JavaScript in Admin Posts fixed.
                * Localhost bugs fixed.
                * Prices, deposits, discounts can have float values.
                * Plugin paths updated.
                * User management updated.
                * Select days from different months on front End Calendar bug fixed.
                * Windows server mySQL text fields bug fixed.

        1.7 (2013-07-31)

                * Add calendars in widgets.
                * Approve reservation bug fix.
                * Back End style changes.
                * Calendar ID is removed from clients notification emails.
                * CSS bug fixes.
                * Custom Post Type added.
                * Date select is fixed when minimum amount of days is set.
                * Datepicker bug fix, when you can select only one day.
                * Drop Down Fields display correct selected option in Email.
                * Hours info displayed on day hover.
                * Major changes in hours logic and display.
                * Newly created forms display correct after PayPal Payment.
                * PayPal notification email content bug fix.
                * Send email using normal function if SMTP is incorrect.
                * Tables not created on Windows OS bug fixed.
                * Text on Settings page has been changed.
                * Translation for Check Fields added.
                * User role is updated when is changed in WP admin.
                * When hours are enabled days details can be set manually or set depending on hours details on that current day.
                * WordPress update error fixed. 

        1.6 (2013-06-15)

                * Admin language is different for each user.
                * Compatibility fixes.
                * Custom Forms tweaks.
                * Database update.
                * Datepicker & Google translate incompatibility bug fixed.
                * Display calendar id & name in notifications emails.
                * Display hours interval from current hour to next one.
                * Posibility to hide Number of Items select field has been added.
                * You can set booking requests to by approved instanly, or not.
                * You have the possibility to calculate the total price using the last hour selected value, or not.

        1.5 (2013-06-08)

                * CSS incompatibility fixes.
                * Custom Forms added.
                * Datepicker z-index bug fix.
                * Email header is custom.
                * Group day date is displayed correctly after select.
                * Users Permissons translation fixes.
 
        1.4 (2013-06-03)

                * ACAO buster added.
                * Admin change language bug fix.
                * Administrators can create calendars for users.
                * Calendar loading time is improved.
                * Calendar resize on hidden elements bug fix.
                * Database is deleted when you delete the plugin.
                * Display only an information calendar in Front End.
                * Emails are sent using wp_mail().
                * Indonesia Rupiah currency bug fix.
                * PayPal credit card payment bug fix.
                * PayPal session bug fixed.
                * Select first day of the week.
                * Slow admin bug fix.
                * Small Admin changes.
                * Touch devices freeze bug fix.
                * Translation fixes.
                * Update notification added.
                * User permissions updated.

        1.3 (2012-12-13)

                * Correct hours format is displayed.
                * Deposit feature has been added.
                * Discounts by number of days booked have been added.
                * Email message and language bugs have been fixed.
                * Frontend responsive has been added.
                * Touch devices navigation has been enabled.
                * You can translate the Sidebar Datepicker.
                * You can use PayPal credit card payment.
	
	1.2 (2012-11-01)
 
                * AM/PM hour format added.
                * Hours data save bug fixed.
                * Language files added (but not translated).
                * Morning Check Out added.
                * Past hours are removed from current day.
                * Rejected reservation notification email fix.  
                * Reservation cancel added.
                * Shortcode generator doesn't appear if you are not allowed to create calendars or you didn't create any calendars.
                * SMTP SSL fix.
                * User permissions bug fix.
                * You can select minimum and/or maximum amount of days that can be booked.
                * You can set default hours values by day(s).

	1.1 (2012-09-05)
	
                * Administrators can view and edit users calendars.
                * Back End & Front End CSS incompatibility fixes.
                * Clean script to remove past days info to clear database from unecessary data.
		* Database structure has been changed (now is much faster to save/load data & works on server with few resources).
                * Delete calendar bug fix.
                * Display corect month in future years bug fix.
                * Emails template system added.
                * ereg() function replaced with preg_match().
                * PayPal bugs fixed.
                * Reservation ID is displayed in notifications emails.
                * Terms & Conditions checkbox and link added.
                * You can now add calendar sidebar in a widget area.
                * You can set if indiviadual users can create or not calendars.
                * You can use SMTP to send notification emails.
	
	1.0 (2012-07-15)
	
		* Initial release.
		
Installation: Upload the folder dopbsp from the zip file to "wp-content/plugins/" and activate the plugin in your admin panel or upload dopbsp.zip in the "Add new" section.
*/

    include_once 'views/templates.php';
    include_once 'views/currencies.php';
    include_once 'dopbsp-email.php';
    include_once 'dopbsp-update.php';
    include_once 'dopbsp-frontend.php';
    include_once 'dopbsp-backend.php';
    include_once 'dopbsp-backend-forms.php';
    include_once 'dopbsp-backend-reservations.php';
    include_once 'dopbsp-widget.php';
    
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){
        //include_once 'dopbsp-backend-woocommerce.php';
    }
    
// Paths
    
    if (!defined('DOPBSP_Plugin_URL')){
        define('DOPBSP_Plugin_URL', plugin_dir_url(__FILE__));
    }
    if (!defined('DOPBSP_Plugin_AbsPath')){
        define('DOPBSP_Plugin_AbsPath', str_replace('\\', '/', plugin_dir_path(__FILE__)));
    }

    if (is_admin()){// If admin is loged in admin init administration panel.
        if (!is_network_admin()){
            $pluggable_file = '../wp-includes/pluggable.php';

            if (!file_exists($pluggable_file)){
                $pluggable_file = '../../wp-includes/pluggable.php';
            }
            
            if (defined('AUTH_COOKIE')){
                include_once $pluggable_file;

                //  Get selected language
                $current_backend_language = get_option('DOPBSP_backend_language_'.wp_get_current_user()->ID);

                if ($current_backend_language == ''){
                    $current_backend_language = 'en';
                    add_option('DOPBSP_backend_language_'.wp_get_current_user()->ID, 'en');
                }
            }
            else{
                $current_backend_language = 'en';
            }
        }
        else{
            $current_backend_language = 'en';
        }
            
        // Include language file.
        include_once "translation/backend/".$current_backend_language.".php";

        if (class_exists("DOPBookingSystemPROBackEnd")){
            $DOPBSP_pluginSeries = new DOPBookingSystemPROBackEnd();
        }
        
        if (class_exists("DOPBookingSystemPROBackEndForms")){
            $DOPBSP_pluginSeries_forms = new DOPBookingSystemPROBackEndForms();
        }
        
        if (class_exists("DOPBookingSystemPROBackEndReservations")){
            $DOPBSP_pluginSeries_reservations = new DOPBookingSystemPROBackEndReservations();
        }
        
        if (class_exists("DOPBookingSystemPROBackEndWooCommerce")){
            $DOPBSP_pluginSeries_woocommerce = new DOPBookingSystemPROBackEndWooCommerce();
        }

        if (!function_exists("DOPBookingSystemPROBackEnd_ap")){// Initialize the admin panel.
            function DOPBookingSystemPROBackEnd_ap(){
                global $DOPBSP_pluginSeries;
                global $DOPBSP_pluginSeries_forms;
                global $DOPBSP_pluginSeries_reservations;

                if (!isset($DOPBSP_pluginSeries)
                    || !isset($DOPBSP_pluginSeries_forms)
                    || !isset($DOPBSP_pluginSeries_reservations)){
                    return;
                }
                
                $DOPBSP_pluginSeries->initTables();
                
                if (!is_super_admin()){
                    switch (wp_get_current_user()->roles[0]){
                        case 'author':
                            $role_action = 'publish_posts';
                            break;
                        case 'contributor':
                            $role_action = 'edit_posts';
                            break;
                        case 'editor':
                            $role_action = 'edit_pages';
                            break;
                        case 'subscriber':
                            $role_action = 'read';
                            break;
                        default:
                            $role_action = 'manage_options';
                            break;
                    }
                } 
                else {
                    $role_action = 'manage_options';
                }
                
                if (!$DOPBSP_pluginSeries->userHasPermissions(wp_get_current_user()->ID) && !$DOPBSP_pluginSeries->userHasCalendars(wp_get_current_user()->ID)){
                    $role_action = 'manage_options';  
                }

                if (function_exists('add_options_page')){
                    add_menu_page(DOPBSP_TITLE, DOPBSP_TITLE, $role_action, 'dopbsp', array(&$DOPBSP_pluginSeries, 'printAdminPage'), plugins_url('assets/gui/images/dop-icon.png', __FILE__));
                    add_submenu_page('dopbsp', DOPBSP_TITLE_BOOKING_FORMS, DOPBSP_TITLE_BOOKING_FORMS, $role_action, 'dopbsp-booking-forms', array(&$DOPBSP_pluginSeries_forms, 'printBookingFormsPage'));
                    add_submenu_page('dopbsp', DOPBSP_TITLE_SETTINGS, DOPBSP_TITLE_SETTINGS, 'manage_options', 'dopbsp-settings', array(&$DOPBSP_pluginSeries, 'printSettingsPage'));
                }
            }
        }

        if (isset($DOPBSP_pluginSeries)){// Init AJAX functions.
            add_action('admin_menu', 'DOPBookingSystemPROBackEnd_ap');

// Change Translation      
            add_action('wp_ajax_dopbsp_change_translation', array(&$DOPBSP_pluginSeries, 'changeTranslation'));
// Calendars admin AJAX requests.
            add_action('wp_ajax_dopbsp_show_calendars', array(&$DOPBSP_pluginSeries, 'showCalendars'));
            add_action('wp_ajax_dopbsp_add_calendar', array(&$DOPBSP_pluginSeries, 'addCalendar'));
            add_action('wp_ajax_dopbsp_show_calendar', array(&$DOPBSP_pluginSeries, 'showCalendar'));
            add_action('wp_ajax_dopbsp_show_calendar_id', array(&$DOPBSP_pluginSeries, 'showCalendarId'));
            add_action('wp_ajax_dopbsp_load_schedule', array(&$DOPBSP_pluginSeries, 'loadSchedule'));
            add_action('wp_ajax_dopbsp_save_schedule', array(&$DOPBSP_pluginSeries, 'saveSchedule'));
            add_action('wp_ajax_dopbsp_delete_schedule', array(&$DOPBSP_pluginSeries, 'deleteSchedule'));
            add_action('wp_ajax_dopbsp_show_calendar_settings', array(&$DOPBSP_pluginSeries, 'showCalendarSettings'));
            add_action('wp_ajax_dopbsp_edit_calendar', array(&$DOPBSP_pluginSeries, 'editCalendar'));
            add_action('wp_ajax_dopbsp_delete_calendar', array(&$DOPBSP_pluginSeries, 'deleteCalendar'));        
// Reservations admin AJAX requests.            
            add_action('wp_ajax_dopbsp_show_no_reservations', array(&$DOPBSP_pluginSeries_reservations, 'showNoReservations'));
            add_action('wp_ajax_dopbsp_show_reservations', array(&$DOPBSP_pluginSeries_reservations, 'showReservations'));
            add_action('wp_ajax_dopbsp_approve_reservation', array(&$DOPBSP_pluginSeries_reservations, 'approveReservation'));
            add_action('wp_ajax_dopbsp_reject_reservation', array(&$DOPBSP_pluginSeries_reservations, 'rejectReservation'));
            add_action('wp_ajax_dopbsp_cancel_reservation', array(&$DOPBSP_pluginSeries_reservations, 'cancelReservation'));
// Forms admin AJAX requests.
            add_action('wp_ajax_dopbsp_show_booking_forms', array(&$DOPBSP_pluginSeries_forms, 'showBookingForms'));
            add_action('wp_ajax_dopbsp_add_booking_form', array(&$DOPBSP_pluginSeries_forms, 'addBookingForm'));
            add_action('wp_ajax_dopbsp_show_booking_form', array(&$DOPBSP_pluginSeries_forms, 'showBookingForm'));
            add_action('wp_ajax_dopbsp_edit_booking_form', array(&$DOPBSP_pluginSeries_forms, 'editBookingForm'));
            add_action('wp_ajax_dopbsp_delete_booking_form', array(&$DOPBSP_pluginSeries_forms, 'deleteBookingForm'));
// Forms fields admin AJAX requests.
            add_action('wp_ajax_dopbsp_show_booking_form_fields', array(&$DOPBSP_pluginSeries_forms, 'showBookingFormFields'));
            add_action('wp_ajax_dopbsp_add_booking_form_field', array(&$DOPBSP_pluginSeries_forms, 'addBookingFormField'));
            add_action('wp_ajax_dopbsp_edit_booking_form_field', array(&$DOPBSP_pluginSeries_forms, 'editBookingFormField'));
            add_action('wp_ajax_dopbsp_update_booking_form_field', array(&$DOPBSP_pluginSeries_forms, 'updateBookingFormFields'));
            add_action('wp_ajax_dopbsp_delete_booking_form_field', array(&$DOPBSP_pluginSeries_forms, 'deleteBookingFormField'));
            add_action('wp_ajax_dopbsp_add_booking_form_field_select_option', array(&$DOPBSP_pluginSeries_forms, 'addBookingFormFieldSelectOption'));
            add_action('wp_ajax_dopbsp_edit_booking_form_field_select_option', array(&$DOPBSP_pluginSeries_forms, 'editBookingFormFieldSelectOption'));
            add_action('wp_ajax_dopbsp_delete_booking_form_field_select_option', array(&$DOPBSP_pluginSeries_forms, 'deleteBookingFormFieldSelectOption'));
// User Permissions admin AJAX requests.
            add_action('wp_ajax_dopbsp_show_users_permissions', array(&$DOPBSP_pluginSeries, 'printSettingsUsersPermissions'));
            add_action('wp_ajax_dopbsp_edit_user_permissions', array(&$DOPBSP_pluginSeries, 'editUserPermissions'));
            add_action('wp_ajax_dopbsp_edit_general_user_permissions', array(&$DOPBSP_pluginSeries, 'editGeneralUserPermissions'));
            add_action('wp_ajax_dopbsp_calendar_users_permissions_settings', array(&$DOPBSP_pluginSeries, 'calendarUsersPermissions'));
            add_action('wp_ajax_dopbsp_calendar_users_permissions_update', array(&$DOPBSP_pluginSeries, 'calendarUsersPermissionsUpdate'));
// User Custom Post Permissions admin AJAX requests.
            add_action('wp_ajax_dopbsp_show_users_custom_posts_permissions', array(&$DOPBSP_pluginSeries, 'printSettingsUsersCustomPostsPermissions'));
            add_action('wp_ajax_dopbsp_edit_general_user_custom_posts_permissions', array(&$DOPBSP_pluginSeries, 'editGeneralUserCustomPostsPermissions'));
            add_action('wp_ajax_dopbsp_edit_user_custom_posts_permissions', array(&$DOPBSP_pluginSeries, 'editUserCustomPostsPermissions'));
        }
    }
    else{// If you view the WordPress website init the gallery.
        if (class_exists("DOPBookingSystemPROFrontEnd")){
            $DOPBSP_pluginSeries = new DOPBookingSystemPROFrontEnd();
        }

        if (isset($DOPBSP_pluginSeries)){// Init AJAX functions.
            add_action('wp_ajax_dopbsp_load_schedule', array(&$DOPBSP_pluginSeries, 'loadSchedule'));
            add_action('wp_ajax_dopbsp_paypal_check', array(&$DOPBSP_pluginSeries, 'paypalCheck'));
            add_action('wp_ajax_dopbsp_book_request', array(&$DOPBSP_pluginSeries, 'bookRequest'));
        }
    }
        
    add_action('widgets_init', create_function('', 'return register_widget("DOPBookingSystemProWidget");'));

// Uninstall

    if (!function_exists("DOPBookingSystemPROUninstall")){
        function DOPBookingSystemPROUninstall() {
            global $wpdb;

            $tables = $wpdb->get_results('SHOW TABLES');

            foreach ($tables as $table){
                $table_name = $table->Tables_in_studios_wp;

                if (strrpos($table_name, 'dopbsp_settings') !== false ||
                    strrpos($table_name, 'dopbsp_calendars') !== false ||
                    strrpos($table_name, 'dopbsp_days') !== false ||
                    strrpos($table_name, 'dopbsp_reservations') !== false ||
                    strrpos($table_name, 'dopbsp_users') !== false){
                    $wpdb->query("DROP TABLE IF EXISTS $table_name");
                }
            }
            
            delete_option('DOPBSP_db_version');
        }
        
        register_uninstall_hook(__FILE__, 'DOPBookingSystemPROUninstall');
    }
    
?>