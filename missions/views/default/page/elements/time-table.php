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

$weekend_array = array();

if($vars['mission_metadata']['mon_start_hour']) {
    $mon_start_hour = $vars['mission_metadata']['mon_start_hour'];
}
if($vars['mission_metadata']['mon_start_min']) {
    $mon_start_min = $vars['mission_metadata']['mon_start_min'];
}
if($vars['mission_metadata']['tue_start_hour']) {
    $tue_start_hour = $vars['mission_metadata']['tue_start_hour'];
}
if($vars['mission_metadata']['tue_start_min']) {
    $tue_start_min = $vars['mission_metadata']['tue_start_min'];
}
if($vars['mission_metadata']['wed_start_hour']) {
    $wed_start_hour = $vars['mission_metadata']['wed_start_hour'];
}
if($vars['mission_metadata']['wed_start_min']) {
    $wed_start_min = $vars['mission_metadata']['wed_start_min'];
}
if($vars['mission_metadata']['thu_start_hour']) {
    $thu_start_hour = $vars['mission_metadata']['thu_start_hour'];
}
if($vars['mission_metadata']['thu_start_min']) {
    $thu_start_min = $vars['mission_metadata']['thu_start_min'];
}
if($vars['mission_metadata']['fri_start_hour']) {
    $fri_start_hour = $vars['mission_metadata']['fri_start_hour'];
}
if($vars['mission_metadata']['fri_start_min']) {
    $fri_start_min = $vars['mission_metadata']['fri_start_min'];
}
if($vars['mission_metadata']['mon_duration_hour']) {
    $mon_duration_hour = $vars['mission_metadata']['mon_duration_hour'];
}
if($vars['mission_metadata']['mon_duration_min']) {
    $mon_duration_min = $vars['mission_metadata']['mon_duration_min'];
}
if($vars['mission_metadata']['tue_duration_hour']) {
    $tue_duration_hour = $vars['mission_metadata']['tue_duration_hour'];
}
if($vars['mission_metadata']['tue_duration_min']) {
    $tue_duration_min = $vars['mission_metadata']['tue_duration_min'];
}
if($vars['mission_metadata']['wed_duration_hour']) {
    $wed_duration_hour = $vars['mission_metadata']['wed_duration_hour'];
}
if($vars['mission_metadata']['wed_duration_min']) {
    $wed_duration_min = $vars['mission_metadata']['wed_duration_min'];
}
if($vars['mission_metadata']['thu_duration_hour']) {
    $thu_duration_hour = $vars['mission_metadata']['thu_duration_hour'];
}
if($vars['mission_metadata']['thu_duration_min']) {
    $thu_duration_min = $vars['mission_metadata']['thu_duration_min'];
}
if($vars['mission_metadata']['fri_duration_hour']) {
    $fri_duration_hour = $vars['mission_metadata']['fri_duration_hour'];
}
if($vars['mission_metadata']['fri_duration_min']) {
    $fri_duration_min = $vars['mission_metadata']['fri_duration_min'];
}
if($vars['mission_metadata']['sat_start_hour']) {
    $sat_start_hour = $vars['mission_metadata']['sat_start_hour'];
    $weekend_array['sat_start_hour'] =  $sat_start_hour;
}
if($vars['mission_metadata']['sat_start_min']) {
    $sat_start_min = $vars['mission_metadata']['sat_start_min'];
    $weekend_array['sat_start_min'] = $sat_start_min;
}
if($vars['mission_metadata']['sun_start_hour']) {
    $sun_start_hour = $vars['mission_metadata']['sun_start_hour'];
    $weekend_array['sun_start_hour'] = $sun_start_hour;
}
if($vars['mission_metadata']['sun_start_min']) {
    $sun_start_min = $vars['mission_metadata']['sun_start_min'];
    $weekend_array['sun_start_min'] = $sun_start_min;
}
if($vars['mission_metadata']['sat_duration_hour']) {
    $sat_duration_hour = $vars['mission_metadata']['sat_duration_hour'];
    $weekend_array['sat_duration_hour'] = $sat_duration_hour;
}
if($vars['mission_metadata']['sat_duration_min']) {
    $sat_duration_min = $vars['mission_metadata']['sat_duration_min'];
    $weekend_array['sat_duration_min'] = $sat_duration_min;
}
if($vars['mission_metadata']['sun_duration_hour']) {
    $sun_duration_hour = $vars['mission_metadata']['sun_duration_hour'];
    $weekend_array['sun_duration_hour'] = $sun_duration_hour;
}
if($vars['mission_metadata']['sun_duration_min']) {
    $sun_duration_min = $vars['mission_metadata']['sun_duration_min'];
    $weekend_array['sun_duration_min'] = $sun_duration_min;
}

$_SESSION['weekend_array'] = $weekend_array;

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

$weekend_button = elgg_view('output/url', array(
		'text' => elgg_echo('missions:weekend'),
		'class' => 'elgg-button btn btn-default',
		'id' => 'time-table-weekend-button',
		'onclick' => 'set_weekend()'
));

$no_weekend_button = elgg_view('output/url', array(
		'text' => elgg_echo('missions:no_weekend'),
		'class' => 'elgg-button btn btn-default',
		'id' => 'time-table-no-weekend-button',
		'onclick' => 'unset_weekend()'
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
            echo '<span class="missions-inline-drop">' . $input_monday_start_hour . '</span>';
            echo '<span style="font-size:16pt;"> : </span>';
            echo '<span class="missions-inline-drop">' . $input_monday_start_minute . '</span>';
        ?></div>
	</td></tr>
	<tr><td>
		<div><?php
            echo '<span class="missions-inline-drop">' . $input_monday_duration_hour . '</span>';
            echo '<span style="font-size:16pt;"> : </span>';
            echo '<span class="missions-inline-drop">' . $input_monday_duration_minute . '</span>';
        ?></div>
	</td></tr>
</table>
<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:tue'); ?> </h4>
	</td></tr>
	<tr><td>
		<div><?php
            echo '<span class="missions-inline-drop">' . $input_tuesday_start_hour . '</span>';
            echo '<span style="font-size:16pt;"> : </span>';
            echo '<span class="missions-inline-drop">' . $input_tuesday_start_minute . '</span>';
        ?></div>
	</td></tr>
	<tr><td>
		<div><?php
            echo '<span class="missions-inline-drop">' . $input_tuesday_duration_hour . '</span>';
            echo '<span style="font-size:16pt;"> : </span>';
            echo '<span class="missions-inline-drop">' . $input_tuesday_duration_minute . '</span>';
        ?></div>
	</td></tr>
</table>
<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:wed'); ?> </h4>
	</td></tr>
	<tr><td>
    	<div><?php
            echo '<span class="missions-inline-drop">' . $input_wednesday_start_hour . '</span>';
            echo '<span style="font-size:16pt;"> : </span>';
            echo '<span class="missions-inline-drop">' . $input_wednesday_start_minute . '</span>';
        ?></div>
	</td></tr>
	<tr><td>
		<div><?php
            echo '<span class="missions-inline-drop">' . $input_wednesday_duration_hour . '</span>';
            echo '<span style="font-size:16pt;"> : </span>';
            echo '<span class="missions-inline-drop">' . $input_wednesday_duration_minute . '</span>';
        ?></div>
	</td></tr>
</table>
<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:thu'); ?> </h4>
	</td></tr>
	<tr><td>
    	<div><?php
            echo '<span class="missions-inline-drop">' . $input_thursday_start_hour . '</span>';
            echo '<span style="font-size:16pt;"> : </span>';
            echo '<span class="missions-inline-drop">' . $input_thursday_start_minute . '</span>';
        ?></div>
	</td></tr>
	<tr><td>
		<div><?php
            echo '<span class="missions-inline-drop">' . $input_thursday_duration_hour . '</span>';
            echo '<span style="font-size:16pt;"> : </span>';
            echo '<span class="missions-inline-drop">' . $input_thursday_duration_minute . '</span>';
        ?></div>
	</td></tr>
</table>
<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:fri'); ?> </h4>
	</td></tr>
	<tr><td>
    	<div><?php
            echo '<span class="missions-inline-drop">' . $input_friday_start_hour . '</span>';
            echo '<span style="font-size:16pt;"> : </span>';
            echo '<span class="missions-inline-drop">' . $input_friday_start_minute . '</span>';
        ?></div>
	</td></tr>
	<tr><td>
		<div><?php
            echo '<span class="missions-inline-drop">' . $input_friday_duration_hour . '</span>';
            echo '<span style="font-size:16pt;"> : </span>';
            echo '<span class="missions-inline-drop">' . $input_friday_duration_minute . '</span>';
        ?></div>
	</td></tr>
</table>
<table class="mission-post-table-day" style="display:none;" id="weekend-button-section">
	<tr><td>
	</td></tr>
	<tr><td>
		<?php echo $weekend_button; ?>
	</td></tr>
	<tr><td>
		<?php echo $no_weekend_button; ?>
	</td></tr>
</table>
</br>
<span id="weekend-section">
	<noscript>
		<?php 
			echo elgg_view('missions/weekend');
		?>
	</noscript>
</span>

<script>
	document.getElementById("weekend-button-section").style.display = "inline-block";

	function set_weekend() {
		var section = "#weekend-section";
		
		elgg.get('ajax/view/missions/weekend', {
			success: function(result, success, xhr) {
				$(section).html(result);
			}
		});
	}

	function unset_weekend() {
		var section = "#weekend-section";
		$(section).html("");
	}
</script>