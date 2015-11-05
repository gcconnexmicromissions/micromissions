<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	 
	/*
	 * View which displays 4 dropdown fields for start hour and minute and end hour and minute.
	 * Values in the dropdown fields are extracted from the hour_string and minute_string found in settings.
	 */
	$hourarray = explode(',', elgg_get_plugin_setting('hour_string', 'missions'));
	$minarray = explode(',', elgg_get_plugin_setting('minute_string', 'missions'));
	
	$start_hour = get_input('itsh');
	$start_min = get_input('itsm');
	$end_hour = get_input('iteh');
	$end_min = get_input('item');
	
	if (elgg_is_sticky_form('tddropfill')) {
		extract(elgg_get_sticky_values('tddropfill'));
		//elgg_clear_sticky_form('thirdfill');
	}
	
	$input_start_hour = elgg_view('input/dropdown', array(
			'name' => 'start_hour',
			'value' => $start_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_start_minute = elgg_view('input/dropdown', array(
			'name' => 'start_min',
			'value' => $start_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_end_hour = elgg_view('input/dropdown', array(
			'name' => 'end_hour',
			'value' => $end_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_end_minute = elgg_view('input/dropdown', array(
			'name' => 'end_min',
			'value' => $end_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
?>

<table class="mission-post-table">
	<tr>
		<td class="mission-post-table-lefty"> <h3> 
			<?php echo elgg_echo('missions:start_time');?> 
		</h3> </td>
		<td class="mission-post-table-righty">
			<?php 
				echo $input_start_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_start_minute;
			?> 
		</td>
	</tr>
	<tr>
		<td class="mission-post-table-lefty"> <h3> 
			<?php echo elgg_echo('missions:end_time');?>
		</h3> </td>
		<td class="mission-post-table-righty">
			<?php 
				echo $input_end_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_end_minute;
			?> 
		</td>
	</tr>
</table>
	