           
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