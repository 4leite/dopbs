<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 1.7
* File                    : doptg-widget.php
* File Version            : 1.1
* Created / Last Modified : 03 June 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System Pro Widget Class.
*/
  
    class DOPBookingSystemPROWidget extends WP_Widget{
        function DOPBookingSystemPROWidget(){
            $widget_ops = array('classname' => 'DOPBookingSystemPROWidget', 'description' => !is_admin() ? '':DOPBSP_WIDGET_DESCRIPTION);
            $this->WP_Widget('DOPBookingSystemPROWidget', !is_admin() ? '':DOPBSP_WIDGET_TITLE, $widget_ops);
        }
 
        function form($instance){
            global $wpdb;
            
            $instance = wp_parse_args((array)$instance, array('title' => '',
                                                              'selection' => 'calendar',
                                                              'id' => '0',
//                                                              'ids' => '0',
                                                              'lang' => 'en'));
            $title = $instance['title'];
            $selection = $instance['selection'];
            $id = $instance['id'];
//            $ids = $instance['ids'];
            $lang = $instance['lang'];
?>
<!-- Title Field -->
            <p>
                <label for="<?php echo $this->get_field_id('title')?>"><?php echo DOPBSP_WIDGET_LABEL_TITLE?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" type="text" value="<?php echo esc_attr($title)?>" />
            </p>

<!-- Action Select Field -->
            <p>
                <label for="<?php echo $this->get_field_id('selection')?>"><?php echo DOPBSP_WIDGET_LABEL_SELECTION?></label>
                <select class="widefat" id="<?php echo $this->get_field_id('selection')?>" name="<?php echo $this->get_field_name('selection')?>" onchange="dopbspConfigureWidgetForm('<?php echo $this->get_field_id('selection')?>', this.value)">
                    <option value="calendar"<?php echo (esc_attr($selection) == 'calendar' ? ' selected="selected"':'')?>><?php echo DOPBSP_WIDGET_SELECTION_CALENDAR?></option>
                    <option value="sidebar"<?php echo (esc_attr($selection) == 'sidebar' ? ' selected="selected"':'')?>><?php echo DOPBSP_WIDGET_SELECTION_SIDEBAR?></option>
                </select>
            </p>

<!-- ID Field -->
            <p id="DOPBSP-widget-id-<?php echo $this->get_field_id('selection')?>">
                <label for="<?php echo $this->get_field_id('id')?>"><?php echo DOPBSP_WIDGET_LABEL_ID?></label>
                <select class="widefat" id="<?php echo $this->get_field_id('id')?>" name="<?php echo $this->get_field_name('id')?>">
<?php
            if (wp_get_current_user()->roles[0] == 'administrator' && $this->administratorHasPermissions(wp_get_current_user()->ID)){
                $calendars = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' ORDER BY id DESC');
            }
            else{
                $calendars = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE user_id="'.wp_get_current_user()->ID.'" ORDER BY id DESC');
            }

            if ($wpdb->num_rows != 0){
                foreach ($calendars as $calendar) {
                    if (esc_attr($id) == $calendar->id){
                        echo '<option value="'.$calendar->id.'" selected="selected">'.$calendar->id.' - '.$calendar->name.'</option>';
                        
                    }
                    else{
                        echo '<option value="'.$calendar->id.'">'.$calendar->id.' - '.$calendar->name.'</option>';
                    }
                }
            }
            else{
                echo '<option value="0">'.DOPBSP_WIDGET_NO_CALENDARS.'</option>';
            }
?>            
            
                </select>
            </p>

<!-- Language Field -->
            <p id="DOPBSP-widget-lang-<?php echo $this->get_field_id('selection')?>">
                <label for="<?$this->get_field_id('lang')?>"><?php echo DOPBSP_WIDGET_LABEL_LANGUAGE. ' '.esc_attr($lang)?></label>
                <select class="widefat" id="<?php echo $this->get_field_id('lang')?>" name="<?php echo $this->get_field_name('lang')?>">
                <?php echo $this->returnLanguages(esc_attr($lang))?>
                </select>
            </p>

<!-- Form Configuration Script -->         
            <script type="text/JavaScript">
                jQuery(document).ready(function(){
                    dopbspConfigureWidgetForm('<?php echo $this->get_field_id('selection')?>', '<?php echo esc_attr($selection)?>');
                });
                
                function dopbspConfigureWidgetForm(id, selection){
                    jQuery('#DOPBSP-widget-id-'+id).css('display', 'none');
                    jQuery('#DOPBSP-widget-lang-'+id).css('display', 'none');

                    switch (selection){
                        case 'calendar':
                            jQuery('#DOPBSP-widget-id-'+id).css('display', 'block');
                            jQuery('#DOPBSP-widget-lang-'+id).css('display', 'block');
                            break;
                        case 'sidebar':
                            jQuery('#DOPBSP-widget-id-'+id).css('display', 'block');
                            break;
                    }
                }
            </script>
<?php       
        }
 
        function update($new_instance, $old_instance){
            $instance = $old_instance;
            
            $instance['title'] = $new_instance['title'];
            $instance['selection'] = $new_instance['selection'];
            $instance['id'] = $new_instance['id'];
            $instance['lang'] = $new_instance['lang'];
            
            return $instance;
        }

        function widget($args, $instance){
            extract($args, EXTR_SKIP);

            echo $before_widget;
            $title = empty($instance['title']) ? ' ':apply_filters('widget_title', $instance['title']);
            $selection = empty($instance['selection']) ? 'calendar':$instance['selection'];
            $id = empty($instance['id']) ? '0':$instance['id'];
//            $ids = empty($instance['ids']) ? '0':$instance['ids'];
            $lang = empty($instance['lang']) ? 'en':$instance['lang'];
 
            if (!empty($title)){
                echo $before_title.$title.$after_title;        
            }
            
            switch ($selection){
                case 'calendar':
                    echo do_shortcode('[dopbsp id="'.$id.'" lang="'.$lang.'"]');
                    break;
                case 'sidebar':
                    echo '<div class="DOPBookingSystemPRO_SidebarWidget" id="DOPBookingSystemPRO_SidebarWidget'.$id.'"></div>';
                    break;
            }

            echo $after_widget;
        }
        
        function administratorHasPermissions($id){
            global $wpdb;     

            $user = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE id='.$id);

            if ($user->view_all == 'true'){
                return true;                    
            }
            else{
                return false;
            }
        }
        
        function returnLanguages($current_language){ // List languages select.
            $html = array();
            
            array_push($html, '<option value="af"'.($current_language == 'af' ? ' selected="selected"':'').'>Afrikaans (Afrikaans)</option>');
            array_push($html, '<option value="al"'.($current_language == 'al' ? ' selected="selected"':'').'>Albanian (Shqiptar)</option>');
            array_push($html, '<option value="ar"'.($current_language == 'ar' ? ' selected="selected"':'').'>Arabic (>العربية)</option>');
            array_push($html, '<option value="az"'.($current_language == 'az' ? ' selected="selected"':'').'>Azerbaijani (Azərbaycan)</option>');
            array_push($html, '<option value="bs"'.($current_language == 'bs' ? ' selected="selected"':'').'>Basque (Euskal)</option>');
            array_push($html, '<option value="by"'.($current_language == 'by' ? ' selected="selected"':'').'>Belarusian (Беларускай)</option>');
            array_push($html, '<option value="bg"'.($current_language == 'bg' ? ' selected="selected"':'').'>Bulgarian (Български)</option>');
            array_push($html, '<option value="ca"'.($current_language == 'ca' ? ' selected="selected"':'').'>Catalan (Català)</option>');
            array_push($html, '<option value="cn"'.($current_language == 'cn' ? ' selected="selected"':'').'>Chinese (中国的)</option>');
            array_push($html, '<option value="cr"'.($current_language == 'cr' ? ' selected="selected"':'').'>Croatian (Hrvatski)</option>');
            array_push($html, '<option value="cz"'.($current_language == 'cz' ? ' selected="selected"':'').'>Czech (Český)</option>');
            array_push($html, '<option value="dk"'.($current_language == 'dk' ? ' selected="selected"':'').'>Danish (Dansk)</option>');
            array_push($html, '<option value="du"'.($current_language == 'du' ? ' selected="selected"':'').'>Dutch (Nederlands)</option>');
            array_push($html, '<option value="en"'.($current_language == 'en' ? ' selected="selected"':'').'>English</option>');
            array_push($html, '<option value="eo"'.($current_language == 'eo' ? ' selected="selected"':'').'>Esperanto (Esperanto)</option>');
            array_push($html, '<option value="et"'.($current_language == 'et' ? ' selected="selected"':'').'>Estonian (Eesti)</option>');
            array_push($html, '<option value="fl"'.($current_language == 'fl' ? ' selected="selected"':'').'>Filipino (na Filipino)</option>');
            array_push($html, '<option value="fi"'.($current_language == 'fi' ? ' selected="selected"':'').'>Finnish (Suomi)</option>');
            array_push($html, '<option value="fr"'.($current_language == 'fr' ? ' selected="selected"':'').'>French (Français)</option>');
            array_push($html, '<option value="gl"'.($current_language == 'gl' ? ' selected="selected"':'').'>Galician (Galego)</option>');
            array_push($html, '<option value="de"'.($current_language == 'de' ? ' selected="selected"':'').'>German (Deutsch)</option>');
            array_push($html, '<option value="gr"'.($current_language == 'gr' ? ' selected="selected"':'').'>Greek (Ɛλληνικά)</option>');
            array_push($html, '<option value="ha"'.($current_language == 'ha' ? ' selected="selected"':'').'>Haitian Creole (Kreyòl Ayisyen)</option>');
            array_push($html, '<option value="he"'.($current_language == 'he' ? ' selected="selected"':'').'>Hebrew (עברית)</option>');
            array_push($html, '<option value="hi"'.($current_language == 'hi' ? ' selected="selected"':'').'>Hindi (हिंदी)</option>');
            array_push($html, '<option value="hu"'.($current_language == 'hu' ? ' selected="selected"':'').'>Hungarian (Magyar)</option>');
            array_push($html, '<option value="is"'.($current_language == 'is' ? ' selected="selected"':'').'>Icelandic (Íslenska)</option>');
            array_push($html, '<option value="id"'.($current_language == 'id' ? ' selected="selected"':'').'>Indonesian (Indonesia)</option>');
            array_push($html, '<option value="ir"'.($current_language == 'ir' ? ' selected="selected"':'').'>Irish (Gaeilge)</option>');
            array_push($html, '<option value="it"'.($current_language == 'it' ? ' selected="selected"':'').'>Italian (Italiano)</option>');
            array_push($html, '<option value="ja"'.($current_language == 'ja' ? ' selected="selected"':'').'>Japanese (日本の)</option>');
            array_push($html, '<option value="ko"'.($current_language == 'ko' ? ' selected="selected"':'').'>Korean (한국의)</option>');
            array_push($html, '<option value="lv"'.($current_language == 'lv' ? ' selected="selected"':'').'>Latvian (Latvijas)</option>');
            array_push($html, '<option value="lt"'.($current_language == 'lt' ? ' selected="selected"':'').'>Lithuanian (Lietuvos)</option>');
            array_push($html, '<option value="mk"'.($current_language == 'mk' ? ' selected="selected"':'').'>Macedonian (македонски)</option>');
            array_push($html, '<option value="mg"'.($current_language == 'mg' ? ' selected="selected"':'').'>Malay (Melayu)</option>');
            array_push($html, '<option value="ma"'.($current_language == 'ma' ? ' selected="selected"':'').'>Maltese (Maltija)</option>');
            array_push($html, '<option value="no"'.($current_language == 'no' ? ' selected="selected"':'').'>Norwegian (Norske)</option>');
            array_push($html, '<option value="pe"'.($current_language == 'pe' ? ' selected="selected"':'').'>Persian (فارسی)</option>');
            array_push($html, '<option value="pl"'.($current_language == 'pl' ? ' selected="selected"':'').'>Polish (Polski)</option>');
            array_push($html, '<option value="pt"'.($current_language == 'pt' ? ' selected="selected"':'').'>Portuguese (Português)</option>');
            array_push($html, '<option value="ro"'.($current_language == 'ro' ? ' selected="selected"':'').'>Romanian (Română)</option>');
            array_push($html, '<option value="ru"'.($current_language == 'ru' ? ' selected="selected"':'').'>Russian (Pусский)</option>');
            array_push($html, '<option value="sr"'.($current_language == 'sr' ? ' selected="selected"':'').'>Serbian (Cрпски)</option>');
            array_push($html, '<option value="sk"'.($current_language == 'sk' ? ' selected="selected"':'').'>Slovak (Slovenských)</option>');
            array_push($html, '<option value="sl"'.($current_language == 'sl' ? ' selected="selected"':'').'>Slovenian (Slovenski)</option>');
            array_push($html, '<option value="sp"'.($current_language == 'sp' ? ' selected="selected"':'').'>Spanish (Español)</option>');
            array_push($html, '<option value="sw"'.($current_language == 'sw' ? ' selected="selected"':'').'>Swahili (Kiswahili)</option>');
            array_push($html, '<option value="se"'.($current_language == 'se' ? ' selected="selected"':'').'>Swedish (Svenskt)</option>');
            array_push($html, '<option value="th"'.($current_language == 'th' ? ' selected="selected"':'').'>Thai (ภาษาไทย)</option>');
            array_push($html, '<option value="tr"'.($current_language == 'tr' ? ' selected="selected"':'').'>Turkish (Türk)</option>');
            array_push($html, '<option value="uk"'.($current_language == 'uk' ? ' selected="selected"':'').'>Ukrainian (Український)</option>');
            array_push($html, '<option value="ur"'.($current_language == 'ur' ? ' selected="selected"':'').'>Urdu (اردو)</option>');
            array_push($html, '<option value="vi"'.($current_language == 'vi' ? ' selected="selected"':'').'>Vietnamese (Việt)</option>');
            array_push($html, '<option value="we"'.($current_language == 'we' ? ' selected="selected"':'').'>Welsh (Cymraeg)</option>');
            array_push($html, '<option value="yi"'.($current_language == 'yi' ? ' selected="selected"':'').'>Yiddish (ייִדיש)</option>');
            
            return implode('', $html);
        }
    }

?>