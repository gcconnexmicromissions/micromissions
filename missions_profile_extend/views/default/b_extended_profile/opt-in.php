<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */

	/*
	 * The view which display the opt-in choices that the user has saved.
	 * If no choices have been made it will display a message.
	 * This view is inside a section wrapper as described in wrapper.php.
	 */

	if (elgg_is_xhr()) {
    	$user_guid = $_GET["guid"];
	}
	else {
    	$user_guid = elgg_get_page_owner_guid();
	}
	
	// Gets the opt_in_set from the user's profile.
	$user = get_user($user_guid);
	$opt_in_set = $user->opt_in_set;
	
	// Division which will surround the table.
	echo '<div class="gcconnex-profile-opt-in-display" style="padding:20px 20px 10px 0px;">';
		
	if($user->canEdit() && empty($opt_in_set)) {
		echo elgg_echo('gcconnex_profile:opt:set_empty');
	}
	else {
		if (!(is_array($opt_in_set)) ) {
			$opt_in_set = array($opt_in_set);
		}
		echo '<table class="gcconnex-profile-opt-in-display-table table table-bordered" style="margin: 10px;">';
			echo '<tbody><tr>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:micro_mission') . '</td>';
				echo '<td>' . elgg_echo($opt_in_set[0]) . '</td>';
			echo '</tr><tr>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:job_swap') . '</td>';
				echo '<td>' . elgg_echo($opt_in_set[1]) . '</td>';
			echo '</tr><tr>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:mentored') . '</td>';
				echo '<td>' . elgg_echo($opt_in_set[2]) . '</td>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:mentoring') . '</td>';
				echo '<td>' . elgg_echo($opt_in_set[3]) . '</td>';
			echo '</tr><tr>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:shadowed') . '</td>';
				echo '<td>' . elgg_echo($opt_in_set[4]) . '</td>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:shadowing') . '</td>';
				echo '<td>' . elgg_echo($opt_in_set[5]) . '</td>';
				echo '</tr><tr>';
			echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:peer_coached') . '</td>';
				echo '<td>' . elgg_echo($opt_in_set[6]) . '</td>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:peer_coaching') . '</td>';
				echo '<td>' . elgg_echo($opt_in_set[7]) . '</td>';
			echo '</tr></tbody></table>';
	}
	echo '</div>';
?>