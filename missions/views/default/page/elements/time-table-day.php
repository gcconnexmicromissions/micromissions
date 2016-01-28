<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * View which displays 4 dropdown fields for start hour and minute and duration hour and minute.
 * Values in the dropdown fields are extracted from the hour_string and minute_string found in settings.
 */
//$hourarray = explode(',', elgg_get_plugin_setting('hour_string', 'missions'));
//$minarray = explode(',', elgg_get_plugin_setting('minute_string', 'missions'));
//$durationarray = explode(',', elgg_get_plugin_setting('duration_string', 'missions'));

$day = $vars['day'];
/*$start_hour = $vars['start_hour'];
$start_min = $vars['start_min'];
$duration_hour = $vars['duration_hour'];
$duration_min = $vars['duration_min'];*/
$start = $vars['start'];
$duration = $vars['duration'];

if (elgg_is_sticky_form('tddropfill')) {
    extract(elgg_get_sticky_values('tddropfill'));
    // elgg_clear_sticky_form('thirdfill');
}

/*$input_start_hour = elgg_view('input/dropdown', array(
    'name' => $day . '_start_hour',
    'value' => $start_hour,
    'options' => $hourarray,
	'style' => 'width:69px;',
	'id' => 'time-' . $day . '-start-hour-dropdown-input'
));
$input_start_minute = elgg_view('input/dropdown', array(
    'name' => $day . '_start_min',
    'value' => $start_min,
    'options' => $minarray,
	'style' => 'width:69px;',
	'id' => 'time-' . $day . '-start-minute-dropdown-input'
));
$input_duration_hour = elgg_view('input/dropdown', array(
    'name' => $day . '_duration_hour',
    'value' => $duration_hour,
    'options' => $durationarray,
	'style' => 'width:69px;',
	'id' => 'time-' . $day . '-duration-hour-dropdown-input'
));
$input_duration_minute = elgg_view('input/dropdown', array(
    'name' => $day . '_duration_min',
    'value' => $duration_min,
    'options' => $minarray,
	'style' => 'width:69px;',
	'id' => 'time-' . $day . '-duration-minute-dropdown-input'
));*/

$input_start = elgg_view('input/text', array(
		'name' => $day . '_start',
		'value' => $start,
		'style' => 'width:100px;',
		'id' => 'time-' . $day . '-start-text-input',
		'placeholder' => 'HH:mm',
		'class' => 'timepicker-start'
));

$input_duration = elgg_view('input/text', array(
		'name' => $day . '_duration',
		'value' => $duration,
		'style' => 'width:100px;',
		'id' => 'time-' . $day . '-duration-text-input',
		'placeholder' => 'HH:mm',
		'class' => 'timepicker-duration'
));
?>

<div style="display:inline-block;">
	<div style="text-align:center;">
		<h4> <?php echo elgg_echo('missions:' . $day); ?> </h4>
	</div>
	<!--  
	<div>
		<?php
			echo '<span style="display:inline-block;">' . $input_start_hour . '</span>';
			echo '<span style="font-size:16pt;"> : </span>';
			echo '<span style="display:inline-block;">' . $input_start_minute . '</span>';
		?>
	</div>
	<div>
		<?php
			echo '<span style="display:inline-block;">' . $input_duration_hour . '</span>';
			echo '<span style="font-size:16pt;"> : </span>';
			echo '<span style="display:inline-block;">' . $input_duration_minute . '</span>';
		?>
	</div>
	-->
	<div>
		<?php echo $input_start; ?>
	</div>
	<div>
		<?php echo $input_duration; ?>
	</div>
</div>