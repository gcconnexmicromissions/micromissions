<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */

	/*
	 * This action evaluates the data from the form for errors.
	 * It then saves this data and all data from the previous two pages as metadata attached to a new object.
	 * This object has the subtype of 'mission'.
	 */
	elgg_make_sticky_form('thirdfill');
	elgg_make_sticky_form('ldropfill');
	elgg_make_sticky_form('tdropfill');
	
	$first_form = elgg_get_sticky_values('firstfill');
	$second_form = elgg_get_sticky_values('secondfill');
	$third_form = elgg_get_sticky_values('thirdfill');
	
	$err = '';
	
	// Checks to see if location is empty
	if(empty($third_form['location'])) {
		$err .= elgg_echo('missions:error:location_needs_input') . "\n";
	}
	
	// A specialized function for checking for errors in the time fields
	$err .= mm_test_time_all($third_form);
	
	// Error reporting for bad user input
	if($err != '') {
		register_error($err);
		forward(REFERER);
	}
	else {
		//$third_form = combine_time_table_from_array($third_form);
		
		// Creation of an ELGGObject of subtype Mission
		$mission = new ElggObject();
		$mission->subtype = 'mission';
		$mission->title = $second_form['job_title'];
		$mission->description = $second_form['description'];
		$mission->access_id = ACCESS_LOGGED_IN;
		$mission->owner_guid = elgg_get_logged_in_user_guid();
		
		// Attaches the form data as metadata to the object
		$mission->name = $first_form['name'];
		$mission->department = $first_form['department'];
		$mission->email = $first_form['email'];
		$mission->phone = $first_form['phone'];
		
		$mission->job_title = $second_form['job_title'];
		$mission->job_type = $second_form['job_type'];
		$mission->number = $second_form['number'];
		$mission->start_date = $second_form['start_date'];
		$mission->completion_date = $second_form['completion_date'];
		$mission->key_skills = $second_form['key_skills'];
		$mission->deadline = $second_form['deadline'];
		$mission->descriptor = $second_form['description'];
		
		$mission->remotely = $third_form['remotely'];
		$mission->flexibility = $third_form['flexibility'];
		$mission->security = $third_form['security'];
		$mission->location = $third_form['location'];
		
		$mission->english = mm_pack_language($third_form['lwc_english'], $third_form['lwe_english'], $third_form['lop_english'], 'english');
		$mission->french = mm_pack_language($third_form['lwc_french'], $third_form['lwe_french'], $third_form['lop_french'], 'french');
		
		$mission->mon_start = mm_pack_time($third_form['mon_start_hour'], $third_form['mon_start_min'], 'mon_start');
		$mission->mon_end = mm_pack_time($third_form['mon_end_hour'], $third_form['mon_end_min'], 'mon_end');
		$mission->tue_start = mm_pack_time($third_form['tue_start_hour'], $third_form['tue_start_min'], 'tue_start');
		$mission->tue_end = mm_pack_time($third_form['tue_end_hour'], $third_form['tue_end_min'], 'tue_end');
		$mission->wed_start = mm_pack_time($third_form['wed_start_hour'], $third_form['wed_start_min'], 'wed_start');
		$mission->wed_end = mm_pack_time($third_form['wed_end_hour'], $third_form['wed_end_min'], 'wed_end');
		$mission->thu_start = mm_pack_time($third_form['thu_start_hour'], $third_form['thu_start_min'], 'thu_start');
		$mission->thu_end = mm_pack_time($third_form['thu_end_hour'], $third_form['thu_end_min'], 'thu_end');
		$mission->fri_start = mm_pack_time($third_form['fri_start_hour'], $third_form['fri_start_min'], 'fri_start');
		$mission->fri_end = mm_pack_time($third_form['fri_end_hour'], $third_form['fri_end_min'], 'fri_end');
		$mission->sat_start = mm_pack_time($third_form['sat_start_hour'], $third_form['sat_start_min'], 'sat_start');
		$mission->sat_end = mm_pack_time($third_form['sat_end_hour'], $third_form['sat_end_min'], 'sat_end');
		$mission->sun_start = mm_pack_time($third_form['sun_start_hour'], $third_form['sun_start_min'], 'sun_start');
		$mission->sun_end = mm_pack_time($third_form['sun_end_hour'], $third_form['sun_end_min'], 'sun_end');
		
		$mission->timezone = $third_form['timezone'];
		
		// Sends the object and all its metadata to the database
		$mission->save();
		
		// Add to the river so it can be seen on the main page.
		add_to_river('river/object/mission/create', 'create', $mission->owner_guid, $mission->getGUID());
		
		// Clears all the sticky forms that have been in use so far.
		elgg_clear_sticky_form('firstfill');
		elgg_clear_sticky_form('secondfill');
		elgg_clear_sticky_form('thirdfill');
		elgg_clear_sticky_form('ldropfill');
		elgg_clear_sticky_form('tdropfill');
		
		forward($mission->getURL());
	}