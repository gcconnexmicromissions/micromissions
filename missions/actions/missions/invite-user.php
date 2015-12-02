<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

 $applicant = get_user(get_input('aid'));
 $mission = get_entity(get_input('mid'));
 
 mm_send_notification_invite($applicant, $mission);
 
 forward(elgg_get_site_url() . 'missions/main');