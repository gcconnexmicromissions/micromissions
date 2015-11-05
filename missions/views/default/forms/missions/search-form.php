<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	$job_title = get_input('sot');
	$key_skills = get_input('sks');
	$department = get_input('sfd');
	$location = get_input('sl');
	$job_type = get_input('sjt');
	$security = get_input('ss');
	
	$language_written_comprehension_english = get_input('tlwce');
	$language_written_comprehension_french = get_input('tlwcf');
	$language_written_expression_english = get_input('tlwee');
	$language_written_expression_french = get_input('tlwef');
	$language_oral_proficiency_english = get_input('tlope');
	$language_oral_proficiency_french = get_input('tlopf');
	
	$mon_start_hour = get_input('monsh');
	$mon_start_min = get_input('monsm');
	$tue_start_hour = get_input('tuesh');
	$tue_start_min = get_input('tuesm');
	$wed_start_hour = get_input('wedsh');
	$wed_start_min = get_input('wedsm');
	$thu_start_hour = get_input('thush');
	$thu_start_min = get_input('thusm');
	$fri_start_hour = get_input('frish');
	$fri_start_min = get_input('frism');
	$mon_end_hour = get_input('moneh');
	$mon_end_min = get_input('monem');
	$tue_end_hour = get_input('tueeh');
	$tue_end_min = get_input('tueem');
	$wed_end_hour = get_input('wedeh');
	$wed_end_min = get_input('wedem');
	$thu_end_hour = get_input('thueh');
	$thu_end_min = get_input('thuem');
	$fri_end_hour = get_input('frieh');
	$fri_end_min = get_input('friem');
	
	if (elgg_is_sticky_form('searchfill')) {
		extract(elgg_get_sticky_values('searchfill'));
		elgg_clear_sticky_form('searchfill');
	}
	
	$input_title = elgg_view('input/text', array(
			'name' => 'job_title',
			'value' => $job_title,
	));
	
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
	
	$input_type = elgg_view('input/text', array (
			'name' => 'job_type',
			'value' => $job_type,
	));
	
	$input_security = elgg_view('input/dropdown', array(
			'name' => 'security',
			'value' => $security,
			'options' => explode(',', elgg_get_plugin_setting('sec_string', 'missions')),
	));
?>

<p>
	<?php echo elgg_echo('missions:search_post:paragraph_one');?>
</p>
</br>
<div>
	<table class="mission-post-table-tabler">
		<tr>
			<td class="mission-post-table-lefty">
				<label><?php echo elgg_echo('missions:opportunity_title') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty"> <div>
				<?php echo $input_title; ?>
			</div> </td>
		</tr>
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
				<label><?php echo elgg_echo('missions:opportunity_type') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty"> <div>
				<?php echo $input_type; ?>
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
	</br>
	<div>
		<?php 
			echo elgg_view('page/elements/language-dropdown', $vars);
		?>
	</div>
	</br>
	<div align="left">
		<?php
			echo elgg_view('page/elements/time-table', $vars);
		?>
	</div>
</div>
<div class="form-button"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:next'))); ?> </div>