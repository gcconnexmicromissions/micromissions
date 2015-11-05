<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	elgg_make_sticky_form('searchfill');
	
	$err = '';
	$search_form = elgg_get_sticky_values('searchfill');
	
	// Currently no error checking is being done for the search form
	if($err != '') {
		register_error($err);
		forward(REFERER);
	}
	else {
		$array = array();
		$mission = '';
		
		// This code constructs an array of what will become WHERE MySQL statements
		$var_count = 0;
		foreach($search_form as $key_fe => $value_fe) {
			if(!empty($value_fe)) {
				// Only select via keys that are from the form.
				//$search_form does contain some other key/value pairs that we do not want to select
				switch($key_fe) {
					// This selects for all 5 *_start_hour elements
					case (strpos($key_fe,'start_hour') !== false):
						$temp_key = substr($key_fe, 0, 9);
						$temp_string = mission_pack_time($search_form[$temp_key . '_hour'], $search_form[$temp_key . '_min'], $temp_key);
						$array[$var_count] = array('name' => $temp_key, 'operand' => '>=', 'value' => $temp_string);
						$var_count++;
						break;
					// This selects for all 5 *_end_hour elements
					case (strpos($key_fe,'end_hour') !== false):
						$temp_key = substr($key_fe, 0, 7);
						$temp_string = mission_pack_time($search_form[$temp_key . '_hour'], $search_form[$temp_key . '_min'], $temp_key);
						$array[$var_count] = array('name' => $temp_key, 'operand' => '<=', 'value' => $temp_string);
						$var_count++;
						break;
					case $key_fe == 'key_skills':
						$array[$var_count] = array('name' => $key_fe, 'operand' => 'LIKE', 'value' => '%' . $value_fe . '%');
						$var_count++;
						break;
					case $key_fe == 'location':
						$array[$var_count] = array('name' => $key_fe, 'operand' => 'LIKE', 'value' => '%' . $value_fe . '%');
						$var_count++;
						break;
					// This is the default case even though we cannot use default itself
					case ($key_fe == 'department' || $key_fe == 'job_title' || $key_fe == 'job_type' || $key_fe =='security'):
						$array[$var_count] = array('name' => $key_fe, 'value' => $value_fe);
						$var_count++;
						break;
				}
			}
		}
		if(!empty($search_form['lwc_english']) || !empty($search_form['lwe_english']) || !empty($search_form['lop_english'])) {
			$temp_string = mm_pack_language($search_form['lwc_english'], $search_form['lwe_english'], $search_form['lop_english'], 'english');
			$array[$var_count] = array('name' => 'english', 'operand' => '>=', 'value' => $temp_string);
			$var_count++;
		}
		if(!empty($search_form['lwc_french']) || !empty($search_form['lwe_french']) || !empty($search_form['lop_french'])) {
			$temp_string = mm_pack_language($search_form['lwc_french'], $search_form['lwe_french'], $search_form['lop_french'], 'french');
			$array[$var_count] = array('name' => 'french', 'operand' => '>=', 'value' => $temp_string);
			$var_count++;
		}
		
		// This finishes the construction and submission of the query
		$options['type'] = 'object';
		$options['subtype'] = 'mission';
		$options['metadata_name_value_pairs'] = $array;
		$options['metadata_name_value_pairs_operator'] = 'AND';
		$options['metadata_case_sensitive'] = false;
		$options['limit'] = 100;
		$missions = elgg_get_entities_from_metadata($options);
		//$options['order_by_metadata'] = array('name' => 'job_title', 'direction' => DESC, 'as' => 'text'); 
		// A query to determine how many mission that satisfy our query exist
		/*$options_temp = $options;
		$options_temp['count'] = true;
		$mission_count = elgg_get_entities_from_metadata($options_temp);*/
		$mission_count = count($missions);
		
		// Error checking to determine if there are any missions that satisfy our query
		if($mission_count == 0) {
			register_error(elgg_echo('missions:error:entity_does_not_exist'));
			forward(REFERER);
		}
		else {
			// Session variables to pass information to the display page
			$_SESSION['mission_count'] = $mission_count;
			//$_SESSION['mission_option_set'] = $options;
			$_SESSION['mission_search_set'] = $missions;
			
			elgg_clear_sticky_form('searchfill');
			forward(elgg_get_site_url() . 'missions/display-search-set');
		}
	}