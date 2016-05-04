<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$temp_array_one = elgg_get_entities_from_relationship(array(
		'relationship' => 'mission_posted',
		'relationship_guid' => elgg_get_logged_in_user_guid()
));
$temp_array_two = elgg_get_entities_from_relationship(array(
		'relationship' => 'mission_accepted',
		'relationship_guid' => elgg_get_logged_in_user_guid(),
		'inverse_relationship' => true
));
$entity_list = array_merge($temp_array_one, $temp_array_two);

$entity_display = '';
foreach($entity_list as $key => $entity) {
	if($entity->state == 'completed') {
		$feedback_search = elgg_get_entities_from_metadata(array(
				'type' => 'object',
				'subtype' => 'mission-feedback',
				'metadata_name_value_pairs' => array(
						array('name' => 'recipient', 'value' => elgg_get_logged_in_user_guid()),
						array('name' => 'mission', 'value' => $entity->guid),
						array('name' => 'endorsement', 'value' => 'on')
				)
		));
		
		$entity_department = get_entity(mo_extract_node_guid($entity->department))->name;
		if(get_current_language == 'fr') {
			$entity_department = get_entity(mo_extract_node_guid($entity->department))->name_french;
		}
		
		$entity_display .= '<div class="row" style="padding:8px;"><div class="col-sm-8">';
		$entity_display .= '<span style="font-weight:bold;">' 
				. elgg_get_excerpt($entity->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')) . '</span><br>(' 
						. $entity->completion_date . ')<br>' 
								. $entity_department;
		$entity_display .= '</div><div class="col-sm-4 gcconnex-avatar-in-list">';
		foreach($feedback_search as $feedback) {
			$entity_display .= elgg_view_entity_icon(get_user($feedback->owner_guid), 'small');
		}
		$entity_display .= '</div></div>';
	}
}


?>

<div class="panel panel-custom">
	<div class="panel-heading profile-heading clearfix">
		<h3 class="profile-info-head pull-left clearfix"><?php echo elgg_echo('gcconnex_profile:completed_missions'); ?></h3>
	</div>
	<div class="gcconnex-profile-section-wrapper panel-body gcconnex-completed-missions">
		<?php echo $entity_display; ?>
	</div>
</div>