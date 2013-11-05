/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 1.7
* File                    : dopbsp-backend.js
* File Version            : 1.7
* Created / Last Modified : 31 July 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Admin Scripts.
*/

//Declare global variables.
var currCalendar = 0,
currBookingForm = 0,
clearClick = true,
calendarLoaded = false,
messageTimeout,
$jDOPBSP = jQuery.noConflict();

$jDOPBSP(document).ready(function(){
    if (typeof DOPBSP_curr_page !== 'undefined'){
        dopbspResize();

        switch (DOPBSP_curr_page){
            case 'Calendars List':
                dopbspShowCalendars();
                break;
            case 'Forms List':
                dopbspShowBookingForms();
                break;
            case 'Settings':
                dopbspShowUsersPermissions();
                break;
            case 'Settings Post':
                dopbspShowUsersCustomPostsPermissions();
                break;
        }
    }
});

function dopbspResize(){// ResiE admin panel.
    if (DOPBSP_curr_page == 'Calendars List'){
        if (!calendarLoaded){
            $jDOPBSP('.column2', '.DOPBSP-admin').width(($jDOPBSP('.DOPBSP-admin').width()-$jDOPBSP('.column1', '.DOPBSP-admin').width()-2)/2);
            $jDOPBSP('.column3', '.DOPBSP-admin').width(($jDOPBSP('.DOPBSP-admin').width()-$jDOPBSP('.column1', '.DOPBSP-admin').width()-2)/2);
        }
        else{
            $jDOPBSP('.column2', '.DOPBSP-admin').width(620);
            $jDOPBSP('.column3', '.DOPBSP-admin').width($jDOPBSP('.DOPBSP-admin').width()-$jDOPBSP('.column1', '.DOPBSP-admin').width()-$jDOPBSP('.column2', '.DOPBSP-admin').width()-2);
        }
    }
    else{
        $jDOPBSP('.column2', '.DOPBSP-admin').width($jDOPBSP('.DOPBSP-admin').width()-$jDOPBSP('.column1', '.DOPBSP-admin').width()-2);
        $jDOPBSP('.column3', '.DOPBSP-admin').width(0);
    }
    
    $jDOPBSP('.column-separator', '.DOPBSP-admin').height(0);
    $jDOPBSP('.column-separator', '.DOPBSP-admin').height($jDOPBSP('.DOPBSP-admin').height()-$jDOPBSP('h2', '.DOPBSP-admin').height()-parseInt($jDOPBSP('h2', '.DOPBSP-admin').css('padding-top'))-parseInt($jDOPBSP('h2', '.DOPBSP-admin').css('padding-bottom')));
    $jDOPBSP('.main', '.DOPBSP-admin').css('display', 'block');
    
    setTimeout(function(){
        dopbspResize();
    }, 100);
}

function dopbspResizeOneTime(){// ResiE admin panel.
    if (!calendarLoaded){
        $jDOPBSP('.column2', '.DOPBSP-admin').width(($jDOPBSP('.DOPBSP-admin').width()-$jDOPBSP('.column1', '.DOPBSP-admin').width()-2)/2);
        $jDOPBSP('.column3', '.DOPBSP-admin').width(($jDOPBSP('.DOPBSP-admin').width()-$jDOPBSP('.column1', '.DOPBSP-admin').width()-2)/2);
    }
    else{
        $jDOPBSP('.column2', '.DOPBSP-admin').width(620);
        $jDOPBSP('.column3', '.DOPBSP-admin').width($jDOPBSP('.DOPBSP-admin').width()-$jDOPBSP('.column1', '.DOPBSP-admin').width()-$jDOPBSP('.column2', '.DOPBSP-admin').width()-2);
    }
    
    $jDOPBSP('.column-separator', '.DOPBSP-admin').height(0);
    $jDOPBSP('.column-separator', '.DOPBSP-admin').height($jDOPBSP('.DOPBSP-admin').height()-$jDOPBSP('h2', '.DOPBSP-admin').height()-parseInt($jDOPBSP('h2', '.DOPBSP-admin').css('padding-top'))-parseInt($jDOPBSP('h2', '.DOPBSP-admin').css('padding-bottom')));
    $jDOPBSP('.main', '.DOPBSP-admin').css('display', 'block');
}

//****************************************************************************** Translation

function dopbspChangeTranslation(){
    if (clearClick){
        dopbspToggleMessage('show', DOPBSP_SAVE);
        clearClick = false;
        $jDOPBSP.post(ajaxurl, {action: 'dopbsp_change_translation',
                                language: $jDOPBSP('#DOPBSP-admin-translation').val()}, function(data){
            window.location.reload();
        });
    }
}

//****************************************************************************** Calendars

function dopbspShowCalendars(){// Show all calendars.
    if (clearClick){
        dopbspRemoveColumns(1);
        dopbspToggleMessage('show', DOPBSP_LOAD);
        clearClick = false;
        
        if (dopbspGetUrlVars()["action"] == 'edit'){
            $jDOPBSP('.column1', '.DOPBSP-admin').remove();
            $jDOPBSP('.DOPBSP-admin .column-separator:first-child').remove();
        }
        
        $jDOPBSP.post(ajaxurl, {action: 'dopbsp_show_calendars'}, function(data){
            var post_id = dopbspGetUrlVars()["post"],
            action = dopbspGetUrlVars()["action"];
            
            if (action != 'edit'){
                $jDOPBSP('.column-content', '.column1', '.DOPBSP-admin').html(data);
                dopbspCalendarsEvents();
                dopbspToggleMessage('hide', DOPBSP_CALENDARS_LOADED);
            }
            else{
                // Show Post calendar
                $jDOPBSP.post(ajaxurl, {action: 'dopbsp_show_calendar_id', post_id: post_id}, function(data){
                    var id = data.split(';;;;;')[0];
                    var name = data.split(';;;;;')[1];
                    dopbspShowCalendar(id);
                });
            }
            clearClick = true;
            
        });
    }
}

function dopbspAddCalendar(){// Add calendar via AJAX.
    if (clearClick){
        dopbspRemoveColumns(2);
        dopbspToggleMessage('show', DOPBSP_ADD_CALENDAR_SUBMITED);
        
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_add_calendar'}, function(data){
            $jDOPBSP('.column-content', '.column1', '.DOPBSP-admin').html(data);
            dopbspCalendarsEvents();
            dopbspToggleMessage('hide', DOPBSP_ADD_CALENDAR_SUCCESS);
        });
    }
}

function dopbspCalendarsEvents(){// Init Calendar Events.
    $jDOPBSP('li', '.column1', '.DOPBSP-admin').click(function(){
        if (clearClick){
            var id = $jDOPBSP(this).attr('id').split('-')[2];
            
            if (currCalendar != id){
                currCalendar = id;
                $jDOPBSP('li', '.column1', '.DOPBSP-admin').removeClass('item-selected');
                $jDOPBSP(this).addClass('item-selected');
                dopbspShowCalendar(id);
            }
        }
    });
}

function dopbspShowCalendar(calendar_id){// Show Images List.
    if (clearClick){
        $jDOPBSP('#calendar_id').val(calendar_id);
        dopbspRemoveColumns(2);
        calendarLoaded = true;            
        dopbspToggleMessage('show', DOPBSP_LOAD);
        
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_show_calendar', calendar_id:calendar_id}, function(data){
            var HeaderHTML = new Array();
            
            HeaderHTML.push('<div class="edit-button">');
            HeaderHTML.push('    <a href="javascript:dopbspShowCalendarSettings()" title="'+DOPBSP_EDIT_CALENDAR_SUBMIT+'"></a>');
            HeaderHTML.push('</div>');
            HeaderHTML.push('<div class="reservations-button">');
            HeaderHTML.push('    <a href="javascript:void(0)" id="DOPBSP-reservations" title="'+DOPBSP_SHOW_RESERVATIONS+'"><span></span></a>');
            HeaderHTML.push('</div>');
            
            if (DOPBSP_user_role == 'administrator'){
                var post_type = dopbspGetUrlVars()["post_type"];
                var post_action = dopbspGetUrlVars()["action"];
                if (post_type != 'dopbsp' && post_action != 'edit') {
                HeaderHTML.push('<div class="users-permissions-button">');
                HeaderHTML.push('    <a href="javascript:dopbspCalendarUsersPermissionsSettings()" title="'+DOPBSP_EDIT_CALENDAR_USERS_PERMISSIONS+'"></a>');
                HeaderHTML.push('</div>');
                }
            }
            
            if (DOPBSP_user_role == 'administrator'){
                HeaderHTML.push('<a href="javascript:void()" class="header-help"><span>'+DOPBSP_CALENDAR_EDIT_ADMINISTRATOR_HELP+'</span></a>');
            }
            else{
                HeaderHTML.push('<a href="javascript:void()" class="header-help"><span>'+DOPBSP_CALENDAR_EDIT_HELP+'</span></a>');
            }
            
            $jDOPBSP('.column-header', '.column2', '.DOPBSP-admin').html(HeaderHTML.join(''));
            $jDOPBSP('.column-content', '.column2', '.DOPBSP-admin').html('<div id="DOPBSP-Calendar"></div>');
            
            $jDOPBSP('#DOPBSP-Calendar').DOPBookingSystemPRO($jDOPBSP.parseJSON(data));
                        
            $jDOPBSP.post(ajaxurl, {action:'dopbsp_show_no_reservations', calendar_id:calendar_id}, function(data){
                if (parseInt(data) != 0){
                    $jDOPBSP('#DOPBSP-reservations').addClass('new');
                    $jDOPBSP('#DOPBSP-reservations span').html(data);
                }
            });            
        });
    }
}

//****************************************************************************** Settings

function dopbspShowCalendarSettings(){// Show calendar settings.
    if (clearClick){
        $jDOPBSP('li', '.column2', '.DOPBSP-admin').removeClass('item-image-selected');
        dopbspRemoveColumns(2);
        dopbspToggleMessage('show', DOPBSP_LOAD);
        
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_show_calendar_settings', calendar_id:$jDOPBSP('#calendar_id').val()}, function(data){
            var HeaderHTML = new Array(),
            json = $jDOPBSP.parseJSON(data);
            
            HeaderHTML.push('<input type="button" name="DOPBSP_calendar_submit" class="submit-style" onclick="dopbspEditCalendar()" title="'+DOPBSP_EDIT_CALENDAR_SUBMIT+'" value="'+DOPBSP_SUBMIT+'" />');
            
            if (dopbspGetUrlVars()["action"] != 'edit'){
                HeaderHTML.push('<input type="button" name="DOPBSP_calendar_delete" class="submit-style" onclick="dopbspDeleteCalendar('+$jDOPBSP('#calendar_id').val()+')" title="'+DOPBSP_DELETE_CALENDAR_SUBMIT+'" value="'+DOPBSP_DELETE+'" />');
            }
            HeaderHTML.push('<input type="button" name="DOPBSP_calendar_back" class="submit-style" onclick="dopbspShowCalendar('+$jDOPBSP('#calendar_id').val()+')" title="'+DOPBSP_BACK_SUBMIT+'" value="'+DOPBSP_BACK+'" />');
            HeaderHTML.push('<a href="javascript:void()" class="header-help"><span>'+DOPBSP_CALENDAR_EDIT_SETTINGS_HELP+'"></span></a>');
            
            $jDOPBSP('.column-header', '.column2', '.DOPBSP-admin').html(HeaderHTML.join(''));
            dopbspSettingsForm(json, 2);
            
            dopbspToggleMessage('hide', DOPBSP_CALENDAR_LOADED);
        });
    }
}

function dopbspEditCalendar(){// Edit Calendar Settings.
    if (clearClick){
        dopbspToggleMessage('show', DOPBSP_SAVE);
        
        var availableDays = '', i,
        hoursDefinitions = new Array(),
        hours = new Array(),
        discountsNoDays = new Array();
            
        for (i=0; i<7; i++){    
            if ($jDOPBSP('#available_days'+i).is(':checked')){
                if (i == 0){
                    availableDays += 'true';
                }
                else{
                    availableDays += ',true';                    
                }                
            } 
            else{
                if (i == 0){
                    availableDays += 'false';
                }
                else{
                    availableDays += ',false';                    
                }
            }
        }
        
        if ($jDOPBSP('#hours_definitions').val() != ''){
            hoursDefinitions = $jDOPBSP('#hours_definitions').val().split('\n');

            for (i=0; i<hoursDefinitions.length; i++){
                hoursDefinitions[i] = hoursDefinitions[i].replace(/\s/g, "");
                                    
                if (hoursDefinitions[i] != ''){
                    hours.push({'value': hoursDefinitions[i]});
                }
            }
        }
        else{
            hours.push({'value': '00:00'});
        }
        
        $jDOPBSP('#discounts_no_days option').each(function(){
            discountsNoDays.push($jDOPBSP(this).attr('value'));
        });
        
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_edit_calendar',
                                calendar_id: $jDOPBSP('#calendar_id').val(),
                                name: $jDOPBSP('#name').val(),
                                available_days: availableDays,
                                first_day: $jDOPBSP('#first_day').val(),
                                currency: $jDOPBSP('#currency').val(),
                                date_type: $jDOPBSP('#date_type').val(),
                                template: $jDOPBSP('#template').val(),
                                min_stay: $jDOPBSP('#min_stay').val(),
                                max_stay: $jDOPBSP('#max_stay').val(),
                                no_items_enabled: $jDOPBSP('#no_items_enabled').val(),
                                view_only: $jDOPBSP('#view_only').val(),
                                page_url: $jDOPBSP('#page_url').val(),
                                template_email: $jDOPBSP('#template_email').val(),
                                notifications_email: $jDOPBSP('#notifications_email').val(),
                                smtp_enabled: $jDOPBSP('#smtp_enabled').val(),
                                smtp_host_name: $jDOPBSP('#smtp_host_name').val(),
                                smtp_host_port: $jDOPBSP('#smtp_host_port').val(),
                                smtp_ssl: $jDOPBSP('#smtp_ssl').val(),
                                smtp_user: $jDOPBSP('#smtp_user').val(),
                                smtp_password: $jDOPBSP('#smtp_password').val(),
                                multiple_days_select: $jDOPBSP('#multiple_days_select').val(),
                                morning_check_out: $jDOPBSP('#morning_check_out').val(),
                                details_from_hours: $jDOPBSP('#details_from_hours').val(),
                                hours_enabled: $jDOPBSP('#hours_enabled').val(),
                                hours_info_enabled: $jDOPBSP('#hours_info_enabled').val(),
                                hours_definitions: hours,
                                multiple_hours_select: $jDOPBSP('#multiple_hours_select').val(),
                                hours_ampm: $jDOPBSP('#hours_ampm').val(),
                                last_hour_to_total_price: $jDOPBSP('#last_hour_to_total_price').val(),
                                hours_interval_enabled: $jDOPBSP('#hours_interval_enabled').val(),
                                discounts_no_days: discountsNoDays.join(','),
                                deposit: $jDOPBSP('#deposit').val(),
                                form: $jDOPBSP('#form').val(),
                                instant_booking: $jDOPBSP('#instant_booking').val(),
                                no_people_enabled: $jDOPBSP('#no_people_enabled').val(),
                                min_no_people: $jDOPBSP('#min_no_people').val(),
                                max_no_people: $jDOPBSP('#max_no_people').val(),
                                no_children_enabled: $jDOPBSP('#no_children_enabled').val(),
                                min_no_children: $jDOPBSP('#min_no_children').val(),
                                max_no_children: $jDOPBSP('#max_no_children').val(),
                                terms_and_conditions_enabled: $jDOPBSP('#terms_and_conditions_enabled').val(),
                                terms_and_conditions_link: $jDOPBSP('#terms_and_conditions_link').val(),
                                payment_arrival_enabled: $jDOPBSP('#payment_arrival_enabled').val(),
                                payment_paypal_enabled: $jDOPBSP('#payment_paypal_enabled').val(),
                                payment_paypal_username: $jDOPBSP('#payment_paypal_username').val(),
                                payment_paypal_password: $jDOPBSP('#payment_paypal_password').val(),
                                payment_paypal_signature: $jDOPBSP('#payment_paypal_signature').val(),
                                payment_paypal_credit_card: $jDOPBSP('#payment_paypal_credit_card').val(),
                                payment_paypal_sandbox_enabled: $jDOPBSP('#payment_paypal_sandbox_enabled').val()}, function(data){
            if ($jDOPBSP('#calendar_id').val() != '0'){
                $jDOPBSP('.name', '#DOPBSP-ID-'+$jDOPBSP('#calendar_id').val()).html(dopbspShortName($jDOPBSP('#name').val(), 25));
                dopbspToggleMessage('hide', DOPBSP_EDIT_CALENDAR_SUCCESS);
            }
            else{
                dopbspToggleMessage('hide', DOPBSP_EDIT_CALENDARS_SUCCESS);
            }
        });
    }
}

function dopbspCalendarUsersPermissionsSettings(){// Users who can manage this calendar.
    if (clearClick){
        $jDOPBSP('li', '.column2', '.DOPBSP-admin').removeClass('item-image-selected');
        dopbspRemoveColumns(2);
        dopbspToggleMessage('show', DOPBSP_LOAD);
        
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_calendar_users_permissions_settings', calendar_id:$jDOPBSP('#calendar_id').val()}, function(data){
            var HeaderHTML = new Array(),
            json = $jDOPBSP.parseJSON(data);
            
            HeaderHTML.push('<input type="button" name="DOPBSP_calendar_back" class="submit-style" onclick="dopbspShowCalendar('+$jDOPBSP('#calendar_id').val()+')" title="'+DOPBSP_BACK_SUBMIT+'" value="'+DOPBSP_BACK+'" />');
            HeaderHTML.push('<a href="javascript:void()" class="header-help"><span>'+DOPBSP_USERS_PERMISSIONS_HELP+'</span></a>');
            
            $jDOPBSP('.column-header', '.column2', '.DOPBSP-admin').html(HeaderHTML.join(''));

            dopbspPermissionsForm(json, 2);
            
            dopbspToggleMessage('hide', DOPBSP_CALENDAR_LOADED);
        });
    }
}

function dopbspDeleteCalendar(id){// Delete calendar
    if (clearClick){
        if (confirm(DOPBSP_DELETE_CALENDAR_CONFIRMATION)){
            dopbspToggleMessage('show', DOPBSP_DELETE_CALENDAR_SUBMITED);
            
            $jDOPBSP.post(ajaxurl, {action:'dopbsp_delete_calendar', id:id}, function(data){
                dopbspRemoveColumns(2);
                
                $jDOPBSP('#DOPBSP-ID-'+id).stop(true, true).animate({'opacity':0}, 600, function(){
                    $jDOPBSP(this).remove();
                    
                    if (data == '0'){
                        $jDOPBSP('.column-content', '.column1', '.DOPBSP-admin').html('<ul><li class="no-data">'+DOPBSP_NO_CALENDARS+'</li></ul>');
                    }
                    dopbspToggleMessage('hide', DOPBSP_DELETE_CALENDAR_SUCCESS);
                });
            });
        }
    }
}

function dopbspRemoveColumns(no){// Clear columns content.
    if (no <= 1){
        $jDOPBSP('.column-content', '.column1', '.DOPBSP-admin').html('');
    }
    if (no <= 2){
        $jDOPBSP('.column-header', '.column2', '.DOPBSP-admin').html('');
        $jDOPBSP('.column-content', '.column2', '.DOPBSP-admin').html('');
        calendarLoaded = false;
    }
    if (no <= 3){
        $jDOPBSP('.column-header', '.column3', '.DOPBSP-admin').html('');
        $jDOPBSP('.column-content', '.column3', '.DOPBSP-admin').html('');        
    }
}

function dopbspToggleMessage(action, message){// Display Info Messages.
    if (action == 'show'){
        clearClick = false;        
        clearTimeout(messageTimeout);
        $jDOPBSP('#DOPBSP-admin-message').addClass('loader');
        $jDOPBSP('#DOPBSP-admin-message').html(message);
        $jDOPBSP('#DOPBSP-admin-message').stop(true, true).animate({'opacity':1}, 600);
    }
    else{
        clearClick = true;
        $jDOPBSP('#DOPBSP-admin-message').removeClass('loader');
        $jDOPBSP('#DOPBSP-admin-message').html(message);
        
        messageTimeout = setTimeout(function(){
            $jDOPBSP('#DOPBSP-admin-message').stop(true, true).animate({'opacity':0}, 600, function(){
                $jDOPBSP('#DOPBSP-admin-message').html('');
            });
        }, 2000);
    }
}

function dopbspSettingsForm(data, column){// Settings Form.
    var HTML = new Array(), i,
    discountsNoDays = data['discounts_no_days'].split(','),
    discountsNoDaysValues = new Array(), 
    discountsNoDaysLabels = new Array(),
    formsItems = data['forms'].split(';;;'),
    formsValues = new Array(),
    formsLabels = new Array();
    
    for (i=0; i<formsItems.length; i++){
        formsValues.push(formsItems[i].split(';;')[0]);
        formsLabels.push(formsItems[i].split(';;')[1]);
    }
    
    HTML.push('<form method="post" class="settings" action="" onsubmit="return false;">');

// General Settings
    HTML.push('    <h3 class="settings">'+DOPBSP_GENERAL_STYLES_SETTINGS+'</h3>');
    
    if ($jDOPBSP('#calendar_id').val() != '0'){
        HTML.push(dopbspSettingsFormInput('name', data['name'], DOPBSP_CALENDAR_NAME, '', '', '', 'help', DOPBSP_CALENDAR_NAME_INFO));
    }
    HTML.push(dopbspSettingsFormAvailableDays('available_days', data['available_days'], DOPBSP_AVAILABLE_DAYS, '', '', '', 'help', DOPBSP_AVAILABLE_DAYS_INFO));
    HTML.push(dopbspSettingsFormSelect('first_day', data['first_day'], DOPBSP_FIRST_DAY, '', '', '', 'help', DOPBSP_FIRST_DAY_INFO, '1;;2;;3;;4;;5;;6;;7', DOPBSP_day_names[1]+';;'+DOPBSP_day_names[2]+';;'+DOPBSP_day_names[3]+';;'+DOPBSP_day_names[4]+';;'+DOPBSP_day_names[5]+';;'+DOPBSP_day_names[6]+';;'+DOPBSP_day_names[0]));
    HTML.push(dopbspSettingsFormSelect('currency', data['currency'], DOPBSP_CURRENCY, '', '', '', 'help', DOPBSP_CURRENCY_INFO, data['currencies_ids'], data['currencies_labels']));
    HTML.push(dopbspSettingsFormSelect('date_type', data['date_type'], DOPBSP_DATE_TYPE, '', '', '', 'help', DOPBSP_DATE_TYPE_INFO, '1;;2', DOPBSP_DATE_TYPE_AMERICAN+';;'+DOPBSP_DATE_TYPE_EUROPEAN));
    HTML.push(dopbspSettingsFormSelect('template', data['template'], DOPBSP_TEMPLATE, '', '', '', 'help', DOPBSP_TEMPLATE_INFO, data['templates'], data['templates']));
    HTML.push(dopbspSettingsFormInput('min_stay', data['min_stay'], DOPBSP_MIN_STAY, '', '', '', 'help', DOPBSP_MIN_STAY_INFO));  
    HTML.push(dopbspSettingsFormInput('max_stay', data['max_stay'], DOPBSP_MAX_STAY, '', '', '', 'help', DOPBSP_MAX_STAY_INFO));  
    HTML.push(dopbspSettingsFormSelect('no_items_enabled', data['no_items_enabled'], DOPBSP_NO_ITEMS_ENABLED, '', '', '', 'help', DOPBSP_NO_ITEMS_ENABLED_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));
    HTML.push(dopbspSettingsFormSelect('view_only', data['view_only'], DOPBSP_VIEW_ONLY, '', '', '', 'help', DOPBSP_VIEW_ONLY_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));
    HTML.push(dopbspSettingsFormInput('page_url', data['page_url'], DOPBSP_PAGE_URL, '', '', '', 'help', DOPBSP_PAGE_URL_INFO));  
    
// Notifications Settings
    HTML.push('    <a href="javascript:dopbspMoveTop()" class="go-top">'+DOPBSP_GO_TOP+'</a><h3 class="settings">'+DOPBSP_NOTIFICATIONS_STYLES_SETTINGS+'</h3>'); 
    HTML.push(dopbspSettingsFormSelect('template_email', data['template_email'], DOPBSP_NOTIFICATIONS_TEMPLATE, '', '', '', 'help', DOPBSP_NOTIFICATIONS_TEMPLATE_INFO, data['templates_email'], data['templates_email']));
    HTML.push(dopbspSettingsFormInput('notifications_email', data['notifications_email'], DOPBSP_NOTIFICATIONS_EMAIL, '', '', '', 'help', DOPBSP_NOTIFICATIONS_EMAIL_INFO));  
    HTML.push(dopbspSettingsFormSelect('smtp_enabled', data['smtp_enabled'], DOPBSP_NOTIFICATIONS_SMTP_ENABLED, '', '', '', 'help', DOPBSP_NOTIFICATIONS_SMTP_ENABLED_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));     
    HTML.push(dopbspSettingsFormInput('smtp_host_name', data['smtp_host_name'], DOPBSP_NOTIFICATIONS_SMTP_HOST_NAME, '', '', '', 'help', DOPBSP_NOTIFICATIONS_SMTP_HOST_NAME_INFO));  
    HTML.push(dopbspSettingsFormInput('smtp_host_port', data['smtp_host_port'], DOPBSP_NOTIFICATIONS_SMTP_HOST_PORT, '', '', '', 'help', DOPBSP_NOTIFICATIONS_SMTP_HOST_PORT_INFO));  
    HTML.push(dopbspSettingsFormSelect('smtp_ssl', data['smtp_ssl'], DOPBSP_NOTIFICATIONS_SMTP_SSL, '', '', '', 'help', DOPBSP_NOTIFICATIONS_SMTP_SSL_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));                           
    HTML.push(dopbspSettingsFormInput('smtp_user', data['smtp_user'], DOPBSP_NOTIFICATIONS_SMTP_USER, '', '', '', 'help', DOPBSP_NOTIFICATIONS_SMTP_USER_INFO));  
    HTML.push(dopbspSettingsFormInput('smtp_password', data['smtp_password'], DOPBSP_NOTIFICATIONS_SMTP_PASSWORD, '', '', '', 'help', DOPBSP_NOTIFICATIONS_SMTP_PASSWORD_INFO));  
    
// Days Settings
    HTML.push('    <a href="javascript:dopbspMoveTop()" class="go-top">'+DOPBSP_GO_TOP+'</a><h3 class="settings">'+DOPBSP_DAYS_STYLES_SETTINGS+'</h3>'); 
    HTML.push(dopbspSettingsFormSelect('multiple_days_select', data['multiple_days_select'], DOPBSP_MULTIPLE_DAYS_SELECT, '', '', '', 'help', DOPBSP_MULTIPLE_DAYS_SELECT_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));  
    HTML.push(dopbspSettingsFormSelect('morning_check_out', data['morning_check_out'], DOPBSP_MORNING_CHECK_OUT, '', '', '', 'help', DOPBSP_MORNING_CHECK_OUT_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED)); 
    HTML.push(dopbspSettingsFormSelect('details_from_hours', data['details_from_hours'], DOPBSP_DETAILS_FROM_HOURS, '', '', '', 'help', DOPBSP_DETAILS_FROM_HOURS_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED)); 
    
// Hours Settings
    HTML.push('    <a href="javascript:dopbspMoveTop()" class="go-top">'+DOPBSP_GO_TOP+'</a><h3 class="settings">'+DOPBSP_HOURS_STYLES_SETTINGS+'</h3>');     
    HTML.push(dopbspSettingsFormSelect('hours_enabled', data['hours_enabled'], DOPBSP_HOURS_ENABLED, '', '', '', 'help', DOPBSP_HOURS_ENABLED_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));  
    HTML.push(dopbspSettingsFormSelect('hours_info_enabled', data['hours_info_enabled'], DOPBSP_HOURS_INFO_ENABLED, '', '', '', 'help', DOPBSP_HOURS_INFO_ENABLED_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));  
    HTML.push(dopbspSettingsFormHoursDefinitions('hours_definitions', data['hours_definitions'], DOPBSP_HOURS_DEFINITIONS, '', '', '', 'help', DOPBSP_HOURS_DEFINITIONS_INFO));
    HTML.push(dopbspSettingsFormSelect('multiple_hours_select', data['multiple_hours_select'], DOPBSP_MULTIPLE_HOURS_SELECT, '', '', '', 'help', DOPBSP_MULTIPLE_HOURS_SELECT_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));
    HTML.push(dopbspSettingsFormSelect('hours_ampm', data['hours_ampm'], DOPBSP_HOURS_AMPM, '', '', '', 'help', DOPBSP_HOURS_AMPM_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));
    HTML.push(dopbspSettingsFormSelect('last_hour_to_total_price', data['last_hour_to_total_price'], DOPBSP_LAST_HOUR_TO_TOTAL_PRICE, '', '', '', 'help', DOPBSP_LAST_HOUR_TO_TOTAL_PRICE_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));
    HTML.push(dopbspSettingsFormSelect('hours_interval_enabled', data['hours_interval_enabled'], DOPBSP_HOURS_INTERVAL_ENABLED, '', '', '', 'help', DOPBSP_HOURS_INTERVAL_ENABLED_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));

// Discounts by Number of Days
    HTML.push('    <a href="javascript:dopbspMoveTop()" class="go-top">'+DOPBSP_GO_TOP+'</a><h3 class="settings">'+DOPBSP_DISCOUNTS_NO_DAYS_SETTINGS+'</h3>');
    
    for (i=2; i<=31; i++){
        discountsNoDaysValues.push(discountsNoDays[i-2]);
        discountsNoDaysLabels.push(i+' '+DOPBSP_DISCOUNTS_NO_DAYS_DAYS+' ('+(discountsNoDays[i-2] != 0 ? '-':'')+discountsNoDays[i-2]+'%)');
    }
    
    HTML.push(dopbspSettingsFormSelect('discounts_no_days', '-1', DOPBSP_DISCOUNTS_NO_DAYS, '', '', '', 'help', DOPBSP_DISCOUNTS_NO_DAYS_INFO, discountsNoDaysValues.join(';;'), discountsNoDaysLabels.join(';;')));
    HTML.push(dopbspSettingsFormInput('discount_no_days', discountsNoDays[0], '2 '+DOPBSP_DISCOUNTS_NO_DAYS_DAYS, '-', '%', 'small', 'help-small', DOPBSP_DISCOUNTS_NO_DAYS_DAYS_INFO));

// Deposit
    HTML.push('    <a href="javascript:dopbspMoveTop()" class="go-top">'+DOPBSP_GO_TOP+'</a><h3 class="settings">'+DOPBSP_DEPOSIT_SETTINGS+'</h3>');
    HTML.push(dopbspSettingsFormInput('deposit', data['deposit'], DOPBSP_DEPOSIT, '', '%', 'small', 'help-small', DOPBSP_DEPOSIT_INFO));

// Contact Form Settings
    HTML.push('    <a href="javascript:dopbspMoveTop()" class="go-top">'+DOPBSP_GO_TOP+'</a><h3 class="settings">'+DOPBSP_FORM_STYLES_SETTINGS+'</h3>');
    HTML.push(dopbspSettingsFormSelect('form', data['form'], DOPBSP_FORM, '', '', '', 'help', DOPBSP_FORM_INFO, formsValues.join(';;'), formsLabels.join(';;')));
    HTML.push(dopbspSettingsFormSelect('instant_booking', data['instant_booking'], DOPBSP_INSTANT_BOOKING_ENABLED, '', '', '', 'help', DOPBSP_INSTANT_BOOKING_ENABLED_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));   
    HTML.push(dopbspSettingsFormSelect('no_people_enabled', data['no_people_enabled'], DOPBSP_NO_PEOPLE_ENABLED, '', '', '', 'help', DOPBSP_NO_PEOPLE_ENABLED_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));   
    HTML.push(dopbspSettingsFormInput('min_no_people', data['min_no_people'], DOPBSP_MIN_NO_PEOPLE, '', '', 'small', 'help-small', DOPBSP_MIN_NO_PEOPLE_INFO));
    HTML.push(dopbspSettingsFormInput('max_no_people', data['max_no_people'], DOPBSP_MAX_NO_PEOPLE, '', '', 'small', 'help-small', DOPBSP_MAX_NO_PEOPLE_INFO));
    HTML.push(dopbspSettingsFormSelect('no_children_enabled', data['no_children_enabled'], DOPBSP_NO_CHILDREN_ENABLED, '', '', '', 'help', DOPBSP_NO_CHILDREN_ENABLED_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));   
    HTML.push(dopbspSettingsFormInput('min_no_children', data['min_no_children'], DOPBSP_MIN_NO_CHILDREN, '', '', 'small', 'help-small', DOPBSP_MIN_NO_CHILDREN_INFO));
    HTML.push(dopbspSettingsFormInput('max_no_children', data['max_no_children'], DOPBSP_MAX_NO_CHILDREN, '', '', 'small', 'help-small', DOPBSP_MAX_NO_CHILDREN_INFO));
    HTML.push(dopbspSettingsFormSelect('payment_arrival_enabled', data['payment_arrival_enabled'], DOPBSP_PAYMENT_ARRIVAL_ENABLED, '', '', '', 'help', DOPBSP_PAYMENT_ARRIVAL_ENABLED_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));
    HTML.push(dopbspSettingsFormSelect('terms_and_conditions_enabled', data['terms_and_conditions_enabled'], DOPBSP_TERMS_AND_CONDITIONS_ENABLED, '', '', '', 'help', DOPBSP_TERMS_AND_CONDITIONS_ENABLED_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));
    HTML.push(dopbspSettingsFormInput('terms_and_conditions_link', data['terms_and_conditions_link'], DOPBSP_TERMS_AND_CONDITIONS_LINK, '', '', '', 'help', DOPBSP_TERMS_AND_CONDITIONS_LINK_INFO));

// PayPal Settings
    HTML.push('    <a href="javascript:dopbspMoveTop()" class="go-top">'+DOPBSP_GO_TOP+'</a><h3 class="settings">'+DOPBSP_PAYMENT_PAYPAL_STYLES_SETTINGS+'</h3>');  
    HTML.push(dopbspSettingsFormSelect('payment_paypal_enabled', data['payment_paypal_enabled'], DOPBSP_PAYMENT_PAYPAL_ENABLED, '', '', '', 'help', DOPBSP_PAYMENT_PAYPAL_ENABLED_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));
    HTML.push(dopbspSettingsFormInput('payment_paypal_username', data['payment_paypal_username'], DOPBSP_PAYMENT_PAYPAL_USERNAME, '', '', '', 'help', DOPBSP_PAYMENT_PAYPAL_USERNAME_INFO));
    HTML.push(dopbspSettingsFormInput('payment_paypal_password', data['payment_paypal_password'], DOPBSP_PAYMENT_PAYPAL_PASSWORD, '', '', '', 'help', DOPBSP_PAYMENT_PAYPAL_PASSWORD_INFO));
    HTML.push(dopbspSettingsFormInput('payment_paypal_signature', data['payment_paypal_signature'], DOPBSP_PAYMENT_PAYPAL_SIGNATURE, '', '', '', 'help', DOPBSP_PAYMENT_PAYPAL_SIGNATURE_INFO));
    HTML.push(dopbspSettingsFormSelect('payment_paypal_credit_card', data['payment_paypal_credit_card'], DOPBSP_PAYMENT_PAYPAL_CREDIT_CARD, '', '', '', 'help', DOPBSP_PAYMENT_PAYPAL_CREDIT_CARD_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));
    HTML.push(dopbspSettingsFormSelect('payment_paypal_sandbox_enabled', data['payment_paypal_sandbox_enabled'], DOPBSP_PAYMENT_PAYPAL_SANDBOX_ENABLED, '', '', '', 'help', DOPBSP_PAYMENT_PAYPAL_SANDBOX_ENABLED_INFO, 'true;;false', DOPBSP_ENABLED+';;'+DOPBSP_DISABLED));

    HTML.push('</form>');
    $jDOPBSP('.column-content', '.column'+column, '.DOPBSP-admin').html(HTML.join(''));
    
    $jDOPBSP('#discounts_no_days').unbind('change');
    $jDOPBSP('#discounts_no_days').bind('change', function(){
        $jDOPBSP('#discount_no_days').val($jDOPBSP('#discounts_no_days').val());
        $jDOPBSP('label', $jDOPBSP('#discount_no_days').parent()).html(($jDOPBSP(this).prop('selectedIndex')+2)+' '+DOPBSP_DISCOUNTS_NO_DAYS_DAYS);
    });
    
    $jDOPBSP('#discount_no_days').unbind('keyup');
    $jDOPBSP('#discount_no_days').bind('keyup', function(){
        dopbspCleanInput(this, '0123456789.', '0', '');
        $jDOPBSP('#discounts_no_days').find(":selected").val($jDOPBSP(this).val());
        $jDOPBSP('#discounts_no_days').find(":selected").text(($jDOPBSP('#discounts_no_days').prop('selectedIndex')+2)+' '+DOPBSP_DISCOUNTS_NO_DAYS_DAYS+' ('+($jDOPBSP(this).val() != '0' ? '-':'')+$jDOPBSP(this).val()+'%)');
    });
    
    $jDOPBSP('#deposit').unbind('keyup');
    $jDOPBSP('#deposit').bind('keyup', function(){
        dopbspCleanInput(this, '0123456789.', '0', '');
    });
}

function dopbspSettingsFormInput(id, value, label, pre, suf, input_class, help_class, help){// Create an Input Field.
    var inputHTML = new Array();

    inputHTML.push('    <div class="setting-box">');
    inputHTML.push('        <label for="'+id+'">'+label+'</label>');
    inputHTML.push('        <span class="pre">'+pre+'</span><input type="text" class="'+input_class+'" name="'+id+'" id="'+id+'" value="'+value+'" /><span class="suf">'+suf+'</span>');
    inputHTML.push('        <a href="javascript:void()" class="'+help_class+'"><span>'+help+'</span></a>');
    inputHTML.push('        <br class="DOPBSP-clear" />');
    inputHTML.push('    </div>');

    return inputHTML.join('');
}

function dopbspSettingsFormAvailableDays(id, value, label, pre, suf, textarea_class, help_class, help){// Create an Input Field.
    var inputHTML = new Array(),
    content = value.split(',');
    
    inputHTML.push('    <div class="setting-box">');
    inputHTML.push('        <label>'+label+'</label>');
    inputHTML.push('        <span class="pre">'+pre+'</span>');
    inputHTML.push('        <span class="days">');
    inputHTML.push('            <input type="checkbox" name="'+id+'0" id="'+id+'0"'+(content[0] == 'true' ? ' checked="checked"':'')+' /><label for="'+id+'0">'+DOPBSP_day_names[0]+'</label><br class="DOPBSP-clear" />');
    inputHTML.push('            <input type="checkbox" name="'+id+'1" id="'+id+'1"'+(content[1] == 'true' ? ' checked="checked"':'')+' /><label for="'+id+'1">'+DOPBSP_day_names[1]+'</label><br class="DOPBSP-clear" />');
    inputHTML.push('            <input type="checkbox" name="'+id+'2" id="'+id+'2"'+(content[2] == 'true' ? ' checked="checked"':'')+' /><label for="'+id+'2">'+DOPBSP_day_names[2]+'</label><br class="DOPBSP-clear" />');
    inputHTML.push('            <input type="checkbox" name="'+id+'3" id="'+id+'3"'+(content[3] == 'true' ? ' checked="checked"':'')+' /><label for="'+id+'3">'+DOPBSP_day_names[3]+'</label><br class="DOPBSP-clear" />');
    inputHTML.push('            <input type="checkbox" name="'+id+'4" id="'+id+'4"'+(content[4] == 'true' ? ' checked="checked"':'')+' /><label for="'+id+'4">'+DOPBSP_day_names[4]+'</label><br class="DOPBSP-clear" />');
    inputHTML.push('            <input type="checkbox" name="'+id+'5" id="'+id+'5"'+(content[5] == 'true' ? ' checked="checked"':'')+' /><label for="'+id+'5">'+DOPBSP_day_names[5]+'</label><br class="DOPBSP-clear" />');
    inputHTML.push('            <input type="checkbox" name="'+id+'6" id="'+id+'6"'+(content[6] == 'true' ? ' checked="checked"':'')+' /><label for="'+id+'6">'+DOPBSP_day_names[6]+'</label><br class="DOPBSP-clear" />');    
    inputHTML.push('        </span>');        
    inputHTML.push('        <span class="suf">'+suf+'</span>');
    inputHTML.push('        <a href="javascript:void()" class="'+help_class+'"><span>'+help+'</span></a>');
    inputHTML.push('        <br class="DOPBSP-clear" />');
    inputHTML.push('    </div>');

    return inputHTML.join('');
}

function dopbspSettingsFormHoursDefinitions(id, value, label, pre, suf, textarea_class, help_class, help){// Create an Input Field.
    var inputHTML = new Array(),
    content = new Array(), i;
    
    for (i=0; i<value.length; i++){
        content.push(value[i]['value']);
    }

    inputHTML.push('    <div class="setting-box">');
    inputHTML.push('        <label for="'+id+'">'+label+'</label>');
    inputHTML.push('        <span class="pre">'+pre+'</span><textarea type="text" class="'+textarea_class+'" name="'+id+'" id="'+id+'" cols="" rows="8">'+content.join('\n')+'</textarea><span class="suf">'+suf+'</span>');
    inputHTML.push('        <a href="javascript:void()" class="'+help_class+'"><span>'+help+'</span></a>');
    inputHTML.push('        <br class="DOPBSP-clear" />');
    inputHTML.push('    </div>');

    return inputHTML.join('');
}

function dopbspSettingsFormSelect(id, value, label, pre, suf, input_class, help_class, help, values, valueLabels){// Create a Combo Box.
    var selectHTML = new Array(), i,
    valuesList = values.split(';;'),
    valueLabelsList = valueLabels.split(';;');

    selectHTML.push('    <div class="setting-box">');
    selectHTML.push('        <label for="'+id+'">'+label+'</label>');
    selectHTML.push('        <span class="pre">'+pre+'</span>');
    
    if (values == 'true;;false'){
        selectHTML.push('        <select name="'+id+'" id="'+id+'" class="'+(value == 'true' ? 'enabled':'disabled')+'" onchange="dopbspSettingsFormSelectEnable(this, this.value)">');
    }
    else{
        selectHTML.push('        <select name="'+id+'" id="'+id+'">');
    }
    
    for (i=0; i<valuesList.length; i++){
        if (valuesList[i] == value){
            selectHTML.push('        <option value="'+valuesList[i]+'" selected="selected">'+valueLabelsList[i]+'</option>');
        }
        else{
            selectHTML.push('        <option value="'+valuesList[i]+'">'+valueLabelsList[i]+'</option>');
        }
    }
    selectHTML.push('            </select>');
    selectHTML.push('        <span class="suf">'+suf+'</span>');
    selectHTML.push('        <a href="javascript:void()" class="'+help_class+'"><span>'+help+'</span></a>');
    selectHTML.push('        <br class="DOPBSP-clear" />');
    selectHTML.push('    </div>');

    return selectHTML.join('');
}

function dopbspSettingsFormSelectEnable(item, value){
    $jDOPBSP(item).removeClass('enabled').removeClass('disabled');
    $jDOPBSP(item).addClass(value == 'true' ? 'enabled':'disabled');
}

// ***************************************************************************** Administrator Settings

// ************************************************************ User Permissions

function dopbspShowUsersPermissions(){
    if (clearClick){
        dopbspRemoveColumns(2);
        dopbspToggleMessage('show', DOPBSP_LOAD);
        clearClick = false;
        
        $jDOPBSP('#dopbsp-user-post-permissions').removeClass('item-selected');
        $jDOPBSP('#dopbsp-user-permissions').addClass('item-selected');
        
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_show_users_permissions'}, function(data){
            $jDOPBSP('.column-content', '.column2', '.DOPBSP-admin').html(data);
            dopbspToggleMessage('hide', '');
            clearClick = true;
            
            dopbspShowHideUsers();
        });
    }
}

function dopbspShowUsersCustomPostsPermissions(){
    if (clearClick){
        dopbspRemoveColumns(2);
        dopbspToggleMessage('show', DOPBSP_LOAD);
        clearClick = false;
        
        $jDOPBSP('#dopbsp-user-post-permissions').addClass('item-selected');
        $jDOPBSP('#dopbsp-user-permissions').removeClass('item-selected');
        
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_show_users_custom_posts_permissions'}, function(data){
            $jDOPBSP('.column-content', '.column2', '.DOPBSP-admin').html(data);
            dopbspToggleMessage('hide', '');
            clearClick = true;
            
            dopbspShowHideUsers();
        });
    }
}

function dopbspEditUserPermissions(id, field, value){
    if (clearClick){
        dopbspToggleMessage('show', DOPBSP_SAVE);
        clearClick = false;
        
        if (value == 'checked'){
            value = 'true';
        }
        else{
            value = 'false';
        }
        
        $jDOPBSP('.DOPSBP-check-all').attr('disabled', 'disabled');
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_edit_user_permissions',
                                id: id,
                                field: field,
                                value: value}, function(data){
            dopbspToggleMessage('hide', DOPBSP_SAVE_SUCCESS);
            clearClick = true;
            $jDOPBSP('.DOPSBP-check-all').removeAttr('disabled');
        });
    }
}

function dopbspEditUserCustomPostsPermissions(id, field, value){
    if (clearClick){
        dopbspToggleMessage('show', DOPBSP_SAVE);
        clearClick = false;
        
        if (value == 'checked'){
            value = 'true';
        }
        else{
            value = 'false';
        }
        
        $jDOPBSP('.DOPSBP-check-all').attr('disabled', 'disabled');
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_edit_user_custom_posts_permissions',
                                id: id,
                                field: field,
                                value: value}, function(data){
                                console.log(data);
            dopbspToggleMessage('hide', DOPBSP_SAVE_SUCCESS);
            clearClick = true;
            $jDOPBSP('.DOPSBP-check-all').removeAttr('disabled');
        });
    }
}

function dopbspEditGeneralUserPermissions(type){
    var checked = '';
    
    if (clearClick){
        $jDOPBSP('.DOPSBP-check-all').attr('disabled', 'disabled');
        clearClick = false;
        
        switch(type){
            case "administrator":
                checked = $jDOPBSP('#dopbsp_administrators_permissions').attr('checked');
                
                if (checked == 'checked'){
                    $jDOPBSP('.DOPSBP-chk-all-admin').attr('checked','checked');
                }
                else {
                    $jDOPBSP('.DOPSBP-chk-all-admin').removeAttr('checked');
                }
                break;
            case "author":
                checked = $jDOPBSP('#dopbsp_authors_permissions').attr('checked');
                
                if (checked == 'checked'){
                    $jDOPBSP('.DOPSBP-chk-all-author').attr('checked','checked');
                }
                else {
                    $jDOPBSP('.DOPSBP-chk-all-author').removeAttr('checked');
                }
                break;
            case "contributor":
                checked = $jDOPBSP('#dopbsp_contributors_permissions').attr('checked');
                
                if (checked == 'checked'){
                    $jDOPBSP('.DOPSBP-chk-all-contributor').attr('checked','checked');
                }
                else {
                    $jDOPBSP('.DOPSBP-chk-all-contributor').removeAttr('checked');
                }
                break;
            case "editor":
                checked = $jDOPBSP('#dopbsp_editors_permissions').attr('checked');
                
                if (checked == 'checked'){
                    $jDOPBSP('.DOPSBP-chk-all-editor').attr('checked','checked');
                }
                else {
                    $jDOPBSP('.DOPSBP-chk-all-editor').removeAttr('checked');
                }
                break;
            case "subscriber":
                checked = $jDOPBSP('#dopbsp_subscribers_permissions').attr('checked');
                
                if (checked == 'checked'){
                    $jDOPBSP('.DOPSBP-chk-all-subscriber').attr('checked','checked');
                }
                else {
                    $jDOPBSP('.DOPSBP-chk-all-subscriber').removeAttr('checked');
                }
                break;

        }
        dopbspToggleMessage('show', DOPBSP_SAVE);
        
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_edit_general_user_permissions',
                                type: type,
                                value: checked}, function(data){
            dopbspToggleMessage('hide', DOPBSP_SAVE_SUCCESS);
            clearClick = true;
            $jDOPBSP('.DOPSBP-check-all').removeAttr('disabled');
        });
    }
}

function dopbspEditGeneralUserCustomPostsPermissions(type){
    var checked = '';
    
    if (clearClick){
        $jDOPBSP('.DOPSBP-check-all').attr('disabled', 'disabled');
        clearClick = false;
        
        switch(type){
            case "administrator":
                checked = $jDOPBSP('#dopbsp_administrators_permissions').attr('checked');
                
                if (checked == 'checked'){
                    $jDOPBSP('.DOPSBP-chk-all-admin').attr('checked','checked');
                }
                else {
                    $jDOPBSP('.DOPSBP-chk-all-admin').removeAttr('checked');
                }
                break;
            case "author":
                checked = $jDOPBSP('#dopbsp_authors_permissions').attr('checked');
                
                if (checked == 'checked'){
                    $jDOPBSP('.DOPSBP-chk-all-author').attr('checked','checked');
                }
                else {
                    $jDOPBSP('.DOPSBP-chk-all-author').removeAttr('checked');
                }
                break;
            case "contributor":
                checked = $jDOPBSP('#dopbsp_contributors_permissions').attr('checked');
                
                if (checked == 'checked'){
                    $jDOPBSP('.DOPSBP-chk-all-contributor').attr('checked','checked');
                }
                else {
                    $jDOPBSP('.DOPSBP-chk-all-contributor').removeAttr('checked');
                }
                break;
            case "editor":
                checked = $jDOPBSP('#dopbsp_editors_permissions').attr('checked');
                
                if (checked == 'checked'){
                    $jDOPBSP('.DOPSBP-chk-all-editor').attr('checked','checked');
                }
                else {
                    $jDOPBSP('.DOPSBP-chk-all-editor').removeAttr('checked');
                }
                break;
            case "subscriber":
                checked = $jDOPBSP('#dopbsp_subscribers_permissions').attr('checked');
                
                if (checked == 'checked'){
                    $jDOPBSP('.DOPSBP-chk-all-subscriber').attr('checked','checked');
                }
                else {
                    $jDOPBSP('.DOPSBP-chk-all-subscriber').removeAttr('checked');
                }
                break;

        }
        dopbspToggleMessage('show', DOPBSP_SAVE);
        
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_edit_general_user_custom_posts_permissions',
                                type: type,
                                value: checked}, function(data){
            dopbspToggleMessage('hide', DOPBSP_SAVE_SUCCESS);
            clearClick = true;
            $jDOPBSP('.DOPSBP-check-all').removeAttr('disabled');
        });
    }
}

function dopbspEditCalendarPermissions(calendar_id){
    if (clearClick){
        dopbspToggleMessage('show', DOPBSP_SAVE);
        clearClick = false;
        
        var noUsers = $jDOPBSP('.DOPSBP-check-all').length-1,
        adminCalendars = '', i;
     
        for(i=0; i<=noUsers; i++){
            var current = $jDOPBSP('.DOPSBP-check-all').eq(i);
            
            if (current.attr('checked') == 'checked'){
               adminCalendars = adminCalendars+','+current.val()+'-1';
            }
            else {
                adminCalendars = adminCalendars+','+current.val()+'-0';
            }
        }
        $jDOPBSP('.DOPSBP-check-all').attr('disabled', 'disabled');
        
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_calendar_users_permissions_update',
                                calendar_id: calendar_id,
                                admin_calendars: adminCalendars}, function(data){
            dopbspToggleMessage('hide', DOPBSP_SAVE_SUCCESS);
            clearClick = true;
            $jDOPBSP('.DOPSBP-check-all').removeAttr('disabled');
        });
    }
}

function dopbspPermissionsForm(data, column){// Settings Form.
    var HTML = new Array(), i;
    
    HTML.push('<form method="post" class="settings" action="" onsubmit="return false;">');

// Authors Settings
    HTML.push('    <a href="javascript:void(0)" id="dopbsp-authors-show-hide" class="show-hide first">'+DOPBSP_USERS_SHOW+'</a>');
    HTML.push('    <h3 class="settings">'+DOPBSP_USERS_AUTHORS+'</h3>');
    HTML.push('    <div class="column-select users" id="dopbsp-authors-list">');
    
    for(i=1; i<=data['authors']; i++){
        HTML.push(dopbspPermissionsFormCheckbox('manage_author_'+i, data['author'][i]['id'], data['author'][i]['name'], '', '', 'DOPSBP-check-all', data['calendar_id'], data['author'][i]['admin_calendars'], data['author'][i]['id'], data['author'][i]['checked']));
    }
    HTML.push('    </div>');

// Contributors Settings
    HTML.push('    <a href="javascript:dopbspMoveTop()" class="go-top">'+DOPBSP_GO_TOP+'</a>');
    HTML.push('    <span class="go-top-separator">|</span>');
    HTML.push('    <a href="javascript:void(0)" id="dopbsp-contributors-show-hide" class="show-hide">'+DOPBSP_USERS_SHOW+'</a>');
    HTML.push('    <h3 class="settings">'+DOPBSP_USERS_CONTRIBUTORS+'</h3>');
    HTML.push('    <div class="column-select users" id="dopbsp-contributors-list">');
    
    for(i=1; i<=data['contributors']; i++){
        HTML.push(dopbspPermissionsFormCheckbox('manage_contributor_'+i, data['contributor'][i]['id'], data['contributor'][i]['name'], '', '', 'DOPSBP-check-all', data['calendar_id'], data['contributor'][i]['admin_calendars'], data['contributor'][i]['id'], data['contributor'][i]['checked']));
    }  
    HTML.push('    </div>');
    
// Editors Settings
    HTML.push('    <a href="javascript:dopbspMoveTop()" class="go-top">'+DOPBSP_GO_TOP+'</a>');
    HTML.push('    <span class="go-top-separator">|</span>');
    HTML.push('    <a href="javascript:void(0)" id="dopbsp-editors-show-hide" class="show-hide">'+DOPBSP_USERS_SHOW+'</a>');
    HTML.push('    <h3 class="settings">'+DOPBSP_USERS_EDITORS+'</h3>');
    HTML.push('    <div class="column-select users" id="dopbsp-editors-list">');
    
    for(i=1; i<=data['editors']; i++){
        HTML.push(dopbspPermissionsFormCheckbox('manage_editor_'+i, data['editor'][i]['id'], data['editor'][i]['name'], '', '', 'DOPSBP-check-all', data['calendar_id'], data['editor'][i]['admin_calendars'], data['editor'][i]['id'], data['editor'][i]['checked']));
    }  
    HTML.push('     </div>');

// Subscriber Settings
    HTML.push('    <a href="javascript:dopbspMoveTop()" class="go-top">'+DOPBSP_GO_TOP+'</a>');
    HTML.push('    <span class="go-top-separator">|</span>');
    HTML.push('    <a href="javascript:void(0)" id="dopbsp-subscribers-show-hide" class="show-hide">'+DOPBSP_USERS_SHOW+'</a>');
    HTML.push('    <h3 class="settings">'+DOPBSP_USERS_SUBSCRIBERS+'</h3>');
    HTML.push('    <div class="column-select users" id="dopbsp-subscribers-list">');
    
    for(i=1; i<=data['subscribers']; i++){
        HTML.push(dopbspPermissionsFormCheckbox('manage_subscriber_'+i, data['subscriber'][i]['id'], data['subscriber'][i]['name'], '', '', 'DOPSBP-check-all', data['calendar_id'], data['subscriber'][i]['admin_calendars'], data['subscriber'][i]['id'], data['subscriber'][i]['checked']));
    }  
    HTML.push('    </div>');
    
    HTML.push('</form>');
    $jDOPBSP('.column-content', '.column'+column, '.DOPBSP-admin').html(HTML.join(''));
            
    dopbspShowHideUsers();
}

function dopbspPermissionsFormCheckbox(id, value, label, pre, suf, input_class, calendar_id, admin_calendars, user_id, checked){// Create a Combo Box.
    var inputHTML = new Array();
    
    if (checked > 0){
        inputHTML.push('    <span class="pre">'+pre+'</span><input type="checkbox" checked="checked" onclick="dopbspEditCalendarPermissions('+calendar_id+')" class="'+input_class+'" name="'+id+'" id="'+id+'" value="'+value+'" /><span class="suf">'+suf+'</span>');
    }
    else{
        inputHTML.push('    <span class="pre">'+pre+'</span><input type="checkbox" onclick="dopbspEditCalendarPermissions('+calendar_id+')" class="'+input_class+'" name="'+id+'" id="'+id+'" value="'+value+'" /><span class="suf">'+suf+'</span>');    
    }
    inputHTML.push('    <label for="'+id+'">'+label+'</label>');
    inputHTML.push('    <br class="DOPBSP-clear" />');

    return inputHTML.join('');
}

//****************************************************************************** Prototypes
                        
function dopbspMoveTop(){
    jQuery('html').stop(true, true).animate({'scrollTop':'0'}, 300);
    jQuery('body').stop(true, true).animate({'scrollTop':'0'}, 300);
}

function dopbspShowHideUsers(){
    $jDOPBSP('#dopbsp-administrators-show-hide').unbind('click');
    $jDOPBSP('#dopbsp-administrators-show-hide').bind('click', function(){
        $jDOPBSP('#dopbsp-administrators-list').toggle('fast', function(){
            if ($jDOPBSP(this).css('display') == 'block'){
                $jDOPBSP('#dopbsp-administrators-show-hide').html(DOPBSP_USERS_HIDE);
            }
            else{
                $jDOPBSP('#dopbsp-administrators-show-hide').html(DOPBSP_USERS_SHOW);
            }
        });
    });

    $jDOPBSP('#dopbsp-authors-show-hide').unbind('click');
    $jDOPBSP('#dopbsp-authors-show-hide').bind('click', function(){
        $jDOPBSP('#dopbsp-authors-list').toggle('fast', function(){
            if ($jDOPBSP(this).css('display') == 'block'){
                $jDOPBSP('#dopbsp-authors-show-hide').html(DOPBSP_USERS_HIDE);
            }
            else{
                $jDOPBSP('#dopbsp-authors-show-hide').html(DOPBSP_USERS_SHOW);
            }
        });
    });

    $jDOPBSP('#dopbsp-contributors-show-hide').unbind('click');
    $jDOPBSP('#dopbsp-contributors-show-hide').bind('click', function(){
        $jDOPBSP('#dopbsp-contributors-list').toggle('fast', function(){
            if ($jDOPBSP(this).css('display') == 'block'){
                $jDOPBSP('#dopbsp-contributors-show-hide').html(DOPBSP_USERS_HIDE);
            }
            else{
                $jDOPBSP('#dopbsp-contributors-show-hide').html(DOPBSP_USERS_SHOW);
            }
        });
    });

    $jDOPBSP('#dopbsp-editors-show-hide').unbind('click');
    $jDOPBSP('#dopbsp-editors-show-hide').bind('click', function(){
        $jDOPBSP('#dopbsp-editors-list').toggle('fast', function(){
            if ($jDOPBSP(this).css('display') == 'block'){
                $jDOPBSP('#dopbsp-editors-show-hide').html(DOPBSP_USERS_HIDE);
            }
            else{
                $jDOPBSP('#dopbsp-editors-show-hide').html(DOPBSP_USERS_SHOW);
            }
        });
    });

    $jDOPBSP('#dopbsp-subscribers-show-hide').unbind('click');
    $jDOPBSP('#dopbsp-subscribers-show-hide').bind('click', function(){
        $jDOPBSP('#dopbsp-subscribers-list').toggle('fast', function(){
            if ($jDOPBSP(this).css('display') == 'block'){
                $jDOPBSP('#dopbsp-subscribers-show-hide').html(DOPBSP_USERS_HIDE);
            }
            else{
                $jDOPBSP('#dopbsp-subscribers-show-hide').html(DOPBSP_USERS_SHOW);
            }
        });
    });
}

function dopbspCleanInput(input, allowedCharacters, firstNotAllowed, min){
    var characters = $jDOPBSP(input).val().split(''),
    returnStr = '', i, startIndex = 0;

    if (characters.length > 1 && characters[0] == firstNotAllowed){
        startIndex = 1;
    }

    for (i=startIndex; i<characters.length; i++){
        if (allowedCharacters.indexOf(characters[i]) != -1){
            returnStr += characters[i];
        }
    }

    if (min > returnStr){
        returnStr = min;
    }

    $jDOPBSP(input).val(returnStr);
}

function dopbspReplaceAll(find, replace, str){
    return str.replace(new RegExp(find, 'g'), replace);
}

function dopbspShortName(name, size){// Return a short string.
    var newName = new Array(),
    pieces = name.split(''),
    i;

    if (pieces.length <= size){
        newName.push(name);
    }
    else{
        for (i=0; i<size-3; i++){
            newName.push(pieces[i]);
        }
        newName.push('...');
    }

    return newName.join('');
}

function dopbspGetUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
