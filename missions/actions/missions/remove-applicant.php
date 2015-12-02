<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * This action removes the relationship between the mission and one of its applicants.
 */
$mid = $_SESSION['mid_act'];
$mission = get_entity($mid);
$aid = get_input('mission_applicant');
$user = get_user($aid);

if($aid == '') {
    register_error(elgg_echo('missions:error:no_applicant_to_remove'));
}
else {
    remove_entity_relationship($mid, 'mission_accepted', $aid);
    
    $subject = elgg_echo('missions:removed_from_mission', array(), $user->language) . ': ' . $mission->title;
    $body = '';
    notify_user($aid, $mission->owner_guid, $subject, $body);
}

forward(REFERER);