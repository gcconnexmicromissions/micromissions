<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */

	/*
	 * This action takes the input from the application form and constructs an email using the input and user profile data.
	 * 
	 * Currently only takes user input.
	 * TODO: Use profile data and construct a better version.
	 */
	$mid = $_SESSION['mid_act'];
	unset($_SESSION['mid_act']);
	$email_body = get_input('email_body');
	
	$mission = get_entity($mid);
	$applicant = elgg_get_logged_in_user_entity();
	
	$from = $applicant->email;
	$to = $mission->email;
	$subject = elgg_echo('missions:application_to') . $mission->job_title;
	
	$body = '';
	$body .= '<a href="' . $applicant->getURL() . '">' . elgg_echo('missions:applicant_profile') . '</a>';
	$body .= $email_body;
	
	elgg_send_email($from, $to, $subject, $body);
	
	forward(elgg_get_site_url() . 'missions/main');