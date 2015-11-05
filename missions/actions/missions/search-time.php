<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	elgg_make_sticky_form('searchtimefill');
	elgg_make_sticky_form('tddropfill');
	
	$err = '';
	$search_form = elgg_get_sticky_values('searchtimefill');
	$refinement = $_SESSION['refinement'];
	
	// Currently no error checking is being done for the search form
	if($err != '') {
		register_error($err);
		forward(REFERER);
	}
	else {
		$array = array();
		$array_more = array();
		$mission = '';
		$day_temp = '';
		$var_count = 0;
		
		// Decides which day was selected by the user.
		switch($search_form['day']) {
			case elgg_echo('missions:mon'):
				$day_temp = 'mon';
				break;
			case elgg_echo('missions:tues'):
				$day_temp = 'tue';
				break;
			case elgg_echo('missions:wed'):
				$day_temp = 'wed';
				break;
			case elgg_echo('missions:thu'):
				$day_temp = 'thu';
				break;
			case elgg_echo('missions:fri'):
				$day_temp = 'fri';
				break;
			case elgg_echo('missions:sat'):
				$day_temp = 'sat';
				break;
			case elgg_echo('missions:sun'):
				$day_temp = 'sun';
				break;
		}
		
		if(!empty($search_form['start_hour'])) {
			if(empty($search_form['start_min'])) {
				$search_form['start_min'] = '00';
			}
			$temp_string = mm_pack_time($search_form['start_hour'], $search_form['start_min'], $day_temp . '_start');
			$array[$var_count] = array('name' => $day_temp . '_start', 'operand' => '>=', 'value' => $temp_string);
			$var_count++;
		}
		if(!empty($search_form['end_hour'])) {
			if(empty($search_form['end_min'])) {
				$search_form['end_min'] = '00';
			}
			$temp_string = mm_pack_time($search_form['end_hour'], $search_form['end_min'], $day_temp . '_end');
			$array[$var_count] = array('name' => $day_temp . '_end', 'operand' => '<=', 'value' => $temp_string);
			$var_count++;
		}
	
		// This function executes the query and returns true or false depending on how succesful that query was.
		$returned = mm_search_database($array, 'AND', $refinement);
		
		if(!$returned) {
			forward(REFERER);
		}
		else {
			elgg_clear_sticky_form('searchtimefill');
			elgg_clear_sticky_form('tddropfill');
			forward(elgg_get_site_url() . 'missions/display-search-set');
		}
	}