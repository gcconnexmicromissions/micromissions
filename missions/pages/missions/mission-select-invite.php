<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Page which allows a manager to select the mission a candidate will be invited to.
 * This is meant to be a follow up to inviting a candidate from the candidate search.
 */
gatekeeper();

$current_uri = $_SERVER['REQUEST_URI'];
$exploded_uri = explode('/', $current_uri);
$user_guid = array_pop($exploded_uri);

$title = elgg_echo('missions:invite_user_to_mission');
$content = elgg_view_title($title);

$entity_list = elgg_get_entities_from_relationship(array(
    'relationship' => 'mission_posted',
    'relationship_guid' => elgg_get_logged_in_user_guid()
));

$content = '<table class="mission-post-table">';
foreach($entity_list as $entity) {
    $count = count(elgg_get_entities_from_relationship(array(
        'relationship' => 'mission_accepted',
        'relationship_guid' => $entity->guid
    )));
    
    // Does not display missions which have filled all the available spots.
    if($count < $entity->number) {
        $content .= '<tr><td>' . elgg_view('output/url', array(
            'href' => $entity->getURL(),
            'text' => $entity->job_title,
            'class' => 'mission-emphasis mission-link-color'
        )) . '</br>';
        $content .= $count . '/' . $entity->number . elgg_echo('missions:spots_filled') . '</td>';
        $content .= '<td>' . elgg_view('output/url', array(
            'href' => elgg_get_site_url() . 'action/missions/invite-user?aid=' . $user_guid . '&mid=' . $entity->guid,
            'text' => elgg_echo('missions:select'),
            'is_action' => true,
            'class' => 'elgg-button btn btn-default tab'
        )) . '</td></tr>';
    }
}
$content .= '</table>';

echo elgg_view_page($title, $content);