<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * User display within the context of the micro missions plugin.
 */
$user_guid = $vars['user']->guid;
$user = get_user($user_guid);
$feedback_string = $_SESSION['candidate_search_feedback'][$user_guid];

// Creates a gray background if the user is not opted in to micro missions.
if($user->opt_in_missions == 'gcconnex_profile:opt:yes') {
	echo '<div>';
}
else {
	echo '<div class="mm-drab-back">';
}

// Displays search feedback from simple search.
if($feedback_string != '') {
    $feedback_array = explode(',', $feedback_string);
    
    echo '<h4>' . elgg_echo('missions:user_matched_by') . ':</h4>';
    foreach($feedback_array as $feedback) {
        if($feedback) {
            echo '<span class="tab">' . $feedback . '</span></br>';
        }
    }
}

// Displays invitation button if the user is opted in to micro missions.
if($user->opt_in_missions == 'gcconnex_profile:opt:yes') {
    echo elgg_view('output/url', array(
        'href' => elgg_get_site_url() . 'missions/mission-select-invite/' . $user_guid,
        'text' => elgg_echo('missions:invite'),
        'class' => 'elgg-button btn btn-default advanced-drop'
    ));
}
else {
	echo '<h4>' . elgg_echo('missions:not_participating_in_missions') . '</h4>';
}
echo '</div>';