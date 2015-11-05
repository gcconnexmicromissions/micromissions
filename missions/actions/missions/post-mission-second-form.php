<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	 
	/*
	 * This action evaluates the data from the form for errors and forwards the user to the next tab.
	 */
	elgg_make_sticky_form('secondfill');
	
	$err = '';
	$second_form = elgg_get_sticky_values('secondfill');

	// Checks to see if these input fields are empty
	if(empty($second_form['job_title'])) {
		$err .= elgg_echo('missions:error:opportunity_title_needs_input') . "\n";
	}
	if(empty($second_form['job_type'])) {
		$err .= elgg_echo('missions:error:opportunity_type_needs_input') . "\n";
	}
	if(empty($second_form['start_date'])) {
		$err .= elgg_echo('missions:error:start_date_needs_input') . "\n";
	}
	if(empty($second_form['completion_date'])) {
		$err .= elgg_echo('missions:error:end_date_needs_input') . "\n";
	}
	if(empty($second_form['deadline'])) {
		$err .= elgg_echo('missions:error:deadline_needs_input') . "\n";
	}
	
	// Checks to see if the completion date comes before the end date
	$date_start = strtotime($second_form['start_date']);
	$date_end = strtotime($second_form['completion_date']);
	$date_dead = strtotime($second_form['deadline']);
	
	if($date_end < $date_start) {
		$err .= elgg_echo('missions:error:start_after_end') . "\n";
	}
	
	if($err == '') {
		forward(elgg_get_site_url() . 'missions/post-mission-third-tab');
	}
	else {
		register_error($err);
		forward(REFERER);
	}