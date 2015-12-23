<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Page which displays the results of a users search, simple or advanced.
 */
gatekeeper();

$search_typing = $_SESSION['mission_search_switch'];

// Variables to help set up pagination
$count = $_SESSION[$search_typing . '_count'];
$offset = (int) get_input('offset', 0);
$max = elgg_get_plugin_setting('search_result_per_page', 'missions');

// Calls a limited amount of missions for display
$search_set = $_SESSION[$search_typing . '_search_set'];

$list_typing = 'list';
$list_class = '';
if($search_typing == 'mission') {
    $list_typing = 'gallery';
    $list_class = 'mission-gallery';
}

// Displays the missions as a list with custom class mission-gallery
$content = elgg_view_entity_list(array_slice($search_set, $offset, $max), array(
    'count' => $count,
    'offset' => $offset,
    'limit' => $max,
    'pagination' => true,
    'list_type' => $list_typing,
    'gallery_class' => $list_class
), $offset, $max);

$sidebar = elgg_view_menu('mission_main', array(
    'sort_by' => 'priority'
));
// $sidebar .= elgg_view_menu('mission_refine', array('sort_by' => 'priority'));
// $sidebar .= elgg_view_menu('mission_browse', array('sort_by' => 'priority'));

$body = elgg_view_layout('one_sidebar', array(
    'content' => $content,
    'sidebar' => $sidebar
));

echo elgg_view_page(elgg_echo('missions:search_results_display'), $body);