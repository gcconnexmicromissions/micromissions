<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
$job_title = get_input('sjt');
$job_type = get_input('sty');
$number = get_input('sn');
$start_date = get_input('ssd');
$completion_date = get_input('scd');
$key_skills = get_input('sks');
$deadline = get_input('sd');
$description = get_input('sdesc');

if (elgg_is_sticky_form('secondfill')) {
    extract(elgg_get_sticky_values('secondfill'));
    // elgg_clear_sticky_form('secondfill');
}

$input_title = elgg_view('input/text', array(
    'name' => 'job_title',
    'value' => $job_title,
    'id' => 'post-mission-title-text-input'
));
$input_type = elgg_view('input/text', array(
    'name' => 'job_type',
    'value' => $job_type,
    'id' => 'post-mission-type-text-input'
));
$input_number_of = elgg_view('input/dropdown', array(
    'name' => 'number',
    'value' => $number,
    'options' => array(1,2,3,4,5),
    'id' => 'post-mission-number-dropdown-input'
));
$input_start_date = elgg_view('input/date', array(
    'name' => 'start_date',
    'value' => $start_date,
    'id' => 'post-mission-start-date-input'
));
$input_completion_date = elgg_view('input/date', array(
    'name' => 'completion_date',
    'value' => $completion_date,
    'id' => 'post-mission-completion-date-input'
));
$input_skills = elgg_view('input/text', array(
    'name' => 'key_skills',
    'value' => $key_skills,
    'id' => 'post-mission-skills-text-input'
));
$input_deadline = elgg_view('input/date', array(
    'name' => 'deadline',
    'value' => $deadline,
    'id' => 'post-mission-deadline-date-input'
));
$input_description = elgg_view('input/plaintext', array(
    'name' => 'description',
    'value' => $description,
    'id' => 'post-mission-description-plaintext-input'
));
?>

<div>
	<table class="mission-post-table">
		<tr>
			<td class="mission-post-table-lefty"><label for='post-mission-title-text-input'><?php echo elgg_echo('missions:opportunity_title') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_title; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='post-mission-type-text-input'><?php echo elgg_echo('missions:opportunity_type') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_type; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='post-mission-number-dropdown-input'l><?php echo elgg_echo('missions:opportunity_number') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_number_of; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='post-mission-start-date-input'><?php echo elgg_echo('missions:ideal_start_date') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_start_date; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='post-mission-completion-date-input'><?php echo elgg_echo('missions:ideal_completion_date') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_completion_date; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='post-mission-skills-text-input'><?php echo elgg_echo('missions:key_skills_opportunity') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty-longer">
				<div>
				<?php echo $input_skills; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='post-mission-deadline-date-input'><?php echo elgg_echo('missions:application_deadline') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_deadline; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='post-mission-description-plaintext-input'><?php echo elgg_echo('missions:opportunity_description') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty-longer">
				<div>
				<?php echo $input_description; ?>
			</div>
			</td>
		</tr>
	</table>
</div>

<div class="form-button"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:next'))); ?> </div>