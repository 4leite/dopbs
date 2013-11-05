<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 1.7
* File                    : dopbsp-frontend.php
* File Version            : 1.7
* Created / Last Modified : 31 July 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Front End Class.
*/

    if (session_id() == ""){
        session_start();
    }

    if (!class_exists("DOPBookingSystemPROFrontEnd")){
        class DOPBookingSystemPROFrontEnd{
            private $woocommerce_enabled = false;
            
            function DOPBookingSystemPROFrontEnd(){// Constructor.
                add_action('wp_enqueue_scripts', array(&$this, 'addScripts'));

                add_action('init', array(&$this, 'initCustomPostsType'));
                add_filter('pre_get_posts', array(&$this, 'getCustomPosts')); // Get custom Post
                add_filter('the_content', array(&$this, 'addBookingSystemPROInCustomPosts')); // Add calendar in dopbsp posts
                
                $this->init();
            }
            
            function addScripts(){
                wp_register_script('DOPBSP_DOPBookingSystemPROJS', plugins_url('assets/js/jquery.dop.FrontendBookingSystemPRO.js', __FILE__), array('jquery'), false, true);

                // Enqueue JavaScript.
                
                if (!wp_script_is('jquery-ui-datepicker', 'queue')){
                    wp_enqueue_script('jquery-ui-datepicker');
                }
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
                wp_enqueue_script('DOPBSP_DOPBookingSystemPROJS');
            }

            function init(){// Init Gallery.
                $this->initConstants();
                add_shortcode('dopbsp', array(&$this, 'captionShortcode'));
            }

            function initConstants(){// Constants init.
                global $wpdb;
                
                // Tables
                define('DOPBSP_Settings_table', $wpdb->prefix.'dopbsp_settings');
                define('DOPBSP_Calendars_table', $wpdb->prefix.'dopbsp_calendars');
                define('DOPBSP_Days_table', $wpdb->prefix.'dopbsp_days');
                define('DOPBSP_Reservations_table', $wpdb->prefix.'dopbsp_reservations');
                define('DOPBSP_Users_table', $wpdb->prefix.'dopbsp_users');
                define('DOPBSP_Forms_table', $wpdb->prefix.'dopbsp_forms');
                define('DOPBSP_Forms_Fields_table', $wpdb->prefix.'dopbsp_forms_fields');
                define('DOPBSP_Forms_Select_Options_table', $wpdb->prefix.'dopbsp_forms_select_options');
            }

            function captionShortcode($atts){// Read Shortcodes.
                extract(shortcode_atts(array(
                    'class' => 'dopbsp',
                ), $atts));
                                
                if (array_key_exists('lang', $atts)){
                    $language = $atts['lang'];
                }
                else{
                    $language = 'en';
                }
                
                $_SESSION['DOPBookingSystemPROFrontEndLanguage'.$atts['id']] = $language;
                $data = array();
                                
                array_push($data, '<link rel="stylesheet" type="text/css" href="'.plugins_url('templates/'.$this->getCalendarTemplate($atts['id']).'/css/jquery-ui-1.8.21.customDatepicker.css', __FILE__).'" />');
                array_push($data, '<link rel="stylesheet" type="text/css" href="'.plugins_url('templates/'.$this->getCalendarTemplate($atts['id']).'/css/jquery.dop.FrontendBookingSystemPRO.css', __FILE__).'" />');
                
                array_push($data, '<script type="text/JavaScript">');
                array_push($data, '    jQuery(document).ready(function(){');
                array_push($data, '        jQuery("#DOPBookingSystemPRO'.$atts['id'].'").DOPBookingSystemPRO('.$this->getCalendarSettings($atts['id'], $language).');');
                array_push($data, '    });');
                array_push($data, '</script>');
                
                array_push($data, '<div class="DOPBookingSystemPROContainer" id="DOPBookingSystemPRO'.$atts['id'].'"><a href="'.DOPBSP_Plugin_URL.'frontend-ajax.php"></a></div>');
                
                return implode("\n", $data);
            }
 
            function getCalendarTemplate($id){// Get Gallery Info.
                global $wpdb;                
                $settings = $wpdb->get_row('SELECT template FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$id.'"');
                
                return $settings->template;
            }

            function getCalendarSettings($id, $language='en'){// Get Gallery Info.
                include_once 'translation/frontend/'.$language.'.php';
                global $wpdb;
                global $DOPBSP_currencies;
                global $DOPBSP_month_names;
                global $DOPBSP_month_short_names;
                global $DOPBSP_day_names;
                global $DOPBSP_day_short_names;
                $data = array();
                                
                $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$id.'"');
                $form = $wpdb->get_results('SELECT * FROM '.DOPBSP_Forms_Fields_table.' WHERE form_id="'.$settings->form.'" ORDER BY position');
                
                foreach ($form as $field){
                    $translation = json_decode(stripslashes($field->translation));
                    $field->translation = $translation->$language;
                    
                    if ($field->type == 'select'){
                        $options = $wpdb->get_results('SELECT * FROM '.DOPBSP_Forms_Select_Options_table.' WHERE field_id='.$field->id.' ORDER BY field_id ASC');
                        
                        foreach ($options as $option){
                            $option_translation = json_decode(stripslashes($option->translation));
                            $option->translation = $option_translation->$language;
                        }
                        $field->options = $options;
                    }
                }
                
                $discountsNoDays = explode(',', $settings->discounts_no_days);
                
                for ($i=0; $i<count($discountsNoDays); $i++){
                    $discountsNoDays[$i] = (float)$discountsNoDays[$i];
                }
                
                $data = array('AddLastHourToTotalPrice' => $settings->last_hour_to_total_price,
                              'AddtMonthViewText' => DOPBSP_ADD_MONTH_VIEW,
                              'AvailableDays' => explode(',', $settings->available_days),
                              'AvailableOneText' => DOPBSP_AVAILABLE_ONE_TEXT,
                              'AvailableText' => DOPBSP_AVAILABLE_TEXT,
                              'BookedText' => DOPBSP_BOOKED_TEXT,
                              'BookNowLabel' => DOPBSP_BOOK_NOW_LABEL,
                              'CheckInLabel' => DOPBSP_CHECK_IN_LABEL,
                              'CheckOutLabel' => DOPBSP_CHECK_OUT_LABEL,
                              'Currency' => $DOPBSP_currencies[(int)$settings->currency-1]['sign'],
                              'CurrencyCode' => $DOPBSP_currencies[(int)$settings->currency-1]['code'],
                              'DayNames' => $DOPBSP_day_names,
                              'DayShortNames' => $DOPBSP_day_short_names,
                              'DateType' => $settings->date_type,
                              'Deposit' => $settings->deposit,
                              'DepositText' => DOPBSP_DEPOSIT_TEXT,
                              'DiscountsNoDays' => $discountsNoDays,
                              'DiscountText' => DOPBSP_DISCOUNT_TEXT,
                              'EndHourLabel' => DOPBSP_END_HOURS_LABEL,
                              'FirstDay' => $settings->first_day,
                              'Form' => $form,
                              'FormID' => $settings->form,
                              'FormEmailInvalid' => DOPBSP_FORM_EMAIL_INVALID,
                              'FormRequired' => DOPBSP_FORM_REQUIRED,
                              'FormTitle' => DOPBSP_FORM_TITLE,
                              'HoursAMPM' => $settings->hours_ampm,
                              'HoursEnabled' => $settings->hours_enabled,
                              'HoursDefinitions' => json_decode($settings->hours_definitions),
                              'HoursInfoEnabled' => $settings->hours_info_enabled,
                              'HoursIntervalEnabled' => $settings->hours_interval_enabled,
                              'ID' => $id,
                              'Language' => $language,
                              'MaxNoChildren' => $settings->max_no_children,
                              'MaxNoPeople' => $settings->max_no_people,
                              'MaxYear' => $settings->max_year,
                              'MaxStay' => $settings->max_stay,
                              'MaxStayWarning' => DOPBSP_MAX_STAY_WARNING,
                              'MinNoChildren' => $settings->min_no_children,
                              'MinNoPeople' => $settings->min_no_people,
                              'MinStay' => $settings->min_stay,
                              'MinStayWarning' => DOPBSP_MIN_STAY_WARNING,
                              'MonthNames' => $DOPBSP_month_names,
                              'MonthShortNames' => $DOPBSP_month_short_names,
                              'MorningCheckOut' => $settings->morning_check_out,
                              'MultipleDaysSelect' => $settings->multiple_days_select,
                              'MultipleHoursSelect' => $settings->multiple_hours_select,
                              'NextMonthText' => DOPBSP_NEXT_MONTH,
                              'NoAdultsLabel' => DOPBSP_NO_ADULTS_LABEL,
                              'NoChildrenEnabled' => $settings->no_children_enabled,
                              'NoChildrenLabel' => DOPBSP_NO_CHILDREN_LABEL,
                              'NoItemsLabel' => DOPBSP_NO_ITEMS_LABEL,
                              'NoItemsEnabled' => $settings->no_items_enabled,
                              'NoPeopleLabel' => DOPBSP_NO_PEOPLE_LABEL,
                              'NoPeopleEnabled' => $settings->no_people_enabled,
                              'NoServicesAvailableText' => DOPBSP_NO_SERVICES_AVAILABLE,
                              'PaymentArrivalEnabled' => $settings->payment_arrival_enabled,
                              'PaymentArrivalLabel' => $settings->instant_booking ? DOPBSP_PAYMENT_ARRIVAL_LABEL:DOPBSP_PAYMENT_ARRIVAL_WITH_APPROVAL_LABEL,
                              'PaymentArrivalSuccess' => DOPBSP_PAYMENT_ARRIVAL_SUCCESS,
                              'PaymentArrivalSuccessInstantBooking' => DOPBSP_PAYMENT_ARRIVAL_SUCCESS_INSTANT_BOOKING,
                              'PaymentPayPalEnabled' => $settings->payment_paypal_enabled,
                              'PaymentPayPalLabel' => DOPBSP_PAYMENT_PAYPAL_LABEL,
                              'PaymentPayPalSuccess' => DOPBSP_PAYMENT_PAYPAL_SUCCESS,
                              'PaymentPayPalError' => DOPBSP_PAYMENT_PAYPAL_ERROR,
                              'PluginURL' => DOPBSP_Plugin_URL,
                              'PreviousMonthText' => DOPBSP_PREVIOUS_MONTH,
                              'RemoveMonthViewText' => DOPBSP_REMOVE_MONTH_VIEW,
                              'ServicesLabel' => DOPBSP_SERVICES_LABEL,
                              'StartHourLabel' => DOPBSP_START_HOURS_LABEL,
                              'TotalPriceLabel' => DOPBSP_TOTAL_PRICE_LABEL,
                              'TermsAndConditionsEnabled' => $settings->terms_and_conditions_enabled,
                              'TermsAndConditionsInvalid' => DOPBSP_TERMS_AND_CONDITIONS_INVALID,
                              'TermsAndConditionsLabel' => DOPBSP_TERMS_AND_CONDITIONS_LABEL,
                              'TermsAndConditionsLink' => $settings->terms_and_conditions_link,
                              'UnavailableText' => DOPBSP_UNAVAILABLE_TEXT,
                              'ViewOnly' => $settings->view_only);
                
                return json_encode($data);
            }
            
            function loadSchedule(){// Load Calendar Data.
                if (isset($_POST['calendar_id'])){
                    global $wpdb;
                    $schedule = array();
                    
                    $days = $wpdb->get_results('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                    
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
            
            function bookRequest(){
                if (session_id() == ""){
                    session_start();
                }
                
                if (isset($_POST['calendar_id'])){
                    global $wpdb;
                    
                    $language = isset($_SESSION['DOPBookingSystemPROFrontEndLanguage'.$_POST['calendar_id']]) ? $_SESSION['DOPBookingSystemPROFrontEndLanguage'.$_POST['calendar_id']]:'en';
                    $form = $_POST['form'];
                    
                    $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                    
                    $wpdb->insert(DOPBSP_Reservations_table, array('calendar_id' => $_POST['calendar_id'],
                                                                   'check_in' => $_POST['check_in'],
                                                                   'check_out' => $_POST['check_out'],
                                                                   'start_hour' => $_POST['start_hour'],
                                                                   'end_hour' => $_POST['end_hour'],
                                                                   'no_items' => $_POST['no_items'],
                                                                   'currency' => $_POST['currency'],
                                                                   'currency_code' => $_POST['currency_code'],
                                                                   'total_price' => $_POST['total_price'],
                                                                   'discount' => $_POST['discount'],
                                                                   'price' => $_POST['price'],
                                                                   'deposit' => $_POST['deposit'],
                                                                   'language' => $language,
                                                                   'email' => $_POST['email'],
                                                                   'no_people' => $_POST['no_people'],
                                                                   'no_children' => $_POST['no_children'],
                                                                   'status' => $settings->instant_booking == 'false' ? 'pending':'approved',
                                                                   'info' => json_encode($form),
                                                                   'payment_method' => $_POST['payment_method']));
                    $reservationId = $wpdb->insert_id;
                    
                    $DOPemail = new DOPBookingSystemPROEmail();
                    
                    if ($settings->instant_booking == 'false'){
                        $DOPemail->sendMessage('booking_without_approval',
                                               $language,
                                               $_POST['calendar_id'], 
                                               $reservationId,
                                               $_POST['check_in'],
                                               $_POST['check_out'],
                                               $_POST['start_hour'],
                                               $_POST['end_hour'],
                                               $_POST['no_items'],
                                               $_POST['currency'],
                                               $_POST['price'],
                                               $_POST['deposit'],
                                               $_POST['total_price'],
                                               $_POST['discount'],
                                               $form,
                                               $_POST['no_people'],
                                               $_POST['no_children'],
                                               $_POST['email'],
                                               true,
                                               true);
                    }
                    else{
                        $DOPemail->sendMessage('booking_with_approval',
                                               $language,
                                               $_POST['calendar_id'], 
                                               $reservationId,
                                               $_POST['check_in'],
                                               $_POST['check_out'],
                                               $_POST['start_hour'],
                                               $_POST['end_hour'],
                                               $_POST['no_items'],
                                               $_POST['currency'],
                                               $_POST['price'],
                                               $_POST['deposit'],
                                               $_POST['total_price'],
                                               $_POST['discount'],
                                               $form,
                                               $_POST['no_people'],
                                               $_POST['no_children'],
                                               $_POST['email'],
                                               true,
                                               true);
                        
                        $DOPreservations = new DOPBookingSystemPROBackEndReservations();
                        $DOPreservations->approveReservationCalendarChange($reservationId, $settings);
                        
                        $ci = explode('-', $_POST['check_in']);
                        echo $ci[0].'-'.(int)$ci[1];
                    }
                }
                
                echo '';                
                die();
            }
            
            function paypalCheck(){
                if (session_id() == ""){
                    session_start();
                }
                
                if (isset($_POST['calendar_id']) && isset($_SESSION['DOPBSP_PayPal'.$_POST['calendar_id']])){
                    $status = $_SESSION['DOPBSP_PayPal'.$_POST['calendar_id']];
                    $_SESSION['DOPBSP_PayPal'.$_POST['calendar_id']] = '';
                    
                    echo $status;                    
                }
                else{
                    echo 'no';
                }               
            }
            
// Custom Post Type      
            function initCustomPostsType(){ // Init Custom Post Type in Front End
                $postdata = array('exclude_from_search' => false,
                                  'has_archive' => true,
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
            
            function getCustomPosts($query){ // Get Custom Post
                if ((is_home() && $query->is_main_query())){
                    $post_types = array();
                    $curr_post_types = get_post_types();

                    foreach ($curr_post_types as $post_type){
                        if ($post_type != 'page' &&
                            $post_type != 'attachment' && 
                            $post_type != 'nav_menu_item' && 
                            $post_type != 'revision'){
                                array_push($post_types, $post_type);
                            }
                    }	

                    array_push($post_types, 'dopbsp');
                    $query->set('post_type', $post_types);
                }
                        
                return $query;
            }
            
            function addBookingSystemPROInCustomPosts($content){ // Add calendar in dopbsp posts
                global $wpdb;
                $post_type = get_post_type();
                
                if ($post_type == 'dopbsp'){
                    $custom_content = $content;
                    
                    $calendar = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE post_id="'.get_the_ID().'" ORDER BY id');

                    if (isset($calendar[0]->id)){
                        $custom_content .= do_shortcode('[dopbsp id="'.$calendar[0]->id.'"]');
                    }
                    return $custom_content;
                }
                else{
                    return $content;
                }
            }

        }
    }
?>