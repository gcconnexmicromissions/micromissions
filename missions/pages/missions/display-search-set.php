<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
gatekeeper();

$search_typing = $_SESSION['mission_search_switch'];
if($_SESSION['mission_search_switch_override'] != '') {
    $search_typing = 'mission';
    $_SESSION['mission_search_switch_override'] = '';
}

// Variables to help set up pagination
$count = $_SESSION[$search_typing . '_count'];
$offset = (int) get_input('offset', 0);
$max = 4;

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