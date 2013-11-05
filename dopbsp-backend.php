<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 1.7
* File                    : dopbsp-backend.php
* File Version            : 1.7
* Created / Last Modified : 31 July 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Back End Class.
*/

    if (!class_exists("DOPBookingSystemPROBackEnd")){
        class DOPBookingSystemPROBackEnd{
            private $DOPBSP_AddEditCalendars;
            private $DOPBSP_db_version = 1.72;

            function DOPBookingSystemPROBackEnd(){// Constructor.
                if (is_admin()){
                    add_action('init', array(&$this, 'initCustomPostsType'));
                    add_action('add_meta_boxes_dopbsp', array(&$this, 'customPostTypeMetaBoxes'));
                    
                    if ($this->validPage()){
                        $this->DOPBSP_AddEditCalendars = new DOPBSPTemplates();
                        add_action('admin_enqueue_scripts', array(&$this, 'addStyles'));
                        add_action('admin_enqueue_scripts', array(&$this, 'addScripts'));
                    }

                    $this->addDOPBSPtoTinyMCE();
                    $this->init();
                }
            }
            
            function addStyles(){
                // Register Styles.
                wp_register_style('DOPBSP_DOPBookingSystemPROStyle', plugins_url('assets/gui/css/jquery.dop.BackendBookingSystemPRO.css', __FILE__));
                wp_register_style('DOPBSP_AdminStyle', plugins_url('assets/gui/css/backend-style.css', __FILE__));

                // Enqueue Styles.
                wp_enqueue_style('thickbox');
                wp_enqueue_style('DOPBSP_DOPBookingSystemPROStyle');
                wp_enqueue_style('DOPBSP_AdminStyle');
            }
            
            function addScripts(){
                // Register JavaScript.
                wp_register_script('DOPBSP_DOPBookingSystemPROJS', plugins_url('assets/js/jquery.dop.BackendBookingSystemPRO.js', __FILE__), array('jquery'), false, true);
                wp_register_script('DOPBSP_DOPBSPJS', plugins_url('assets/js/dopbsp-backend.js', __FILE__), array('jquery'), false, true);
                wp_register_script('DOPBSP_DOPBSPJS_FORMS', plugins_url('assets/js/dopbsp-backend-forms.js', __FILE__), array('jquery'), false, true);

                // Enqueue JavaScript.
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
                //wp_enqueue_script('jqueryUI');
                wp_enqueue_script('DOPBSP_DOPBookingSystemPROJS');
                wp_enqueue_script('DOPBSP_DOPBSPJS');
                wp_enqueue_script('DOPBSP_DOPBSPJS_FORMS');
                
                if (!wp_script_is('jquery-ui-sortable', 'queue')){
                    wp_enqueue_script('jquery-ui-sortable');
                }
            }
            
            function init(){// Admin init.
                $this->initConstants();
                $this->initTables();
            }

            function initConstants(){// Constants init.
                global $wpdb;
                
                // Tables
                if (!defined('DOPBSP_Settings_table')){
                    define('DOPBSP_Settings_table', $wpdb->prefix.'dopbsp_settings');
                }
                if (!defined('DOPBSP_Calendars_table')){
                    define('DOPBSP_Calendars_table', $wpdb->prefix.'dopbsp_calendars');
                }
                if (!defined('DOPBSP_Days_table')){
                    define('DOPBSP_Days_table', $wpdb->prefix.'dopbsp_days');
                }
                if (!defined('DOPBSP_Reservations_table')){
                    define('DOPBSP_Reservations_table', $wpdb->prefix.'dopbsp_reservations');
                }
                if (!defined('DOPBSP_Users_table')){
                    define('DOPBSP_Users_table', $wpdb->prefix.'dopbsp_users');
                }
                if (!defined('DOPBSP_Forms_table')){
                    define('DOPBSP_Forms_table', $wpdb->prefix.'dopbsp_forms');
                }
                if (!defined('DOPBSP_Forms_Fields_table')){
                    define('DOPBSP_Forms_Fields_table', $wpdb->prefix.'dopbsp_forms_fields');
                }
                if (!defined('DOPBSP_Forms_Select_Options_table')){
                    define('DOPBSP_Forms_Select_Options_table', $wpdb->prefix.'dopbsp_forms_select_options');
                }
            }

            function validPage(){// Valid Admin Page.
                if (isset($_GET['page'])){
                    if ($_GET['page'] == 'dopbsp' || $_GET['page'] == 'dopbsp-booking-forms' || $_GET['page'] == 'dopbsp-settings'){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else if (isset($_GET['post_type'])){
                    if ($_GET['post_type'] == 'dopsbp') {
                        return true; 
                    } 
                    else{
                        return false;
                    }
                }
                else if (isset($_GET['action'])){
                    if ($_GET['action'] == 'edit') {
                        return true; 
                    } 
                    else{
                        return false;
                    }
                }
                else{
                    return false;
                }
            }

            function initTables(){// Tables init.
                //update_option('DOPBSP_db_version', '1.0');
                $current_db_version = get_option('DOPBSP_db_version');
                
                if ($this->DOPBSP_db_version != $current_db_version){
                    require_once(str_replace('\\', '/', ABSPATH).'wp-admin/includes/upgrade.php');

                    $sql_settings = "CREATE TABLE " . DOPBSP_Settings_table . " (
                                        id INT NOT NULL AUTO_INCREMENT,
                                        calendar_id INT DEFAULT 0 NOT NULL,
                                        available_days VARCHAR(128) DEFAULT 'true,true,true,true,true,true,true' COLLATE utf8_unicode_ci NOT NULL,
                                        first_day INT DEFAULT 1 NOT NULL,
                                        currency INT DEFAULT 108 NOT NULL,
                                        fixed_tax FLOAT DEFAULT 0 NOT NULL,
                                        percent_tax FLOAT DEFAULT 0 NOT NULL,
                                        date_type INT DEFAULT 1 NOT NULL,
                                        template VARCHAR(128) DEFAULT 'default' COLLATE utf8_unicode_ci NOT NULL,
                                        template_email VARCHAR(128) DEFAULT 'default' COLLATE utf8_unicode_ci NOT NULL,
                                        min_stay INT DEFAULT 1 NOT NULL,
                                        max_stay INT DEFAULT 0 NOT NULL,
                                        no_items_enabled VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        view_only VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,  
                                        page_url VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        notifications_email VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,                                       
                                        smtp_enabled VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,                                     
                                        smtp_host_name VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        smtp_host_port INT DEFAULT 25 NOT NULL,
                                        smtp_ssl VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,                                   
                                        smtp_user VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,                                   
                                        smtp_password VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        multiple_days_select VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        morning_check_out VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        details_from_hours VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        hours_enabled VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        hours_info_enabled VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        hours_definitions TEXT COLLATE utf8_unicode_ci NOT NULL,
                                        multiple_hours_select VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        hours_ampm VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        last_hour_to_total_price VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        hours_interval_enabled VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        discounts_no_days VARCHAR(256) DEFAULT '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0' COLLATE utf8_unicode_ci NOT NULL,
                                        deposit FLOAT DEFAULT 0 NOT NULL,
                                        form int DEFAULT 1 NOT NULL,
                                        instant_booking VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        no_people_enabled VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        min_no_people INT DEFAULT 1 NOT NULL,
                                        max_no_people INT DEFAULT 4 NOT NULL,
                                        no_children_enabled VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        min_no_children INT DEFAULT 0 NOT NULL,
                                        max_no_children INT DEFAULT 2 NOT NULL,
                                        terms_and_conditions_enabled VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        terms_and_conditions_link VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        payment_arrival_enabled VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        payment_paypal_enabled VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        payment_paypal_username VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        payment_paypal_password VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        payment_paypal_signature VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        payment_paypal_credit_card VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        payment_paypal_sandbox_enabled VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        max_year INT DEFAULT ".date('Y')." NOT NULL,
                                        UNIQUE KEY id (id)
                                    );";

                    $sql_calendars = "CREATE TABLE " . DOPBSP_Calendars_table . " (
                                        id INT NOT NULL AUTO_INCREMENT,
                                        user_id INT DEFAULT 0 NOT NULL,
                                        post_id INT DEFAULT 0 NOT NULL,
                                        name VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        min_price FLOAT DEFAULT 0 NOT NULL,
                                        max_price FLOAT DEFAULT 0 NOT NULL,
                                        availability TEXT COLLATE utf8_unicode_ci NOT NULL,
                                        UNIQUE KEY id (id)
                                    );";


                    $sql_days = "CREATE TABLE " . DOPBSP_Days_table . " (
                                        calendar_id INT DEFAULT 0 NOT NULL,
                                        day VARCHAR(16) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        year INT DEFAULT ".date('Y')." NOT NULL,
                                        data TEXT COLLATE utf8_unicode_ci NOT NULL
                                    );";

                    $sql_reservations = "CREATE TABLE " . DOPBSP_Reservations_table . " (
                                        id INT NOT NULL AUTO_INCREMENT,
                                        calendar_id INT DEFAULT 0 NOT NULL,
                                        check_in VARCHAR(16) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        check_out VARCHAR(16) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        start_hour VARCHAR(16) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        end_hour VARCHAR(16) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        no_items INT DEFAULT 1 NOT NULL,
                                        currency VARCHAR(8) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        currency_code VARCHAR(8) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        total_price FLOAT DEFAULT 0 NOT NULL,
                                        discount FLOAT DEFAULT 0 NOT NULL,
                                        price FLOAT DEFAULT 0 NOT NULL,
                                        deposit FLOAT DEFAULT 0 NOT NULL,
                                        language VARCHAR(8) DEFAULT 'en' COLLATE utf8_unicode_ci NOT NULL,
                                        email VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        no_people INT DEFAULT 1 NOT NULL,
                                        no_children INT DEFAULT 0 NOT NULL,
                                        payment_method INT DEFAULT 0 NOT NULL, 
                                        paypal_transaction_id VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL, 
                                        status VARCHAR(16) DEFAULT 'pending' COLLATE utf8_unicode_ci NOT NULL,
                                        info TEXT COLLATE utf8_unicode_ci NOT NULL,
                                        date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                                        UNIQUE KEY id (id)
                                    );";

                    $sql_users = "CREATE TABLE " . DOPBSP_Users_table . " (
                                        id INT NOT NULL AUTO_INCREMENT,
                                        user_id INT DEFAULT 0 NOT NULL,
                                        type VARCHAR(16) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        view VARCHAR(6) DEFAULT 'true' COLLATE utf8_unicode_ci NOT NULL,
                                        view_all VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        view_custom_posts VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        admin_calendars TEXT COLLATE utf8_unicode_ci NOT NULL,
                                        UNIQUE KEY id (id)
                                    );";
                    
                    $sql_forms = "CREATE TABLE " . DOPBSP_Forms_table . " (
                                        id INT NOT NULL AUTO_INCREMENT,
                                        user_id INT DEFAULT 0 NOT NULL,
                                        name VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        UNIQUE KEY id (id)
                                    );";
                    
                    $sql_forms_fields = "CREATE TABLE " . DOPBSP_Forms_Fields_table . " (
                                        id INT NOT NULL AUTO_INCREMENT,
                                        form_id INT DEFAULT 0 NOT NULL,
                                        type VARCHAR(20) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                                        position INT DEFAULT 0 NOT NULL,
                                        multiple_select VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        allowed_characters TEXT COLLATE utf8_unicode_ci NOT NULL,
                                        size INT DEFAULT 0 NOT NULL,
                                        is_email VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        required VARCHAR(6) DEFAULT 'false' COLLATE utf8_unicode_ci NOT NULL,
                                        translation TEXT COLLATE utf8_unicode_ci NOT NULL,
                                        UNIQUE KEY id (id)
                                    );";
                    
                    $sql_forms_select_options = "CREATE TABLE " . DOPBSP_Forms_Select_Options_table . " (
                                        id INT NOT NULL AUTO_INCREMENT,
                                        field_id INT DEFAULT 0 NOT NULL,
                                        translation TEXT COLLATE utf8_unicode_ci NOT NULL,
                                        UNIQUE KEY id (id)
                                    );";

                    dbDelta($sql_settings);
                    dbDelta($sql_calendars);
                    dbDelta($sql_days);
                    dbDelta($sql_reservations);
                    dbDelta($sql_users);
                    dbDelta($sql_forms);
                    dbDelta($sql_forms_fields);
                    dbDelta($sql_forms_select_options);

                    if ($current_db_version == ''){
                        add_option('DOPBSP_db_version', $this->DOPBSP_db_version);
                    }
                    else{
                        update_option('DOPBSP_db_version', $this->DOPBSP_db_version);
                    }
                    
                    if (get_option('DOPBSP_administrators_permissions') == ''){add_option('DOPBSP_administrators_permissions', 0);}
                    if (get_option('DOPBSP_authors_permissions') == ''){add_option('DOPBSP_authors_permissions', 0);}
                    if (get_option('DOPBSP_contributors_permissions') == ''){add_option('DOPBSP_contributors_permissions', 0);}
                    if (get_option('DOPBSP_editors_permissions') == ''){add_option('DOPBSP_editors_permissions', 0);}
                    if (get_option('DOPBSP_subscribers_permissions') == ''){add_option('DOPBSP_subscribers_permissions', 0);}
                
                    if (get_option('DOPBSP_administrators_custom_posts_permissions') == ''){add_option('DOPBSP_administrators_custom_posts_permissions', 1);}
                    if (get_option('DOPBSP_authors_custom_posts_permissions') == ''){add_option('DOPBSP_authors_custom_posts_permissions', 1);}
                    if (get_option('DOPBSP_contributors_custom_posts_permissions') == ''){add_option('DOPBSP_contributors_custom_posts_permissions', 1);}
                    if (get_option('DOPBSP_editors_custom_posts_permissions') == ''){add_option('DOPBSP_editors_custom_posts_permissions', 1);}
                    if (get_option('DOPBSP_subscribers_custom_posts_permissions') == ''){add_option('DOPBSP_subscribers_custom_posts_permissions', 1);}
                    
                    $this->initTablesData();
                }
                $this->updateUsers();
            }
            
            function initTablesData(){
                global $wpdb;

                $settings = $wpdb->get_results('SELECT * FROM '.DOPBSP_Forms_table.' WHERE id=1');
                
                if ($wpdb->num_rows == 0){
                    dbDelta($wpdb->insert(DOPBSP_Forms_table, array('id' => 1,
                                                                    'user_id' => 0,
                                                                    'name' => DOPBSP_BOOKING_FORM_NAME_DEFAULT)));
                    
                    dbDelta($wpdb->insert(DOPBSP_Forms_Fields_table, array('id' => 1,
                                                                           'form_id' => 1,
                                                                           'type' => 'text',
                                                                           'position' => 1,
                                                                           'multiple_select' => 'false',
                                                                           'allowed_characters' => '',
                                                                           'size' => 0,
                                                                           'is_email' => 'false',
                                                                           'required' => 'true',
                                                                           'translation' => '{"af": "First Name","al": "First Name","ar": "First Name","az": "First Name","bs": "First Name","by": "First Name","bg": "First Name","ca": "First Name","cn": "First Name","cr": "First Name","cz": "First Name","dk": "First Name","du": "First Name","en": "First Name","eo": "First Name","et": "First Name","fl": "First Name","fi": "First Name","fr": "First Name","gl": "First Name","de": "First Name","gr": "First Name","ha": "First Name","he": "First Name","hi": "First Name","hu": "First Name","is": "First Name","id": "First Name","ir": "First Name","it": "First Name","ja": "First Name","ko": "First Name","lv": "First Name","lt": "First Name","mk": "First Name","mg": "First Name","ma": "First Name","no": "First Name","pe": "First Name","pl": "First Name","pt": "First Name","ro": "First Name","ru": "First Name","sr": "First Name","sk": "First Name","sl": "First Name","sp": "First Name","sw": "First Name","se": "First Name","th": "First Name","tr": "First Name","uk": "First Name","ur": "First Name","vi": "First Name","we": "First Name","yi": "First Name"}')));
                    dbDelta($wpdb->insert(DOPBSP_Forms_Fields_table, array('id' => 2,
                                                                           'form_id' => 1,
                                                                           'type' => 'text',
                                                                           'position' => 2,
                                                                           'multiple_select' => 'false',
                                                                           'allowed_characters' => '',
                                                                           'size' => 0,
                                                                           'is_email' => 'false',
                                                                           'required' => 'true',
                                                                           'translation' => '{"af": "Last Name","al": "Last Name","ar": "Last Name","az": "Last Name","bs": "Last Name","by": "Last Name","bg": "Last Name","ca": "Last Name","cn": "Last Name","cr": "Last Name","cz": "Last Name","dk": "Last Name","du": "Last Name","en": "Last Name","eo": "Last Name","et": "Last Name","fl": "Last Name","fi": "Last Name","fr": "Last Name","gl": "Last Name","de": "Last Name","gr": "Last Name","ha": "Last Name","he": "Last Name","hi": "Last Name","hu": "Last Name","is": "Last Name","id": "Last Name","ir": "Last Name","it": "Last Name","ja": "Last Name","ko": "Last Name","lv": "Last Name","lt": "Last Name","mk": "Last Name","mg": "Last Name","ma": "Last Name","no": "Last Name","pe": "Last Name","pl": "Last Name","pt": "Last Name","ro": "Last Name","ru": "Last Name","sr": "Last Name","sk": "Last Name","sl": "Last Name","sp": "Last Name","sw": "Last Name","se": "Last Name","th": "Last Name","tr": "Last Name","uk": "Last Name","ur": "Last Name","vi": "Last Name","we": "Last Name","yi": "Last Name"}')));
                    dbDelta($wpdb->insert(DOPBSP_Forms_Fields_table, array('id' => 3,
                                                                           'form_id' => 1,
                                                                           'type' => 'text',
                                                                           'position' => 3,
                                                                           'multiple_select' => 'false',
                                                                           'allowed_characters' => '',
                                                                           'size' => 0,
                                                                           'is_email' => 'true',
                                                                           'required' => 'true',
                                                                           'translation' => '{"af": "Email","al": "Email","ar": "Email","az": "Email","bs": "Email","by": "Email","bg": "Email","ca": "Email","cn": "Email","cr": "Email","cz": "Email","dk": "Email","du": "Email","en": "Email","eo": "Email","et": "Email","fl": "Email","fi": "Email","fr": "Email","gl": "Email","de": "Email","gr": "Email","ha": "Email","he": "Email","hi": "Email","hu": "Email","is": "Email","id": "Email","ir": "Email","it": "Email","ja": "Email","ko": "Email","lv": "Email","lt": "Email","mk": "Email","mg": "Email","ma": "Email","no": "Email","pe": "Email","pl": "Email","pt": "Email","ro": "Email","ru": "Email","sr": "Email","sk": "Email","sl": "Email","sp": "Email","sw": "Email","se": "Email","th": "Email","tr": "Email","uk": "Email","ur": "Email","vi": "Email","we": "Email","yi": "Email"}')));
                    dbDelta($wpdb->insert(DOPBSP_Forms_Fields_table, array('id' => 4,
                                                                           'form_id' => 1,
                                                                           'type' => 'text',
                                                                           'position' => 4,
                                                                           'multiple_select' => 'false',
                                                                           'allowed_characters' => '0123456789+-().',
                                                                           'size' => 0,
                                                                           'is_email' => 'false',
                                                                           'required' => 'true',
                                                                           'translation' => '{"af": "Phone","al": "Phone","ar": "Phone","az": "Phone","bs": "Phone","by": "Phone","bg": "Phone","ca": "Phone","cn": "Phone","cr": "Phone","cz": "Phone","dk": "Phone","du": "Phone","en": "Phone","eo": "Phone","et": "Phone","fl": "Phone","fi": "Phone","fr": "Phone","gl": "Phone","de": "Phone","gr": "Phone","ha": "Phone","he": "Phone","hi": "Phone","hu": "Phone","is": "Phone","id": "Phone","ir": "Phone","it": "Phone","ja": "Phone","ko": "Phone","lv": "Phone","lt": "Phone","mk": "Phone","mg": "Phone","ma": "Phone","no": "Phone","pe": "Phone","pl": "Phone","pt": "Phone","ro": "Phone","ru": "Phone","sr": "Phone","sk": "Phone","sl": "Phone","sp": "Phone","sw": "Phone","se": "Phone","th": "Phone","tr": "Phone","uk": "Phone","ur": "Phone","vi": "Phone","we": "Phone","yi": "Phone"}')));
                    dbDelta($wpdb->insert(DOPBSP_Forms_Fields_table, array('id' => 5,
                                                                           'form_id' => 1,
                                                                           'type' => 'textarea',
                                                                           'position' => 5,
                                                                           'multiple_select' => 'false',
                                                                           'allowed_characters' => '',
                                                                           'size' => 0,
                                                                           'is_email' => 'false',
                                                                           'required' => 'true',
                                                                           'translation' => '{"af": "Message","al": "Message","ar": "Message","az": "Message","bs": "Message","by": "Message","bg": "Message","ca": "Message","cn": "Message","cr": "Message","cz": "Message","dk": "Message","du": "Message","en": "Message","eo": "Message","et": "Message","fl": "Message","fi": "Message","fr": "Message","gl": "Message","de": "Message","gr": "Message","ha": "Message","he": "Message","hi": "Message","hu": "Message","is": "Message","id": "Message","ir": "Message","it": "Message","ja": "Message","ko": "Message","lv": "Message","lt": "Message","mk": "Message","mg": "Message","ma": "Message","no": "Message","pe": "Message","pl": "Message","pt": "Message","ro": "Message","ru": "Message","sr": "Message","sk": "Message","sl": "Message","sp": "Message","sw": "Message","se": "Message","th": "Message","tr": "Message","uk": "Message","ur": "Message","vi": "Message","we": "Message","yi": "Message"}')));
                }
            }

// Pages            
            function printAdminPage(){// Prints out the admin page.
                $this->DOPBSP_AddEditCalendars->calendarsList();
            }
            
            function printSettingsPage(){// Prints out the settings page.
                $this->DOPBSP_AddEditCalendars->settings();
            }
            
            function printSettingsUsersPermissions(){// Prints out the User Permissions page.
                $this->DOPBSP_AddEditCalendars = new DOPBSPTemplates();
                $this->DOPBSP_AddEditCalendars->settingsUsersPermissions();
                
                die();
            }
            
            function printSettingsUsersCustomPostsPermissions(){// Prints out the User Permissions page.
                $this->DOPBSP_AddEditCalendars = new DOPBSPTemplates();
                $this->DOPBSP_AddEditCalendars->settingsUsersCustomPostsPermissions();
                
                die();
            }
            
// Change Translation
            function changeTranslation(){
                $current_backend_language = get_option('DOPBSP_backend_language_'.wp_get_current_user()->ID);
                
                if ($current_backend_language == ''){
                    add_option('DOPBSP_backend_language_'.wp_get_current_user()->ID, 'en');
                }
                else{
                    update_option('DOPBSP_backend_language_'.wp_get_current_user()->ID, $_POST['language']);
                }
                
                die();
            }

// Calendars            
            function showCalendars(){// Show Calendars List.
                global $wpdb;
                                    
                $calendarsHTML = array();
                $noCalendars = 0;
                array_push($calendarsHTML, '<ul>');
                
                //array_push($calendarsHTML,$_GET['post'].$_GET['action']); die();
                if (!isset($_GET['post'])){
                    if ($this->administratorHasPermissions(wp_get_current_user()->ID)){
                        $calendars = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' ORDER BY id DESC');
                        $noCalendars = $wpdb->num_rows;

                    }
                    else{
                        if ($this->userHasPermissions(wp_get_current_user()->ID)){
                            $calendars = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE user_id="'.wp_get_current_user()->ID.'" ORDER BY id DESC');
                        }

                        if ($this->userCalendarsIds(wp_get_current_user()->ID)){
                            $calendarsIds = explode(',', $this->userCalendarsIds(wp_get_current_user()->ID));
                            $calendarlist = '';
                            $calendarsfound = array();
                            $i=0;

                            foreach($calendarsIds as $calendarId){
                                if ($calendarId){
                                    if ($i < 1){
                                        $calendarlist .= $calendarId;
                                    }
                                    else{
                                      $calendarlist .= ", ".$calendarId;  
                                    }

                                    array_push($calendarsfound, $calendarId);
                                    $i++;
                                }
                            }


                            //echo $calendarlist; die();

                            if ($calendarlist){
                               $calendars_assigned = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE id IN ('.$calendarlist.') ORDER BY id DESC');   
                            }
                        }
                        else{
                            $calendars_assigned = $calendars;
                        }
                    }
                }
                
                if ($noCalendars != 0 || (isset($calendars_assigned) && count($calendars_assigned) != 0)){
                    if ($calendars){
                        foreach ($calendars as $calendar){
                            if (isset($calendarsfound)){
                                if (!in_array($calendar->id, $calendarsfound)){
                                    array_push($calendarsHTML, '<li class="item" id="DOPBSP-ID-'.$calendar->id.'"><span class="id">ID '.$calendar->id.':</span> <span class="name">'.$this->shortName($calendar->name, 25).'</span></li>');
                                }
                            }
                            
                            if($this->administratorHasPermissions(wp_get_current_user()->ID)){
                              array_push($calendarsHTML, '<li class="item" id="DOPBSP-ID-'.$calendar->id.'"><span class="id">ID '.$calendar->id.':</span> <span class="name">'.$this->shortName($calendar->name, 25).'</span></li>');  
                            }
                        }
                    }
                    
                    if (isset($calendars_assigned)){
                        foreach ($calendars_assigned as $calendar) {
                            array_push($calendarsHTML, '<li class="item" id="DOPBSP-ID-'.$calendar->id.'"><span class="id">ID '.$calendar->id.':</span> <span class="name">'.$this->shortName($calendar->name, 25).'</span></li>');
                        }
                    }
                   
                }
                else{
                    array_push($calendarsHTML, '<li class="no-data">'.DOPBSP_NO_CALENDARS.'</li>');
                }
                
                array_push($calendarsHTML, '</ul>');
                echo implode('', $calendarsHTML);
                
            	die();                
            }
        
            function addCalendar(){// Add Calendar.
                global $wpdb;
                                
                $wpdb->insert(DOPBSP_Calendars_table, array('user_id' => wp_get_current_user()->ID,
                                                            'name' => DOPBSP_ADD_CALENDAR_NAME,
                                                            'availability' => ''));
                $wpdb->insert(DOPBSP_Settings_table, array('calendar_id' => $wpdb->insert_id,
                                                           'hours_definitions' => '[{"value": "00:00"}]'));                                
                $this->showCalendars();

            	die();
            }
            
            function showCalendarId(){
                global $wpdb;
                $calendar = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE post_id="'.$_POST['post_id'].'" ORDER BY id');
                echo $calendar[0]->id.';;;;;'.$calendar[0]->name;
                die();
            }

            function showCalendar(){// Show Calendar.
                if (isset($_POST['calendar_id'])){
                    global $wpdb;
                    global $DOPBSP_currencies;
                    global $DOPBSP_month_names;
                    global $DOPBSP_day_names;
                    $data = array();
                    
                    $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                                        
                    $data = array('AddLastHourToTotalPrice' => $settings->last_hour_to_total_price,
                                  'AddtMonthViewText' => DOPBSP_ADD_MONTH_VIEW,
                                  'AvailableDays' => explode(',', $settings->available_days),
                                  'AvailableLabel' => DOPBSP_AVAILABLE_LABEL,
                                  'AvailableOneText' => DOPBSP_AVAILABLE_ONE_TEXT,
                                  'AvailableText' => DOPBSP_AVAILABLE_TEXT,
                                  'BookedText' => DOPBSP_BOOKED_TEXT,
                                  'Currency' => $DOPBSP_currencies[(int)$settings->currency-1]['sign'],
                                  'DateEndLabel' => DOPBSP_DATE_END_LABEL,
                                  'DateStartLabel' => DOPBSP_DATE_START_LABEL,
                                  'DateType' => 1,
                                  'DayNames' => $DOPBSP_day_names,
                                  'DetailsFromHours' => $settings->details_from_hours,
                                  'FirstDay' => $settings->first_day,
                                  'HoursEnabled' => $settings->hours_enabled,
                                  'GroupDaysLabel' => DOPBSP_GROUP_DAYS_LABEL,
                                  'GroupHoursLabel' => DOPBSP_GROUP_HOURS_LABEL,
                                  'HourEndLabel' => DOPBSP_HOURS_END_LABEL,
                                  'HourStartLabel' => DOPBSP_HOURS_START_LABEL,
                                  'HoursAMPM' => $settings->hours_ampm,
                                  'HoursDefinitions' => json_decode($settings->hours_definitions),
                                  'HoursDefinitionsChangeLabel' => DOPBSP_HOURS_DEFINITIONS_CHANGE_LABEL,
                                  'HoursDefinitionsLabel' => DOPBSP_HOURS_DEFINITIONS_LABEL,
                                  'HoursSetDefaultDataLabel' => DOPBSP_HOURS_SET_DEFAULT_DATA_LABEL, 
                                  'HoursIntervalEnabled' => $settings->hours_interval_enabled,
                                  'ID' => $_POST['calendar_id'],
                                  'InfoLabel' => DOPBSP_HOURS_INFO_LABEL,
                                  'MaxYear' => $settings->max_year,
                                  'MonthNames' => $DOPBSP_month_names,
                                  'NextMonthText' => DOPBSP_NEXT_MONTH,
                                  'NotesLabel' => DOPBSP_HOURS_NOTES_LABEL,
                                  'PreviousMonthText' => DOPBSP_PREVIOUS_MONTH,
                                  'PriceLabel' => DOPBSP_PRICE_LABEL,
                                  'PromoLabel' => DOPBSP_PROMO_LABEL,
                                  'RemoveMonthViewText' => DOPBSP_REMOVE_MONTH_VIEW,
                                  'ResetConfirmation' => DOPBSP_RESET_CONFIRMATION,
                                  'StatusAvailableText' => DOPBSP_STATUS_AVAILABLE_TEXT,
                                  'StatusBookedText' => DOPBSP_STATUS_BOOKED_TEXT,
                                  'StatusLabel' => DOPBSP_STATUS_LABEL,
                                  'StatusSpecialText' => DOPBSP_STATUS_SPECIAL_TEXT,
                                  'StatusUnavailableText' => DOPBSP_STATUS_UNAVAILABLE_TEXT,
                                  'UnavailableText' => DOPBSP_UNAVAILABLE_TEXT,
                                  'ViewOnly' => $settings->view_only);
                    
                    echo json_encode($data);

                    die();
                }
            }
            
            function loadSchedule(){// Load Calendar Data.
                if (isset($_POST['calendar_id'])){
                    global $wpdb;
                    $schedule = array();
                    
                    $this->cleanSchedule();
                    $days = $wpdb->get_results('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$_POST['calendar_id'].'" AND year="'.$_POST['year'].'"');
                    
                    foreach ($days as $day):
                        $schedule[$day->day] = json_decode($day->data);
                    endforeach;
                                            
                    if (count($schedule) > 0){
                        echo json_encode($schedule);
                    }
                    else{
                        echo '';
                    }

                    die();
                }                
            }
            
            function saveSchedule(){// Save Calendar Data.
                if (isset($_POST['calendar_id'])){
                    global $wpdb;
                    
                    $schedule = $_POST['schedule'];
                    $calendar_id = $_POST['calendar_id'];
                                        
                    while ($data = current($schedule)){
                        $day = key($schedule);
                        $day_items = explode('-', $day);
                        $result = $wpdb->get_results('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id='.$calendar_id.' AND day=\''.$day.'\'');
                                                
                        if ($wpdb->num_rows != 0){  
                            $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $calendar_id, 
                                                                                                        'day' => $day));
                        }
                        else{
                            $wpdb->insert(DOPBSP_Days_table, array('calendar_id' => $calendar_id,
                                                                   'day' => $day,
                                                                   'year' => $day_items[0],
                                                                   'data' => json_encode($data)));
                        }
                        
                        next($schedule);                        
                    }
                    
                    $max_year = $wpdb->get_row('SELECT MAX(year) AS year FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$calendar_id.'"');
                    
                    if ($max_year->year > 0){
                        $wpdb->update(DOPBSP_Settings_table, array('max_year' => $max_year->year), array('calendar_id' => $calendar_id));
                    }
                    else{
                        $wpdb->update(DOPBSP_Settings_table, array('max_year' => date('Y')), array('calendar_id' => $calendar_id));
                    }
                    
                    $this->setMinMaxAvailability($calendar_id);
                    
                    echo DOPBSP_EDIT_CALENDAR_SUCCESS;

                    die();
                }                
            }
            
            function deleteSchedule(){// Save Calendar Data.
                if (isset($_POST['calendar_id'])){
                    global $wpdb;
                    
                    $schedule = $_POST['schedule'];
                    $calendar_id = $_POST['calendar_id'];
                                        
                    while ($data = current($schedule)){
                        $day = key($schedule);
                        $wpdb->query('DELETE FROM '.DOPBSP_Days_table.' WHERE calendar_id='.$calendar_id.' AND day=\''.$day.'\'');                        
                        next($schedule);                        
                    }
                    
                    $max_year = $wpdb->get_row('SELECT MAX(year) AS year FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$calendar_id.'"'); 
                    
                    if ($max_year->year > 0){
                        $wpdb->update(DOPBSP_Settings_table, array('max_year' => $max_year->year), array('calendar_id' => $calendar_id));
                    }
                    else{
                        $wpdb->update(DOPBSP_Settings_table, array('max_year' => date('Y')), array('calendar_id' => $calendar_id));
                    }
                    
                    echo DOPBSP_EDIT_CALENDAR_SUCCESS;

                    die();
                }                
            }
            
            function cleanSchedule(){
                global $wpdb;
                $wpdb->query('DELETE FROM '.DOPBSP_Days_table.' WHERE day<\''.date('Y-m-d').'\'');
            }

            function showCalendarSettings(){// Show Calendar Info.
                global $wpdb;
                global $DOPBSP_pluginSeries_forms;
                $result = array();
                
                $calendar = $wpdb->get_row('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE id="'.$_POST['calendar_id'].'"');
                $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
  
                $result['name'] = $calendar->name;
                
                $result['available_days'] = $settings->available_days;
                $result['first_day'] = $settings->first_day;
                $result['currency'] = $settings->currency;
                $result['currencies_ids'] = $this->listCurrenciesIDs();
                $result['currencies_labels'] = $this->listCurrenciesLabels();
                $result['date_type'] = $settings->date_type;   
                $result['template'] = $settings->template;
                $result['templates'] = $this->listTemplates(); 
                $result['min_stay'] = $settings->min_stay;
                $result['max_stay'] = $settings->max_stay;
                $result['no_items_enabled'] = $settings->no_items_enabled;
                $result['view_only'] = $settings->view_only;
                $result['page_url'] = $settings->page_url;
                $result['template_email'] = $settings->template_email;
                $result['templates_email'] = $this->listEmailTemplates();  
                $result['notifications_email'] = $settings->notifications_email;  
                $result['smtp_enabled'] = $settings->smtp_enabled;
                $result['smtp_host_name'] = $settings->smtp_host_name;
                $result['smtp_host_port'] = $settings->smtp_host_port;
                $result['smtp_ssl'] = $settings->smtp_ssl;
                $result['smtp_user'] = $settings->smtp_user;
                $result['smtp_password'] = $settings->smtp_password;
                $result['multiple_days_select'] = $settings->multiple_days_select;
                $result['morning_check_out'] = $settings->morning_check_out;
                $result['details_from_hours'] = $settings->details_from_hours;
                $result['hours_enabled'] = $settings->hours_enabled;
                $result['hours_info_enabled'] = $settings->hours_info_enabled;
                $result['hours_definitions'] = json_decode($settings->hours_definitions);
                $result['multiple_hours_select'] = $settings->multiple_hours_select;
                $result['hours_ampm'] = $settings->hours_ampm;
                $result['last_hour_to_total_price'] = $settings->last_hour_to_total_price;
                $result['hours_interval_enabled'] = $settings->hours_interval_enabled;
                $result['discounts_no_days'] = $settings->discounts_no_days;
                $result['deposit'] = $settings->deposit;
                $result['form'] = $settings->form;
                $result['forms'] = $DOPBSP_pluginSeries_forms->listForms();
                $result['instant_booking'] = $settings->instant_booking;
                $result['no_people_enabled'] = $settings->no_people_enabled;
                $result['min_no_people'] = $settings->min_no_people;
                $result['max_no_people'] = $settings->max_no_people;
                $result['no_children_enabled'] = $settings->no_children_enabled;
                $result['min_no_children'] = $settings->min_no_children;
                $result['max_no_children'] = $settings->max_no_children;
                $result['terms_and_conditions_enabled'] = $settings->terms_and_conditions_enabled;
                $result['terms_and_conditions_link'] = $settings->terms_and_conditions_link;
                $result['payment_arrival_enabled'] = $settings->payment_arrival_enabled;
                $result['payment_paypal_enabled'] = $settings->payment_paypal_enabled;  
                $result['payment_paypal_username'] = $settings->payment_paypal_username;   
                $result['payment_paypal_password'] = $settings->payment_paypal_password;   
                $result['payment_paypal_signature'] = $settings->payment_paypal_signature;  
                $result['payment_paypal_credit_card'] = $settings->payment_paypal_credit_card;
                $result['payment_paypal_sandbox_enabled'] = $settings->payment_paypal_sandbox_enabled;                           
                                            
                echo json_encode($result);
            	die();
            }
            
            function calendarUsersPermissions(){// Show Calendar Info.
                global $wpdb;
                $result = array();
                                
                $users_authors = get_users('orderby=nicename&role=author');
                $users_contributors = get_users('orderby=nicename&role=contributor');
                $users_editors = get_users('orderby=nicename&role=editor');
                $users_subscribers = get_users('orderby=nicename&role=subscriber');
                $word = ",".$_POST['calendar_id'];
                $i=0;
                
                foreach ($users_authors as $author){
                    $i++;
                    $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$author->ID);
                    $result['author'][$i]['id'] = $author->ID;
                    $result['author'][$i]['name'] = $author->user_nicename;
                    $result['author'][$i]['admin_calendars'] = $user_permissions->admin_calendars;
                    
                    if (strpos($user_permissions->admin_calendars,$word) !== false) {
                        $result['author'][$i]['checked'] = 1;
                    }
                    else {
                        $result['author'][$i]['checked'] = 0;
                    }
                    $result['authors'] = $i;
                    
                    $result['admin_cal'][$i] = $user_permissions->admin_calendars;
                }
                $i=0;
                
                foreach ($users_contributors as $contributor){
                    $i++;
                    $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$contributor->ID);
                    $result['contributor'][$i]['id'] = $contributor->ID;
                    $result['contributor'][$i]['name'] = $contributor->user_nicename;
                    $result['contributor'][$i]['admin_calendars'] = $user_permissions->admin_calendars;
                    
                    if (strpos($user_permissions->admin_calendars,$word) !== false) {
                        $result['contributor'][$i]['checked'] = 1;
                    }
                    else {
                        $result['contributor'][$i]['checked'] = 0;
                    }
                    $result['contributors'] = $i;
                }
                $i=0;
                
                foreach ($users_editors as $editor){
                    $i++;
                    $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$editor->ID);
                    $result['editor'][$i]['id'] = $editor->ID;
                    $result['editor'][$i]['name'] = $editor->user_nicename;
                    $result['editor'][$i]['admin_calendars'] = $user_permissions->admin_calendars;
                    
                    if (strpos($user_permissions->admin_calendars,$word) !== false) {
                        $result['editor'][$i]['checked'] = 1;
                    }
                    else {
                        $result['editor'][$i]['checked'] = 0;
                    }
                    $result['editors'] = $i;
                }
                $i=0;
                
                foreach ($users_subscribers as $subscriber){
                    $i++;
                    $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$subscriber->ID);
                    $result['subscriber'][$i]['id'] = $subscriber->ID;
                    $result['subscriber'][$i]['name'] = $subscriber->user_nicename;
                    $result['subscriber'][$i]['admin_calendars'] = $user_permissions->admin_calendars;
                    
                    if (strpos($user_permissions->admin_calendars,$word) !== false) {
                        $result['subscriber'][$i]['checked'] = 1;
                    }
                    else {
                        $result['subscriber'][$i]['checked'] = 0;
                    }
                    $result['subscribers'] = $i;
                }
                $result['calendar_id'] = $_POST['calendar_id'];
                                            
                echo json_encode($result);
            	die();
            }
            
            function calendarUsersPermissionsUpdate(){// Update Calendar Users Permissions
                global $wpdb;
                $admin_calendars = $_POST['admin_calendars'];
                $calendar_id = $_POST['calendar_id'];
                $users = explode(',', $admin_calendars);
                
                for ($i=1; $i<=count($users); $i++){
                    $user_pieces = explode('-', $users[$i]);
                    $user_id = $user_pieces[0];
                    $user_status = (int)$user_pieces[1];
                    
                    $user = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id="'.$user_id.'"');
                    $new_admin_calendars = $user->admin_calendars;
                        
                    if (strpos($user->admin_calendars, ','.$_POST['calendar_id']) !== false){
                        if ($user_status < 1){
                            $new_admin_calendars = str_replace(','.$_POST['calendar_id'], '', $new_admin_calendars);
                        }
                    }
                    else{
                        if ($user_status > 0){
                            $new_admin_calendars .= ",".$_POST['calendar_id'];
                        }
                    }
                    $wpdb->update(DOPBSP_Users_table, array('admin_calendars' => $new_admin_calendars), array(user_id => $user_id));
                }
                
                die();
            }
            
            function editCalendar(){// Edit Calendar Settings.
                global $wpdb;
                
                $settings = array('available_days' => $_POST['available_days'],
                                  'first_day' => $_POST['first_day'],
                                  'currency' => $_POST['currency'],
                                  'date_type' => $_POST['date_type'],
                                  'template' => $_POST['template'],
                                  'min_stay' => $_POST['min_stay'],
                                  'max_stay' => $_POST['max_stay'],
                                  'no_items_enabled' => $_POST['no_items_enabled'],
                                  'view_only' => $_POST['view_only'],
                                  'page_url' => $_POST['page_url'],
                                  'template_email' => $_POST['template_email'],
                                  'notifications_email' => $_POST['notifications_email'],
                                  'smtp_enabled' => $_POST['smtp_enabled'],
                                  'smtp_host_name' => $_POST['smtp_host_name'],
                                  'smtp_host_port' => $_POST['smtp_host_port'],
                                  'smtp_ssl' => $_POST['smtp_ssl'],
                                  'smtp_user' => $_POST['smtp_user'],
                                  'smtp_password' => $_POST['smtp_password'],
                                  'multiple_days_select' => $_POST['multiple_days_select'],
                                  'morning_check_out' => $_POST['morning_check_out'],
                                  'details_from_hours' => $_POST['details_from_hours'],
                                  'hours_enabled' => $_POST['hours_enabled'],
                                  'hours_info_enabled' => $_POST['hours_info_enabled'],
                                  'hours_definitions' => json_encode($_POST['hours_definitions']),
                                  'multiple_hours_select' => $_POST['multiple_hours_select'],
                                  'hours_ampm' => $_POST['hours_ampm'],
                                  'last_hour_to_total_price' => $_POST['last_hour_to_total_price'],
                                  'hours_interval_enabled' => $_POST['hours_interval_enabled'],
                                  'discounts_no_days' => $_POST['discounts_no_days'],
                                  'deposit' => $_POST['deposit'],
                                  'form' => $_POST['form'],
                                  'instant_booking' => $_POST['instant_booking'],
                                  'no_people_enabled' => $_POST['no_people_enabled'],
                                  'min_no_people' => $_POST['min_no_people'],
                                  'max_no_people' => $_POST['max_no_people'],
                                  'no_children_enabled' => $_POST['no_children_enabled'],
                                  'min_no_children' => $_POST['min_no_children'],
                                  'max_no_children' => $_POST['max_no_children'],
                                  'terms_and_conditions_enabled' => $_POST['terms_and_conditions_enabled'],
                                  'terms_and_conditions_link' => $_POST['terms_and_conditions_link'],
                                  'payment_arrival_enabled' => $_POST['payment_arrival_enabled'],
                                  'payment_paypal_enabled' => $_POST['payment_paypal_enabled'],
                                  'payment_paypal_username' => $_POST['payment_paypal_username'],
                                  'payment_paypal_password' => $_POST['payment_paypal_password'],
                                  'payment_paypal_signature' => $_POST['payment_paypal_signature'],
                                  'payment_paypal_credit_card' => $_POST['payment_paypal_credit_card'],
                                  'payment_paypal_sandbox_enabled' => $_POST['payment_paypal_sandbox_enabled']);     
                
                $wpdb->update(DOPBSP_Calendars_table, array('name' => $_POST['name']), array(id => $_POST['calendar_id']));
                $wpdb->update(DOPBSP_Settings_table, $settings, array('calendar_id' => $_POST['calendar_id']));
                
                echo '';
                
            	die();
            }

            function deleteCalendar(){// Delete Calendar.
                global $wpdb;

                $wpdb->query('DELETE FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['id'].'"');
                $wpdb->query('DELETE FROM '.DOPBSP_Calendars_table.' WHERE id="'.$_POST['id'].'"');
                $wpdb->query('DELETE FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$_POST['id'].'"');
                $wpdb->query('DELETE FROM '.DOPBSP_Reservations_table.' WHERE calendar_id="'.$_POST['id'].'"');
                
                $calendars = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }

            function setMinMaxAvailability($calendar_id){
                global $wpdb;
                $min = 1000000000;
                $max = 0;
                $start_date = '';  
                $end_date = '';  
                $availability = array();

                $this->cleanSchedule();
                $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$calendar_id.'"');
                $days = $wpdb->get_results('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$calendar_id.'" ORDER BY day');

                foreach ($days as $day):
                    $day_data = json_decode($day->data);
                    
                    if ($settings->hours_enabled == 'false'){
                        if ($day_data->promo != ''){
                            if ($min > $day_data->promo){
                                $min = $day_data->promo;
                            }

                            if ($max < $day_data->promo){
                                $max = $day_data->promo;
                            }
                        }
                        else{
                            if ($day_data->price != ''){
                                if ($min > $day_data->price){
                                    $min = $day_data->price;
                                }

                                if ($max < $day_data->price){
                                    $max = $day_data->price;
                                }
                            }
                        }
                        
                        if ($day_data->status == 'available' || $day_data->status == 'special'){
                            if ($start_date == ''){
                                $start_date = $day->day;   
                            }

                            if ($end_date == ''){
                                $end_date = $day->day;
                            }

                            if ($end_date < $day->day && $day->day == date('Y-m-d', strtotime($end_date.' +1 day'))){
                                $end_date = $day->day;
                            }
                            else if ($end_date != $day->day){
                                array_push($availability, array("start-date" => $start_date,
                                                                "end-date" => $end_date));
                                
                                if ($day_data->status == 'available' || $day_data->status == 'special'){
                                    $start_date = $day->day; 
                                    $end_date = $day->day;
                                }
                                else{
                                    $start_date = ''; 
                                    $end_date = '';
                                }
                            }
                        }
                    }
                    else{
                        $start_hour = '';  
                        $end_hour = '';
                        $hours_availability = array();
                            
                        foreach ($day_data->hours as $key => $hour):
                            if ($hour->promo != ''){
                                if ($min > $hour->promo){
                                    $min = $hour->promo;
                                }

                                if ($max < $hour->promo){
                                    $max = $hour->promo;
                                }
                            }
                            else{
                                if ($hour->price != ''){
                                    if ($min > $hour->price){
                                        $min = $hour->price;
                                    }

                                    if ($max < $hour->price){
                                        $max = $hour->price;
                                    }
                                }
                            }
                            
                            if ($hour->status == 'available' || $hour->status == 'special'){
                                if ($start_hour == ''){
                                    $start_hour = $key;   
                                }

                                if ($end_hour == ''){
                                    $end_hour = $key;
                                }

                                if ($end_hour < $key && $key == $this->nextHour($end_hour, $day_data->hours_definitions)){
                                    $end_hour = $key;
                                }
                                else if ($end_hour != $key){
                                    array_push($hours_availability, array("start-hour" => $start_hour,
                                                                          "end-hour" => $end_hour));

                                    if ($hour->status == 'available' || $hour->status == 'special'){
                                        $start_hour = $key;
                                        $end_hour = $key;
                                    }
                                    else{
                                        $start_hour = '';
                                        $end_hour = '';
                                    }
                                }
                            }
                        endforeach;
                        
                        if ($start_hour != '' && $end_hour != ''){
                            array_push($hours_availability, array("start-hour" => $start_hour,
                                                                  "end-hour" => $end_hour));
                        }
                        
                        if (count($hours_availability) > 0){
                            array_push($availability, array("date" => $day->day,
                                                            "hours" => $hours_availability));
                        }
                    }
                endforeach;
                
                if ($settings->hours_enabled == 'false' && $start_date != '' && $end_date != ''){
                    array_push($availability, array("start-date" => $start_date,
                                                    "end-date" => $end_date));
                }
                
                $data = array('min_price' => $min,
                              'max_price' => $max,
                              'availability' => json_encode($availability));
                $wpdb->update(DOPBSP_Calendars_table, $data, array('calendar_id' => $calendar_id));
            }
            
            function nextHour($hour, $hours){
                $next_hour = '24:00';
                        
                for ($i=count($hours)-1; $i>=0; $i--){
                    if ($hours[$i]->value > $hour){
                        $next_hour = $hours[$i]->value;
                    }
                }
                
                return $next_hour;
            }
            
// Custom Post Type
            function initCustomPostsType(){ // Init Custom Post Type
                global $wpdb;
                global $current_user;
                $current_user = wp_get_current_user();
                
                if (isset($current_user->data->ID)){
                    $user_permissions = $wpdb->get_results('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$current_user->data->ID);

                    if ($user_permissions[0]->view_custom_posts == 'true'){
                        $postdata = array('exclude_from_search' => false,
                                          'has_archive' => true,
                                          'labels' => array('name' => DOPBSP_CUSTOM_POSTS_TYPE,
                                                            'singular_name' => DOPBSP_CUSTOM_POSTS_TYPE,
                                                            'menu_name' => DOPBSP_CUSTOM_POSTS_TYPE,
                                                            'all_items' => DOPBSP_CUSTOM_POSTS_TYPE_ADD_NEW_ITEM_ALL_ITEMS,
                                                            'add_new_item' => DOPBSP_CUSTOM_POSTS_TYPE_ADD_NEW_ITEM,
                                                            'edit_item' => DOPBSP_CUSTOM_POSTS_TYPE_EDIT_ITEM),
                                          'menu_icon' => plugins_url('assets/gui/images/custom-post-type-icon.png', __FILE__),
                                          'public' => true,
                                          'publicly_queryable' => true,
                                          'rewrite' => array('slug' => 'booking'),
                                          'taxonomies' => array('category', 'post_tag'),
                                          'show_in_nav_menus' => true,
                                          'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions'));
                        register_post_type('dopbsp', $postdata);
                        flush_rewrite_rules();
                    }
                }
            }
            
            function customPostTypeMetaBoxes($post){ // Generate Custom Post Type Meta Box
                global $wpdb;
                global $current_user;
                $current_user = wp_get_current_user();
                
                if ($post->post_status == "publish"){
                    $meta = array('id' => 'dopsbsp-custom-post-meta',
                                  'title' => DOPBSP_CUSTOM_POSTS_TYPE_BOOKING_SYSTEM,
                                  'description' => '',
                                  'post_type' => 'dopbsp',
                                  'context' => 'normal',
                                  'priority' => 'high');
                    
                    $control_data = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE post_id='.$post->ID);
                
                    if ($wpdb->num_rows == 0){
                        $wpdb->insert(DOPBSP_Calendars_table, array('post_id' => $post->ID,
                                                                    'user_id' => $current_user->data->ID,
                                                                    'name' => get_the_title($post->ID),
                                                                    'availability' => ''));
                        $wpdb->insert(DOPBSP_Settings_table, array('calendar_id' => $wpdb->insert_id,
                                                                   'hours_definitions' => '[{"value": "00:00"}]',
                                                                   'page_url' => get_permalink($post->ID)));
                    }
                    
                    $callback = create_function('$post, $meta', 'DOPBookingSystemPROBackEnd::generateCustomPostsTypeMeta($post, $meta["args"]);');
                    add_meta_box($meta['id'], $meta['title'], $callback, $meta['post_type'], $meta['context'], $meta['priority'], $meta);
                }
                
            }
            
            function generateCustomPostsTypeMeta($post, $meta){ // Generate Custom Post Type Meta Content
                new DOPBSPTemplates();    
                DOPBookingSystemPROBackEnd::printAdminCustomPostsTypeMetaTemplate();
            }
            
            function printAdminCustomPostsTypeMetaTemplate(){ // Print Custom Post Type Meta Content
                require_once(DOPBSP_Plugin_AbsPath.'/views/templates.php');
                $post_meta_template = new DOPBSPTemplates();
                $post_meta_template->calendarsList();
            }
            
// Options
            function listTemplates(){
                $folder = DOPBSP_Plugin_AbsPath.'templates/';
                $folderData = opendir($folder);
                $list = array();
                
                while (($file = readdir($folderData)) !== false){
                    if ($file != '.' && $file != '..' && $file != '.DS_Store'){                        
                        array_push($list, $file);
                    }
                }
                closedir($folderData);
                
                return implode(';;', $list);
            }
            
            function listEmailTemplates(){
                $folder = DOPBSP_Plugin_AbsPath.'emails/';
                $folderData = opendir($folder);
                $list = array();
                
                while (($file = readdir($folderData)) !== false){
                    if ($file != '.' && $file != '..' && $file != '.DS_Store'){                        
                        array_push($list, $file);
                    }
                }
                closedir($folderData);
                
                return implode(';;', $list);
            }
            
            function listCurrenciesIDs(){
                global $DOPBSP_currencies;
                $result = array();
                
                for ($i=0; $i<count($DOPBSP_currencies); $i++){
                    array_push($result, $DOPBSP_currencies[$i]['id']);
                }
                
                return implode(';;', $result);
            }
            
            function listCurrenciesLabels(){
                global $DOPBSP_currencies;
                $result = array();
                
                for ($i=0; $i<count($DOPBSP_currencies); $i++){
                    array_push($result, $DOPBSP_currencies[$i]['name'].' ('.$DOPBSP_currencies[$i]['sign'].', '.$DOPBSP_currencies[$i]['code'].')');
                }
                
                return implode(';;', $result);          
            }
            
            function shortName($name, $size){// Return a short name for the calendar.
                $new_name = '';
                $pieces = str_split($name);
               
                if (count($pieces) <= $size){
                    $new_name = $name;
                }
                else{
                    for ($i=0; $i<$size-3; $i++){
                        $new_name .= $pieces[$i];
                    }
                    $new_name .= '...';
                }

                return $new_name;
            }
            
// Settings
            function updateUsers(){
                require_once(str_replace('\\', '/', ABSPATH).'wp-includes/pluggable.php');
                global $wpdb;
                
                $users = get_users('orderby=id');
                
                foreach ($users as $user){
                    $control_data = $wpdb->get_results('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);

                    if ($wpdb->num_rows == 0){
                        switch (get_userdata($user->ID)->roles[0]){
                            case 'author':
                                $view = get_option('DOPBSP_authors_permissions') == 1 ? 'true':'false';
                                $view_all = 'false';
                                $view_custom_posts = get_option('DOPBSP_authors_custom_posts_permissions') == 1 ? 'true':'false';
                                break;
                            case 'contributor':
                                $view = get_option('DOPBSP_contributors_permissions') == 1 ? 'true':'false';
                                $view_all = 'false';
                                $view_custom_posts = get_option('DOPBSP_contributors_custom_posts_permissions') == 1 ? 'true':'false';
                                break;
                            case 'editor':
                                $view = get_option('DOPBSP_editors_permissions') == 1 ? 'true':'false';
                                $view_all = 'false';
                                $view_custom_posts = get_option('DOPBSP_editors_custom_posts_permissions') == 1 ? 'true':'false';
                                break;
                            case 'subscriber':
                                $view = get_option('DOPBSP_subscribers_permissions') == 1 ? 'true':'false';
                                $view_all = 'false';
                                $view_custom_posts = get_option('DOPBSP_subscribers_custom_posts_permissions') == 1 ? 'true':'false';
                                break;
                            default:
                                $view = 'true';
                                $view_all = get_option('DOPBSP_administrators_permissions') == 1 ? 'true':'false';
                                $view_custom_posts = get_option('DOPBSP_administrators_custom_posts_permissions') == 1 ? 'true':'false';
                        }
                        echo $view_all;
                        $wpdb->insert(DOPBSP_Users_table, array('user_id' => $user->ID,
                                                                'type' => get_userdata($user->ID)->roles[0],
                                                                'view' => $view,
                                                                'view_all' => $view_all,
                                                                'view_custom_posts' => $view_custom_posts,
                                                                'admin_calendars' => ''));
                    }
                    else{
                        $wpdb->update(DOPBSP_Users_table, array('type' => get_userdata($user->ID)->roles[0]), array('user_id' => $user->ID));
                    }
                }
                
                $superusers = get_super_admins();
                
                foreach ($superusers as $superuser){
                    $user = get_user_by('login', $superuser); 
                    $control_data = $wpdb->get_results('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
                    
                    if ($wpdb->num_rows == 0){
                        $wpdb->insert(DOPBSP_Users_table, array('user_id' => $user->ID,
                                                                'type' => 'administrator',
                                                                'view' => 'true',
                                                                'view_all' => get_option('DOPBSP_administrators_permissions') == 1 ? 'true':'false',
                                                                'view_custom_posts' => get_option('DOPBSP_administrators_custom_posts_permissions') == 1 ? 'true':'false',
                                                                'admin_calendars' => ''));
                    }
                } 
                
                $table_users = $wpdb->get_results('SELECT * FROM '.DOPBSP_Users_table);
                
                foreach ($table_users as $table_user){
                    $user_found = false;
                    
                    foreach ($users as $user){
                        if ($table_user->user_id == $user->ID){
                            $user_found = true;
                        }
                    }
                    
                    if (!$user_found){
                        $wpdb->update(DOPBSP_Calendars_table, array('user_id' => 1), array('user_id' => $table_user->user_id));
                        $wpdb->update(DOPBSP_Forms_table, array('user_id' => 1), array('user_id' => $table_user->user_id));
                        $wpdb->delete(DOPBSP_Users_table, array('user_id' => $table_user->user_id));
                    }
                }
            }

            function administratorHasPermissions($id){
                global $wpdb;     
                
                $user = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$id);
                
                if ($user->view_all == 'true'){
                    return true;                    
                }
                else{
                    return false;
                }
            }

            function userHasPermissions($id){
                global $wpdb;     
                
                $user = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$id);
         
                if ($user->view == 'true'){
                    return true;                    
                }
                else{
                    return false;
                }
            }
            
            function userHasCalendars($id){
                global $wpdb;     
                
                $user = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$id);
         
                if ($user->admin_calendars){
                    return true;                    
                }
                else{
                    return false;
                }
            }
            
            function userCalendarsIds($id){
                global $wpdb;     
                
                $user = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$id);
         
                if ($user->admin_calendars){
                    return $user->admin_calendars;                    
                }
            }
            
            function editUserPermissions(){
                global $wpdb;
                
                if ($_POST['field'] == '1'){
                    $data = array('view' => $_POST['value']);
                }
                else{
                    $data = array('view_all' => $_POST['value']);
                }
                $wpdb->update(DOPBSP_Users_table, $data, array('user_id' => $_POST['id']));
                
                echo '';
                
            	die();
            }
            
            function editUserCustomPostsPermissions(){
                global $wpdb;
                
                $data = array('view_custom_posts' => $_POST['value']);
                $wpdb->update(DOPBSP_Users_table, $data, array('user_id' => $_POST['id']));
                
                echo '';
                
            	die();
            }
            
            function editGeneralUserPermissions(){
                global $wpdb;
                
                if ($_POST['value'] == 'checked'){
                    $permissions = 1;
                    $permissions_value = 'true';
                }
                else {
                    $permissions = 0;
                    $permissions_value = 'false';
                }
                
                switch ($_POST['type']){
                    case 'administrator':
                        if (get_option('DOPBSP_administrators_permissions') == ''){
                            add_option('DOPBSP_administrators_permissions', $permissions);
                        }
                        else{
                            update_option('DOPBSP_administrators_permissions', $permissions);
                        }
                        $data = array('view_all' => $permissions_value);
                        $wpdb->update(DOPBSP_Users_table, $data, array('type' => 'administrator'));
                        break;
                    case 'author':
                        if (get_option('DOPBSP_authors_permissions') == ''){
                            add_option('DOPBSP_authors_permissions', $permissions);
                        }
                        else{
                            update_option('DOPBSP_authors_permissions', $permissions);
                        }
                        $data = array('view' => $permissions_value);
                        $wpdb->update(DOPBSP_Users_table, $data, array('type' => 'author'));
                        break;
                    case 'contributor':
                        if (get_option('DOPBSP_contributors_permissions') == ''){
                            add_option('DOPBSP_contributors_permissions', $permissions);
                        }
                        else{
                            update_option('DOPBSP_contributors_permissions', $permissions);
                        }
                        $data = array('view' => $permissions_value);
                        $wpdb->update(DOPBSP_Users_table, $data, array('type' => 'contributor'));
                        break;
                    case 'editor':
                        if (get_option('DOPBSP_editors_permissions') == ''){
                            add_option('DOPBSP_editors_permissions', $permissions);
                        }
                        else{
                            update_option('DOPBSP_editors_permissions', $permissions);
                        }
                        $data = array('view' => $permissions_value);
                        $wpdb->update(DOPBSP_Users_table, $data, array('type' => 'editor'));
                        break;
                    case 'subscriber':
                        if (get_option('DOPBSP_subscribers_permissions') == ''){
                            add_option('DOPBSP_subscribers_permissions', $permissions);
                        }
                        else{
                            update_option('DOPBSP_subscribers_permissions', $permissions);
                        }
                        $data = array('view' => $permissions_value);
                        $wpdb->update(DOPBSP_Users_table, $data, array('type' => 'subscriber'));
                        break;
                }
                
                die();
            }
            
            function editGeneralUserCustomPostsPermissions(){
                global $wpdb;
                
                if ($_POST['value'] == 'checked'){
                    $DOPBSP_permissions = 1;
                    $DOPBSP_permissions_value = 'true';
                }
                else{
                   $DOPBSP_permissions = 0;
                   $DOPBSP_permissions_value = 'false';
                }
                
                switch ($_POST['type']){
                    case 'administrator':
                        if (get_option('DOPBSP_administrators_custom_posts_permissions') == ''){
                            add_option('DOPBSP_administrators_custom_posts_permissions', $DOPBSP_permissions);
                        }
                        else{
                            update_option('DOPBSP_administrators_custom_posts_permissions', $DOPBSP_permissions);
                        }
                        $data = array('view_custom_posts' => $DOPBSP_permissions_value);
                        $wpdb->update(DOPBSP_Users_table, $data, array('type' => 'administrator'));
                        break;
                    case 'author':
                        if (get_option('DOPBSP_authors_custom_posts_permissions') == ''){
                            add_option('DOPBSP_authors_custom_posts_permissions', $DOPBSP_permissions);
                        }
                        else{
                            update_option('DOPBSP_authors_custom_posts_permissions', $DOPBSP_permissions);
                        }
                        $data = array('view_custom_posts' => $DOPBSP_permissions_value);
                        $wpdb->update(DOPBSP_Users_table, $data, array('type' => 'author'));
                        break;
                    case 'contributor':
                        if (get_option('DOPBSP_contributors_custom_posts_permissions') == ''){
                            add_option('DOPBSP_contributors_custom_posts_permissions', $DOPBSP_permissions);
                        }
                        else{
                            update_option('DOPBSP_contributors_custom_posts_permissions', $DOPBSP_permissions);
                        }
                        $data = array('view_custom_posts' => $DOPBSP_permissions_value);
                        $wpdb->update(DOPBSP_Users_table, $data, array('type' => 'contributor'));
                        break;
                    case 'editor':
                        if (get_option('DOPBSP_editors_custom_posts_permissions') == ''){
                            add_option('DOPBSP_editors_custom_posts_permissions', $DOPBSP_permissions);
                        }
                        else{
                            update_option('DOPBSP_editors_custom_posts_permissions', $DOPBSP_permissions);
                        }
                        $data = array('view_custom_posts' => $DOPBSP_permissions_value);
                        $wpdb->update(DOPBSP_Users_table, $data, array('type' => 'editor'));
                        break;
                    case 'subscriber':
                        if (get_option('DOPBSP_subscribers_custom_posts_permissions') == ''){
                            add_option('DOPBSP_subscribers_custom_posts_permissions', $DOPBSP_permissions);
                        }
                        else{
                            update_option('DOPBSP_subscribers_custom_posts_permissions', $DOPBSP_permissions);
                        }
                        $data = array('view_custom_posts' => $DOPBSP_permissions_value);
                        $wpdb->update(DOPBSP_Users_table, $data, array('type' => 'subscriber'));
                        break;
                }
                
                die();
            }
            
// Editor Changes
            function addDOPBSPtoTinyMCE(){// Add calendar button to TinyMCE Editor.
                add_filter('tiny_mce_version', array (&$this, 'changeTinyMCEVersion'));
                add_action('init', array (&$this, 'addDOPBSPButtons'));
            }

            function tinyMCECalendars(){// Send data to editor button.
                global $wpdb;
                $tinyMCE_data = '';
                $calendarsList = array();

                $calendars = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE user_id="'.wp_get_current_user()->ID.'" ORDER BY id');
                
                foreach ($calendars as $calendar){
                    array_push($calendarsList, $calendar->id.';;'.$calendar->name);
                }
                $tinyMCE_data = DOPBSP_TINYMCE_ADD.';;;;;'.implode(';;;', $calendarsList);
                
                echo '<script type="text/JavaScript">'.
                     '    var DOPBSP_tinyMCE_data = "'.$tinyMCE_data.'"'.
                     '</script>';
            }

            function addDOPBSPButtons(){// Add Button.
                if (!current_user_can('edit_posts') && !current_user_can('edit_pages')){
                    return;
                }

                if ( get_user_option('rich_editing') == 'true'){
                    add_action('admin_head', array (&$this, 'tinyMCECalendars'));
                    add_filter('mce_external_plugins', array (&$this, 'addDOPBSPTinyMCEPlugin'), 5);
                    add_filter('mce_buttons', array (&$this, 'registerDOPBSPTinyMCEPlugin'), 5);
                }
            }

            function registerDOPBSPTinyMCEPlugin($buttons){// Register editor buttons.
                array_push($buttons, '', 'DOPBSP');
                return $buttons;
            }

            function addDOPBSPTinyMCEPlugin($plugin_array){// Add plugin to TinyMCE editor.
                $plugin_array['DOPBSP'] =  DOPBSP_Plugin_URL.'assets/js/tinymce-plugin.js';
                return $plugin_array;
            }

            function changeTinyMCEVersion($version){// TinyMCE version.
                $version = $version+100;
                return $version;
            }
            
// Prototypes
            function dateToFormat($date, $type){
                global $DOPBSP_month_names;  
                $dayPieces = explode('-', $date);

                if ($type == '1'){
                    return $DOPBSP_month_names[(int)$dayPieces[1]-1].' '.$dayPieces[2].', '.$dayPieces[0];
                }
                else{
                    return $dayPieces[2].' '.$DOPBSP_month_names[(int)$dayPieces[1]-1].' '.$dayPieces[0];
                }
            }
            
            function timeToAMPM($item){
                $time_pieces = explode(':', $item);
                $hour = (int)$time_pieces[0];
                $minutes = $time_pieces[1];
                $result = '';

                if ($hour == 0){
                    $result = '12';
                }
                else if ($hour > 12){
                    $result = $this->timeLongItem($hour-12);
                }
                else{
                    $result = $this->timeLongItem($hour);
                }

                $result .= ':'.$minutes.' '.($hour < 12 ? 'AM':'PM');

                return $result;
            }
            
            function timeLongItem($item){
                if ($item < 10){
                    return '0'.$item;
                }
                else{
                    return $item;
                }
            }
            
            function validEmail($email){
                if (preg_match("/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is", $email)){
                    return true;
                }
                else{
                    return false;
                }
            }
            
            function getWithDecimals($number, $length = 2){
                return (int)$number == $number ? (string)$number:number_format($number, $length, '.', '');
            }
        }
    }