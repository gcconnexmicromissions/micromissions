<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	elgg_make_sticky_form('searchlanguagefill');
	elgg_make_sticky_form('lsdropfill');
	
	$err = '';
	$search_form = elgg_get_sticky_values('searchlanguagefill');
	$refinement = $_SESSION['refinement'];
	
	// Currently no error checking is being done for the search form
	if($err != '') {
		register_error($err);
		forward(REFERER);
	}
	else {
		$array = array();
		$mission = '';
		$lang_temp = '';
		$var_count = 0;
		
		// Decides which language was selected by the user.
		switch($search_form['language_name']) {
			case elgg_echo('missions:english'):
				$lang_temp = 'english';
				break;
			case elgg_echo('missions:french'):
				$lang_temp = 'french';
				break;
		}
		
		// At least one of these fields must be filled out for a search to occur.
		if(!empty($search_form['lwc']) || !empty($search_form['lwe']) || !empty($search_form['lop'])) {
			// Input language values are packed.
			$temp_string = mm_pack_language($search_form['lwc'], $search_form['lwe'], $search_form['lop'], $lang_temp);
			// WHERE section of the query is set up.
			$array[$var_count] = array('name' => $lang_temp, 'operand' => '>=', 'value' => $temp_string);
		}
	
		// This function executes the query and returns true or false depending on how succesful that query was.
		$returned = mm_search_database($array, 'AND', $refinement);
		
		if(!$returned) {
			forward(REFERER);
		}
		else {
			elgg_clear_sticky_form('searchlanguagefill');
			elgg_clear_sticky_form('lsdropfill');
			forward(elgg_get_site_url() . 'missions/display-search-set');
		}
	}