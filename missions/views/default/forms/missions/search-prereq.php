<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	$key_skills = get_input('sks');
	$department = get_input('sfd');
	$location = get_input('sl');
	$security = get_input('ss');
	
	if (elgg_is_sticky_form('searchprereqfill')) {
		extract(elgg_get_sticky_values('searchprereqfill'));
		elgg_clear_sticky_form('searchprereqfill');
	}
	
	$input_skills = elgg_view('input/text', array(
			'name' => 'key_skills',
			'value' => $key_skills,
	));
	
	$input_department = elgg_view('input/text', array(
			'name' => 'department',
			'value' => $department,
	));
	
	$input_location = elgg_view('input/text', array(
			'name' => 'location',
			'value' => $location,
	));
	
	$input_security = elgg_view('input/dropdown', array(
			'name' => 'security',
			'value' => $security,
			'options' => explode(',', elgg_get_plugin_setting('sec_string', 'missions')),
	));
?>

<div>
	<table class="mission-post-table">
		<tr>
			<td class="mission-post-table-lefty">
				<label><?php echo elgg_echo('missions:key_skills_opportunity') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty"> <div>
				<?php echo $input_skills; ?>
			</div> </td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty">
				<label><?php echo elgg_echo('missions:manager_department') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty"> <div>
				<?php echo $input_department; ?>
			</div> </td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty">
				<label><?php echo elgg_echo('missions:opportunity_location') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty"> <div>
				<?php echo $input_location; ?>
			</div> </td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty">
				<label><?php echo elgg_echo('missions:security_level') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty"> <div>
				<?php echo $input_security; ?>
			</div> </td>
		</tr>
	</table>
</div>

<div class="form-button"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:next'))); ?> </div>