<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	 
	/*
	 * Returns an array of tabs to display depending on what context is set in $_SESSION['tab_context'].
	 * The tab has a link attached to it depending on whether or not the user has visited that tab.
	 */ 
	function mm_write_tab_links() {
		$context = $_SESSION['tab_context'];
		$array = '';
		
		$url = elgg_get_site_url() . 'missions/';
		
		// Decides on how many linked tabs to return depending on $_SESSION['tab_context']
		switch($context) {
				case 'firstpost':
					$array = array(
						array(elgg_echo('missions:tab:manager'), $url . 'post-mission-first-tab'),
						array(elgg_echo('missions:tab:opportunity'), ''),
						array(elgg_echo('missions:tab:requirements'), ''));
						
					break;
				case 'secondpost':
					$array = array(
						array(elgg_echo('missions:tab:manager'), $url . 'post-mission-first-tab'),
						array(elgg_echo('missions:tab:opportunity'), $url . 'post-mission-second-tab'),
						array(elgg_echo('missions:tab:requirements'), ''));
					break;
				case 'thirdpost':
					$array = array(
						array(elgg_echo('missions:tab:manager'), $url . 'post-mission-first-tab'),
						array(elgg_echo('missions:tab:opportunity'), $url . 'post-mission-second-tab'),
						array(elgg_echo('missions:tab:requirements'), $url . 'post-mission-third-tab'));
					break;
				default:
					$array = NULL;
					break;
		}
		
		return $array;
	}
	
	/*
	 * A regex which returns true if the input is a phone number.
	 * Regular expression created by Eric Holmes (http://ericholmes.ca/php-phone-number-validation-revisited/)
	 * Valid:
	 * 		5555555555
	 * 		555-555-5555
	 * 		555 555 5555
	 * 		1(555) 555-5555
	 * 		1 (555) 555-5555
	 * 		1-555-555-5555
	 * Invalid:
	 * 		5
	 * 		555-5555
	 * 		1-(555)-555-5555
	 */
	function mm_is_valid_phone_number($number) {
		$regex = "/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";
		
		return preg_match($regex, (string)$number);
	}
	
	/*
	 * A regex which checks that no numbers are in the expression.
	 * Valid:
	 * 		Eileen
	 * 		Eileen Williamson
	 * Valid but Wrong:
	 * 		%$@#%$#&/:'.']}
	 * Invalid:
	 * 		4Wesley
	 * 		Wes7ley
	 * 		Wesley9
	 */ 
	function mm_is_valid_person_name($name) {
		$regex = "/^[^0-9]+$/";
		
		return preg_match($regex, $name);
	}
	
	/*
	 * A regex which checks that only numbers are in the expression.
	 * Valid:
	 * 		5
	 * 		673445
	 * Invalid:
	 * 		532K351
	 * 		@578(532)
	 */ 
	function mm_is_guid_number($num) {
		$regex = "/^[0-9]*$/";
		
		return preg_match($regex, $num);
	}
	
	/*
	 * Tests all days of the week given the form input.
	 */
	function mm_test_time_all(&$input_array) {
		$err = '';
		
		$err .= mm_test_time('mon', $input_array);
		$err .= mm_test_time('tue', $input_array);
		$err .= mm_test_time('wed', $input_array);
		$err .= mm_test_time('thu', $input_array);
		$err .= mm_test_time('fri', $input_array);
		$err .= mm_test_time('sat', $input_array);
		$err .= mm_test_time('sun', $input_array);
		
		return $err;
	}
	
	/*
	 * Tests a the start time and end time of the given day of the week.
	 * Also defaults the minutes to '00' if the hour is set and the minute value is null.
	 */
	function mm_test_time($day, &$input_array) {
		$start_hour = $input_array[$day . '_start_hour'];
		$start_min = $input_array[$day . '_start_min'];
		$end_hour = $input_array[$day . '_end_hour'];
		$end_min = $input_array[$day . '_end_min'];
		$day_full = elgg_echo('missions:' . $day);
		$err = '';
		
		if($_SESSION['language'] = 'fr') {
			$day_full = strtolower($day_full);
		}
		
		// If one hour value is not empty then the other cannot be empty and the associated minute value cannot be NULL.
		if(!empty($start_hour)) {
			if(empty($end_hour)) {
				$err .= elgg_echo('missions:end_hour_must_be_set') . $day_full . ".\n";
			}
			if(empty($start_min)) {
				$input_array[$day . '_start_min'] = '00';
				$start_min = '00';
			}
		}
		if(!empty($end_hour)) {
			if(empty($start_hour)) {
				$err .= elgg_echo('missions:start_hour_must_be_set') . $day_full . ".\n";
			}
			if(empty($end_min)) {
				$input_array[$day . '_end_min'] = '00';
				$end_min = '00';
			}
		}
		
		// The start time cannot occur after the end time.
		if(!empty($start_hour) && !empty($end_hour)) {
			if((int)($start_hour . $start_min) > (int)($end_hour . $end_min)) {
				$err .= elgg_echo('missions:error:start_after_end_time') . $day_full . ".\n";
			}
		}
		
		return $err;
	}
	
	/*
	 * Handles the call to the database using elgg_get_entities_from_metadata.
	 * Sets the resulting array and count of the array to SESSION variables if the count is not 0.
	 * Also handles intersecting with any array that currently exists within SESSION.
	 */
	function mm_search_database($query_array, $query_operand, $refinement) {
		$options = array();
		$mission_count = '';
		$missions = '';
		
		$filtered_array = array_filter($query_array);
		if(empty($filtered_array)) {
			register_error(elgg_echo('missions:error:no_search_values'));
			return false;
		}
		
		// Setting options with which the query will be built.
		$options['type'] = 'object';
		$options['subtype'] = 'mission';
		$options['metadata_name_value_pairs'] = $filtered_array;
		$options['metadata_name_value_pairs_operator'] = $query_operand;
		$options['metadata_case_sensitive'] = false;
		$options['limit'] = elgg_get_plugin_setting('search_limit', 'missions');
		$missions = elgg_get_entities_from_metadata($options);
		
		// Deprecated merge logic
		/*if(is_array($minute_clause)) {
			$options['metadata_name_value_pairs'] = $minute_clause;
			$missions_clause = elgg_get_entities_from_metadata($options);
			$missions = array_merge($missions, $missions_clause);
		}*/
		
		// Compares mission guids and keeps those that appear in both arrays.
		if($refinement && !empty($_SESSION['mission_search_set'])) {
			$missions = array_uintersect($missions, $_SESSION['mission_search_set'], 'mm_compare_guid');
		}
		
		$mission_count = count($missions);
		
		if($mission_count == 0) {
			register_error(elgg_echo('missions:error:entity_does_not_exist'));
			return false;
		}
		else {
			$_SESSION['mission_count'] = $mission_count;
			$_SESSION['mission_search_set'] = $missions;
			
			return true;
		}
	}
	
	/*
	 * Small function to compare missions according to their guid.
	 */
	function mm_compare_guid($a, $b) {
		if($a->guid == $b->guid) {
			return 0;
		}
		if($a->guid > $b->guid) {
			return 1;
		}
		return -1;
	}
	
	/*
	 * Packs the language variables for a single language into a single string.
	 */
	function mm_pack_language($lwc, $lwe, $lop, $lang) {
		$returner = '';
		
		$value = strtolower($lang);
		$returner .= $value;
			
		if(!empty($lwc) || $lwc == '-') {
			$returner .= $lwc;
		}
		else {
			$returner .= '-';
		}
		
		if(!empty($lwe) || $lwe == '-') {
			$returner .= $lwe;
		}
		else {
			$returner .= '-';
		}
		
		if(!empty($lop) || $lop == '-') {
			$returner .= $lop;
		}
		else {
			$returner .= '-';
		}
		
		return $returner;
	}
	
	/*
	 * Unpacks a language string into an array of its component variable.
	 */
	function mm_unpack_language($data_string, $lang) {
		$returner = array();
		
		$value = strtolower($lang);
		$index = stripos($data_string, $value) + strlen($value);
			
		$returner['lwc_' . $value] = substr($data_string, $index, 1);
		if($returner['lwc_' . $value] == '-') {
			$returner['lwc_' . $value] = '';
		}
		$index++;
		
		$returner['lwe_' . $value] = substr($data_string, $index, 1);
		if($returner['lwe_' . $value] == '-') {
			$returner['lwe_' . $value] = '';
		}
		$index++;
		
		$returner['lop_' . $value] = substr($data_string, $index, 1);
		if($returner['lop_' . $value] == '-') {
			$returner['lop_' . $value] = '';
		}
		
		return $returner;
	}
	
	/*
	 * Packs the time (hour and minute) into a single string.
	 */
	function mm_pack_time($hour, $min, $day) {
		$returner = '';
		
		$value = strtolower($day);
		$returner .= $day;
		
		if(!empty($hour)) {
			$returner .= $hour;
			$returner .= $min;
		}
		
		return $returner;
	}
	
	/*
	 * Unpacks the time into an array of hour and minute.
	 */
	function mm_unpack_time($data_string, $day) {
		$returner = array();
		
		$value = strtolower($day);
		$index = stripos($data_string, $value) + strlen($value);
		
		if(!empty($data_string)) {
			$returner[$day . '_hour'] = substr($data_string, $index, 2);
			$returner[$day . '_min'] = substr($data_string, $index+2, 2);
		}
		
		return $returner;
	}
	
	/*
	 * Unpacks every unpackable item within a given entity.
	 */
	function mm_unpack_mission($entity) {
		$returner = array();
		
		$returner = array_merge($returner, mm_unpack_language($entity->english, 'english'));
		$returner = array_merge($returner, mm_unpack_language($entity->french, 'french'));
		$returner = array_merge($returner, mm_unpack_time($entity->mon_start, 'mon_start'));
		$returner = array_merge($returner, mm_unpack_time($entity->mon_end, 'mon_end'));
		$returner = array_merge($returner, mm_unpack_time($entity->tue_start, 'tue_start'));
		$returner = array_merge($returner, mm_unpack_time($entity->tue_end, 'tue_end'));
		$returner = array_merge($returner, mm_unpack_time($entity->wed_start, 'wed_start'));
		$returner = array_merge($returner, mm_unpack_time($entity->wed_end, 'wed_end'));
		$returner = array_merge($returner, mm_unpack_time($entity->thu_start, 'thu_start'));
		$returner = array_merge($returner, mm_unpack_time($entity->thu_end, 'thu_end'));
		$returner = array_merge($returner, mm_unpack_time($entity->fri_start, 'fri_start'));
		$returner = array_merge($returner, mm_unpack_time($entity->fri_end, 'fri_end'));
		$returner = array_merge($returner, mm_unpack_time($entity->sat_start, 'sat_start'));
		$returner = array_merge($returner, mm_unpack_time($entity->sat_end, 'sat_end'));
		$returner = array_merge($returner, mm_unpack_time($entity->sun_start, 'sun_start'));
		$returner = array_merge($returner, mm_unpack_time($entity->sun_end, 'sun_end'));
		
		return $returner;
	}
	
	/*
	 * Analyzes the selection values and selection element values in order to construct a WHERE statement.
	 * This is for when Javascript is enabled.
	 */
	function mm_analyze_selection($place, $array) {
		$returner = array();
		
		switch($array['selection_' . $place]) {
			// Returns an empty array if 
			case '':
				break;
				
			// Selects time element which requires packing.
			case elgg_echo('missions:time'):
				if($array['selection_' . $place . '_element_hour'] != '') {
					$name_option = '';
					// Selects which day will be searched.
					switch($array['selection_' . $place . '_element']) {
						case elgg_echo('missions:mon'):
							$name_option = 'mon';
							break;
						case elgg_echo('missions:tues'):
							$name_option = 'tue';
							break;
						case elgg_echo('missions:wed'):
							$name_option = 'wed';
							break;
						case elgg_echo('missions:thu'):
							$name_option = 'thu';
							break;
						case elgg_echo('missions:fri'):
							$name_option = 'fri';
							break;
						case elgg_echo('missions:sat'):
							$name_option = 'sat';
							break;
						case elgg_echo('missions:sun'):
							$name_option = 'sun';
							break;
					}
					$operand_option = '';
					// Selects whether we need a greate then or less then comparison.
					switch($array['selection_' . $place . '_element_bound']) {
						case elgg_echo('missions:start'):
							$name_option .= '_start';
							$operand_option = '>=';
							break;
						case elgg_echo('missions:end'):
							$name_option .= '_end';
							$operand_option = '<=';
							break;
					}
					// Packs the input hour and time for comparison with the packed elements in the database.
					$option_value = mm_pack_time($array['selection_' . $place . '_element_hour'], $array['selection_' . $place . '_element_min'], $name_option);
					$returner['name'] = $name_option;
					$returner['operand'] = $operand_option;
					$returner['value'] = $option_value;
				}
				break;
				
			// Selects language element	which requires packing.
			case elgg_echo('missions:language'):
				if($array['selection_' . $place . '_element_lwc'] != '' || $array['selection_' . $place . '_element_lwe'] != '' || $array['selection_' . $place . '_element_lop'] != '') {
					$name_option = '';
					// Selects which language will be searched
					switch($array['selection_' . $place . '_element']) {
						case elgg_echo('missions:english'):
							$name_option = 'english';
							break;
						case elgg_echo('missions:french'):
							$name_option = 'french';
							break;
					}
					// Packs the input written comprehension, written expression and oral proficiency for comparison with the packed elements in the database.
					$option_value = mm_pack_language($array['selection_' . $place . '_element_lwc'], $array['selection_' . $place . '_element_lwe'], $array['selection_' . $place . '_element_lop'], $name_option);
					$returner['name'] = $name_option;
					$returner['operand'] = '>=';
					$returner['value'] = $option_value;
				}
				break;
				
			// The next 3 are select elements that require a MySQL LIKE comparison.
			case elgg_echo('missions:key_skills'):
				if($array['selection_' . $place . '_element'] != '') {
					$returner['name'] = 'key_skills';
					$returner['operand'] = 'LIKE';
					$returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
				}
				break;
				
			case elgg_echo('missions:location'):
				if($array['selection_' . $place . '_element'] != '') {
					$returner['name'] = 'location';
					$returner['operand'] = 'LIKE';
					$returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
				}
				break;
				
			case elgg_echo('missions:type'):
				if($array['selection_' . $place . '_element'] != '') {
					$returner['name'] = 'job_type';
					$returner['operand'] = 'LIKE';
					$returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
				}
				break;
				
			// The next 3 are selects elements that require a direct equivalence comparison.
			case elgg_echo('missions:title'):
				if($array['selection_' . $place . '_element'] != '') {
					$returner['name'] = 'job_title';
					$returner['value'] = $array['selection_' . $place . '_element'];
				}
				break;
				
			case elgg_echo('missions:security'):
				if($array['selection_' . $place . '_element'] != '') {
					$returner['name'] = 'security';
					$returner['value'] = $array['selection_' . $place . '_element'];
				}
				break;
				
			case elgg_echo('missions:department'):
				if($array['selection_' . $place . '_element'] != '') {
					$returner['name'] = 'department';
					$returner['value'] = $array['selection_' . $place . '_element'];
				}
				break;
		}
		
		return $returner;
	}
	
	/*
	 * Analyzes the selection values and selection element values in order to construct a WHERE statement.
	 * This is for when Javascript is disabled.
	 */
	function mm_analyze_backup($place, $array) {
		$returner = array();
		
		$name_option = '';
		$operand_option = '';
		$value_option = '';
		
		// If the selection element has been chosen.
		if($array['selection_' . $place] != '') {
			// Base operand and value.
			$operand_option = '=';
			$value_option = $array['backup_' . $place];
			// Modifies name, operand and/or value depending on which selection element was chosen.
			switch($array['selection_' . $place]) {
				case elgg_echo('missions:title'):
					$name_option = 'job_title';
					break;
				case elgg_echo('missions:type'):
					$name_option = 'job_type';
					$operand_option = 'LIKE';
					$value_option = '%' . $array['backup_' . $place] . '%';
					break;
				case elgg_echo('missions:department'):
					$name_option = 'department';
					break;
				case elgg_echo('missions:location'):
					$name_option = 'location';
					break;
				case elgg_echo('missions:key_skills'):
					$name_option = 'key_skills';
					$operand_option = 'LIKE';
					$value_option = '%' . $array['backup_' . $place] . '%';
					break;
				case elgg_echo('missions:security'):
					$name_option = 'security';
					break;
				// In the language case, the value needs to have the format {language}{LWC}{LWE}{LOP}
				case elgg_echo('missions:language'):
					switch($array['backup_' . $place]) {
						case (strpos($array['backup_' . $place],'english') !== false):
							$name_option = 'english';
							break;
						case (strpos($array['backup_' . $place],'french') !== false):
							$name_option = 'french';
							break;
						default:
							return array();
					}
					$operand_option = '>=';
					break;
				// In the time case, the value needs to have the format {day}_{start/end}{hour}:{min}
				case elgg_echo('missions:time'):
					switch($array['backup_' . $place]) {
						case (strpos($array['backup_' . $place],'mon_start') !== false):
							$name_option = 'mon_start';
							break;
						case (strpos($array['backup_' . $place],'mon_end') !== false):
							$name_option = 'mon_end';
							break;
						case (strpos($array['backup_' . $place],'tue_start') !== false):
							$name_option = 'tue_start';
							break;
						case (strpos($array['backup_' . $place],'tue_end') !== false):
							$name_option = 'tue_end';
							break;
						case (strpos($array['backup_' . $place],'wed_start') !== false):
							$name_option = 'wed_start';
							break;
						case (strpos($array['backup_' . $place],'wed_end') !== false):
							$name_option = 'wed_end';
							break;
						case (strpos($array['backup_' . $place],'thu_start') !== false):
							$name_option = 'thu_start';
							break;
						case (strpos($array['backup_' . $place],'thu_end') !== false):
							$name_option = 'thu_end';
							break;
						case (strpos($array['backup_' . $place],'fri_start') !== false):
							$name_option = 'fri_start';
							break;
						case (strpos($array['backup_' . $place],'fri_end') !== false):
							$name_option = 'fri_end';
							break;
						case (strpos($array['backup_' . $place],'sat_start') !== false):
							$name_option = 'sat_start';
							break;
						case (strpos($array['backup_' . $place],'sat_end') !== false):
							$name_option = 'sat_end';
							break;
						case (strpos($array['backup_' . $place],'sun_start') !== false):
							$name_option = 'sun_start';
							break;
						case (strpos($array['backup_' . $place],'sun_end') !== false):
							$name_option = 'sun_end';
							break;
						default:
							return array();
					}
					switch($array['backup_' . $place]) {
						case (strpos($array['backup_' . $place],'start') !== false):
							$operand_option = '>=';
							break;
						case (strpos($array['backup_' . $place],'end') !== false):
							$operand_option = '<=';
							break;
					}
					break;
			}
			$returner['name'] = $name_option;
			$returner['operand'] = $operand_option;
			$returner['value'] = $value_option;
		}
		
		return $returner;
	}
	
	/*
	 * Returns an array of buttons for actions taken with regards to a mission.
	 */
	function mm_create_button_set($mission) {
		$returner = array();
		$apply_button = '';
		$close_button = '';
		
		// Button to send an application e-mail to the mission creator.
		if($mission->owner_guid != elgg_get_logged_in_user_guid()) {
			$apply_button = elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/mission-application?mid=' . $mission->guid,
					'text' => elgg_echo('missions:apply'),
					'class' => 'elgg-button',
			));
		}
		$returner['apply_button'] = $apply_button;
		
		// Button to close the mission.
		// TODO: This currently deletes the mission. It will change later on when mission filling and mission completion are implemented.
		if($mission->owner_guid == elgg_get_logged_in_user_guid()) {
			$close_button = elgg_view('output/url', array (
					'href' => elgg_get_site_url() . 'action/missions/close-from-display?mission_guid=' . $mission->guid,
					'text' => elgg_echo('missions:delete'),
					'is_action' => true,
					'class' => 'elgg-button',
			));
		}
		$returner['close_button'] = $close_button;
		
		return $returner;
	}