<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	 
	/*
	 * View which displays 28 dropdown fields. These are for the start and end times of every day of the week.
	 * Values in the dropdown fields are extracted from the hour_string and minute_string found in settings.
	 */
	$hourarray = explode(',', elgg_get_plugin_setting('hour_string', 'missions'));
	$minarray = explode(',', elgg_get_plugin_setting('minute_string', 'missions'));
	
	$mon_start_hour = get_input('itmsh');
	$mon_start_min = get_input('itmsm');
	$tue_start_hour = get_input('ittsh');
	$tue_start_min = get_input('ittsm');
	$wed_start_hour = get_input('itwsh');
	$wed_start_min = get_input('itwsm');
	$thu_start_hour = get_input('itthsh');
	$thu_start_min = get_input('itthsm');
	$fri_start_hour = get_input('itfsh');
	$fri_start_min = get_input('itfsm');
	$mon_end_hour = get_input('itmeh');
	$mon_end_min = get_input('itmem');
	$tue_end_hour = get_input('itteh');
	$tue_end_min = get_input('ittem');
	$wed_end_hour = get_input('itweh');
	$wed_end_min = get_input('itwem');
	$thu_end_hour = get_input('ittheh');
	$thu_end_min = get_input('itthem');
	$fri_end_hour = get_input('itfeh');
	$fri_end_min = get_input('itfem');
	$sat_start_hour = get_input('itssh');
	$sat_start_min = get_input('itssm');
	$sun_start_hour = get_input('itsush');
	$sun_start_min = get_input('itsusm');
	$sat_end_hour = get_input('itseh');
	$sat_end_min = get_input('itsem');
	$sun_end_hour = get_input('itsueh');
	$sun_end_min = get_input('itsuem');
	
	if (elgg_is_sticky_form('tdropfill')) {
		extract(elgg_get_sticky_values('tdropfill'));
		//elgg_clear_sticky_form('thirdfill');
	}
	
	$input_monday_start_hour = elgg_view('input/dropdown', array(
			'name' => 'mon_start_hour',
			'value' => $mon_start_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_monday_start_minute = elgg_view('input/dropdown', array(
			'name' => 'mon_start_min',
			'value' => $mon_start_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_tuesday_start_hour = elgg_view('input/dropdown', array(
			'name' => 'tue_start_hour',
			'value' => $tue_start_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_tuesday_start_minute = elgg_view('input/dropdown', array(
			'name' => 'tue_start_min',
			'value' => $tue_start_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_wednesday_start_hour = elgg_view('input/dropdown', array(
			'name' => 'wed_start_hour',
			'value' => $wed_start_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_wednesday_start_minute = elgg_view('input/dropdown', array(
			'name' => 'wed_start_min',
			'value' => $wed_start_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_thursday_start_hour = elgg_view('input/dropdown', array(
			'name' => 'thu_start_hour',
			'value' => $thu_start_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_thursday_start_minute = elgg_view('input/dropdown', array(
			'name' => 'thu_start_min',
			'value' => $thu_start_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_friday_start_hour = elgg_view('input/dropdown', array(
			'name' => 'fri_start_hour',
			'value' => $fri_start_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_friday_start_minute = elgg_view('input/dropdown', array(
			'name' => 'fri_start_min',
			'value' => $fri_start_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_monday_end_hour = elgg_view('input/dropdown', array(
			'name' => 'mon_end_hour',
			'value' => $mon_end_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_monday_end_minute = elgg_view('input/dropdown', array(
			'name' => 'mon_end_min',
			'value' => $mon_end_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_tuesday_end_hour = elgg_view('input/dropdown', array(
			'name' => 'tue_end_hour',
			'value' => $tue_end_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_tuesday_end_minute = elgg_view('input/dropdown', array(
			'name' => 'tue_end_min',
			'value' => $tue_end_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_wednesday_end_hour = elgg_view('input/dropdown', array(
			'name' => 'wed_end_hour',
			'value' => $wed_end_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_wednesday_end_minute = elgg_view('input/dropdown', array(
			'name' => 'wed_end_min',
			'value' => $wed_end_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_thursday_end_hour = elgg_view('input/dropdown', array(
			'name' => 'thu_end_hour',
			'value' => $thu_end_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_thursday_end_minute = elgg_view('input/dropdown', array(
			'name' => 'thu_end_min',
			'value' => $thu_end_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_friday_end_hour = elgg_view('input/dropdown', array(
			'name' => 'fri_end_hour',
			'value' => $fri_end_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_friday_end_minute = elgg_view('input/dropdown', array(
			'name' => 'fri_end_min',
			'value' => $fri_end_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_saturday_start_hour = elgg_view('input/dropdown', array(
			'name' => 'sat_start_hour',
			'value' => $sat_start_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_saturday_start_minute = elgg_view('input/dropdown', array(
			'name' => 'sat_start_min',
			'value' => $sat_start_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_sunday_start_hour = elgg_view('input/dropdown', array(
			'name' => 'sun_start_hour',
			'value' => $sun_start_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_sunday_start_minute = elgg_view('input/dropdown', array(
			'name' => 'sun_start_min',
			'value' => $sun_start_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_saturday_end_hour = elgg_view('input/dropdown', array(
			'name' => 'sat_end_hour',
			'value' => $sat_end_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_saturday_end_minute = elgg_view('input/dropdown', array(
			'name' => 'sat_end_min',
			'value' => $sat_end_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
	$input_sunday_end_hour = elgg_view('input/dropdown', array(
			'name' => 'sun_end_hour',
			'value' => $sun_end_hour,
			'options' => $hourarray,
			'class' => 'time-dropdown'
	));
	$input_sunday_end_minute = elgg_view('input/dropdown', array(
			'name' => 'sun_end_min',
			'value' => $sun_end_min,
			'options' => $minarray,
			'class' => 'time-dropdown'
	));
?>

<table class="mission-post-table-inner">
	<tr>
		<td></td>
		<td> <h3> <?php echo elgg_echo('missions:mon'); ?> </h3> </td>
		<td> <h3> <?php echo elgg_echo('missions:tue'); ?> </h3> </td>
		<td> <h3> <?php echo elgg_echo('missions:wed'); ?> </h3> </td>
		<td> <h3> <?php echo elgg_echo('missions:thu'); ?> </h3> </td>
		<td> <h3> <?php echo elgg_echo('missions:fri'); ?> </h3> </td>
		<td> <h3> <?php echo elgg_echo('missions:sat'); ?> </h3> </td>
		<td> <h3> <?php echo elgg_echo('missions:sun'); ?> </h3> </td>
	</tr>
	<tr>
		<td> <h3> <?php echo elgg_echo('missions:start_time');?> </h3> </td>
		<td><div>
			<?php 
				echo $input_monday_start_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_monday_start_minute;
			?> 
		</div> </td>
		<td><div>
			<?php 
				echo $input_tuesday_start_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_tuesday_start_minute;
			?> 
		</div></td>
		<td><div>
			<?php 
				echo $input_wednesday_start_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_wednesday_start_minute;
			?> 
		</div></td>
		<td><div>
			<?php 
				echo $input_thursday_start_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_thursday_start_minute;
			?> 
		</div></td>
		<td><div>
			<?php 
				echo $input_friday_start_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_friday_start_minute;
			?> 
		</div></td>
		<td><div>
			<?php 
				echo $input_saturday_start_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_saturday_start_minute;
			?> 
		</div></td>
		<td><div>
			<?php 
				echo $input_sunday_start_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_sunday_start_minute;
			?> 
		</div></td>
	</tr>
	<tr>
		<td> <h3> <?php echo elgg_echo('missions:end_time');?> </h3> </td>
		<td><div> 
			<?php 
				echo $input_monday_end_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_monday_end_minute;
			?> 
		</div></td>
		<td><div>
			<?php 
				echo $input_tuesday_end_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_tuesday_end_minute;
			?> 
		</div></td>
		<td><div>
			<?php 
				echo $input_wednesday_end_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_wednesday_end_minute;
			?> 
		</div></td>
		<td><div>
			<?php 
				echo $input_thursday_end_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_thursday_end_minute;
			?> 
		</div></td>
		<td><div>
			<?php 
				echo $input_friday_end_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_friday_end_minute;
			?> 
		</div></td>
		<td><div>
			<?php 
				echo $input_saturday_end_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_saturday_end_minute;
			?> 
		</div></td>
		<td><div>
			<?php 
				echo $input_sunday_end_hour;
				echo '<span style="font-size:16pt;">: </span>';
				echo $input_sunday_end_minute;
			?> 
		</div></td>
	</tr>
</table>
	