<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	elgg_make_sticky_form('searchprereqfill');
	
	$err = '';
	$search_form = elgg_get_sticky_values('searchprereqfill');
	$refinement = $_SESSION['refinement'];
	
	// Currently no error checking is being done for the search form
	if($err != '') {
		register_error($err);
		forward(REFERER);
	}
	else {
		$array = array();
		$var_count = 0;
		
		// Evaluates each field and sets up a WHERE query for each valid section.
		if(!empty($search_form['department'])) {
			$array[$var_count] = array('name' => 'department', 'value' => $search_form['department']);
			$var_count++;
		}
		if(!empty($search_form['key_skills'])) {
			$array[$var_count] = array('name' => 'key_skills', 'operand' => 'LIKE', 'value' => '%' . $search_form['key_skills'] . '%');
			$var_count++;
		}
		if(!empty($search_form['security'])) {
			$array[$var_count] = array('name' => 'security', 'value' => $search_form['security']);
			$var_count++;
		}
		if(!empty($search_form['location'])) {
			$array[$var_count] = array('name' => 'location', 'operand' => 'LIKE', 'value' => '%' . $search_form['location'] . '%');
		}
	
		// This function executes the query and returns true or false depending on how succesful that query was.
		$returned = mm_search_database($array, 'AND', $refinement);
		
		if(!$returned) {
			forward(REFERER);
		}
		else {
			elgg_clear_sticky_form('searchprereqfill');
			forward(elgg_get_site_url() . 'missions/display-search-set');
		}
	}