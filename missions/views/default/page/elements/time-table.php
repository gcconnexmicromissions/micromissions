<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * View which displays 28 dropdown fields. These are for the start times and duration of every day of the week.
 * Values in the dropdown fields are extracted from the hour_string and minute_string found in settings.
 */
$hourarray = explode(',', elgg_get_plugin_setting('hour_string', 'missions'));
$minarray = explode(',', elgg_get_plugin_setting('minute_string', 'missions'));
$durationarray = explode(',', elgg_get_plugin_setting('duration_string', 'missions'));

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
$mon_duration_hour = get_input('itmeh');
$mon_duration_min = get_input('itmem');
$tue_duration_hour = get_input('itteh');
$tue_duration_min = get_input('ittem');
$wed_duration_hour = get_input('itweh');
$wed_duration_min = get_input('itwem');
$thu_duration_hour = get_input('ittheh');
$thu_duration_min = get_input('itthem');
$fri_duration_hour = get_input('itfeh');
$fri_duration_min = get_input('itfem');
$sat_start_hour = get_input('itssh');
$sat_start_min = get_input('itssm');
$sun_start_hour = get_input('itsush');
$sun_start_min = get_input('itsusm');
$sat_duration_hour = get_input('itseh');
$sat_duration_min = get_input('itsem');
$sun_duration_hour = get_input('itsueh');
$sun_duration_min = get_input('itsuem');

if (elgg_is_sticky_form('tdropfill')) {
    extract(elgg_get_sticky_values('tdropfill'));
    // elgg_clear_sticky_form('thirdfill');
}

$input_monday_start_hour = elgg_view('input/dropdown', array(
    'name' => 'mon_start_hour',
    'value' => $mon_start_hour,
    'options' => $hourarray,
    'class' => 'time-dropdown',
    'id' => 'time-monday-start-hour-dropdown-input'
));
$input_monday_start_minute = elgg_view('input/dropdown', array(
    'name' => 'mon_start_min',
    'value' => $mon_start_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-monday-start-minute-dropdown-input'
));
$input_tuesday_start_hour = elgg_view('input/dropdown', array(
    'name' => 'tue_start_hour',
    'value' => $tue_start_hour,
    'options' => $hourarray,
    'class' => 'time-dropdown',
    'id' => 'time-tuesday-start-hour-dropdown-input'
));
$input_tuesday_start_minute = elgg_view('input/dropdown', array(
    'name' => 'tue_start_min',
    'value' => $tue_start_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-tuesday-start-minute-dropdown-input'
));
$input_wednesday_start_hour = elgg_view('input/dropdown', array(
    'name' => 'wed_start_hour',
    'value' => $wed_start_hour,
    'options' => $hourarray,
    'class' => 'time-dropdown',
    'id' => 'time-wednesday-start-hour-dropdown-input'
));
$input_wednesday_start_minute = elgg_view('input/dropdown', array(
    'name' => 'wed_start_min',
    'value' => $wed_start_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-wednesday-start-minute-dropdown-input'
));
$input_thursday_start_hour = elgg_view('input/dropdown', array(
    'name' => 'thu_start_hour',
    'value' => $thu_start_hour,
    'options' => $hourarray,
    'class' => 'time-dropdown',
    'id' => 'time-thursday-start-hour-dropdown-input'
));
$input_thursday_start_minute = elgg_view('input/dropdown', array(
    'name' => 'thu_start_min',
    'value' => $thu_start_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-thursday-start-minute-dropdown-input'
));
$input_friday_start_hour = elgg_view('input/dropdown', array(
    'name' => 'fri_start_hour',
    'value' => $fri_start_hour,
    'options' => $hourarray,
    'class' => 'time-dropdown',
    'id' => 'time-friday-start-hour-dropdown-input'
));
$input_friday_start_minute = elgg_view('input/dropdown', array(
    'name' => 'fri_start_min',
    'value' => $fri_start_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-friday-start-minute-dropdown-input'
));
$input_monday_duration_hour = elgg_view('input/dropdown', array(
    'name' => 'mon_duration_hour',
    'value' => $mon_duration_hour,
    'options' => $durationarray,
    'class' => 'time-dropdown',
    'id' => 'time-monday-duration-hour-dropdown-input'
));
$input_monday_duration_minute = elgg_view('input/dropdown', array(
    'name' => 'mon_duration_min',
    'value' => $mon_duration_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-monday-duration-minute-dropdown-input'
));
$input_tuesday_duration_hour = elgg_view('input/dropdown', array(
    'name' => 'tue_duration_hour',
    'value' => $tue_duration_hour,
    'options' => $durationarray,
    'class' => 'time-dropdown',
    'id' => 'time-tuesday-duration-hour-dropdown-input'
));
$input_tuesday_duration_minute = elgg_view('input/dropdown', array(
    'name' => 'tue_duration_min',
    'value' => $tue_duration_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-tuesday-duration-minute-dropdown-input'
));
$input_wednesday_duration_hour = elgg_view('input/dropdown', array(
    'name' => 'wed_duration_hour',
    'value' => $wed_duration_hour,
    'options' => $durationarray,
    'class' => 'time-dropdown',
    'id' => 'time-wednesday-duration-hour-dropdown-input'
));
$input_wednesday_duration_minute = elgg_view('input/dropdown', array(
    'name' => 'wed_duration_min',
    'value' => $wed_duration_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-wednesday-duration-minute-dropdown-input'
));
$input_thursday_duration_hour = elgg_view('input/dropdown', array(
    'name' => 'thu_duration_hour',
    'value' => $thu_duration_hour,
    'options' => $durationarray,
    'class' => 'time-dropdown',
    'id' => 'time-thursday-duration-hour-dropdown-input'
));
$input_thursday_duration_minute = elgg_view('input/dropdown', array(
    'name' => 'thu_duration_min',
    'value' => $thu_duration_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-thursday-duration-minute-dropdown-input'
));
$input_friday_duration_hour = elgg_view('input/dropdown', array(
    'name' => 'fri_duration_hour',
    'value' => $fri_duration_hour,
    'options' => $durationarray,
    'class' => 'time-dropdown',
    'id' => 'time-friday-duration-hour-dropdown-input'
));
$input_friday_duration_minute = elgg_view('input/dropdown', array(
    'name' => 'fri_duration_min',
    'value' => $fri_duration_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-friday-duration-minute-dropdown-input'
));
$input_saturday_start_hour = elgg_view('input/dropdown', array(
    'name' => 'sat_start_hour',
    'value' => $sat_start_hour,
    'options' => $hourarray,
    'class' => 'time-dropdown',
    'id' => 'time-saturday-start-hour-dropdown-input'
));
$input_saturday_start_minute = elgg_view('input/dropdown', array(
    'name' => 'sat_start_min',
    'value' => $sat_start_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-saturday-start-minute-dropdown-input'
));
$input_sunday_start_hour = elgg_view('input/dropdown', array(
    'name' => 'sun_start_hour',
    'value' => $sun_start_hour,
    'options' => $hourarray,
    'class' => 'time-dropdown',
    'id' => 'time-sunday-start-hour-dropdown-input'
));
$input_sunday_start_minute = elgg_view('input/dropdown', array(
    'name' => 'sun_start_min',
    'value' => $sun_start_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-sunday-start-minute-dropdown-input'
));
$input_saturday_duration_hour = elgg_view('input/dropdown', array(
    'name' => 'sat_duration_hour',
    'value' => $sat_duration_hour,
    'options' => $durationarray,
    'class' => 'time-dropdown',
    'id' => 'time-saturday-duration-hour-dropdown-input'
));
$input_saturday_duration_minute = elgg_view('input/dropdown', array(
    'name' => 'sat_duration_min',
    'value' => $sat_duration_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-saturday-duration-minute-dropdown-input'
));
$input_sunday_duration_hour = elgg_view('input/dropdown', array(
    'name' => 'sun_duration_hour',
    'value' => $sun_duration_hour,
    'options' => $durationarray,
    'class' => 'time-dropdown',
    'id' => 'time-sunday-duration-hour-dropdown-input'
));
$input_sunday_duration_minute = elgg_view('input/dropdown', array(
    'name' => 'sun_duration_min',
    'value' => $sun_duration_min,
    'options' => $minarray,
    'class' => 'time-dropdown',
    'id' => 'time-sunday-duration-minute-dropdown-input'
));
?>

<table class="mission-post-table-day">
	<tr><td>

	</td></tr>
	<tr><td>
    	<h3> <?php echo elgg_echo('missions:start_time');?> </h3>
    </td></tr>
    <tr><td>
    	<h3> <?php echo elgg_echo('missions:duration');?> </h3>
    </td></tr>
</table>
<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:mon'); ?> </h4>
	</td></tr>
	<tr><td>
		<div><?php
            echo $input_monday_start_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_monday_start_minute;
        ?></div>
	</td></tr>
	<tr><td>
		<div><?php
            echo $input_monday_duration_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_monday_duration_minute;
        ?></div>
	</td></tr>
</table>
<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:tue'); ?> </h4>
	</td></tr>
	<tr><td>
		<div><?php
            echo $input_tuesday_start_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_tuesday_start_minute;
        ?></div>
	</td></tr>
	<tr><td>
		<div><?php
            echo $input_tuesday_duration_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_tuesday_duration_minute;
        ?></div>
	</td></tr>
</table>
<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:wed'); ?> </h4>
	</td></tr>
	<tr><td>
    	<div><?php
            echo $input_wednesday_start_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_wednesday_start_minute;
        ?></div>
	</td></tr>
	<tr><td>
		<div><?php
            echo $input_wednesday_duration_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_wednesday_duration_minute;
        ?></div>
	</td></tr>
</table>
<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:thu'); ?> </h4>
	</td></tr>
	<tr><td>
    	<div><?php
            echo $input_thursday_start_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_thursday_start_minute;
        ?></div>
	</td></tr>
	<tr><td>
		<div><?php
            echo $input_thursday_duration_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_thursday_duration_minute;
        ?></div>
	</td></tr>
</table>
<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:fri'); ?> </h4>
	</td></tr>
	<tr><td>
    	<div><?php
            echo $input_friday_start_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_friday_start_minute;
        ?></div>
	</td></tr>
	<tr><td>
		<div><?php
            echo $input_friday_duration_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_friday_duration_minute;
        ?></div>
	</td></tr>
</table>
<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:sat'); ?> </h4>
	</td></tr>
	<tr><td>
		<div><?php
            echo $input_saturday_start_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_saturday_start_minute;
        ?></div>
	</td></tr>
	<tr><td>
		<div><?php
            echo $input_saturday_duration_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_saturday_duration_minute;
        ?></div>
	</td></tr>
</table>
<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:sun'); ?> </h4>
	</td></tr>
	<tr><td>
		<div><?php
            echo $input_sunday_start_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_sunday_start_minute;
        ?></div>
	</td></tr>
	<tr><td>
		<div><?php
            echo $input_sunday_duration_hour;
            echo '<span style="font-size:16pt;">: </span>';
            echo $input_sunday_duration_minute;
        ?></div>
	</td></tr>
</table>