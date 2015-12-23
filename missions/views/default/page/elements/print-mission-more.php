<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This view displays the full scope of metadata attached to mission objects.
 * This view extends the print-mission view element.
 */
$mission = '';
$full_view = '';
if (isset($vars['entity'])) {
    $mission = $vars['entity'];
}
if (isset($vars['full_view'])) {
    $full_view = $vars['full_view'];
}

// Generates the content of the lesser view before we append the rest of the data to it.
echo elgg_view('page/elements/print-mission', array(
    'entity' => $mission,
    'full_view' => $full_view
));

//
$clean_phone = elgg_echo('missions:none_given');
$clean_security = elgg_echo('missions:none_required');
$clean_skills = elgg_echo('missions:none_given');
if (! empty($mission->phone)) {
    $clean_phone = $mission->phone;
}
if (! empty($mission->security)) {
    $clean_security = $mission->security;
}
if (! empty($mission->key_skills)) {
    $clean_skills = $mission->key_skills;
}

// Unpacks all language and time metadata attached to the mission.
$unpacked_array = mm_unpack_mission($mission);

// Sets up the display for language metadata.
$unpacked_language = '';
if (! empty($unpacked_array['lwc_english']) || ! empty($unpacked_array['lwc_french'])) {
    $unpacked_language .= '<span class="mission-emphasis">' . elgg_echo('missions:written_comprehension') . ':</span>';
    if (! empty($unpacked_array['lwc_english'])) {
        $unpacked_language .= '<span>' . elgg_echo('missions:formatted:english', array($unpacked_array['lwc_english'])) . '</span>';
    }
    if (! empty($unpacked_array['lwc_french'])) {
        $unpacked_language .= '<span>' . elgg_echo('missions:formatted:french', array($unpacked_array['lwc_french'])) . '</span>';
    }
    $unpacked_language .= '</br>';
}
if (! empty($unpacked_array['lwe_english']) || ! empty($unpacked_array['lwe_french'])) {
    $unpacked_language .= '<span class="mission-emphasis">' . elgg_echo('missions:written_expression') . ':</span>';
    if (! empty($unpacked_array['lwe_english'])) {
        $unpacked_language .= '<span>' . elgg_echo('missions:formatted:english', array($unpacked_array['lwe_english'])) . '</span>';
    }
    if (! empty($unpacked_array['lwe_french'])) {
        $unpacked_language .= '<span>' . elgg_echo('missions:formatted:french', array($unpacked_array['lwc_french'])) . '</span>';
    }
    $unpacked_language .= '</br>';
}
if (! empty($unpacked_array['lop_english']) || ! empty($unpacked_array['lop_french'])) {
    $unpacked_language .= '<span class="mission-emphasis">' . elgg_echo('missions:oral_proficiency') . ':</span>';
    if (! empty($unpacked_array['lop_english'])) {
        $unpacked_language .= '<span>' . elgg_echo('missions:formatted:english', array($unpacked_array['lop_english'])) . '</span>';
    }
    if (! empty($unpacked_array['lop_french'])) {
        $unpacked_language .= '<span>' . elgg_echo('missions:formatted:french', array($unpacked_array['lop_french'])) . '</span>';
    }
    $unpacked_language .= '</br>';
}
if (empty($unpacked_language)) {
    $unpacked_language = elgg_echo('missions:none_required');
}

// Sets up the display for time metadata.
$unpacked_time = '';
if (! empty($unpacked_array['mon_start_hour'])) {
    $unpacked_time .= '<span class="mission-emphasis">' . elgg_echo('missions:mon') . ':</span>';
    $unpacked_time .= '<span>' . elgg_echo('missions:formatted:time', array(
    		$unpacked_array['mon_start_hour'],
    		$unpacked_array['mon_start_min'],
    		$unpacked_array['mon_duration_hour'],
    		$unpacked_array['mon_duration_min']
    )) . '</span></br>';
}
if (! empty($unpacked_array['tue_start_hour'])) {
    $unpacked_time .= '<span class="mission-emphasis">' . elgg_echo('missions:tue') . ':</span>';
    $unpacked_time .= '<span>' . elgg_echo('missions:formatted:time', array(
    		$unpacked_array['tue_start_hour'],
    		$unpacked_array['tue_start_min'],
    		$unpacked_array['tue_duration_hour'],
    		$unpacked_array['tue_duration_min']
    )) . '</span></br>';
}
if (! empty($unpacked_array['wed_start_hour'])) {
    $unpacked_time .= '<span class="mission-emphasis">' . elgg_echo('missions:wed') . ':</span>';
    $unpacked_time .= '<span>' . elgg_echo('missions:formatted:time', array(
    		$unpacked_array['wed_start_hour'],
    		$unpacked_array['wed_start_min'],
    		$unpacked_array['wed_duration_hour'],
    		$unpacked_array['wed_duration_min']
    )) . '</span></br>';
}
if (! empty($unpacked_array['thu_start_hour'])) {
    $unpacked_time .= '<span class="mission-emphasis">' . elgg_echo('missions:thu') . ':</span>';
    $unpacked_time .= '<span>' . elgg_echo('missions:formatted:time', array(
    		$unpacked_array['thu_start_hour'],
    		$unpacked_array['thu_start_min'],
    		$unpacked_array['thu_duration_hour'],
    		$unpacked_array['thu_duration_min']
    )) . '</span></br>';
}
if (! empty($unpacked_array['fri_start_hour'])) {
    $unpacked_time .= '<span class="mission-emphasis">' . elgg_echo('missions:fri') . ':</span>';
    $unpacked_time .= '<span>' . elgg_echo('missions:formatted:time', array(
    		$unpacked_array['fri_start_hour'],
    		$unpacked_array['fri_start_min'],
    		$unpacked_array['fri_duration_hour'],
    		$unpacked_array['fri_duration_min']
    )) . '</span></br>';
}
if (! empty($unpacked_array['sat_start_hour'])) {
    $unpacked_time .= '<span class="mission-emphasis">' . elgg_echo('missions:sat') . ':</span>';
    $unpacked_time .= '<span>' . elgg_echo('missions:formatted:time', array(
    		$unpacked_array['sat_start_hour'],
    		$unpacked_array['sat_start_min'],
    		$unpacked_array['sat_duration_hour'],
    		$unpacked_array['sat_duration_min']
    )) . '</span></br>';
}
if (! empty($unpacked_array['sun_start_hour'])) {
    $unpacked_time .= '<span class="mission-emphasis">' . elgg_echo('missions:sun') . ':</span>';
    $unpacked_time .= '<span>' . elgg_echo('missions:formatted:time', array(
    		$unpacked_array['sun_start_hour'],
    		$unpacked_array['sun_start_min'],
    		$unpacked_array['sun_duration_hour'],
    		$unpacked_array['sun_duration_min']
    )) . '</span></br>';
}
if (empty($unpacked_time)) {
    $unpacked_time = elgg_echo('missions:none_required');
}

$clean_timezone = '';
if (! empty($mission->timezone)) {
    $clean_timezone .= '<h3>' . elgg_echo('missions:timezone') . ': </h3>' . $mission->timezone . '</br>';
}

// Creates a set of buttons for the bottom of the view.
if(!$vars['override_buttons']) {
    $button_set = mm_create_button_set($mission, true);
}
?>

<div class="mission-printer mission-more">
	<div>
		<h3><?php echo elgg_echo('missions:manager_name')  . ':';?></h3> 
		<?php echo $mission->name;?></br>
		<h3><?php echo elgg_echo('missions:department')  . ':';?></h3> 
		<?php echo $mission->department;?></br>
		<h3><?php echo elgg_echo('missions:manager_email') . ':';?></h3> 
		<?php echo $mission->email;?></br>
		<h3><?php echo elgg_echo('missions:your_phone') . ':';?></h3> 
		<?php echo $clean_phone;?>
	</div>
	</br>
	<div>
		<h3><?php echo elgg_echo('missions:opportunity_number')  . ':';?></h3> 
		<?php echo $mission->number;?></br>
		<h3><?php echo elgg_echo('missions:ideal_start_date') . ':';?></h3> 
		<?php echo $mission->start_date;?></br>
		<h3><?php echo elgg_echo('missions:ideal_completion_date') . ':';?></h3> 
		<?php echo $mission->completion_date;?></br>
		<h3><?php echo elgg_echo('missions:opportunity_location') . ':';?></h3> 
		<?php echo $mission->location;?></br>
		<h3><?php echo elgg_echo('missions:security_level') . ':';?></h3> 
		<?php echo $clean_security;?></br>
		<h3><?php echo elgg_echo('missions:key_skills_opportunity') . ':';?></h3> 
		<?php echo $clean_skills;?></br>
	</div>
	</br>
	<div>
		<h3><?php echo elgg_echo('missions:language_requirements') . ':</br>';?></h3>
		<?php echo $unpacked_language;?>
	</div>
	</br>
	<div>
		<?php echo $clean_timezone;?>
		<h3><?php echo elgg_echo('missions:scheduling_requirements') . ':</br>';?></h3>
		<?php echo $unpacked_time; ?>
	</div>
	<div>
		<?php
			foreach ($button_set as $value) {
			    echo $value;
			}
		?>
	</div>
</div>