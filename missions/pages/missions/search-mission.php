<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	gatekeeper();
	
	$title = elgg_echo('missions:search_for_opportunity');
	$body = elgg_view_title($title);
	$body .= elgg_view_form('missions/search-form', array(
			'class' => 'mission-form'
	));
	
	echo elgg_view_page('missions-find-missions-page', $body);