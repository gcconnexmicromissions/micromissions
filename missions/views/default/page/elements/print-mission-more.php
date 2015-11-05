<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */	
	 
	/*
	 * This view  displays the full scope of metadata attached to mission objects.
	 * This view extends the print-mission view element.
	 */
	$mission = '';
	$full_view = '';
	if(isset($vars['entity'])) {
		$mission = $vars['entity'];
	}
	if(isset($vars['full_view'])) {
		$full_view = $vars['full_view'];
	}
	
	// Generates the content of the lesser view before we append the rest of the data to it.
	echo elgg_view('page/elements/print-mission', array(
			'entity' => $mission,
			'full_view' => $full_view,
	));
	
	// 
	$clean_phone = elgg_echo('missions:none_given');
	$clean_security = elgg_echo('missions:none_required');
	$clean_skills = elgg_echo('missions:none_given');
	if(!empty($mission->phone)) {
		$clean_phone = $mission->phone;
	}
	if(!empty($mission->security)) {
		$clean_security = $mission->security;
	}
	if(!empty($mission->key_skills)) {
		$clean_skills = $mission->key_skills;
	}
	
	// Unpacks all language and time metadata attached to the mission.
	$unpacked_array = mm_unpack_mission($mission);
	
	// Sets up the display for language metadata.
	$unpacked_language = '';
	if(!empty($unpacked_array['lwc_english']) || !empty($unpacked_array['lwc_french'])) {
		$unpacked_language .= '<h3>' . elgg_echo('missions:written_comprehension') . ':</h3>';
		if(!empty($unpacked_array['lwc_english'])) {
			$unpacked_language .= '<span>' . elgg_echo('missions:english') . ' (' . $unpacked_array['lwc_english'] . ')</span>';
		}
		if(!empty($unpacked_array['lwc_french'])) {
			$unpacked_language .= '<span>' . elgg_echo('missions:french') . ' (' . $unpacked_array['lwc_french'] . ')</span>';
		}
		$unpacked_language .= '</br>';
	}
	if(!empty($unpacked_array['lwe_english']) || !empty($unpacked_array['lwe_french'])) {
		$unpacked_language .= '<h3>' . elgg_echo('missions:written_expression') . ':</h3>';
		if(!empty($unpacked_array['lwe_english'])) {
			$unpacked_language .= '<span>' . elgg_echo('missions:english') . ' (' . $unpacked_array['lwe_english'] . ')</span>';
		}
		if(!empty($unpacked_array['lwe_french'])) {
			$unpacked_language .= '<span>' . elgg_echo('missions:french') . ' (' . $unpacked_array['lwe_french'] . ')</span>';
		}
		$unpacked_language .= '</br>';
	}
	if(!empty($unpacked_array['lop_english']) || !empty($unpacked_array['lop_french'])) {
		$unpacked_language .= '<h3>' . elgg_echo('missions:oral_proficiency') . ':</h3>';
		if(!empty($unpacked_array['lop_english'])) {
			$unpacked_language .= '<span>' . elgg_echo('missions:english') . ' (' . $unpacked_array['lop_english'] . ')</span>';
		}
		if(!empty($unpacked_array['lop_french'])) {
			$unpacked_language .= '<span>' . elgg_echo('missions:french') . ' (' . $unpacked_array['lop_french'] . ')</span>';
		}
		$unpacked_language .= '</br>';
	}
	if(empty($unpacked_language)) {
		$unpacked_language = elgg_echo('missions:none_required');
	}
	
	// Sets up the display for time metadata.
	$unpacked_time = '';
	if(!empty($unpacked_array['mon_start_hour'])) {
		$unpacked_time .= '<h3>' . elgg_echo('missions:mon') . ':</h3>';
		$unpacked_time .= '<span>' . $unpacked_array['mon_start_hour'] . ':' . $unpacked_array['mon_start_min'] . '</span>';
		$unpacked_time .= elgg_echo('missions:to');
		$unpacked_time .= '<span>' . $unpacked_array['mon_end_hour'] . ':' . $unpacked_array['mon_end_min'] . '</span></br>';
	}
	if(!empty($unpacked_array['tue_start_hour'])) {
		$unpacked_time .= '<h3>' . elgg_echo('missions:tue') . ':</h3>';
		$unpacked_time .= '<span>' . $unpacked_array['tue_start_hour'] . ':' . $unpacked_array['tue_start_min'] . '</span>';
		$unpacked_time .= elgg_echo('missions:to');
		$unpacked_time .= '<span>' . $unpacked_array['tue_end_hour'] . ':' . $unpacked_array['tue_end_min'] . '</span></br>';
	}
	if(!empty($unpacked_array['wed_start_hour'])) {
		$unpacked_time .= '<h3>' . elgg_echo('missions:wed') . ':</h3>';
		$unpacked_time .= '<span>' . $unpacked_array['wed_start_hour'] . ':' . $unpacked_array['wed_start_min'] . '</span>';
		$unpacked_time .= elgg_echo('missions:to');
		$unpacked_time .= '<span>' . $unpacked_array['wed_end_hour'] . ':' . $unpacked_array['wed_end_min'] . '</span></br>';
	}
	if(!empty($unpacked_array['thu_start_hour'])) {
		$unpacked_time .= '<h3>' . elgg_echo('missions:thu') . ':</h3>';
		$unpacked_time .= '<span>' . $unpacked_array['thu_start_hour'] . ':' . $unpacked_array['thu_start_min'] . '</span>';
		$unpacked_time .= elgg_echo('missions:to');
		$unpacked_time .= '<span>' . $unpacked_array['thu_end_hour'] . ':' . $unpacked_array['thu_end_min'] . '</span></br>';
	}
	if(!empty($unpacked_array['fri_start_hour'])) {
		$unpacked_time .= '<h3>' . elgg_echo('missions:fri') . ':</h3>';
		$unpacked_time .= '<span>' . $unpacked_array['fri_start_hour'] . ':' . $unpacked_array['fri_start_min'] . '</span>';
		$unpacked_time .= elgg_echo('missions:to');
		$unpacked_time .= '<span>' . $unpacked_array['fri_end_hour'] . ':' . $unpacked_array['fri_end_min'] . '</span></br>';
	}
	if(!empty($unpacked_array['sat_start_hour'])) {
		$unpacked_time .= '<h3>' . elgg_echo('missions:sat') . ':</h3>';
		$unpacked_time .= '<span>' . $unpacked_array['sat_start_hour'] . ':' . $unpacked_array['sat_start_min'] . '</span>';
		$unpacked_time .= elgg_echo('missions:to');
		$unpacked_time .= '<span>' . $unpacked_array['sat_end_hour'] . ':' . $unpacked_array['sat_end_min'] . '</span></br>';
	}
	if(!empty($unpacked_array['sun_start_hour'])) {
		$unpacked_time .= '<h3>' . elgg_echo('missions:sun') . ':</h3>';
		$unpacked_time .= '<span>' . $unpacked_array['sun_start_hour'] . ':' . $unpacked_array['sun_start_min'] . '</span>';
		$unpacked_time .= elgg_echo('missions:to');
		$unpacked_time .= '<span>' . $unpacked_array['sun_end_hour'] . ':' . $unpacked_array['sun_end_min'] . '</span></br>';
	}
	if(empty($unpacked_time)) {
		$unpacked_time = elgg_echo('missions:none_required');
	}
	
	$clean_timezone = '';
	if(!empty($mission->timezone)) {
		$clean_timezone .= '<h3>' . elgg_echo('missions:timezone') . ': </h3>' . $mission->timezone . '</br>';
	}
	
	// Creates a set of buttons for the bottom of the view.
	$button_set = mm_create_button_set($mission);
?>

<div class="mission-printer mission-more">
	<table class="long-table">
		<tr>
			<td>
				<h3><?php echo elgg_echo('missions:manager_name')  . ':';?></h3> 
				<?php echo $mission->name;?>
			</td>
			<td>
				<h3><?php echo elgg_echo('missions:opportunity_number')  . ':';?></h3> 
				<?php echo $mission->number;?>
			</td>
		</tr>
		<tr>
			<td>
				<h3><?php echo elgg_echo('missions:department')  . ':';?></h3> 
				<?php echo $mission->department;?>
			</td>
			<td>
				<h3><?php echo elgg_echo('missions:ideal_start_date') . ':';?></h3> 
				<?php echo $mission->start_date;?>
			</td>
		</tr>
		<tr>
			<td>
				<h3><?php echo elgg_echo('missions:manager_email') . ':';?></h3> 
				<?php echo $mission->email;?>
			</td>
			<td>
				<h3><?php echo elgg_echo('missions:ideal_completion_date') . ':';?></h3> 
				<?php echo $mission->completion_date;?>
			</td>
		</tr>
		<tr>
			<td>
				<h3><?php echo elgg_echo('missions:your_phone') . ':';?></h3> 
				<?php echo $clean_phone;?>
			</td>
			<td>
				<h3><?php echo elgg_echo('missions:opportunity_location') . ':';?></h3> 
				<?php echo $mission->location;?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<h3><?php echo elgg_echo('missions:security_level') . ':';?></h3> 
				<?php echo $clean_security;?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<h3><?php echo elgg_echo('missions:key_skills_opportunity') . ':';?></h3> 
				<?php echo $clean_skills;?>
			</td>
		</tr>
	</table>
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
			foreach($button_set as $value) {
				echo $value;
			}
		?>
	</div>
</div>