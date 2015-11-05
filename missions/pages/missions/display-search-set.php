<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	gatekeeper();
	
	// Variables to help set up pagination
	$count = $_SESSION['mission_count'];
	$offset = (int)get_input('offset', 0);
	$max = 4;
	
	// Calls a limited amount of missions for display
	$missions = $_SESSION['mission_search_set'];
	
	// Displays the missions as a list with custom class mission-gallery
	$content = elgg_view_entity_list(array_slice($missions, $offset, $max), array(
			'count' => $count,
			'offset' => $offset,
			'limit' => $max,
			'pagination' => true,
			'list_type' => 'gallery',
			'gallery_class' => 'mission-gallery'), $offset, $max);
	
	$sidebar = elgg_view_menu('mission_main', array('sort_by' => 'priority'));
	//$sidebar .= elgg_view_menu('mission_refine', array('sort_by' => 'priority'));
	//$sidebar .= elgg_view_menu('mission_browse', array('sort_by' => 'priority'));
	
	$body = elgg_view_layout('one_sidebar', array(
			'content' => $content,
			'sidebar' => $sidebar
	));
	
	echo elgg_view_page(elgg_echo('missions:mission_display'), $body);