<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$skill_array = $_SESSION['mission_skill_match_array'];
$skill_set = implode(', ', $skill_array);
unset($_SESSION['mission_skill_match_array']);

// Finds a list of users who have the same skills that were input in the third form.
$user_skill_match = array();
foreach($skill_array as $skill) {
	$options['type'] = 'object';
	$options['subtype'] = 'MySkill';
	$options['attribute_name_value_pairs'] = array(
			'name' => 'title',
			'value' => '%' . $skill . '%',
			'operand' => 'LIKE',
			'case_sensitive' => false
	);
	$skill_match = elgg_get_entities_from_attributes($options);
	 
	foreach($skill_match as $key => $value) {
		$skill_match[$key] = $value->owner_guid;
	}
	 
	if(empty($user_skill_match)) {
		$user_skill_match = $skill_match;
	}
	else {
		$user_skill_match = array_intersect($user_skill_match, $skill_match);
	}
}

// Turns the user GUIDs into user entities.
foreach($user_skill_match as $key => $value) {
	$user_skill_match[$key] = get_entity($value);
}

$_SESSION['mission_search_switch'] = 'candidate';
$_SESSION['candidate_count'] = count($user_skill_match);
$_SESSION['candidate_search_set'] = $user_skill_match;
$_SESSION['candidate_search_set_timestamp'] = time();
$_SESSION['missions_from_skill_match'] = true;

// Clears all the sticky forms that have been in use so far.
elgg_clear_sticky_form('firstfill');
elgg_clear_sticky_form('secondfill');
elgg_clear_sticky_form('thirdfill');
elgg_clear_sticky_form('ldropfill');
elgg_clear_sticky_form('tdropfill');

unset($_SESSION['tab_context']);

// If the list of users with matching skills returned any results then those results are displayed.
if(count($user_skill_match) > 0) {
	forward(elgg_get_site_url() . 'missions/display-search-set');
}
else {
	system_message('missions:no_skill_matches_found', array($skill_set));
	forward(elgg_get_site_url() . 'missions/main');
}