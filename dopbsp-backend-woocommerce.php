<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 1.7
* File                    : dopbsp-backend-woocommerce.php
* File Version            : 1.0
* Created / Last Modified : 31 August 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO WooCommerce Class.
*/

    if (!class_exists("DOPBookingSystemPROBackEndWooCommerce")){
        class DOPBookingSystemPROBackEndWooCommerce extends DOPBookingSystemPROBackEnd{
            private $DOPBSP_AddEditCalendars;

            function DOPBookingSystemPROBackEndWooCommerce(){// Constructor.
                if (is_admin()){
//                    if ($this->validPage()){
//                        $this->DOPBSP_AddEditCalendars = new DOPBSPTemplates();
//                    }
                    
                    add_action('woocommerce_product_write_panel_tabs', array(&$this, 'addTab'));
                    add_action('woocommerce_product_write_panels', array(&$this, 'showTab'));
                }
            }
            
            function addTab(){
                echo '<li class="dopbsp_tab"><a href="#dopbsp_tab_data">'.DOPBSP_WOOCOMMERCE.'</a></li>';
            }
            
            function showTab() {
                global $post;
	
                $custom_tab_options = array(
                        'title' => get_post_meta($post->ID, 'custom_tab_title', true),
                        'content' => get_post_meta($post->ID, 'custom_tab_content', true),
                );
	
?>
    <div id="dopbsp_tab_data" class="panel woocommerce_options_panel">
        <div class="options_group">
            <p class="form-field">
                <?php woocommerce_wp_select(array('id' => 'custom_tab_enabled', 'options' => $this->getCalendars(), 'label' => __('Enable Custom Tab?', 'woothemes'), 'description' => __('Enable this option to enable the custom tab on the frontend.', 'woothemes') ) ); ?>
            </p>
        </div>
		
        <div class="options_group">
        </div>	
    </div>
<?php
            }
            
            
            function getCalendars(){// Show Calendars List.
                global $wpdb;
                                    
                $calendarsHTML = array();
                $noCalendars = 0;
                $calendarsHTML[0] = '- No Calendar -';
                
                if ($this->administratorHasPermissions(wp_get_current_user()->ID)){
                    $calendars = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' ORDER BY id');
                    $noCalendars = $wpdb->num_rows;

                }
                else{
                    if ($this->userHasPermissions(wp_get_current_user()->ID)){
                        $calendars = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE user_id="'.wp_get_current_user()->ID.'" ORDER BY id');
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
                           $calendars_assigned = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE id IN ('.$calendarlist.') ORDER BY id');   
                        }
                    }
                    else{
                        $calendars_assigned = $calendars;
                    }
                }
                
                if ($noCalendars != 0 || (isset($calendars_assigned) && count($calendars_assigned) != 0)){
                    if ($calendars){
                        foreach ($calendars as $calendar){
                            if (isset($calendarsfound)){
                                if (!in_array($calendar->id, $calendarsfound)){
                                    $calendarsHTML[$calendar->id] = 'ID '.$calendar->id.': '.$calendar->name;
                                }
                            }
                            
                            if($this->administratorHasPermissions(wp_get_current_user()->ID)){
                                $calendarsHTML[$calendar->id] = 'ID '.$calendar->id.': '.$calendar->name;
                            }
                        }
                    }
                    
                    if (isset($calendars_assigned)){
                        foreach ($calendars_assigned as $calendar){
                            $calendarsHTML[$calendar->id] = 'ID '.$calendar->id.': '.$calendar->name;
                        }
                    }
                   
                }
                
                return $calendarsHTML;
            }
        }
    }
            
            

/**
 * Custom Tabs for Product display
 * 
 * Outputs an extra tab to the default set of info tabs on the single product page.
 */ 


/**
 * Custom Tab Options
 * 
 * Provides the input fields and add/remove buttons for custom tabs on the single product page.
 */


/**
 * Process meta
 * 
 * Processes the custom tab options when a post is saved
 */
function process_product_meta_custom_tab( $post_id ) {
	update_post_meta( $post_id, 'custom_tab_enabled', ( isset($_POST['custom_tab_enabled']) && $_POST['custom_tab_enabled'] ) ? 'yes' : 'no' );
	update_post_meta( $post_id, 'custom_tab_title', $_POST['custom_tab_title']);
	update_post_meta( $post_id, 'custom_tab_content', $_POST['custom_tab_content']);
}
add_action('woocommerce_process_product_meta', 'process_product_meta_custom_tab');


/** Add extra tabs to front end product page **/
if (!function_exists('woocommerce_product_custom_tab')) {
	function woocommerce_product_custom_tab() {
		global $post;
		
		$custom_tab_options = array(
			'enabled' => get_post_meta($post->ID, 'custom_tab_enabled', true),
			'title' => get_post_meta($post->ID, 'custom_tab_title', true),
		);
		
		if ( $custom_tab_options['enabled'] != 'yes' )
			return false;
		
?>
		<li><a href="#tab-models"><?php echo $custom_tab_options['title']; ?></a></li>
<?php
	}
}
add_action( 'woocommerce_product_tabs', 'woocommerce_product_custom_tab', 11 );


if (!function_exists('woocommerce_product_custom_panel')) {
	function woocommerce_product_custom_panel() {
		global $post;
		
		$custom_tab_options = array(
			'title' => get_post_meta($post->ID, 'custom_tab_title', true),
			'content' => get_post_meta($post->ID, 'custom_tab_content', true),
		);
		
?>
		<div class="panel" id="tab-models">			
			<?php echo $custom_tab_options['content']; ?>
		</div>
<?php
	}
}
add_action( 'woocommerce_product_tab_panels', 'woocommerce_product_custom_panel', 11 );

//        }
//    }
    
?>    