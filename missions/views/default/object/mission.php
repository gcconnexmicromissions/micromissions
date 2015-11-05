<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	gatekeeper();
	
	$mission = $vars['entity'];
	$current_uri = $_SERVER['REQUEST_URI'] . '!';
	
	// Decides an whether to use the expanded view or not
	if(strpos($current_uri, 'display-search-set') !== false) {
		echo elgg_view('page/elements/print-mission', array(
				'entity' => $mission,
				'full_view' => false,
		));
	}
	else {
		echo elgg_view('page/elements/print-mission-more', array(
				'entity' => $mission,
				'full_view' => true,
		));
	}
?>