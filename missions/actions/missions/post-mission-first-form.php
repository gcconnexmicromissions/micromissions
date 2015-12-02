<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This action evaluates the data from the form for errors and forwards the user to the next tab.
 */
elgg_make_sticky_form('firstfill');

$err = '';
$first_form = elgg_get_sticky_values('firstfill');

// Checks if the name field is empty then checks to see that there are no numbers in the name
if (empty($first_form['name'])) {
    $err .= elgg_echo('missions:error:name_needs_input') . "\n";
} else {
    if (! mm_is_valid_person_name($first_form['name'])) {
        $err .= elgg_echo('missions:error:name_no_numbers') . "\n";
    }
}

// Checks if the department is empty
if (empty($first_form['department'])) {
    $err .= elgg_echo('missions:error:department_needs_input') . "\n";
}

// Checks if the email is empty
if (! filter_var($first_form['email'], FILTER_VALIDATE_EMAIL)) {
    $err .= elgg_echo('missions:error:email_invalid') . "\n";
}

// Checks if the phone number is empty
if (! mm_is_valid_phone_number($first_form['phone']) && ! empty($first_form['phone'])) {
    $err .= elgg_echo('missions:error:phone_invalid') . "\n";
}

// If there is an error message it will be posted on the same page that will be reloaded
// If not then the next page will be loaded
if ($err == '') {
    forward(elgg_get_site_url() . 'missions/post-mission-second-tab');
} else {
    register_error($err);
    forward(REFERER);
}