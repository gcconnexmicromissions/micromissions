<?php 
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	// This sends users who are not logged in back to the gcconnex login page
	gatekeeper();
	
	// Sets the custom session context variable if the previous context was as defined.
	if($_SESSION['tab_context'] == 'missions' || $_SESSION['tab_context'] == '') {
		$_SESSION['tab_context'] = 'firstpost';
	}
	
	$content = elgg_view_form('missions/post-mission-first-form', array(
			'class' => 'mission-form'
	));
	$tab_bar = mm_write_tab_links();

	// Creates a body of content with the custom 'one_tabbar' layout
	$body = elgg_view_layout('one-tab-bar', array(
			'content' => $content,
			'tab_bar' => $tab_bar
	));
	
	echo elgg_view_page(elgg_echo('missions:tab:manager'), $body);