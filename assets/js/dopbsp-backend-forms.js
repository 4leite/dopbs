/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 1.7
* File                    : dopbsp-backend-forms.js
* File Version            : 1.0
* Created / Last Modified : 15 June 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Forms Scripts.
*/

//****************************************************************************** Forms

function dopbspShowBookingForms(){// Show all forms.
    if (clearClick){
        clearClick = false;
        dopbspRemoveColumns(1);
        dopbspToggleMessage('show', DOPBSP_LOAD);
        
        $jDOPBSP('#DOPBSP-add-booking-form-btn').css('display', 'block');
        $jDOPBSP('#DOPBSP-add-language-btn').css('display', 'none');
        $jDOPBSP('#DOPBSP-edit-calendars-btn').css('display', 'block');
        $jDOPBSP('#DOPBSP-languages-help').css('display', 'none');
        $jDOPBSP('#DOPBSP-languages-btn').css('display', 'block');
        $jDOPBSP('#DOPBSP-calendars-help').css('display', 'block');
        $jDOPBSP('#DOPBSP-calendars-btn').css('display', 'none');

        $jDOPBSP.post(ajaxurl, {action:'dopbsp_show_booking_forms'}, function(data){
            $jDOPBSP('.column-content', '.column1', '.DOPBSP-admin').html(data);
            dopbspBookingFormsEvents();
            dopbspToggleMessage('hide', DOPBSP_BOOKING_FORMS_LOADED);
            clearClick = true;
        });
    }
}

function dopbspAddBookingForm(){// Add booking form via AJAX.
    if (clearClick){
        clearClick = false;
        dopbspRemoveColumns(2);
        dopbspToggleMessage('show', DOPBSP_ADD_BOOKING_FORM_SUBMITED);
        
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_add_booking_form'}, function(data){
            $jDOPBSP('.column-content', '.column1', '.DOPBSP-admin').html(data);
            dopbspBookingFormsEvents();
            dopbspToggleMessage('hide', DOPBSP_ADD_BOOKING_FORM_SUCCESS);
            clearClick = true;
        });
    }
}

function dopbspBookingFormsEvents(){// Init Booking Forms Events.
    $jDOPBSP('li', '.column1', '.DOPBSP-admin').click(function(){
        if (clearClick){
            var id = $jDOPBSP(this).attr('id').split('-')[2];
            
            if (currBookingForm != id){
                currBookingForm = id;
                $jDOPBSP('li', '.column1', '.DOPBSP-admin').removeClass('item-selected');
                $jDOPBSP(this).addClass('item-selected');
                dopbspShowBookingForm(id);
            }
        }
    });
}

function dopbspShowBookingForm(id){// Show Form
    if (clearClick){
        clearClick = false;
        $jDOPBSP('li', '.column2', '.DOPBSP-admin').removeClass('item-image-selected');
        dopbspRemoveColumns(2);
        dopbspToggleMessage('show', DOPBSP_LOAD);
        $jDOPBSP('#booking_form_id').val(id);
        
        $jDOPBSP.post(ajaxurl, {action: 'dopbsp_show_booking_form', 
                                id: id}, function(data){
            var HeaderHTML = new Array();
            
            HeaderHTML.push('<input type="button" name="DOPBSP_calendar_submit" class="submit-style" onclick="dopbspEditBookingForm()" title="'+DOPBSP_EDIT_BOOKING_FORM_SUBMIT+'" value="'+DOPBSP_SUBMIT+'" />');
            HeaderHTML.push('<input type="button" name="DOPBSP_calendar_delete" class="submit-style" onclick="dopbspDeleteBookingForm('+$jDOPBSP('#booking_form_id').val()+')" title="'+DOPBSP_DELETE_CALENDAR_SUBMIT+'" value="'+DOPBSP_DELETE+'" />');
            HeaderHTML.push('<a href="javascript:void()" class="header-help last"><span>'+DOPBSP_BOOKING_FORM_SETTINGS_HELP+'</span></a>');
            
            $jDOPBSP('.column-header', '.column2', '.DOPBSP-admin').html(HeaderHTML.join(''));
;
            dopbspSettingsBookingForm(data, 2);
            
            clearClick = true;
        });
    }
}

function dopbspEditBookingForm(){// Edit Form Settings.
    if (clearClick){
        clearClick = false;
        
        dopbspToggleMessage('show', DOPBSP_SAVE);
        $jDOPBSP.post(ajaxurl, {action:'dopbsp_edit_booking_form',
                                id: $jDOPBSP('#booking_form_id').val(),
                                name: $jDOPBSP('#form-name').val()}, function(data){
            clearClick = true;
            
            if ($jDOPBSP('#booking_form_id').val() != '0'){
                $jDOPBSP('.name', '#DOPBSP-ID-'+$jDOPBSP('#booking_form_id').val()).html(dopbspShortName($jDOPBSP('#form-name').val(), 25));
                dopbspToggleMessage('hide', DOPBSP_EDIT_BOOKING_FORM_SUCCESS);
            }
            else{
                dopbspToggleMessage('hide', DOPBSP_EDIT_BOOKING_FORM_SUCCESS);
            }
        });
    }
}

function dopbspDeleteBookingForm(id){// Delete Form
    if (clearClick){
        if (confirm(DOPBSP_DELETE_BOOKING_FORM_CONFIRMATION)){
            clearClick = false;
            dopbspToggleMessage('show', DOPBSP_DELETE_BOOKING_FORM_SUBMITED);
            
            $jDOPBSP.post(ajaxurl, {action:'dopbsp_delete_booking_form', id:id}, function(data){
                dopbspRemoveColumns(2);
                
                $jDOPBSP('#DOPBSP-ID-'+id).stop(true, true).animate({'opacity':0}, 600, function(){
                    $jDOPBSP(this).remove();
                    
                    if (data == '0'){
                        $jDOPBSP('.column-content', '.column1', '.DOPBSP-admin').html('<ul><li class="no-data">'+DOPBSP_NO_BOOKING_FORMS+'</li></ul>');
                    }
                    clearClick = true;
                });
                
                dopbspToggleMessage('hide', DOPBSP_DELETE_BOOKING_FORM_SUCCESS);
            });
        }
    }
}

// Form Generator
function dopbspSettingsBookingForm(name, column){// Settings Form.
    var HTML = new Array(), 
    nameTranslation = new Array(),
    copyHelper;
    
    HTML.push('<form method="post" class="settings" action="" onsubmit="return false;">');
    
// General Settings
    HTML.push('    <h3 class="settings">'+DOPBSP_GENERAL_STYLES_SETTINGS+'</h3>');
    
    if ($jDOPBSP('#booking_form_id').val() != '0'){
        HTML.push(dopbspSettingsFormInput('form-name', name, DOPBSP_BOOKING_FORM_NAME, '', '', '', 'help', DOPBSP_BOOKING_FORM_NAME_INFO));
    }
    HTML.push('</form>');
    
    // Booking Form Fields
    HTML.push('<h3 class="settings">'+DOPBSP_BOOKING_FORM_FIELDS_TITLE+'</h3>');
    
    HTML.push('<div class="booking-form-wrapper">');

    // Form Fields
    HTML.push('    <div class="booking-form-fields-wrapper">');
    HTML.push('        <div class="booking-form-fields-container">');
    HTML.push('            <ul id="DOPBSP-form-fields" class="connect-form-fields remove-form-fields">');
    HTML.push(dopbspBookingFormShowFields());
    HTML.push('            </ul>');
    HTML.push('        </div>');
    HTML.push('    </div>');
    
    // Form Fields Types
    HTML.push('    <div class="booking-form-fields-type-wrapper">');
    HTML.push('        <div class="booking-form-fields-types-container">');
    HTML.push('            <ul id="DOPBSP-form-fields-types" class="connect-form-fields">');
    // Text Input Field
    HTML.push('                <li class="booking-form-item text">');
    HTML.push('                    <span class="booking-form-field-name-wrapper">');
    HTML.push('                        <span class="booking-form-field-name">'+DOPBSP_BOOKING_FORM_FIELDS_TYPE_TEXT_LABEL+'</span>');
    HTML.push('                        <span class="booking-form-field-loader" style="display: none;"></span>');
    HTML.push('                        <a href="javascript:void(0)" class="booking-form-field-show-settings-button" style="display: none;">'+DOPBSP_BOOKING_FORM_FIELDS_SHOW_SETTINGS+'</a>');
    HTML.push('                        <br class="DOPBSP-clear">');
    HTML.push('                    </span>');
    HTML.push('                    <div class="booking-form-field-settings-wrapper"></div>');
    HTML.push('                </li>');
    // Text Area Field
    HTML.push('                <li class="booking-form-item textarea">');
    HTML.push('                    <span class="booking-form-field-name-wrapper">');
    HTML.push('                        <span class="booking-form-field-name">'+DOPBSP_BOOKING_FORM_FIELDS_TYPE_TEXTAREA_LABEL+'</span>');
    HTML.push('                        <span class="booking-form-field-loader" style="display: none;"></span>');
    HTML.push('                        <a href="javascript:void(0)" class="booking-form-field-show-settings-button" style="display: none;">'+DOPBSP_BOOKING_FORM_FIELDS_SHOW_SETTINGS+'</a>');
    HTML.push('                        <br class="DOPBSP-clear">');
    HTML.push('                    </span>');
    HTML.push('                    <div class="booking-form-field-settings-wrapper"></div>');
    HTML.push('                 </li>');
    // Checkbox Field
    HTML.push('                 <li class="booking-form-item checkbox">');
    HTML.push('                    <span class="booking-form-field-name-wrapper">');
    HTML.push('                        <span class="booking-form-field-name">'+DOPBSP_BOOKING_FORM_FIELDS_TYPE_CHECKBOX_LABEL+'</span>');
    HTML.push('                        <span class="booking-form-field-loader" style="display: none;"></span>');
    HTML.push('                        <a href="javascript:void(0)" class="booking-form-field-show-settings-button" style="display: none;">'+DOPBSP_BOOKING_FORM_FIELDS_SHOW_SETTINGS+'</a>');
    HTML.push('                        <br class="DOPBSP-clear">');
    HTML.push('                    </span>');
    HTML.push('                    <div class="booking-form-field-settings-wrapper"></div>');
    HTML.push('                 </li>');
    // Select Field
    HTML.push('                 <li class="booking-form-item select">');
    HTML.push('                    <span class="booking-form-field-name-wrapper">');
    HTML.push('                        <span class="booking-form-field-name">'+DOPBSP_BOOKING_FORM_FIELDS_TYPE_SELECT_LABEL+'</span>');
    HTML.push('                        <span class="booking-form-field-loader" style="display: none;"></span>');
    HTML.push('                        <a href="javascript:void(0)" class="booking-form-field-show-settings-button" style="display: none;">'+DOPBSP_BOOKING_FORM_FIELDS_SHOW_SETTINGS+'</a>');
    HTML.push('                        <br class="DOPBSP-clear">');
    HTML.push('                    </span>');
    HTML.push('                    <div class="booking-form-field-settings-wrapper"></div>');
    HTML.push('                 </li>');
    HTML.push('             </ul>');
    HTML.push('         </div>');
    HTML.push('     </div>');
    
    // Form Fields Delete
    HTML.push('    <div class="booking-form-fields-delete-wrapper">');
    HTML.push('        <div class="booking-form-fields-delete-container">');
    HTML.push('            <ul id="DOPBSP-form-fields-delete" class="remove-form-fields"></ul>');
    HTML.push('        </div>');
    HTML.push('    </div>');
    
    HTML.push('    <br class="DOPBSP-clear" />');
    HTML.push('</div>');
    
    $jDOPBSP('.column-content', '.column'+column, '.DOPBSP-admin').html(HTML.join(''));
     
    $jDOPBSP( "#DOPBSP-form-fields-types" ).sortable({
        connectWith: ".connect-form-fields",
        forcePlaceholderSize: true,
        helper: function(e,li){
            copyHelper= li.clone().insertAfter(li);
            return li.clone();
        },
        update: function (e,li){
            var nrLi = $jDOPBSP('#DOPBSP-form-fields li').length,
            type = '',
            fieldId = 0,
            position = 0,
            positions = '',
            newId = '',
            idall = '',
            m = 0, j;
        
            if ($jDOPBSP('#DOPBSP-form-fields').find('li').hasClass('text')){
                $jDOPBSP('#DOPBSP-form-fields .text').attr('id', 'prov');
                type = 'text';
            } 
            else if ($jDOPBSP('#DOPBSP-form-fields').find('li').hasClass('textarea')){ 
                $jDOPBSP('#DOPBSP-form-fields .textarea').attr('id', 'prov');
                type = 'textarea';
            }
            else if($jDOPBSP('#DOPBSP-form-fields').find('li').hasClass('checkbox')){
                $jDOPBSP('#DOPBSP-form-fields .checkbox').attr('id', 'prov');
                type = 'checkbox';
            }
            else if ($jDOPBSP('#DOPBSP-form-fields').find('li').hasClass('select')){
                $jDOPBSP('#DOPBSP-form-fields .select').attr('id', 'prov');
                type = 'select';
            }
        
            for(j=1; j<=nrLi; j++){
                if ($jDOPBSP('#DOPBSP-form-fields li').eq(j-1).hasClass('text')
                    || $jDOPBSP('#DOPBSP-form-fields li').eq(j-1).hasClass('textarea') 
                    || $jDOPBSP('#DOPBSP-form-fields li').eq(j-1).hasClass('checkbox')
                    || $jDOPBSP('#DOPBSP-form-fields li').eq(j-1).hasClass('select')){
                   position = j;
                }
                else {
                    idall = $jDOPBSP('#DOPBSP-form-fields li').eq(j-1).attr('id');
                    newId = idall.split('booking-form-field-')[1];

                    if (m > 0){
                        positions = positions+','+newId+'-'+j;
                    }
                    else{
                       positions = positions+newId+'-'+j; 
                    }
                    m++;
                }
            }
            positions = '"'+positions+'"';
        
            //Generate translation
            var nameTranslation = new Array(),
            names = new Array(),
            namesSec = new Array(),
            label;
            
            switch (type){
                case 'text':
                    label = DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_TEXT_LABEL;
                    break;
                case 'textarea':
                    label = DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_TEXTAREA_LABEL;
                    break;
                case 'checkbox':
                    label = DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_CHECKBOX_LABEL;
                    break;
                case 'select':
                    label = DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_SELECT_LABEL;
                    break;
            }
        
            $jDOPBSP("#DOPBSP-admin-translation option").each(function(){
                nameTranslation[$jDOPBSP(this).val()] = label;
                names.push('"'+$jDOPBSP(this).val()+'": "'+nameTranslation[$jDOPBSP(this).val()]+'"');
                namesSec.push('#'+$jDOPBSP(this).val()+'#: #'+nameTranslation[$jDOPBSP(this).val()]+'#');
            });
            names.join(',');
            names = '{'+names+'}';
            namesSec.join(',');
            namesSec = '{'+namesSec+'}';
            
            $jDOPBSP('#DOPBSP-form-fields #prov .booking-form-field-loader').css('display', 'block');
            
            $jDOPBSP.post(ajaxurl, {action: 'dopbsp_add_booking_form_field',
                                    form_id: $jDOPBSP('#booking_form_id').val(),
                                    type: type,
                                    position: position,
                                    positions: positions,
                                    translation: names}, function(data){
                if (data){
                    fieldId = data.trim();
                    $jDOPBSP('#DOPBSP-form-fields #prov .booking-form-field-loader').css('display', 'none');
                    
                    switch (type){
                        case 'text':
                            $jDOPBSP('#DOPBSP-form-fields').find('li.text').attr('id', 'booking-form-field-'+fieldId);
                            $jDOPBSP('#booking-form-field-'+fieldId).removeClass('text');
                            break;
                        case 'textarea':
                            $jDOPBSP('#DOPBSP-form-fields').find('li.textarea').attr('id','booking-form-field-'+fieldId);
                            $jDOPBSP('#booking-form-field-'+fieldId).removeClass('textarea');
                            break;
                        case 'checkbox':
                            $jDOPBSP('#DOPBSP-form-fields').find('li.checkbox').attr('id','booking-form-field-'+fieldId);
                            $jDOPBSP('#booking-form-field-'+fieldId).removeClass('checkbox');
                            break;
                        case 'select':
                            $jDOPBSP('#DOPBSP-form-fields').find('li.select').attr('id','booking-form-field-'+fieldId);
                            $jDOPBSP('#booking-form-field-'+fieldId).removeClass('select');
                            break;
                    }
                    
                    $jDOPBSP('#booking-form-field-'+fieldId+' .booking-form-field-name').html(label+' <span></span>');
                    $jDOPBSP('#booking-form-field-'+fieldId+' .booking-form-field-show-settings-button').attr('href','javascript:dopbspExpandBookingFormField('+fieldId+')');
                    $jDOPBSP('#booking-form-field-'+fieldId+' .booking-form-field-show-settings-button').removeAttr('style');
                    $jDOPBSP('#booking-form-field-'+fieldId+' .booking-form-field-settings-wrapper').html(dopsbsGenerateBookingFormFieldSettings(fieldId, type, namesSec));
                    
                    switch (type){
                        case 'text':
                            $jDOPBSP('#booking-form-field-'+fieldId+' .booking-form-field-name-wrapper').append('<input type="text" name="booking-form-field-demo-'+fieldId+'" id="booking-form-field-demo-'+fieldId+'" class="booking-form-field-demo-text" value="" disabled="disabled" />');
                            break;
                        case 'textarea':
                            $jDOPBSP('#booking-form-field-'+fieldId+' .booking-form-field-name-wrapper').append('<textarea name="booking-form-field-demo-'+fieldId+'" id="booking-form-field-demo-'+fieldId+'" class="booking-form-field-demo-textarea" disabled="disabled"></textarea>');
                            break;
                        case 'checkbox':
                            $jDOPBSP('#booking-form-field-'+fieldId+' .booking-form-field-name-wrapper').prepend('<input type="checkbox" name="booking-form-field-demo-'+fieldId+'" id="booking-form-field-demo-'+fieldId+'" class="booking-form-field-demo-checkbox" disabled="disabled" />');
                            break;
                        case 'select':
                            $jDOPBSP('#booking-form-field-'+fieldId+' .booking-form-field-name-wrapper').append('<select name="booking-form-field-demo-'+fieldId+'" id="booking-form-field-demo-'+fieldId+'" class="booking-form-field-demo-select" disabled="disabled"></select>');
                            break;
                    }
                    
                    dopbspExpandBookingFormField(fieldId);
                }
            });
        },        
        stop: function() {
            copyHelper && copyHelper.remove();
        }
    });
    
    $jDOPBSP("#DOPBSP-form-fields").sortable({
        connectWith: '.remove-form-fields',
        receive: function(e,ui) {
            copyHelper= null;
        },
        update: function(e,ui){
            var fieldId = ui.item.context.id.split('booking-form-field-')[1],
            position = 0,
            positions = '',
            nrLi = $jDOPBSP('#DOPBSP-form-fields li').length,
            m = 0, j,
            idall = '',
            newId = '';
            
            for(j=1; j<=nrLi; j++){
                if ($jDOPBSP('#DOPBSP-form-fields li').eq(j-1).attr('id') == ui.item.context.id){
                   position = j;
                }
                else{
                    idall = $jDOPBSP('#DOPBSP-form-fields li').eq(j-1).attr('id');
                    newId = idall.split('booking-form-field-')[1];

                    if (m > 0){
                        positions = positions+','+newId+'-'+j;
                    }
                    else {
                       positions = positions+newId+'-'+j; 
                    }
                    m++;
                }
            }
            positions = '"'+positions+'"';

            $jDOPBSP.post(ajaxurl, {action: 'dopbsp_update_booking_form_field',
                                    fieldId: fieldId,
                                    position: position,
                                    positions: positions}, function(data){});
        }
    });

    $jDOPBSP("#DOPBSP-form-fields-delete").sortable({
        receive: function(e,ui){
            var fieldId = ui.item.context.id.split('booking-form-field-')[1];
            ui.item.remove();
            
            $jDOPBSP.post(ajaxurl, {action: 'dopbsp_delete_booking_form_field',
                                    fieldId: fieldId}, function(data){});
        }
    });
}

function dopsbsGenerateBookingFormFieldSettings(id, type, namesSec){
    var HTML = new Array(),
    label;

    switch (type){
        case 'text':
            label = DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_TEXT_LABEL;
            break;
        case 'textarea':
            label = DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_TEXTAREA_LABEL;
            break;
        case 'checkbox':
            label = DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_CHECKBOX_LABEL;
            break;
        case 'select':
            label = DOPBSP_BOOKING_FORM_FIELDS_NEW_FIELD_SELECT_LABEL;
            break;
    }
    
    // Language
    HTML.push(' <div class="settings-box">');
    HTML.push('     <label for="DOPBSP-admin-form-field-language-'+id+'">'+DOPBSP_BOOKING_FORM_FIELDS_LANGUAGE_LABEL+'</label>');
    HTML.push(dopbspTranslationBookingFormField(id));
    HTML.push('     <a href="javascript:void()" class="help"><span>'+DOPBSP_BOOKING_FORM_FIELDS_LANGUAGE_INFO+'</span></a>');
    HTML.push('     <br class="DOPBSP-clear" />');
    HTML.push(' </div>');
    // Name
    HTML.push(' <div class="settings-box">');
    HTML.push('     <label for="booking-form-field-name-'+id+'">'+DOPBSP_BOOKING_FORM_FIELDS_NAME_LABEL+' *</label>');
    HTML.push('     <input type="text" name="booking-form-field-name-'+id+'" id="booking-form-field-name-'+id+'" value="'+label+'" onkeyup="dopbspBookingFormFieldChange(\'translation\', '+id+', this.value, \''+$jDOPBSP('#DOPBSP-admin-translation').val()+'\', \'\')" onblur="dopbspBookingFormFieldChange(\'translation\', '+id+', this.value, \''+$jDOPBSP('#DOPBSP-admin-translation').val()+'\', \'\')" />');
    HTML.push('     <a href="javascript:void()" class="help"><span>'+DOPBSP_BOOKING_FORM_FIELDS_NAME_INFO+'</span></a>');
    HTML.push('     <span class="loader" id="booking-form-loader-field-name-'+id+'"></span>');
    HTML.push('     <br class="DOPBSP-clear" />');
    HTML.push('     <input type="hidden" name="booking-form-field-translation-'+id+'" id="booking-form-field-translation-'+id+'" value="'+namesSec+'" />');
    HTML.push(' </div>');

    if (type == 'select'){
        HTML.push(' <div class="settings-box">');
        HTML.push('     <label>'+DOPBSP_BOOKING_FORM_FIELDS_SELECT_OPTIONS_LABEL+'</label>');
        HTML.push('     <div class="booking-form-field-select-options" id="booking-form-field-select-options-'+id+'">');
        HTML.push('         <a class="add" href="javascript:dopbspBookingFormFieldSelectAddOption('+id+')" title="'+DOPBSP_BOOKING_FORM_FIELDS_SELECT_ADD_OPTION+'"></a>');
        HTML.push('         <a href="javascript:void()" class="help"><span>'+DOPBSP_BOOKING_FORM_FIELDS_SELECT_OPTIONS_INFO+'</span></a>');
        HTML.push('         <span class="loader" id="booking-form-loader-field-select-'+id+'"></span>');
        HTML.push('         <br class="DOPBSP-clear" /><br />');
        HTML.push('     </div>');
        HTML.push('    <br class="DOPBSP-clear" />');
        HTML.push(' </div>');

        // Multiple Select    
        HTML.push(' <div class="settings-box">');
        HTML.push('     <label for="booking-form-field-multiple-select-'+id+'">'+DOPBSP_BOOKING_FORM_FIELDS_SELECT_MULTIPLE_SELECT_LABEL+'</label>');
        HTML.push('     <input type="checkbox" name="booking-form-field-multiple-select-'+id+'" id="booking-form-field-multiple-select-'+id+'" onclick="dopbspBookingFormFieldChange(\'multiple_select\', \''+id+'\', \'false\', \'\')" />');
        HTML.push('     <a href="javascript:void()" class="help"><span>'+DOPBSP_BOOKING_FORM_FIELDS_SELECT_MULTIPLE_SELECT_INFO+'</span></a>');
        HTML.push('     <span class="loader" id="booking-form-loader-field-multiple-select-'+id+'"></span>');
        HTML.push('     <br class="DOPBSP-clear" />');
        HTML.push(' </div>');
    }

    if (type !='checkbox' && type !='select'){
        // Allowed Characters    
        HTML.push(' <div class="settings-box">');
        HTML.push('     <label for="booking-form-field-allowed-characters-'+id+'">'+DOPBSP_BOOKING_FORM_FIELDS_ALLOWED_CHARACTERS_LABEL+'</label>');
        HTML.push('     <input type="text" name="booking-form-field-allowed-characters-'+id+'" id="booking-form-field-allowed-characters-'+id+'" value="" onkeyup="dopbspBookingFormFieldChange(\'allowed_characters\', \''+id+'\', this.value, \'\')" onblur="dopbspBookingFormFieldChange(\'allowed_characters\', \''+id+'\', this.value, \'\')" />');
        HTML.push('     <a href="javascript:void()" class="help"><span>'+DOPBSP_BOOKING_FORM_FIELDS_ALLOWED_CHARACTERS_INFO+'</span></a>');
        HTML.push('     <span class="loader" id="booking-form-loader-field-allowed-characters-'+id+'"></span>');
        HTML.push('     <br class="DOPBSP-clear" />');
        HTML.push(' </div>');
        //Size
        HTML.push(' <div class="settings-box">');
        HTML.push('     <label for="booking-form-field-size-'+id+'">'+DOPBSP_BOOKING_FORM_FIELDS_SIZE_LABEL+'</label>');
        HTML.push('     <input type="text" name="booking-form-field-size-'+id+'" id="booking-form-field-size-'+id+'" value="" onkeyup="dopbspBookingFormFieldChange(\'size\', \''+id+'\', this.value, \'\')" onblur="dopbspBookingFormFieldChange(\'size\', \''+id+'\', this.value, \'\')" />');
        HTML.push('     <a href="javascript:void()" class="help"><span>'+DOPBSP_BOOKING_FORM_FIELDS_SIZE_INFO+'</span></a>');
        HTML.push('     <span class="loader" id="booking-form-loader-field-size-'+id+'"></span>');
        HTML.push('     <br class="DOPBSP-clear" />');
        HTML.push(' </div>');
    }

    if (type == 'text'){
        // Email
        HTML.push(' <div class="settings-box">');
        HTML.push('     <label for="booking-form-field-email-'+id+'">'+DOPBSP_BOOKING_FORM_FIELDS_EMAIL_LABEL+'</label>');
        HTML.push('     <input type="checkbox" name="booking-form-field-email-'+id+'" id="booking-form-field-email-'+id+'" onclick="dopbspBookingFormFieldChange(\'is_email\', \''+id+'\', \'false\', \'\')" />');
        HTML.push('     <a href="javascript:void()" class="help"><span>'+DOPBSP_BOOKING_FORM_FIELDS_EMAIL_INFO+'</span></a>');
        HTML.push('     <span class="loader" id="booking-form-loader-field-is-email-'+id+'"></span>');
        HTML.push('     <br class="DOPBSP-clear" />');
        HTML.push(' </div>');
    }

    // Required
    HTML.push(' <div class="settings-box">');
    HTML.push('     <label for="booking-form-field-required-'+id+'">'+DOPBSP_BOOKING_FORM_FIELDS_REQUIRED_LABEL+'</label>');
    HTML.push('     <input type="checkbox" name="booking-form-field-required-'+id+'" id="booking-form-field-required-'+id+'" onclick="dopbspBookingFormFieldChange(\'required\', \''+id+'\', \'false\', \'\')" />');
    HTML.push('     <a href="javascript:void()" class="help"><span>'+DOPBSP_BOOKING_FORM_FIELDS_REQUIRED_INFO+'</span></a>');
    HTML.push('     <span class="loader" id="booking-form-loader-field-required-'+id+'"></span>');
    HTML.push('     <br class="DOPBSP-clear" />');
    HTML.push(' </div>');
    
    return HTML.join('');
}

function dopbspBookingFormShowFields(){
    $jDOPBSP.post(ajaxurl, {action:'dopbsp_show_booking_form_fields',
                            booking_form_id:$jDOPBSP('#booking_form_id').val(),
                            language: $jDOPBSP("#DOPBSP-admin-translation").val()}, function(data){
        $jDOPBSP('#DOPBSP-form-fields').append(data);
        dopbspToggleMessage('hide', DOPBSP_BOOKING_FORM_LOADED);
    });
}

function dopbspBookingFormFieldChange(name, id, value, language){
    var alphaValue = value;
    
    if (name == 'translation'){
        var fieldTranslation = $jDOPBSP('#booking-form-field-translation-'+id).val(),
        newFieldTranslation = new Array()
        ;
        $jDOPBSP('#booking-form-field-'+id+' .booking-form-field-name').html(value+' <span></span>');
        
        fieldTranslation = dopbspReplaceAll('#', '"', fieldTranslation);
        fieldTranslation = JSON.parse(fieldTranslation);

        $jDOPBSP.each(fieldTranslation, function(key){
            if (key == language){
                fieldTranslation[key] = value;
            }
            newFieldTranslation.push('#'+key+'#: #'+fieldTranslation[key]+'#');
        });
        newFieldTranslation.join(',');
        newFieldTranslation = '{'+newFieldTranslation+'}';
        $jDOPBSP('#booking-form-field-translation-'+id).val(newFieldTranslation);
        
        alphaValue = dopbspReplaceAll('#', '"', newFieldTranslation);;
    }
    
    if (name == 'multiple_select' && $jDOPBSP('#booking-form-field-multiple-select-'+id).is(':checked')){
        alphaValue = 'true';
    }
    
    if (name == 'is_email' && $jDOPBSP('#booking-form-field-email-'+id).is(':checked')){
        alphaValue = 'true';    
    }
    
    if (name == 'required' && $jDOPBSP('#booking-form-field-required-'+id).is(':checked')){
        alphaValue = 'true';    
    }
    
    switch (name){
        case 'translation':
            $jDOPBSP('#booking-form-loader-field-name-'+id).css('display', 'block');
            break;
        case 'multiple_select':
            $jDOPBSP('#booking-form-loader-field-multiple-select-'+id).css('display', 'block');
            
            if ($jDOPBSP('#booking-form-field-multiple-select-'+id).is(':checked')){
                $jDOPBSP('#booking-form-field-demo-'+id).attr('multiple', 'multiple');
            }
            else{
                $jDOPBSP('#booking-form-field-demo-'+id).removeAttr('multiple');
            }
            break;
        case 'allowed_characters':
            $jDOPBSP('#booking-form-loader-field-allowed-characters-'+id).css('display', 'block');
            break;
        case 'size':
            $jDOPBSP('#booking-form-loader-field-size-'+id).css('display', 'block');
            break;
        case 'is_email':
            $jDOPBSP('#booking-form-loader-field-is-email-'+id).css('display', 'block');
            break;
        case 'required':
            $jDOPBSP('#booking-form-loader-field-required-'+id).css('display', 'block');
            break;
    }
    
    $jDOPBSP.post(ajaxurl, {action:'dopbsp_edit_booking_form_field',
                            id: id,
                            name: name,
                            value: alphaValue}, function(data){
        switch (name){
            case 'translation':
                $jDOPBSP('#booking-form-loader-field-name-'+id).css('display', 'none');
                break;
            case 'multiple_select':
                $jDOPBSP('#booking-form-loader-field-multiple-select-'+id).css('display', 'none');
                break;
            case 'allowed_characters':
                $jDOPBSP('#booking-form-loader-field-allowed-characters-'+id).css('display', 'none');
                break;
            case 'size':
                $jDOPBSP('#booking-form-loader-field-size-'+id).css('display', 'none');
                break;
            case 'is_email':
                $jDOPBSP('#booking-form-loader-field-is-email-'+id).css('display', 'none');
                break;
            case 'required':
                $jDOPBSP('#booking-form-loader-field-required-'+id).css('display', 'none');
                break;
        }
    });
}

function dopbspExpandBookingFormField(id){
    if ($jDOPBSP('#booking-form-field-'+id+' .booking-form-field-show-settings-button').html() == DOPBSP_BOOKING_FORM_FIELDS_SHOW_SETTINGS){
        $jDOPBSP('#booking-form-field-'+id+' .booking-form-field-show-settings-button').html(DOPBSP_BOOKING_FORM_FIELDS_HIDE_SETTINGS);
        $jDOPBSP('#booking-form-field-'+id).addClass('selected');
    }
    else{
        $jDOPBSP('#booking-form-field-'+id+' .booking-form-field-show-settings-button').html(DOPBSP_BOOKING_FORM_FIELDS_SHOW_SETTINGS);
        $jDOPBSP('#booking-form-field-'+id).removeClass('selected');
    }
    
    $jDOPBSP('#booking-form-field-'+id+' .booking-form-field-settings-wrapper').toggle('fast');
}

function dopbspChangeTranslationBookingFormField(fieldId, language){
    var fieldTranslation = $jDOPBSP('#booking-form-field-translation-'+fieldId).val();
    
    fieldTranslation = dopbspReplaceAll('#', '"', fieldTranslation);
    fieldTranslation = JSON.parse(fieldTranslation);
    
    $jDOPBSP('#booking-form-field-name-'+fieldId).attr('onkeyup', "dopbspBookingFormFieldChange('translation', "+fieldId+", this.value, '"+language+"')");
    $jDOPBSP('#booking-form-field-name-'+fieldId).attr('onblur', "dopbspBookingFormFieldChange('translation', "+fieldId+", this.value, '"+language+"')");
    $jDOPBSP('#booking-form-field-'+fieldId+' .booking-form-field-name').html(fieldTranslation[language]+' <span></span>');
    $jDOPBSP('#booking-form-field-name-'+fieldId).val(fieldTranslation[language]);
    
    $jDOPBSP('#booking-form-field-select-options-'+fieldId+' .form_options_name_cls').each(function(){
        if ($jDOPBSP(this).attr('id') != undefined){
            var optionId = $jDOPBSP(this).attr('id').split('booking-form-field-select-option-id-')[1];
            
            $jDOPBSP('#booking-form-field-select-option-language-'+optionId).val(language);
            fieldTranslation = $jDOPBSP('#booking-form-field-select-option-translation-'+optionId).val();

            fieldTranslation = dopbspReplaceAll('#', '"', fieldTranslation);
            fieldTranslation = JSON.parse(fieldTranslation);

            $jDOPBSP('#booking-form-field-select-option-id-'+optionId).val(fieldTranslation[language]);
            $jDOPBSP('#booking-form-field-option-demo-'+optionId).html(fieldTranslation[language]);
        }
    });
}

function dopbspTranslationBookingFormField(id){
    var HTML = new Array(), i,
    languageValues = ['af',
                      'al',
                      'ar',
                      'az',
                      'bs',
                      'by',
                      'bg',
                      'ca',
                      'cn',
                      'cr',
                      'cz',
                      'dk',
                      'du',
                      'en',
                      'eo',
                      'et',
                      'fl',
                      'fl',
                      'fi',
                      'fr',
                      'gl',
                      'de',
                      'gr',
                      'ha',
                      'he',
                      'hi',
                      'hu',
                      'is',
                      'id',
                      'ir',
                      'it',
                      'ja',
                      'ko',
                      'lv',
                      'lt',
                      'mk',
                      'mg',
                      'ma',
                      'no',
                      'pe',
                      'pl',
                      'pt',
                      'ro',
                      'ru',
                      'sr',
                      'sk',
                      'sl',
                      'sp',
                      'sw',
                      'se',
                      'th',
                      'tr',
                      'uk',
                      'ur',
                      'vi',
                      'we',
                      'yi'],
    languageNames = ['Afrikaans (Afrikaans)',
                     'Albanian (Shqiptar)',
                     'Arabic (>العربية)',
                     'Azerbaijani (Azərbaycan)',
                     'Basque (Euskal)',
                     'Belarusian (Беларускай)',
                     'Bulgarian (Български)',
                     'Catalan (Català)',
                     'Chinese (中国的)',
                     'Croatian (Hrvatski)',
                     'Czech (Český)',
                     'Danish (Dansk)',
                     'Dutch (Nederlands)',
                     'English',
                     'Esperanto (Esperanto)',
                     'Estonian (Eesti)',
                     'Filipino (na Filipino)',
                     'Filipino (na Filipino)',
                     'Finnish (Suomi)',
                     'French (Français)',
                     'Galician (Galego)',
                     'German (Deutsch)',
                     'Greek (Ɛλληνικά)',
                     'Haitian Creole (Kreyòl Ayisyen)',
                     'Hebrew (עברית)',
                     'Hindi (हिंदी)',
                     'Hungarian (Magyar)',
                     'Icelandic (Íslenska)',
                     'Indonesian (Indonesia)',
                     'Irish (Gaeilge)',
                     'Italian (Italiano)',
                     'Japanese (日本の)',
                     'Korean (한국의)',
                     'Latvian (Latvijas)',
                     'Lithuanian (Lietuvos)',
                     'Macedonian (македонски)',
                     'Malay (Melayu)',
                     'Maltese (Maltija)',
                     'Norwegian (Norske)',
                     'Persian (فارسی)',
                     'Polish (Polski)',
                     'Portuguese (Português)',
                     'Romanian (Română)',
                     'Russian (Pусский)',
                     'Serbian (Cрпски)',
                     'Slovak (Slovenských)',
                     'Slovenian (Slovenski)',
                     'Spanish (Español)',
                     'Swahili (Kiswahili)',
                     'Swedish (Svenskt)',
                     'Thai (ภาษาไทย)',
                     'Turkish (Türk)',
                     'Ukrainian (Український)',
                     'Urdu (اردو)',
                     'Vietnamese (Việt)',
                     'Welsh (Cymraeg)',
                     'Yiddish (ייִדיש)'];
    
    HTML.push('<select id="DOPBSP-admin-form-field-language-'+id+'" onchange="dopbspChangeTranslationBookingFormField('+id+',this.value)">');
    
    for (i=0; i<languageValues.length; i++){
        HTML.push(' <option value="'+languageValues[i]+'" '+($jDOPBSP("#DOPBSP-admin-translation").val() == languageValues[i] ? 'selected="selected"':'')+'>'+languageNames[i]+'</option>');
    }
    
    HTML.push('</select>');
    return HTML.join('');
}

function dopbspBookingFormFieldSelectAddOption(fieldId){
    var HTML = new Array(),
    namesSec = new Array(),
    names = new Array();

    $jDOPBSP("#DOPBSP-admin-translation option").each(function(){
        names.push('"'+$jDOPBSP(this).val()+'": "'+DOPBSP_BOOKING_FORM_FIELDS_SELECT_NEW_OPTION_LABEL+'"');
        namesSec.push('#'+$jDOPBSP(this).val()+'#: #'+DOPBSP_BOOKING_FORM_FIELDS_SELECT_NEW_OPTION_LABEL+'#');
    });
    
    names.join(',');
    names = '{'+names+'}';
    namesSec.join(',');
    namesSec = '{'+namesSec+'}';

    $jDOPBSP('#booking-form-loader-field-select-'+fieldId).css('display', 'block');
        
    $jDOPBSP.post(ajaxurl, {action: 'dopbsp_add_booking_form_field_select_option',
                            field_id: fieldId,
                            translation: names}, function(data){
        $jDOPBSP('#booking-form-loader-field-select-'+fieldId).css('display', 'none');
        
        if (data){
            HTML.push('<div class="option-box" id="booking-form-field-select-option-'+data+'">');
            HTML.push(' <input type="text" class="form_name form_options_name_cls" id="booking-form-field-select-option-id-'+data+'" value="'+DOPBSP_BOOKING_FORM_FIELDS_SELECT_NEW_OPTION_LABEL+'" onkeyup="dopbspBookingFormFieldOptionChange('+data+', this.value)" onblur="dopbspBookingFormFieldOptionChange('+data+', this.value)" />');
            HTML.push(' <a href="javascript:dopbspBookingFormFieldSelectDeleteOption('+data+')" title="'+DOPBSP_BOOKING_FORM_FIELDS_SELECT_DELETE_OPTION+'" class="remove" id="booking-form-field-select-option-remove-'+data+'"></a>');
            HTML.push(' <span class="loader" id="booking-form-loader-field-select-option-'+data+'"></span>');
            HTML.push(' <input type="hidden" class="dopbsp-booking-form-options-translations" id="booking-form-field-select-option-translation-'+data+'" name="option" value="'+namesSec+'"/>');
            HTML.push(' <input type="hidden" class="dopbsp-booking-form-options-curent-language" id="booking-form-field-select-option-language-'+data+'" name="language" value="'+$jDOPBSP("#DOPBSP-admin-form-field-language-"+fieldId).val()+'"/>');
            HTML.push(' <br class="DOPBSP-clear">');
            HTML.push('</div>');

            $jDOPBSP('#booking-form-field-select-options-'+fieldId).append(HTML.join(''));
            $jDOPBSP('#booking-form-field-demo-'+fieldId).append('<option id="booking-form-field-option-demo-'+data+'" value="'+data+'">'+DOPBSP_BOOKING_FORM_FIELDS_SELECT_NEW_OPTION_LABEL+'</option>')
        }   
    });
}

function dopbspBookingFormFieldOptionChange(id, value){
    var fieldTranslation = $jDOPBSP('#booking-form-field-select-option-translation-'+id).val(),
    fieldLanguage = $jDOPBSP('#booking-form-field-select-option-language-'+id).val(),
    fieldNewTranslation = new Array();

    fieldTranslation = dopbspReplaceAll('#', '"', fieldTranslation);
    fieldTranslation = JSON.parse(fieldTranslation);

    $jDOPBSP.each(fieldTranslation, function(key){
        if (key == fieldLanguage){
            fieldTranslation[key] = value;
        }
        fieldNewTranslation.push('#'+key+'#: #'+fieldTranslation[key]+'#');
    });
    fieldNewTranslation.join(',');
    fieldNewTranslation = '{'+fieldNewTranslation+'}';

    $jDOPBSP('#booking-form-field-select-option-translation-'+id).val(fieldNewTranslation); 
    $jDOPBSP('#booking-form-loader-field-select-option-'+id).css('display', 'block');

    $jDOPBSP.post(ajaxurl, {action:'dopbsp_edit_booking_form_field_select_option',
                            id: id,
                            translation: fieldNewTranslation}, function(data){
        $jDOPBSP('#booking-form-loader-field-select-option-'+id).css('display', 'none');
        $jDOPBSP('#booking-form-field-option-demo-'+id).html(value);
    });
}

function dopbspBookingFormFieldSelectDeleteOption(id){
    $jDOPBSP('#booking-form-loader-field-select-option-'+id).css('display', 'block');
    
    $jDOPBSP.post(ajaxurl, {action: 'dopbsp_delete_booking_form_field_select_option',
                            id: id}, function(data){
        $jDOPBSP('#booking-form-loader-field-select-option-'+id).css('display', 'none');
    
        if (data){
            $jDOPBSP('#booking-form-field-option-demo-'+id).remove(); 
            $jDOPBSP('#booking-form-field-select-option-'+data).remove(); 
            $jDOPBSP('#booking-form-field-select-option-label-id-'+data).remove();
            $jDOPBSP('#booking-form-field-select-option-id-'+data).remove();
            $jDOPBSP('#booking-form-field-select-option-translation-'+data).remove();
            $jDOPBSP('#booking-form-field-select-option-remove-'+data).remove(); 
            
            if (data == '0'){
                $jDOPBSP('.column-content', '.column1', '.DOPBSP-admin').html('<ul><li class="no-data">'+DOPBSP_NO_FORMS+'</li></ul>');
            }
        }
    });
}