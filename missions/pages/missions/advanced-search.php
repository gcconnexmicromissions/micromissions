<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	gatekeeper();
	
	$title = elgg_echo('missions:advanced_search');
	$content = elgg_view_title($title);
	$content .= elgg_view_form('missions/advanced-form', array(
			'class' => 'mission-form'
	));
	
	$sidebar = elgg_view_menu('mission_main', array('sort_by' => 'priority'));
	//$sidebar .= elgg_view_menu('mission_browse', array('sort_by' => 'priority'));
	
	$body = elgg_view_layout('one_sidebar', array(
			'content' => $content,
			'sidebar' => $sidebar
	));
	
	echo elgg_view_page(elgg_echo('missions:advanced_search'), $body);