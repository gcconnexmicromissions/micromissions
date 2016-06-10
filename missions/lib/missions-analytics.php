<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

// WORK IN PROGRESS

function mm_validate_date_for_time_scale($date) {
	//$regex = "/^((19|20)\d\d)(-(0?[1-9]|1[012]|Q[1234])(-(0?[1-9]|[12][0-9]|3[01]|W[12345]))?)?$/";
	$regex = "/^((19|20)\d\d)(-(0?[1-9]|1[012]|Q[1234])(-(0?[1-9]|[12][0-9]|3[01]))?)?$/";
	return preg_match($regex, $date);
}

/*
 * 
 */
function mm_generate_time_scale_timestamps($beginning_date, $end_date, $interval) {
	if(!mm_validate_date_for_time_scale($beginning_date) || !mm_validate_date_for_time_scale($end_date)) {
		return false;
	}
	
	$beginning_array = explode('-', $beginning_date);
	$end_array = explode('-', $end_date);
	
	if(strtolower(substr($beginning_array[1], 0, 1)) == 'q') {
		$beginning_array[1] = (3 * intval(substr($beginning_array[1], 1, 1))) - 2;
	}
	
	if(strtolower(substr($end_array[1], 0, 1)) == 'q') {
		$end_array[1] = (3 * intval(substr($end_array[1], 1, 1))) - 2;
	}

	$end = strtotime(implode('-', $end_array));
	
	switch($interval) {
		case 'missions:year':
			$step = '+1 year';
			$beginning = strtotime($beginning_array[0] . '-01-01');
			break;
		case 'missions:fiscal_year':
			$step = '+1 year';
			$beginning = strtotime($beginning_array[0] . '-04-01');
			if($beginning_array[1] != '') {
				if(intval($beginning_array[1]) <  4) {
					$beginning = strtotime('-1 year', $beginning);
				}
			}
			break;
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
		case 'missions:month':
			$step = '+1 month';
			$beginning = strtotime($beginning_array[0] . '-' . $beginning_array[1] . '-01');
			break;
		case 'missions:week':
			$step = '+1 week';
			$beginning = strtotime(implode('-', $beginning_array));
			break;
		case 'missions:day':
			$step = '+1 day';
			$beginning = strtotime(implode('-', $beginning_array));
			break;
		default:
			return false;
	}
	
	$returner_array = array($beginning, strtotime($step, $beginning));
	if($returner_array[1] > $end) {
		$returner_array[1] = $end;
	}
	else {
		while(true) {
			$new_index = count($returner_array);
			$latest_time = strtotime($step, $returner_array[$new_index - 1]);
			$returner_array[$new_index] = $latest_time;
			if($latest_time > $end) {
				$returner_array[$new_index] = $end;
				break;
			}
		}
	}
	
	return $returner_array;
}