<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 1.7
* File                    : dopbsp-backend-reservations.php
* File Version            : 1.0
* Created / Last Modified : 15 June 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Reservations Class.
*/

    if (!class_exists("DOPBookingSystemPROBackEndReservations")){
        class DOPBookingSystemPROBackEndReservations extends DOPBookingSystemPROBackEnd{
            function DOPBookingSystemPROBackEndReservations(){// Constructor.
            }
            
// Reservations            
            function showNoReservations(){
                global $wpdb;
                
                $reservations = $wpdb->get_results('SELECT * FROM '.DOPBSP_Reservations_table.' WHERE calendar_id="'.$_POST['calendar_id'].'" AND CURDATE() <= check_in AND status <> "rejected" AND status <> "canceled"');
                echo $wpdb->num_rows;
                
            	die();      
            }
            
            function showReservations(){
                global $wpdb;              
                $reservationsHTML = array();
                                
                $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                $reservations = $wpdb->get_results('SELECT * FROM '.DOPBSP_Reservations_table.' WHERE calendar_id="'.$_POST['calendar_id'].'" AND CURDATE() <= check_in AND status <> "rejected" AND status <> "canceled" ORDER BY check_in DESC');
                     
                array_push($reservationsHTML, '<ul>');
                
                foreach ($reservations as $reservation){
                    array_push($reservationsHTML, '<li id="DOPBSP_Reservation_ID'.$reservation->id.'">');
                    
                    array_push($reservationsHTML, '<div class="DOPBookingSystemPRO_Reservation">');
                    array_push($reservationsHTML, '    <div class="container">');
                         
                    // ********************************************************* Dates/Hours Info
                                                
                    array_push($reservationsHTML, '        <div class="section">');
                        
                    $dayPieces = explode('-', $reservation->check_in);
                    $ciMonth = (int)$dayPieces[1];
                    $ciYear = $dayPieces[0];
                    $day = $this->dateToFormat($reservation->check_in, $settings->date_type);
                    
                    array_push($reservationsHTML, '            <div class="toggle" id="DOPBSP_Reservation_ToggleID'.$reservation->id.'">+</div>');

                    array_push($reservationsHTML, '            <div class="section-item">');
                    array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_CHECK_IN_LABEL.'</label>');
                    array_push($reservationsHTML, '                <span class="date">'.$day.'</span>');
                    array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                    array_push($reservationsHTML, '            </div>');
                    
                    if ($reservation->check_out != ''){
                        $day = $this->dateToFormat($reservation->check_out, $settings->date_type);

                        array_push($reservationsHTML, '            <div class="section-item">');
                        array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_CHECK_OUT_LABEL.'</label>');
                        array_push($reservationsHTML, '                <span class="date">'.$day.'</span>');
                        array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                        array_push($reservationsHTML, '            </div>');
                    }
                    
                    if ($reservation->start_hour != ''){
                        array_push($reservationsHTML, '            <div class="section-item">');
                        array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_START_HOURS_LABEL.'</label>');
                        array_push($reservationsHTML, '                <span class="date">'.($settings->hours_ampm == 'true' ? $this->timeToAMPM($reservation->start_hour):$reservation->start_hour).'</span>');
                        array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                        array_push($reservationsHTML, '            </div>');
                    }
                    
                    if ($reservation->end_hour != ''){
                        array_push($reservationsHTML, '            <div class="section-item">');
                        array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_END_HOURS_LABEL.'</label>');
                        array_push($reservationsHTML, '                <span class="date">'.($settings->hours_ampm == 'true' ? $this->timeToAMPM($reservation->end_hour):$reservation->end_hour).'</span>');
                        array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                        array_push($reservationsHTML, '            </div>');
                    }
                    array_push($reservationsHTML, '        </div>');
                    
                    
                    // ********************************************************* Dates/Hours Info
                                                
                    array_push($reservationsHTML, '        <div class="section content" id="DOPBSP_Reservation_ContentID'.$reservation->id.'">');
                    array_push($reservationsHTML, '            <div class="section-item">');
                    array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_STATUS_LABEL.'</label>');
                    array_push($reservationsHTML, '                <span class="text" id="DOPBSP_Reservation_StatusID'.$reservation->id.'">'.($reservation->status == 'approved' ? DOPBSP_RESERVATIONS_STATUS_APPROVED:DOPBSP_RESERVATIONS_STATUS_PENDING).'</span>');
                    array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                    array_push($reservationsHTML, '            </div>');
                    array_push($reservationsHTML, '            <div class="section-item">');
                    array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_DATE_CREATED_LABEL.'</label>');
                    array_push($reservationsHTML, '                <span class="text">'.$reservation->date_created.'</span>');
                    array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                    array_push($reservationsHTML, '            </div>');
                    
                    if ($reservation->payment_method != 0){
                        array_push($reservationsHTML, '            <div class="section-item">');
                        array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_PAYMENT_METHOD_LABEL.'</label>');
                        array_push($reservationsHTML, '                <span class="text">'.($reservation->payment_method == 1 ? DOPBSP_RESERVATIONS_PAYMENT_METHOD_ARRIVAL:DOPBSP_RESERVATIONS_PAYMENT_METHOD_PAYPAL).'</span>');
                        array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                        array_push($reservationsHTML, '            </div>');
                    }
                                        
                    if ($reservation->paypal_transaction_id != ''){
                        array_push($reservationsHTML, '            <div class="section-item">');
                        array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_PAYMENT_METHOD_PAYPAL_TRANSACTION_ID_LABEL.'</label>');
                        array_push($reservationsHTML, '                <span class="text">'.$reservation->paypal_transaction_id.'</span>');
                        array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                        array_push($reservationsHTML, '            </div>');
                    }
                    
                    if ($settings->no_items_enabled == 'true'){
                        array_push($reservationsHTML, '            <div class="section-item">');
                        array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_NO_ITEMS_LABEL.'</label>');
                        array_push($reservationsHTML, '                <span class="text">'.$reservation->no_items.'</span>');
                        array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                        array_push($reservationsHTML, '            </div>');
                    }
                    
                    if ($reservation->price != 0){
                        array_push($reservationsHTML, '            <div class="section-item">');
                        array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_PRICE_LABEL.'</label>');
                        array_push($reservationsHTML, '                <span class="text">'.$reservation->currency.$this->getWithDecimals($reservation->price).'</span>');
                        array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                        array_push($reservationsHTML, '            </div>');
                    }
                    
                    if ($reservation->deposit != 0){
                        array_push($reservationsHTML, '            <div class="section-item">');
                        array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_DEPOSIT_PRICE_LABEL.'</label>');
                        array_push($reservationsHTML, '                <span class="text">'.$reservation->currency.$this->getWithDecimals($reservation->deposit).' ('.$settings->deposit.'%)</span>');
                        array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                        array_push($reservationsHTML, '            </div>');
                        array_push($reservationsHTML, '            <div class="section-item">');
                        array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_DEPOSIT_PRICE_LEFT_LABEL.'</label>');
                        array_push($reservationsHTML, '                <span class="text">'.$reservation->currency.$this->getWithDecimals($reservation->price-$reservation->deposit).'</span>');
                        array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                        array_push($reservationsHTML, '            </div>');
                    }
                    
                    if ($reservation->total_price != 0 && $reservation->total_price != $reservation->price){
                        array_push($reservationsHTML, '            <div class="section-item">');
                        array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_DISCOUNT_PRICE_LABEL.'</label>');
                        array_push($reservationsHTML, '                <span class="text"><span class="cut">'.$reservation->currency.$this->getWithDecimals($reservation->total_price).'</span> ('.$reservation->discount.'% '.DOPBSP_RESERVATIONS_DISCOUNT_PRICE_TEXT.')</span>');
                        array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                        array_push($reservationsHTML, '            </div>');
                    }
                    
                    if ($reservation->info != ''){
                        $info = json_decode($reservation->info);
                        
                        foreach ($info as $item){
                            array_push($reservationsHTML, '            <div class="section-item">');
                            array_push($reservationsHTML, '                <label class="left">'.$item->name.'</label>');
                            array_push($reservationsHTML, '                <span class="text">');
                            
                            if (is_array($item->value)){
                                $j = 0;
                                
                                foreach ($item->value as $value){
                                    $j++;
                                    
                                    if ($j == 1){
                                        array_push($reservationsHTML, ($this->validEmail($value->translation) ? '<a href="mailto:'.$value->translation.'">'.$value->translation.'</a>':$value->translation));
                                    }
                                    else{
                                        array_push($reservationsHTML, ', '.($this->validEmail($item->translation) ? '<a href="mailto:'.$value->translation.'">'.$value->translation.'</a>':$value->translation));
                                    }
                                }
                            }
                            else{
                                if ($item->value == 'true'){
                                    $value = DOPBSP_BOOKING_FORM_CHECKED;
                                }
                                elseif ($item->value == 'false'){
                                    $value = DOPBSP_BOOKING_FORM_UNCHECKED;
                                }
                                else{
                                    $value = $item->value;
                                }
                                array_push($reservationsHTML, '                <span class="text">'.($this->validEmail($item->value) ? '<a href="mailto:'.$item->value.'">'.$item->value.'</a>':$value).'</span>');
                            }
                            
                            array_push($reservationsHTML, '                </span>');
                            array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                            array_push($reservationsHTML, '            </div>');
                        }
                    }
                    
                    if ($reservation->no_people != '' && $reservation->no_people != 0){
                        array_push($reservationsHTML, '            <div class="section-item">');
                        array_push($reservationsHTML, '                <label class="left">'.($reservation->no_children == '' ? DOPBSP_RESERVATIONS_NO_PEOPLE_LABEL:DOPBSP_RESERVATIONS_NO_ADULTS_LABEL).'</label>');
                        array_push($reservationsHTML, '                <span class="text">'.$reservation->no_people.'</span>');
                        array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                        array_push($reservationsHTML, '            </div>');
                    }
                    
                    if ($reservation->no_children != '' && $reservation->no_children != 0){
                        array_push($reservationsHTML, '            <div class="section-item">');
                        array_push($reservationsHTML, '                <label class="left">'.DOPBSP_RESERVATIONS_NO_CHILDREN_LABEL.'</label>');
                        array_push($reservationsHTML, '                <span class="text">'.$reservation->no_children.'</span>');
                        array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                        array_push($reservationsHTML, '            </div>');
                    }
                   
                    array_push($reservationsHTML, '            <div class="section-item">');
                    array_push($reservationsHTML, '                <label class="left">&nbsp;</label>');
                    array_push($reservationsHTML, '                <span class="text">');                        
                    array_push($reservationsHTML, '                     <a href="javascript:void(0)" class="DOPBookingSystemPRO_Message_JumpDay" id="DOPBookingSystemPRO_Message_JumpDay_'.$ciYear.'-'.$ciMonth.'">'.DOPBSP_RESERVATIONS_JUMP_TO_DAY_LABEL.'</a>');    
                    
                    if ($reservation->status == 'pending'){              
                        array_push($reservationsHTML, '                     <a href="javascript:void(0)" class="DOPBookingSystemPRO_ReservationApprove" id="DOPBookingSystemPRO_ReservationApprove'.$reservation->id.'">'.DOPBSP_RESERVATIONS_APPROVE_LABEL.'</a>');                  
                        array_push($reservationsHTML, '                     <a href="javascript:void(0)" class="DOPBookingSystemPRO_ReservationReject" id="DOPBookingSystemPRO_ReservationReject'.$reservation->id.'">'.DOPBSP_RESERVATIONS_REJECT_LABEL.'</a>');
                        array_push($reservationsHTML, '                     <a href="javascript:void(0)" class="DOPBookingSystemPRO_ReservationCancel" id="DOPBookingSystemPRO_ReservationCancel'.$reservation->id.'" style="display: none;">'.DOPBSP_RESERVATIONS_CANCEL_LABEL.'</a>');
                    }
                    else{
                        array_push($reservationsHTML, '                     <a href="javascript:void(0)" class="DOPBookingSystemPRO_ReservationCancel" id="DOPBookingSystemPRO_ReservationCancel'.$reservation->id.'">'.DOPBSP_RESERVATIONS_CANCEL_LABEL.'</a>');
                    }
                    
                    array_push($reservationsHTML, '                </span>');
                    array_push($reservationsHTML, '                <br class="DOPBSP-clear" />');  
                    array_push($reservationsHTML, '            </div>');
                    array_push($reservationsHTML, '        </div>');                   
                    array_push($reservationsHTML, '    </div>');                      
                    array_push($reservationsHTML, '</div>');
                    
                    
                    array_push($reservationsHTML, '</li>');
                }
                array_push($reservationsHTML, '</ul>');
                
                echo implode("\n", $reservationsHTML);
                
            	die();      
            }
            
            function approveReservation(){                
                if (isset($_POST['reservation_id'])){
                    global $wpdb;
                    
                    // =========================================================
                    
                    $DOPemail = new DOPBookingSystemPROEmail();
                    $reservationId = $_POST['reservation_id'];
                                        
                    $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                    $reservation = $wpdb->get_row('SELECT * FROM '.DOPBSP_Reservations_table.' WHERE id="'.$reservationId.'"');
                    
                    $DOPemail->sendMessage('booking_approved',
                                           $reservation->language,
                                           $_POST['calendar_id'], 
                                           $reservationId,
                                           $reservation->check_in,
                                           $reservation->check_out,
                                           $reservation->start_hour,
                                           $reservation->end_hour,
                                           $reservation->no_items,
                                           $reservation->currency,
                                           $reservation->price,
                                           $reservation->deposit,
                                           $reservation->total_price,
                                           $reservation->discount,
                                           json_decode($reservation->info),
                                           $reservation->no_people,
                                           $reservation->no_children,
                                           $reservation->email,
                                           false,
                                           true);
                    
                    $this->approveReservationCalendarChange($reservationId, $settings);
                    
                    $ci = explode('-', $reservation->check_in);
                    echo $ci[0].'-'.(int)$ci[1];
                    die();
                }
            }
            
            function rejectReservation(){
                if (isset($_POST['reservation_id'])){
                    global $wpdb;

                    $wpdb->update(DOPBSP_Reservations_table, array('status' => 'rejected'), array('id' => $_POST['reservation_id']));
                    $DOPemail = new DOPBookingSystemPROEmail();
                    $reservationId = $_POST['reservation_id'];
                                        
                    $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                    $reservation = $wpdb->get_row('SELECT * FROM '.DOPBSP_Reservations_table.' WHERE id="'.$_POST['reservation_id'].'"');
                    
                    $DOPemail->sendMessage('booking_rejected',
                                           $reservation->language,
                                           $_POST['calendar_id'], 
                                           $reservationId,
                                           $reservation->check_in,
                                           $reservation->check_out,
                                           $reservation->start_hour,
                                           $reservation->end_hour,
                                           $reservation->no_items,
                                           $reservation->currency,
                                           $reservation->price,
                                           $reservation->deposit,
                                           $reservation->total_price,
                                           $reservation->discount,
                                           json_decode($reservation->info),
                                           $reservation->no_people,
                                           $reservation->no_children,
                                           $reservation->email,
                                           false,
                                           true);
                    echo '';
                    die();
                }
            }
            
            function cancelReservation(){
                if (isset($_POST['reservation_id'])){
                    global $wpdb;
                    
                    $reservationId = $_POST['reservation_id'];
                    echo $reservationId;
                    $wpdb->update(DOPBSP_Reservations_table, array('status' => 'canceled'), array('id' => $reservationId));
                    $DOPemail = new DOPBookingSystemPROEmail();
                                        
                    $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                    $reservation = $wpdb->get_row('SELECT * FROM '.DOPBSP_Reservations_table.' WHERE id="'.$reservationId.'"');
                    
                    $DOPemail->sendMessage('booking_canceled',
                                           $reservation->language,
                                           $_POST['calendar_id'], 
                                           $reservationId,
                                           $reservation->check_in,
                                           $reservation->check_out,
                                           $reservation->start_hour,
                                           $reservation->end_hour,
                                           $reservation->no_items,
                                           $reservation->currency,
                                           $reservation->price,
                                           $reservation->deposit,
                                           $reservation->total_price,
                                           $reservation->discount,
                                           json_decode($reservation->info),
                                           $reservation->no_people,
                                           $reservation->no_children,
                                           $reservation->email,
                                           false,
                                           true);
                    echo '';
                    die();
                }
            }
            
            function approveReservationCalendarChange($reservationId, $settings){
                global $wpdb;
                
                $wpdb->update(DOPBSP_Reservations_table, array('status' => 'approved'), array('id' => $reservationId));
                $reservation = $wpdb->get_row('SELECT * FROM '.DOPBSP_Reservations_table.' WHERE id="'.$reservationId.'"');
                $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$reservation->calendar_id.'"');
                    
                if ($reservation->check_out == ''){
                    $day = $wpdb->get_row('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$reservation->calendar_id.'" AND day="'.$reservation->check_in.'"');
                }
                else{
                    if ($settings->morning_check_out == 'true'){
                        $days = $wpdb->get_results('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$reservation->calendar_id.'" AND day>="'.$reservation->check_in.'" AND day<"'.$reservation->check_out.'"');
                    }
                    else{
                        $days = $wpdb->get_results('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$reservation->calendar_id.'" AND day>="'.$reservation->check_in.'" AND day<="'.$reservation->check_out.'"');
                    }
                }


                if ($reservation->check_out == '' && $reservation->start_hour == ''){ 
                    $data = json_decode($day->data);

                    if ($data->available == '' || (int)$data->available < 1){
                        $available = 1;
                    }
                    else{
                        $available = $data->available;
                    }

                    if ($available-$reservation->no_items == 0){
                            $data->price = '';
                            $data->promo = '';
                            $data->status = 'booked';
                    }

                    $data->available = $available-$reservation->no_items;
                    
  			//added by jon
                    $res_inf = json_decode($reservation->info);
                    $data->tour_type = $res_inf[0]->value[0]->id;
                    //end jon edit
                    $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $reservation->calendar_id, 
                                                                                                'day' => $day->day));
                }
                else if ($reservation->check_out != ''){                 
                    foreach ($days as $key => $day){
                        $data = json_decode($day->data);

                        if ($data->available == '' || (int)$data->available < 1){
                            $available = 1;
                        }
                        else{
                            $available = $data->available;
                        }

                        if ($available-$reservation->no_items == 0){
                                $data->price = '';
                                $data->promo = '';
                                $data->status = 'booked';
                        }

                        $data->available = $available-$reservation->no_items;

                        $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $reservation->calendar_id, 
                                                                                                    'day' => $day->day));
                    }
                }
                else if ($reservation->start_hour != '' && $reservation->end_hour == ''){ 
                    $data = json_decode($day->data);
                    $start_hour = $reservation->start_hour;
                    $hour = $data->hours->$start_hour;

                    if ($hour->available == '' || (int)$hour->available < 1){
                        $available = 1;
                    }
                    else{
                        $available = (int)$hour->available;
                    }

                    if ($available-$reservation->no_items == 0){
                        $hour->price = '';
                        $hour->promo = '';
                        $hour->status = 'booked';
                    }

                    $hour->available = $available-$reservation->no_items;

                    $data->hours->$start_hour = $hour;
                    $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $reservation->calendar_id, 
                                                                                                'day' => $day->day));
                    if ($settings->details_from_hours == 'true'){
                        $this->setDayFromHours($reservation->calendar_id, $day->day);
                    }
                }
                else if ($reservation->end_hour != ''){
                    $data = json_decode($day->data);

                    foreach ($data->hours as $key => $item){
                        if ($reservation->start_hour <= $key &&
                                ((($settings->last_hour_to_total_price == 'false' || $settings->hours_interval_enabled == 'true') && $key < $reservation->end_hour) || 
                                ($settings->last_hour_to_total_price == 'true' && $settings->hours_interval_enabled == 'false' && $key <= $reservation->end_hour))){
                            $hour = $data->hours->$key;

                            if ($hour->available == '' || (int)$hour->available < 1){
                                $available = 1;
                            }
                            else{
                                $available = (int)$hour->available;
                            }

                            if ($available-$reservation->no_items == 0){
                                $hour->price = '';
                                $hour->promo = '';
                                $hour->status = 'booked';
                            }

                            $hour->available = $available-$reservation->no_items;

                            $data->hours->$key = $hour;
                        }
                    }

                    $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $reservation->calendar_id, 
                                                                                                'day' => $day->day));
                    if ($settings->details_from_hours == 'true'){
                        $this->setDayFromHours($reservation->calendar_id, $day->day);
                    }
                }
            }
            
            function setDayFromHours($calendar_id, $day){
                global $wpdb;
                
                $day_data = $wpdb->get_row('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$calendar_id.'" AND day="'.$day.'"');
                $data = json_decode($day_data->data);
                
                $available = 0;
                $price = '';
                $status = 'none';

                foreach ($data->hours as $hour){
                    // No Available Check
                    if ($hour->bind == 0 || $hour->bind == 1){
                        if ($hour->available != ''){
                            $available += $hour->available;
                        }

                        // Price Check
                        if ($hour->price != '' && ($price == '' || (float)$hour->price < $price)){
                            $price = (float)$hour->price;
                        }

                        if ($hour->promo != '' && ($price == '' || (float)$hour->promo < $price)){
                            $price = (float)$hour->promo;
                        }

                        //  Status Check
                        if ($hour->status == 'unavailable' && $status == 'none'){
                            $status = 'unavailable';
                        }

                        if ($hour->status == 'booked' && ($status == 'none' || $status == 'unavailable')){
                            $status = 'booked';
                        }

                        if ($hour->status == 'special' && ($status == 'none' || $status == 'unavailable' || $status == 'booked')){
                            $status = 'special';
                        }

                        if ($hour->status == 'available'){
                            $status = 'available';
                        }
                    }
                }
                
                $data->available = $available == 0 ? '':$available;
                $data->price = $price;
                $data->status = $status;
                
                $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $calendar_id, 
                                                                                            'day' => $day));
            }
        }
    }