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
	
	$search_type = $_SESSION['search_page_type'];
	unset($_SESSION['search_page_type']);
	
	// TODO remove later when 4 search method gets removed
	$refine = false;
	if(get_input('ref')) {
		$refine = get_input('ref');
	}
	$_SESSION['refinement'] = $refine;
	
	$temp_form_title = 'missions:' . $search_type . '_search';
	$temp_form_path = 'missions/search-' . $search_type;
	
	$title = elgg_echo($temp_form_title);
	$content = elgg_view_title($title);
	$content .= elgg_view_form($temp_form_path, array(
			'class' => 'mission-form'
	));
	
	$sidebar = elgg_view_menu('mission_main', array('sort_by' => 'priority'));
	//$sidebar .= elgg_view_menu('mission_browse', array('sort_by' => 'priority'));
	
	$body = elgg_view_layout('one_sidebar', array(
			'content' => $content,
			'sidebar' => $sidebar
	));
	
	echo elgg_view_page(elgg_echo('missions:search'), $body);