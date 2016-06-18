<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Validate date inputs which allow yyyy, yyyy-mm, or yyyy-mm-dd entries.
 * yyyy must be sometime in the 1900's or 2000's.
 * mm must be 1 to 12.
 * dd must be 1 to 31.
 */
function mm_validate_date_for_time_scale($date) {
	//$regex = "/^((19|20)\d\d)(-(0?[1-9]|1[012]|Q[1234])(-(0?[1-9]|[12][0-9]|3[01]|W[12345]))?)?$/";
	//$regex = "/^((19|20)\d\d)(-(0?[1-9]|1[012]|Q[1234])(-(0?[1-9]|[12][0-9]|3[01]))?)?$/";
	$regex = "/^((19|20)\d\d)(-(0?[1-9]|1[012])(-(0?[1-9]|[12][0-9]|3[01]))?)?$/";
	return preg_match($regex, $date);
}

/*
 * Function which takes a start date and end date and generates an array of timestamps starting at 00:00 on the start date and ending at 23:59 on the end date.
 * The time between timestamps is determined by the interval which can be year, fiscal year, quarter, month, week, or day.
 * The end date given is always the last element of the array (which overrides the interval spacing).
 */
function mm_generate_time_scale_timestamps($beginning_date, $end_date, $interval) {
	// Validates the dates using the regex found in mm_validate_date_for_time_scale.
	if(!mm_validate_date_for_time_scale($beginning_date) || !mm_validate_date_for_time_scale($end_date)) {
		return false;
	}
	
	// Needed to ensure that date's start at 00:00.
	date_default_timezone_set('Etc/GMT+0');
	
	$beginning_array = explode('-', $beginning_date);
	$end_array = explode('-', $end_date);
	
	// If the month is set as Qx, then it is translated to a integer value corresponding to the beginning of the quarter.
	/*if(strtolower(substr($beginning_array[1], 0, 1)) == 'q') {
		$beginning_array[1] = (3 * intval(substr($beginning_array[1], 1, 1))) + 1;
		if($beginning_array[1] == 13) {
			$beginning_array[1] = 1;
			$beginning_array[0] = date('Y', strtotime('+1 year', strtotime($beginning_array[0] . '-01')));
		}
	}
	
	if(strtolower(substr($end_array[1], 0, 1)) == 'q') {
		$end_array[1] = (3 * intval(substr($end_array[1], 1, 1))) + 1;
		if($end_array[1] == 13) {
			$end_array[1] = 1;
			$end_array[0] = date('Y', strtotime('+1 year', strtotime($end_array[0] . '-01')));
		}
		$end_array[1] = $end_array[1] + 2;
	}*/
	
	// Decides on the beginning date for the time range .
	switch($interval) {
		// Years always start on 01-01.
		case 'missions:year':
			$step = '+1 year';
			$beginning = strtotime($beginning_array[0] . '-01-01');
			break;
		// Fiscal years always start on 04-01. If the month value is after the year start but before the fiscal year start then it is the previous fiscal year.
		case 'missions:fiscal_year':
			$step = '+1 year';
			$beginning = strtotime($beginning_array[0] . '-04-01');
			if($beginning_array[1] != '') {
				if(intval($beginning_array[1]) <  4) {
					$beginning = strtotime('-1 year', $beginning);
				}
			}
			break;
		// Quarters always start on the day 01 of the months 01, 04, 07, or 10.
		case 'missions:quarter':
			$step = '+3 months';
			$month_int = intval($beginning_array[1]);
			if($month_int >= 1 && $month_int <= 3) {
				$beginning = strtotime($beginning_array[0] . '-01-01');
			}
			else if($month_int >= 4 && $month_int <= 6) {
				$beginning = strtotime($beginning_array[0] . '-04-01');
			}
			else if($month_int >= 7 && $month_int <= 9) {
				$beginning = strtotime($beginning_array[0] . '-07-01');
			}
			else if($month_int >= 10 && $month_int <= 12) {
				$beginning = strtotime($beginning_array[0] . '-10-01');
			}
			break;
		// Months always start on the day 01.
		case 'missions:month':
			$step = '+1 month';
			$beginning = strtotime($beginning_array[0] . '-' . $beginning_array[1] . '-01');
			break;
		// Weeks always start on a Monday.
		case 'missions:week':
			$step = '+1 week';
			$beginning = strtotime('this week', strtotime(implode('-', $beginning_array)));
			break;
		// Days correspond to the granularity of the date inputs.
		case 'missions:day':
			$step = '+1 day';
			$beginning = strtotime(implode('-', $beginning_array));
			break;
		default:
			return false;
	}

	$end = strtotime(implode('-', $end_array));
	
	// Creates steps in the interval until a step exceeds the end date and the end date replaces that last step.
	$returner_array = array($beginning);
	while(true) {
		$new_index = count($returner_array);
		$latest_time = strtotime($step, $returner_array[$new_index - 1]);
		$returner_array[$new_index] = $latest_time;
		if($latest_time > $end) {
			$end_array = explode('-', date('m-d-Y', $end));
			$returner_array[$new_index] = mktime(23,59,59,$end_array[0],$end_array[1],$end_array[2]);
			break;
		}
	}
	
	return $returner_array;
}

/*
 * Creates labels for the graph x-axis according to the array of timestamps produced by mm_generate_time_scale_timestamps and the interval.
 */
function mm_generate_time_scale_labels($timescale_array, $interval) {
	$timescale_labels = $timescale_array;
	array_pop($timescale_labels);
	foreach($timescale_labels as $key => $time) {
		if($interval == 'missions:year') {
			$timescale_labels[$key] = date('Y', $time);
		}
		else if($interval == 'missions:fiscal_year') {
			$timescale_labels[$key] = 'FY: ' . date('Y', $time);
		}
		else if($interval == 'missions:quarter') {
			$q_num = ceil(intval(date('m', $time)) / 3) - 1;
			$year = date('Y', $time);
			if($q_num == 0) {
				$q_num = 4;
				$year = date('Y', strtotime('-1 year', $time));
			}
			$timescale_labels[$key] = 'Q' . $q_num . ', ' . $year;
		}
		else if($interval == 'missions:month') {
			$timescale_labels[$key] = date('M, Y', $time);
		}
		else if($interval == 'missions:week') {
			$timescale_labels[$key] = 'W' . date('W, Y', $time);
		}
		else if($interval == 'missions:day') {
			$timescale_labels[$key] = date('Y-m-d', $time);
		}
	}
	
	return $timescale_labels;
}

/*
 * Function which formats the start and end timestamps and the given type in order to check against the mission metadata of that type.
 */
function mm_modify_start_end_type($start, $end, $type) {
	$returner = array($start, $end, '');
	switch($type) {
		case 'missions:date_posted':
			$returner[2] = 'time_created';
			break;
		case 'missions:start_date':
			$returner[2] = 'start_date';
			$returner[0] = date('Y-m-d', $start);
			$returner[1] = date('Y-m-d', $end);
			break;
		case 'missions:closure_date':
			$returner[2] = 'time_closed';
			break;
	}
	return $returner;
}

/*
 * Gets all the missions in between the start and end dates according to the date they were posted, their ideal start date, or the date they were completed or cancelled.
 */
function mm_get_missions_by_dates($start_date, $end_date, $date_type) {
	// Modifies the function attributes so that it knows the name of the metadata it's targetting and matches the time metadata format (date or timestamp).
	$modified_input = mm_modify_start_end_type($start_date, $end_date, $date_type);
	$start = $modified_input[0];
	$end = $modified_input[1];
	$type = $modified_input[2];
	
	if($type == '') {
		return false;
	}
	
	$options['type'] = 'object';
	$options['subtype'] = 'mission';
	$options['limit'] = 0;
	
	// Time created is an attribute of the entity table in the database and not metadata.
	if($type == 'time_created') {
		$options['created_time_lower'] = $start;
		$options['created_time_upper'] = $end;
		
		$missions = elgg_get_entities($options);
	}
	else {
		$options['metadata_name_value_pairs'] = array(
				array('name' => $type, 'value' => $start, 'operand' => '>='),
				array('name' => $type, 'value' => $end, 'operand' => '<=')
		);
		$options['metadata_name_value_pairs_operator'] = 'AND';
		
		$missions = elgg_get_entities_from_metadata($options);
	}
	
	return $missions;
}

/*
 * Removes all missions from the set which are not a part of the given department or that departments children.
 */
function mm_cull_missions_by_department($mission_set, $department) {
	$department_and_children = mo_array_node_and_all_children($department);
	$mission_set_copy = $mission_set;
	foreach($mission_set_copy as $key => $mission) {
		if(!in_array($mission->department, $department_and_children)) {
			unset($mission_set_copy[$key]);
		}
	}
	
	return $mission_set_copy;
}

/*
 * Separates the missions into different series according to the given value.
 */
function mm_separate_missions_by_values($mission_set, $separator) {
	$returner_array = array();
	if($separator == '') {
		$returner_array[0] = $mission_set;
	}
	else {
		// Creates the array of values which determine which bin a mission will occupy and the metadata where these values are stored..
		switch($separator) {
			case 'missions:state':
				$meta_tag = 'state';
				$comparison_array = array('posted', 'completed', 'cancelled');
				break;
			case 'missions:reliability':
				$meta_tag = 'security';
				$comparison_array = explode(',', elgg_get_plugin_setting('security_string', 'missions'));
				break;
			case 'missions:virtual_opportunity':
				$meta_tag = 'remotely';
				$comparison_array = array('on', false);
				break;
			case 'missions:limited_by_department':
				$meta_tag = 'openess';
				$comparison_array = array('on', false);
				break;
		}
		
		// Creates the bins which the missions will be divided into.
		$count = 0;
		foreach($comparison_array as $comparator) {
			$returner_array[$count] = array();
			$count++;
		}

		// Divides the missions into the bins according to what value their metadata matches.
		foreach($mission_set as $mission) {
			$count = 0;
			foreach($comparison_array as $comparator) {
				if($mission->$meta_tag == $comparison_array[$count]) {
					$returner_array[$count][] = $mission;
				}
				$count++;
			}
		}
	}
	
	return $returner_array;
}

/*
 * Creates labels for the different series.
 */
function mm_generate_separation_labels($separator) {
	$returner = array();
	switch($separator) {
		case 'missions:state':
			$returner = array('missions:posted', 'missions:cancelled', 'missions:completed');
			break;
		case 'missions:reliability':
			$returner = explode(',', elgg_get_plugin_setting('security_string', 'missions'));
			$returner[0] = 'missions:not_declared';
			break;
		case 'missions:virtual_opportunity':
			$returner = array('missions:virtual_opportunity', 'missions:not_virtual_opportunity');
			break;
		case 'missions:limited_by_department':
			$returner = array('missions:limited_by_department', 'missions:not_limited_by_department');
			break;
		default:
			$returner = array('missions:all_opportunities');
	}
	return $returner;
}

/*
 * Separates the missions within the series into the different time intervals.
 */
function mm_separate_missions_by_time($mission_set, $timescale_array, $time_type) {
	$last_time = array_pop($timescale_array);
	
	// Creates a set of bins corresponding to the intervals.
	$returner = array();
	$temp_x_array = array();
	foreach($timescale_array as $value) {
		$temp_x_array[] = array();
	}
	// Adds an interval bin to each of the series bins.
	foreach($mission_set as $value) {
		$returner[] = $temp_x_array;
	}
	
	// Creates an array containing the interval timestamp as the lower bound and the next interval timestamp minus one second as the upper bound.
	$time_bound_array = array();
	foreach($timescale_array as $key_t => $time) {
		$next_time = $timescale_array[$key_t + 1];
		if($next_time == '') {
			$next_time = $last_time;
		}
		else {
			$next_time = strtotime('-1 second', $next_time);
		}
		$time_bound_array[$key_t] = array($timescale_array[$key_t], $next_time);
	}
	
	foreach($mission_set as $y => $set) {
		foreach($set as $mission) {
			foreach($time_bound_array as $x => $bounds) {
				$modified_data_by_type = mm_modify_start_end_type($bounds[0], $bounds[1], $time_type);
				if($mission->$modified_data_by_type[2] >= $modified_data_by_type[0] && $mission->$modified_data_by_type[2] <= $modified_data_by_type[1]) {
					$returner[$y][$x][] = $mission;
				}
			}
		}
	}
	
	return $returner;
}