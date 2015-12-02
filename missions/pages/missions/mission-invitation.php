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
$blast_radius = explode('/', $current_uri);
$mission = get_entity(array_pop($blast_radius));

$applicant = elgg_get_logged_in_user_guid();

$title = elgg_echo('missions:mission_invitation');
$content = elgg_view_title($title);

$content .= elgg_view_entity($mission, array(
    'override_buttons' => true
));

$content .= elgg_view('output/url', array(
    'href' => elgg_get_site_url() . 'action/missions/accept-invite?applicant=' . $applicant . '&mission=' . $mission->guid,
    'text' => elgg_echo('missions:accept'),
    'is_action' => true,
    'class' => 'elgg-button'
));
$content .= elgg_view('output/url', array(
    'href' => elgg_get_site_url() . 'action/missions/decline-invite?applicant=' . $applicant . '&mission=' . $mission->guid,
    'text' => elgg_echo('missions:decline'),
    'is_action' => true,
    'class' => 'elgg-button'
));

echo elgg_view_page($title, $content);