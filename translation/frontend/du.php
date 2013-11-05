<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 1.7
* File                    : du.php
* File Version            : 1.3
* Created / Last Modified : 15 June 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Dutch Front End Translation.
* Translated by           : Kay van Aarssen - ICTWebSolution (http://www.ictwebsolution.nl)
*/
   
    // Months & Week Days
    global $DOPBSP_month_names;
    global $DOPBSP_month_short_names;
    $DOPBSP_month_names = array('Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December');
    $DOPBSP_month_short_names = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec');
    
    global $DOPBSP_day_names;
    global $DOPBSP_day_short_names;
    $DOPBSP_day_names = array('Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag');
    $DOPBSP_day_short_names = array('Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za');
    
    // Calendar 
    define('DOPBSP_ADD_MONTH_VIEW', "Voeg extra maand toe");
    define('DOPBSP_REMOVE_MONTH_VIEW', "Verwijder extra maand");
    define('DOPBSP_PREVIOUS_MONTH', "Vorige maand");
    define('DOPBSP_NEXT_MONTH', "Volgende maand");
    define('DOPBSP_AVAILABLE_ONE_TEXT', "beschikbaar");
    define('DOPBSP_AVAILABLE_TEXT', "beschikbaar");
    define('DOPBSP_BOOKED_TEXT', "bezet");
    define('DOPBSP_UNAVAILABLE_TEXT', "niet beschikbaar");
                            
    // Calendar Form 
    define('DOPBSP_CHECK_IN_LABEL', "Check In");
    define('DOPBSP_CHECK_OUT_LABEL', "Check Uit");
    define('DOPBSP_START_HOURS_LABEL', "Start op"); 
    define('DOPBSP_END_HOURS_LABEL', "Eindigd op");
    define('DOPBSP_NO_ITEMS_LABEL', "# Accomodaties"); 
    define('DOPBSP_SERVICES_LABEL', "Services");
    define('DOPBSP_TOTAL_PRICE_LABEL', "Totaal:");
    define('DOPBSP_DEPOSIT_PRICE_LABEL', "Tegoed:");
    define('DOPBSP_DEPOSIT_PRICE_LEFT_LABEL', " Te betalen:");
    define('DOPBSP_DISCOUNT_PRICE_LABEL', "Actuele prijs Price:");
    define('DOPBSP_DISCOUNT_TEXT', "Korting");
    define('DOPBSP_DEPOSIT_TEXT', "Tegoed");
    
    define('DOPBSP_NO_SERVICES_AVAILABLE', "Er zijn geen Er zijn geen diensten beschikbaar voor de periode die u hebt geselecteerd.");
    define('DOPBSP_MIN_STAY_WARNING', "U dient een minimaal aantal dagen te reserveren");
    define('DOPBSP_MAX_STAY_WARNING', "U kunt een maximum aantal dagen boeken");
    
    define('DOPBSP_FORM_TITLE', 'Contact Informatie');
    define('DOPBSP_FORM_REQUIRED', "is verplicht.");    
    define('DOPBSP_FORM_EMAIL_INVALID', "is niet juist. Vul a.u.b. een geldig mail adres in."); 
    define('DOPBSP_NO_PEOPLE_LABEL', "Geen Personen");
    define('DOPBSP_NO_ADULTS_LABEL', "Geen Volwassenen");
    define('DOPBSP_NO_CHILDREN_LABEL', "Geen Kinderen");
    define('DOPBSP_PAYMENT_ARRIVAL_LABEL', "Betaling na bevestiging (Direct boeken)"); 
    define('DOPBSP_PAYMENT_ARRIVAL_WITH_APPROVAL_LABEL', "Betaling na bevestiging"); 
    define('DOPBSP_PAYMENT_ARRIVAL_SUCCESS', "Uw aanvraag is succesvol verzonden. U ontvangt z.s.m. een reactie.");
    define('DOPBSP_PAYMENT_ARRIVAL_SUCCESS_INSTANT_BOOKING', "Your request has been successfully received. We are waiting you!");
    define('DOPBSP_PAYMENT_PAYPAL_LABEL', "Betaal via PayPal (Direct boeken)");
    define('DOPBSP_PAYMENT_PAYPAL_TRANSACTON_ID_LABEL', "PayPal Transactie ID");
    define('DOPBSP_PAYMENT_PAYPAL_SUCCESS', "Uw betaling is goedgekeurd en de diensten zijn geboekt."); 
    define('DOPBSP_PAYMENT_PAYPAL_ERROR', "Er is een fout opgetreden tijdens het verwerken van PayPal-betaling. Probeer het opnieuw.");
    define('DOPBSP_TERMS_AND_CONDITIONS_INVALID', "U moet de algemene voorwaarden accepteren om door te gaan.");  
    define('DOPBSP_TERMS_AND_CONDITIONS_LABEL', "Ik accepteer de algemene voorwaarden.");
    define('DOPBSP_BOOK_NOW_LABEL', "Reserveer nu!");
    
    // Email 
    define('DOPBSP_EMAIL_RESERVATION_ID', 'Reserverings ID');
    define('DOPBSP_EMAIL_CALENDAR_ID', 'Kalender ID');
    define('DOPBSP_EMAIL_CALENDAR_NAME', 'Agendanaam');
    
    define('DOPBSP_EMAIL_TO_USER_SUBJECT', "Uw boekingsverzoek is verzonden.");
    define('DOPBSP_EMAIL_TO_USER_MESSAGE_PAYMENT_ARRIVAL', "Wacht a.u.b. op goedkeuring. Hieronder staat de gegevens.");
    define('DOPBSP_EMAIL_TO_USER_MESSAGE_PAYMENT_ARRIVAL_INSTANT_BOOKING', "Hieronder staat de gegevens.");
    define('DOPBSP_EMAIL_TO_USER_MESSAGE_PAYMENT_PAYPAL', "De periode is geboekt. Hieronder staan de gegevens.");
    
    define('DOPBSP_EMAIL_TO_ADMIN_SUBJECT', "U heeft een boekingsaanvraag ontvangen");
    define('DOPBSP_EMAIL_TO_ADMIN_MESSAGE_PAYMENT_ARRIVAL', "Hieronder staan de gegevens. Ga naar het administratie gedeelte om de boeking te accepteren of af te wijzen.");
    define('DOPBSP_EMAIL_TO_ADMIN_MESSAGE_PAYMENT_ARRIVAL_INSTANT_BOOKING', "Hieronder staat de gegevens. Ga naar het administratie gedeelte om de boeking te annuleren.");
    define('DOPBSP_EMAIL_TO_ADMIN_MESSAGE_PAYMENT_PAYPAL', "Hieronder staan de gegevens. De betaling is gedaan via PayPal en de periode is geboekt.");
    
    define('DOPBSP_EMAIL_APPROVED_SUBJECT', "Uw boekingsaanvraag is goedgekeurd.");
    define('DOPBSP_EMAIL_APPROVED_MESSAGE', "Gefelifiteerd! Uw boekingsaanvraag is goedgekeurd. Gegevens over uw boeking staan hieronder.");
    
    define('DOPBSP_EMAIL_REJECTED_SUBJECT', "Uw boekingsaanvraag is afgewezen.");
    define('DOPBSP_EMAIL_REJECTED_MESSAGE', "Sorry, maar helaas is uw boekingsaanvraag afgewezen. De gegevens van uw boeking staan hieronder.");
    
    define('DOPBSP_EMAIL_CANCELED_SUBJECT', "Uw boekingsaanvraag is geannuleerd.");
    define('DOPBSP_EMAIL_CANCELED_MESSAGE', "Sorry, maar helaas is uw boekingsaanvraag geannuleerd. De gegevens van uw boeking staan hieronder.");
    
    define('DOPBSP_BOOKING_FORM_CHECKED', "Gecontroleerd");
    define('DOPBSP_BOOKING_FORM_UNCHECKED', "Ongehinderd");
    
?>