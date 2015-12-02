<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
// This sends users who are not logged in back to the gcconnex login page
// gatekeeper();

// Sets a custom context session variable to track the progress of users across mission post tabs.
// For example if they have gone to the third tab and returned to the first tab they need links activated to skip back to the third tab.
$_SESSION['tab_context'] = 'missions';

$title = elgg_echo('missions:micromissions');

$content = elgg_view_title(elgg_echo('missions:micromissions'));

// TODO Introductory text

$options['type'] = 'object';
$options['subtype'] = 'mission';
$options['action_type'] = 'create';
$options['limit'] = elgg_get_plugin_setting('river_element_limit', 'missions');
$content .= elgg_list_river($options);

// Right hand sidebar.
$sidebar = elgg_view_menu('mission_main', array(
    'sort_by' => 'priority'
));

// Creates the body of content according to the layout 'one_sidebar'.
$body = elgg_view_layout('one_sidebar', array(
    'content' => $content,
    'sidebar' => $sidebar
));

// Displays the page with the given title and body
echo elgg_view_page($title, $body);