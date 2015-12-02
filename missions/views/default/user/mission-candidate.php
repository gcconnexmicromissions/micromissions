<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * User display for mission context.
 */
$user_guid = $vars['user']->guid;
$feedback_string = $_SESSION['candidate_search_feedback'][$user_guid];
if($feedback_string != '') {
    $feedback_array = explode(',', $feedback_string);
    
    echo '<h4>' . elgg_echo('missions:user_matched_by') . ':</h4>';
    foreach($feedback_array as $feedback) {
        if($feedback) {
            echo '<span class="tab">' . $feedback . '</span></br>';
        }
    }
}

echo elgg_view('output/url', array(
    'href' => elgg_get_site_url() . 'missions/mission-select-invite/' . $user_guid,
    'text' => elgg_echo('missions:invite'),
    'class' => 'elgg-button' . ' advanced-drop'
));