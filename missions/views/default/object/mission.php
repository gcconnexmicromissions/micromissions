<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
// View for the mission entity.
gatekeeper();

$mission = $vars['entity'];
$button_override = $vars['override_buttons'];
$current_uri = $_SERVER['REQUEST_URI'];
$exploded_uri = explode('/', $current_uri);
$current_guid = array_pop($exploded_uri);
$_SESSION['mid_act'] = $current_guid;

// Decides an whether to use the expanded view or not
if (strpos($current_uri, 'display-search-set') !== false || strpos($current_uri, 'mission-mine') !== false) {
    echo elgg_view('page/elements/print-mission', array(
        'entity' => $mission,
        'full_view' => false,
        'override_buttons' => $button_override
    ));
} else {
    $content = elgg_view('page/elements/print-mission-more', array(
        'entity' => $mission,
        'full_view' => true,
        'override_buttons' => $button_override
    ));
    
    $applicants = get_entity_relationships($mission->guid);
    
    // Sidebar content which displays the candidates who are going to work on this mission.
    $applicants_none_accepted = true;
    $applicants_none_tentative = true;
    $accepted = '<h3>' . elgg_echo('missions:filled_by') . ':</h3>';
    $tentative = '<h3>' . elgg_echo('missions:tentative') . ':</h3>';
    foreach ($applicants as $applicant) {
    	// Candidates which have been accepted into the mission.
        if ($applicant->relationship == 'mission_accepted') {
        	$accepted .= '<div>';
            $accepted .= '<span class="missions-inline-drop">' . elgg_view_entity(get_user($applicant->guid_two)) . '</span>';
            
            // Removal button for the candidate.
            $accepted .= elgg_view('output/url', array(
	            'href' => elgg_get_site_url() . 'action/missions/remove-applicant?mission_applicant=' . $applicant->guid_two,
	            'text' => elgg_echo('missions:remove'),
	            'is_action' => true,
	            'class' => 'elgg-button btn btn-default mm-raise',
	        	'id' => 'fill-mission-applicant-' . $i . '-remove-button'
	        ));
            $accepted .= '</div>';
            $applicants_none_accepted = false;
        }
        
        // Candidates which have been sent an invitation to the mission.
        if ($applicant->relationship == 'mission_tentative') {
        	$tentative .= '<div>';
            $tentative .= '<span class="missions-inline-drop">' . elgg_view_entity(get_user($applicant->guid_two)) . '</span>';
            
            // Removal button for the candidate.
            $tentative .= elgg_view('output/url', array(
	            'href' => elgg_get_site_url() . 'action/missions/remove-applicant?mission_applicant=' . $applicant->guid_two,
	            'text' => elgg_echo('missions:remove'),
	            'is_action' => true,
	            'class' => 'elgg-button btn btn-default mm-raise',
	        	'id' => 'fill-mission-applicant-' . $i . '-remove-button'
	        ));
        	$tentative .= '</div>';
            $applicants_none_tentative = false;
        }
    }
    // Display something if there are no applicants.
    if ($applicants_none_accepted) {
        $accepted .= elgg_echo('missions:nobody') . '</br>';
    }
    if ($applicants_none_tentative) {
        $tentative .= elgg_echo('missions:nobody') . '</br>';
    }
    
    $sidebar .= $accepted;
    $sidebar .= $tentative;
    
    echo elgg_view_layout('one_sidebar', array(
        'content' => $content,
        'sidebar' => $sidebar,
        'is_mission' => true
    ));
}
?>