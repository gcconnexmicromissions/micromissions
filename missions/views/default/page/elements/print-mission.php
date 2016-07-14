<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This view displays some of the mission metadata. It is meant to be a first glance summary.
 */
$mission = '';
if (isset($vars['entity'])) {
    $mission = $vars['entity'];
}

$description_string = elgg_get_excerpt($mission->description, 200);
$card_height = elgg_get_plugin_setting('mission_card_height', 'missions');
$card_width = elgg_get_plugin_setting('mission_card_width', 'missions');

// Sets the buttons to the bottom of whichever view is used.
if(!$vars['override_buttons']) {
    $button_set = mm_create_button_set_base($mission, false);
}

$mission_state = '';
if($mission->state == 'completed') {
	$mission_state = '(' . strtolower(elgg_echo('missions:completed')) . ')';
}
if($mission->state == 'cancelled') {
	$mission_state = '(' . strtolower(elgg_echo('missions:cancelled')) . ')';
}

// Linking to the mission managers profile.
/*$manager = get_entity($mission->owner_guid);
$manager_profile = elgg_view('output/url', array(
		'href' => elgg_get_site_url() . 'profile/' . $manager->username,
		'text' => $manager->name,
		'id' => 'mission-user-link-' . $manager->guid
));*/

$manager_info = elgg_view('page/elements/mission-manager-info', array(
		'mission' => $mission,
		'container_class' => 'mission-user-card-info',
		'grid_number' => '2'
));

if($mission->owner_guid == elgg_get_logged_in_user_guid() || $mission->account == elgg_get_logged_in_user_guid()) {
	$relationship_count = elgg_get_entities_from_relationship(array(
			'relationship' => 'mission_applied',
			'relationship_guid' => $mission->guid,
			'count' => true
	));
		
	$relationship_count += elgg_get_entities_from_relationship(array(
			'relationship' => 'mission_offered',
			'relationship_guid' => $mission->guid,
			'count' => true
	));
	
	if($relationship_count > 0 && $mission->state == 'posted') {
		$relationship_alert = '<div name="mission-applicant-number" class="notif-badge" id="mission-' . $mission->guid . '-applicant-number" style="position:absolute;right:2px;top:2px;">' . $relationship_count . '</div>';
	}
}

$completion_date_fixed = $mission->completion_date;
if(trim($completion_date_fixed) == '') {
	$completion_date_fixed = elgg_echo('missions:unknown');
}
?>

<div class="mission-printer mission-less" style="height:<?php echo $card_height;?>px;width:<?php echo $card_width;?>px;" name="mission-object">
	<?php echo $relationship_alert; ?>
	<div style="width:100%;overflow-x:auto;">
		<h2>
			<span name="mission-job-title"><?php echo elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'));?></span>
			<span style="font-style:italic;font-size:small;" name="mission-state"><?php echo $mission_state; ?></span>
		</h2>
	</div>
	<div name="mission-job-type">
		<b><?php echo elgg_echo($mission->job_type); ?></b>
	</div>
	<div style="max-height:115px;width:100%;overflow:hidden;" name="mission-description"><?php echo $description_string;?></div>
	<br>
	<div>
		<div style="display:inline-block;vertical-align:top;">
			<h5><?php echo elgg_echo('missions:date') . ':';?></h5>
		</div>
		<div style="display:inline-block;">
			<div name="mission-start-and-completion-date">
				<span name="mission-start-date"><?php echo $mission->start_date; ?></span>
				<span><?php echo elgg_echo('missions:to'); ?></span>
				<span name="mission-completion-date"><?php echo $completion_date_fixed; ?></span>
			</div>
			<div style="font-style:italic;" name="mission-time-commitment-and-interval">
				<span name="mission-time-commitment">
					<?php echo $mission->time_commitment; ?>
				</span>
				<span>
					<?php echo elgg_echo('missions:hours'); ?>
				</span>
				<span name="mission-time-interval">
					<?php echo elgg_echo($mission->time_interval); ?>
				</span>
			</div>
		</div>
	</div>
	<div>
		<div style="display:inline-block;">
			<h5><?php echo elgg_echo('missions:apply_by') . ':';?></h5>
		</div>
		<div style="display:inline-block;" name="mission-deadline"><?php echo $mission->deadline;?></div>
	</div>
	<br>
	<?php echo $manager_info; ?>
	<div class="mission-button-set"><?php
			if (! $full_view) {
			    foreach ($button_set as $value) {
			        echo $value;
			    }
			}
		?></div>
	<div hidden name="mission-card-guid" id="mission-card-guid-<?php echo $mission->guid; ?>"><?php echo $mission->guid; ?></div>
</div>