<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This action creates an array of dates using a date, a range and an interval.
 */
elgg_make_sticky_form('intervalfill');

$interval_form = elgg_get_sticky_values('intervalfill');

$range = $interval_form['time_period'];
$graph = $interval_form['graph'];

if($graph == 'pie') {
	$date_array = array(array('OVERRIDE', 'OVERRIDE'));
}
else {
	$initial_start = $interval_form['start_year'] . '-' . $interval_form['start_month'] . '-' . '01';
	$final_end = date('Y-m-t', strtotime($interval_form['end_year'] . '-' . $interval_form['end_month'] . '-' . '01'));
	
	if(strtotime($initial_start) > strtotime($final_end)) {
		register_error(elgg_echo('missions:error:future_analytics'));
		forward(REFERER);
	}
	
	$initial_end = '';
	$step = '';
	if($range == elgg_echo('missions:year')) {
		$step = '+1 year';
		$initial_end = date('Y', strtotime($initial_start)) . '-12-31';
	}
	else if($range == elgg_echo('missions:fiscal_year')) {
		$step = '+1 year';
		$initial_end = date('Y', strtotime($initial_start)) . '-03-31';
		if(strtotime($initial_start) > strtotime($initial_end)) {
			$initial_end = date('Y-m-t', strtotime($step, strtotime($initial_end)));
		}
	}
	else if($range == elgg_echo('missions:quarter')) {
		$step = '+3 month';
		$initial_end = date('Y', strtotime($initial_start)) . '-03-31';
		if(strtotime($initial_start) > strtotime($initial_end)) {
			$initial_end = date('Y', strtotime($initial_start)) . '-06-30';
			if(strtotime($initial_start) > strtotime($initial_end)) {
				$initial_end = date('Y', strtotime($initial_start)) . '-09-30';
				if(strtotime($initial_start) > strtotime($initial_end)) {
					$initial_end = date('Y', strtotime($initial_start)) . '-12-31';
				}
			}
		}
	}
	else if($range == elgg_echo('missions:month')) {
		$step = '+1 month';
		$initial_end = date('Y-m-t', strtotime($initial_start));
	}
	
	//system_message($initial_start . ' to ' . $initial_end);
	
	$first_period = array($initial_start, $initial_end);
	$date_array = array($first_period);
	
	if(strtotime($date_array[0][1]) >= strtotime($final_end)) {
		$date_array[0][1] = $final_end;
	}
	else {
		while(true) {
			$new_index = count($date_array);
			$new_start = date('Y-m-d', strtotime('+1 day', strtotime($date_array[$new_index - 1][1])));
			$new_end = date('Y-m-t', strtotime($step, strtotime(date('Y-m' ,strtotime($date_array[$new_index - 1][1]) . '-01'))));
			$new_set = array($new_start, $new_end);
			//system_message($new_start . ' to ' . $new_end);
			$date_array[$new_index] = $new_set;
			if(strtotime($date_array[$new_index][1]) >= strtotime($final_end)) {
				$date_array[$new_index][1] = $final_end;
				break;
			}
		}
	}
	
	/*foreach($date_array as $set) {
		system_message($set[0] . ' to ' . $set[1]);
	}*/
}

$_SESSION['mission_graph_date_array'] = $date_array;

elgg_clear_sticky_form('intervalfill');

//forward(REFERER);
forward(elgg_get_site_url() . 'missions/graph-data/' . $graph);