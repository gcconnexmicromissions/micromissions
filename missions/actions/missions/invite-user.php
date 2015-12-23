<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action to send an invitation to a candidate.
 * This is meant to be called from a link or button.
 */
$applicant = get_user(get_input('aid'));
$mission = get_entity(get_input('mid'));

// Only users who have opted in to micro missions can be invited.
if($applicant->opt_in_missions == 'gcconnex_profile:opt:yes') {
	mm_send_notification_invite($applicant, $mission);
}
else {
	register_error(elgg_echo('missions:error:not_participating_in_missions'));
}
 
forward(elgg_get_site_url() . 'missions/main');