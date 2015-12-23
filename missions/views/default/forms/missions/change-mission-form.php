<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Form which allows a manager to modify their mission.
 * This form includes all the same input fields as the post opportunity forms and they are formatted similarly..
 */
$mission = $vars['entity'];
$unpacked = mm_unpack_mission($mission);
$vars['mission_metadata'] = $unpacked;

if (elgg_is_sticky_form('editfill')) {
    extract(elgg_get_sticky_values('editfill'));
    // elgg_clear_sticky_form('thirdfill');
}

$input_name = elgg_view('input/text', array(
	'name' => 'name',
	'value' => $mission->name,
	'id' => 'edit-mission-name-text-input'
));
$input_department = elgg_view('input/text', array(
	'name' => 'department',
	'value' => $mission->department,
	'id' => 'edit-mission-department-text-input'
));
$input_email = elgg_view('input/text', array(
	'name' => 'email',
	'value' => $mission->email,
	'id' => 'edit-mission-email-text-input'
));
$input_phone = elgg_view('input/text', array(
	'name' => 'phone',
	'value' => $mission->phone,
	'id' => 'edit-mission-phone-text-input'
));

$input_number_of = elgg_view('input/dropdown', array(
    'name' => 'number',
    'value' => $mission->number,
    'options' => array(1,2,3,4,5),
    'id' => 'edit-mission-number-dropdown-input'
));

$input_title = elgg_view('input/text', array(
	'name' => 'job_title',
	'value' => $mission->job_title,
	'id' => 'edit-mission-title-text-input'
));

$input_type = elgg_view('input/text', array(
	'name' => 'job_type',
	'value' => $mission->job_type,
	'id' => 'edit-mission-type-text-input'
));

$input_deadline = elgg_view('input/date', array(
    'name' => 'deadline',
    'value' => $mission->deadline,
    'id' => 'edit-mission-deadline-date-input'
));

$input_start_date = elgg_view('input/date', array(
    'name' => 'start_date',
    'value' => $mission->start_date,
    'id' => 'edit-mission-start-date-input'
));

$input_completion_date = elgg_view('input/date', array(
    'name' => 'completion_date',
    'value' => $mission->completion_date,
    'id' => 'edit-mission-completion-date-input'
));

$input_skills = elgg_view('input/text', array(
    'name' => 'key_skills',
    'value' => $mission->key_skills,
    'id' => 'edit-mission-skills-text-input'
));

$input_description = elgg_view('input/plaintext', array(
	'name' => 'description',
	'value' => $mission->description,
	'id' => 'edit-mission-description-plaintext-input'
));

$input_remotely = elgg_view('input/checkbox', array(
	'name' => 'remotely',
	'checked' => $mission->remotely,
	'id' => 'edit-mission-remotely-checkbox-input'
));

$input_location = elgg_view('input/text', array(
	'name' => 'location',
	'value' => $mission->location,
	'id' => 'edit-mission-location-text-input'
));

$input_security = elgg_view('input/dropdown', array(
	'name' => 'security',
	'value' => $mission->security,
	'options' => explode(',', elgg_get_plugin_setting('security_string', 'missions')),
	'id' => 'edit-mission-security-dropdown-input'
));

$input_timezone = elgg_view('input/dropdown', array(
	'name' => 'timezone',
	'value' => $mission->timezone,
	'options' => explode(',', elgg_get_plugin_setting('timezone_string', 'missions')),
	'id' => 'edit-mission-timezone-dropdown-input'
));

$hidden_guid = elgg_view('input/hidden', array(
    'name' => 'hidden_guid',
    'value' => $mission->guid
));
?>

<div>
	<?php echo $hidden_guid; ?>
</div>
<div>
	<table class="mission-post-table">
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-name-text-input'><?php echo elgg_echo('missions:your_name') . '*:';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div><?php echo $input_name; ?></div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-department-text-input'><?php echo elgg_echo('missions:your_department') . '*:';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div><?php echo $input_department; ?></div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-email-text-input'><?php echo elgg_echo('missions:your_email') . '*:';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div><?php echo $input_email; ?></div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-phone-text-input'><?php echo elgg_echo('missions:your_phone') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div><?php echo $input_phone; ?></div>
			</td>
		</tr>
	</table>
	<hr>
	<table class="mission-post-table">
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-title-text-input'><?php echo elgg_echo('missions:opportunity_title') . '*:';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_title; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-type-text-input'><?php echo elgg_echo('missions:opportunity_type') . '*:';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_type; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-number-dropdown-input'><?php echo elgg_echo('missions:opportunity_number') . '*:';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_number_of; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-start-date-input'><?php echo elgg_echo('missions:ideal_start_date') . '*:';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div><?php echo $input_start_date; ?></div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-completion-date-input'><?php echo elgg_echo('missions:ideal_completion_date') . '*:';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div><?php echo $input_completion_date; ?></div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-skills-text-input'><?php echo elgg_echo('missions:key_skills_opportunity') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty-longer">
				<div><?php echo $input_skills; ?></div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-deadline-date-input'><?php echo elgg_echo('missions:application_deadline') . '*:';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div><?php echo $input_deadline; ?></div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-description-plaintext-input'><?php echo elgg_echo('missions:opportunity_description') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty-longer">
				<div>
				<?php echo $input_description; ?>
			</div>
			</td>
		</tr>
	</table>
	<hr>
	<table class="mission-post-table">
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-timezone-dropdown-input'><?php echo elgg_echo('missions:timezone') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_timezone; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<?php echo elgg_view('page/elements/time-table', $vars); ?> 
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-remotely-checkbox-input'><?php echo elgg_echo('missions:work_remotely') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_remotely; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-location-text-input'><?php echo elgg_echo('missions:opportunity_location') . '*:';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_location; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='edit-mission-security-dropdown-input'><?php echo elgg_echo('missions:security_level') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_security; ?>
			</div>
			</td>
		</tr>
	</table>
	</br>
	<div>
		<?php echo elgg_view('page/elements/language-dropdown', $vars); ?>
	</div>
</div>
<p>
	<?php echo elgg_echo('missions:required_fields_star');?>
</p>

<div class="form-button"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:save'))); ?> </div>