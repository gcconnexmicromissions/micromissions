<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 *
 */
gatekeeper();

/*$search_type = $_SESSION['search_page_type'];
unset($_SESSION['search_page_type']);

// TODO remove later when 4 search method gets removed
$refine = false;
if (get_input('ref')) {
    $refine = get_input('ref');
}
$_SESSION['refinement'] = $refine;

if($_SESSION['mission_search_switch'] == '') {
    $_SESSION['mission_search_switch'] = 'mission';
}

$temp_form_title = 'missions:' . $search_type . '_search';
$temp_form_path = 'missions/search-' . $search_type;*/

$title = elgg_echo('missions:search');
$content = elgg_view_title($title);

// Creates buttons which allow the user to switch between mission and candidate searching.
$switch_buttons = mm_create_switch_buttons();
$content .= '<h3>' . elgg_echo('missions:search_for') . ':</h3>' . "\n";
$content .= $switch_buttons['mission_button'] . $switch_buttons['candidate_button'];

$content .= elgg_view_form('missions/search-simple', array(
    'class' => 'mission-form'
));

$sidebar = elgg_view_menu('mission_main', array(
    'sort_by' => 'priority'
));
// $sidebar .= elgg_view_menu('mission_browse', array('sort_by' => 'priority'));

$body = elgg_view_layout('one_sidebar', array(
    'content' => $content,
    'sidebar' => $sidebar
));

echo elgg_view_page($title, $body);