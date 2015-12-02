<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
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
    
    if($count < $entity->number) {
        $content .= '<tr><td><a href="' . $entity->getURL() . '" class="mission-emphasis">' . $entity->job_title . '</a></br>';
        $content .= $count . '/' . $entity->number . elgg_echo('missions:spots_filled') . '</td>';
        $content .= '<td>' . elgg_view('output/url', array(
            'href' => elgg_get_site_url() . 'action/missions/invite-user?aid=' . $user_guid . '&mid=' . $entity->guid,
            'text' => elgg_echo('missions:select'),
            'is_action' => true,
            'class' => 'elgg-button tab'
        )) . '</td></tr>';
    }
}
$content .= '</table>';

echo elgg_view_page($title, $content);