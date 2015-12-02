<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Returns an array of tabs to display depending on what context is set in $_SESSION['tab_context'].
 * The tab has a link attached to it depending on whether or not the user has visited that tab.
 */
function mm_write_tab_links($context, $url)
{
    $array = '';
    
    // Decides on how many linked tabs to return depending on $_SESSION['tab_context']
    switch ($context) {
        case 'firstpost':
            $array = array(
                array(
                    elgg_echo('missions:tab:manager'),
                    $url . 'post-mission-first-tab'
                ),
                array(
                    elgg_echo('missions:tab:opportunity'),
                    ''
                ),
                array(
                    elgg_echo('missions:tab:requirements'),
                    ''
                )
            );
            
            break;
        case 'secondpost':
            $array = array(
                array(
                    elgg_echo('missions:tab:manager'),
                    $url . 'post-mission-first-tab'
                ),
                array(
                    elgg_echo('missions:tab:opportunity'),
                    $url . 'post-mission-second-tab'
                ),
                array(
                    elgg_echo('missions:tab:requirements'),
                    ''
                )
            );
            break;
        case 'thirdpost':
            $array = array(
                array(
                    elgg_echo('missions:tab:manager'),
                    $url . 'post-mission-first-tab'
                ),
                array(
                    elgg_echo('missions:tab:opportunity'),
                    $url . 'post-mission-second-tab'
                ),
                array(
                    elgg_echo('missions:tab:requirements'),
                    $url . 'post-mission-third-tab'
                )
            );
            break;
        default:
            $array = NULL;
            break;
    }
    
    return $array;
}

/*
 * A regex which returns true if the input is a phone number.
 * Regular expression created by Eric Holmes (http://ericholmes.ca/php-phone-number-validation-revisited/)
 * Valid:
 * 5555555555
 * 555-555-5555
 * 555 555 5555
 * 1(555) 555-5555
 * 1 (555) 555-5555
 * 1-555-555-5555
 * Invalid:
 * 5
 * 555-5555
 * 1-(555)-555-5555
 */
function mm_is_valid_phone_number($number)
{
    $regex = "/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";
    
    return preg_match($regex, (string) $number);
}

/*
 * A regex which checks that no numbers are in the expression.
 * Valid:
 * Eileen
 * Eileen Williamson
 * Valid but Wrong:
 * %$@#%$#&/:'.']}
 * Invalid:
 * 4Wesley
 * Wes7ley
 * Wesley9
 */
function mm_is_valid_person_name($name)
{
    $regex = "/^[^0-9]+$/";
    
    return preg_match($regex, $name);
}

/*
 * A regex which checks that only numbers are in the expression.
 * Valid:
 * 5
 * 673445
 * Invalid:
 * 532K351
 * @578(532)
 */
function mm_is_guid_number($num)
{
    $regex = "/^[0-9]*$/";
    
    return preg_match($regex, $num);
}

/*
 * Tests all days of the week given the form input.
 */
function mm_validate_time_all(&$input_array)
{
    $err = '';
    
    $err .= mm_validate_time('mon', $input_array);
    $err .= mm_validate_time('tue', $input_array);
    $err .= mm_validate_time('wed', $input_array);
    $err .= mm_validate_time('thu', $input_array);
    $err .= mm_validate_time('fri', $input_array);
    $err .= mm_validate_time('sat', $input_array);
    $err .= mm_validate_time('sun', $input_array);
    
    return $err;
}

/*
 * Tests a the start time and duration of the given day of the week.
 * Also defaults the minutes to '00' if the hour is set and the minute value is null.
 */
function mm_validate_time($day, &$input_array)
{
    $start_hour = $input_array[$day . '_start_hour'];
    $start_min = $input_array[$day . '_start_min'];
    $duration_hour = $input_array[$day . '_duration_hour'];
    $duration_min = $input_array[$day . '_duration_min'];
    $day_full = elgg_echo('missions:' . $day);
    $err = '';
    
    if ($_SESSION['language'] == 'fr') {
        $day_full = strtolower($day_full);
    }
    
    // If one hour value is not empty then the other cannot be empty and the associated minute value cannot be NULL.
    if (! empty($start_hour)) {
        if (empty($duration_hour) && empty($duration_min)) {
            $err .= elgg_echo('missions:duration_must_be_set') . $day_full . ".\n";
        }
        if (empty($start_min)) {
            $input_array[$day . '_start_min'] = '00';
            $start_min = '00';
        }
    }
    if (! empty($duration_hour) || ! empty($duration_min)) {
        if (empty($start_hour)) {
            $err .= elgg_echo('missions:start_hour_must_be_set') . $day_full . ".\n";
        }
        if (empty($duration_hour)) {
            $input_array[$day . '_duration_hour'] = '0';
            $duration_hour = '0';
        }
        if (empty($duration_min)) {
            $input_array[$day . '_duration_min'] = '00';
            $duration_min = '00';
        }
    }
    
    // The start time cannot occur after the duration time.
    /*
     * if(!empty($start_hour) && !empty($duration_hour)) {
     * if((int)($start_hour . $start_min) > (int)($duration_hour . $duration_min)) {
     * $err .= elgg_echo('missions:error:start_after_duration_time') . $day_full . ".\n";
     * }
     * }
     */
    
    return $err;
}

/*
 * Packs the language variables for a single language into a single string.
 */
function mm_pack_language($lwc, $lwe, $lop, $lang)
{
    $returner = '';
    
    $value = strtolower($lang);
    $returner .= $value;
    
    if (! empty($lwc) || $lwc == '-') {
        $returner .= $lwc;
    } else {
        $returner .= '-';
    }
    
    if (! empty($lwe) || $lwe == '-') {
        $returner .= $lwe;
    } else {
        $returner .= '-';
    }
    
    if (! empty($lop) || $lop == '-') {
        $returner .= $lop;
    } else {
        $returner .= '-';
    }
    
    return $returner;
}

/*
 * Unpacks a language string into an array of its component variable.
 */
function mm_unpack_language($data_string, $lang)
{
    $returner = array();
    
    $value = strtolower($lang);
    $index = stripos($data_string, $value) + strlen($value);
    
    $returner['lwc_' . $value] = substr($data_string, $index, 1);
    if ($returner['lwc_' . $value] == '-') {
        $returner['lwc_' . $value] = '';
    }
    $index ++;
    
    $returner['lwe_' . $value] = substr($data_string, $index, 1);
    if ($returner['lwe_' . $value] == '-') {
        $returner['lwe_' . $value] = '';
    }
    $index ++;
    
    $returner['lop_' . $value] = substr($data_string, $index, 1);
    if ($returner['lop_' . $value] == '-') {
        $returner['lop_' . $value] = '';
    }
    
    return $returner;
}

/*
 * Packs the time (hour and minute) into a single string.
 */
function mm_pack_time($hour, $min, $day)
{
    $returner = '';
    
    $value = strtolower($day);
    $returner .= $day;
    
    if($min == '') {
        $min = '00';
    }
    
    if (! empty($hour)) {
        $returner .= $hour . $min;
    }
    
    if (empty($hour) && (strpos($day, 'duration') !== false)) {
        $returner .= '0' . $min;
    }
    
    return $returner;
}

/*
 * Unpacks the time into an array of hour and minute.
 */
function mm_unpack_time($data_string, $day)
{
    $returner = array();
    
    $value = strtolower($day);
    $index = stripos($data_string, $value) + strlen($value);
    
    $dividing_time = 2;
    if (strpos($data_string, 'duration') !== false) {
        $dividing_time = 1;
    }
    
    if (! empty($data_string)) {
        $returner[$day . '_hour'] = substr($data_string, $index, $dividing_time);
        $returner[$day . '_min'] = substr($data_string, $index + $dividing_time, 2);
    }
    
    return $returner;
}

/*
 * Unpacks every unpackable item within a given entity.
 */
function mm_unpack_mission($entity)
{
    $returner = array();
    
    $returner = array_merge($returner, mm_unpack_language($entity->english, 'english'));
    $returner = array_merge($returner, mm_unpack_language($entity->french, 'french'));
    $returner = array_merge($returner, mm_unpack_time($entity->mon_start, 'mon_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->mon_duration, 'mon_duration'));
    $returner = array_merge($returner, mm_unpack_time($entity->tue_start, 'tue_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->tue_duration, 'tue_duration'));
    $returner = array_merge($returner, mm_unpack_time($entity->wed_start, 'wed_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->wed_duration, 'wed_duration'));
    $returner = array_merge($returner, mm_unpack_time($entity->thu_start, 'thu_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->thu_duration, 'thu_duration'));
    $returner = array_merge($returner, mm_unpack_time($entity->fri_start, 'fri_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->fri_duration, 'fri_duration'));
    $returner = array_merge($returner, mm_unpack_time($entity->sat_start, 'sat_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->sat_duration, 'sat_duration'));
    $returner = array_merge($returner, mm_unpack_time($entity->sun_start, 'sun_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->sun_duration, 'sun_duration'));
    
    return $returner;
}

/*
 * Returns an array of buttons for actions taken with regards to a mission.
 */
function mm_create_button_set($mission)
{
    $returner = array();
    $apply_button = '';
    $close_button = '';
    
    // Button to send an application e-mail to the mission creator.
    if ($mission->owner_guid != elgg_get_logged_in_user_guid()) {
        $apply_button = elgg_view('output/url', array(
            'href' => elgg_get_site_url() . 'missions/mission-application/' . $mission->guid,
            'text' => elgg_echo('missions:apply'),
            'class' => 'elgg-button'
        ));
    }
    $returner['apply_button'] = $apply_button;
    
    if ($mission->owner_guid == elgg_get_logged_in_user_guid()) {
        $fill_button = elgg_view('output/url', array(
            'href' => elgg_get_site_url() . 'missions/mission-fill/' . $mission->guid,
            'text' => elgg_echo('missions:fill'),
            'class' => 'elgg-button'
        ));
    }
    $returner['fill_button'] = $fill_button;
    
    // Button to close the mission.
    // TODO: This currently deletes the mission. It will change later on when mission filling and mission completion are implemented.
    if ($mission->owner_guid == elgg_get_logged_in_user_guid()) {
        $close_button = elgg_view('output/confirmlink', array(
            'href' => elgg_get_site_url() . 'action/missions/close-from-display?mission_guid=' . $mission->guid,
            'text' => elgg_echo('missions:delete'),
            'is_action' => true,
            'class' => 'elgg-button'
        ));
    }
    $returner['close_button'] = $close_button;
    
    return $returner;
}

/*
 * Returns two buttons which switch between mission and candidate searching.
 */
function mm_create_switch_buttons() {
    $returner = array();
    
    $active_mission_button = 'not_active';
    $active_candidate_button = 'not_active';
    if($_SESSION['mission_search_switch'] == 'mission') {
        $active_mission_button = 'active';
    }
    if($_SESSION['mission_search_switch'] == 'candidate') {
        $active_candidate_button = 'active';
    }
    
    $returner['mission_button'] = elgg_view('output/url', array(
        'href' => elgg_get_site_url() . 'action/missions/search-switch?switch=mission',
        'text' => elgg_echo('missions:mission'),
        'is_action' => true,
        'class' => 'elgg-button' . ' ' . $active_mission_button
    ));
    $returner['candidate_button'] = elgg_view('output/url', array(
        'href' => elgg_get_site_url() . 'action/missions/search-switch?switch=candidate',
        'text' => elgg_echo('missions:candidate'),
        'is_action' => true,
        'class' => 'elgg-button' . ' ' . $active_candidate_button
    ));
    
    return $returner;
}

/*
 * Sends a notification to a user containing an invitation to a mission.
 */
function mm_send_notification_invite($target, $mission) {
    // Link to a page which contains the invitation.
    $invitation_link = elgg_view('output/url', array(
        'href' => elgg_get_site_url() . 'missions/mission-invitation/' . $mission->guid,
        'text' => elgg_echo('missions:mission_invitation')
    ));
    
    $subject = get_user($mission->owner_guid)->name . elgg_echo('missions:invited_you', array(), $target->language) . $mission->title;
    $body = $invitation_link;
    notify_user($target->guid, $mission->owner_guid, $subject, $body);
    
    // Create a tentative relationship between mission and user for identification purposes.
    add_entity_relationship($mission->guid, 'mission_tentative', $target->guid);
    
    return true;
}