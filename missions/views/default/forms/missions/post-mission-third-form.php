<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	$flexibility = get_input('tt');
	$remotely = get_input('tr');
	$location = get_input('tl');
	$security = get_input('ts');
	
	if (elgg_is_sticky_form('thirdfill')) {
		extract(elgg_get_sticky_values('thirdfill'));
		//elgg_clear_sticky_form('thirdfill');
	}
	
	$input_flexibility = elgg_view('input/radio', array(
							'name' => 'flexibility',
							'value' => $flexibility,
							'options' => array(elgg_echo('missions:flexible') => 'flexible', elgg_echo('missions:specific') => 'specific'),
					));
	$input_remotely = elgg_view('input/checkbox', array(
							'name' => 'remotely',
							'value' => $remotely,
					));
	$input_location = elgg_view('input/text', array(
							'name' => 'location',
							'value' => $location,
					));
	$input_security = elgg_view('input/dropdown', array(
							'name' => 'security',
							'value' => $security,
							'options' => explode(',', elgg_get_plugin_setting('security_string', 'missions')),
					));
	$input_timezone = elgg_view('input/dropdown', array(
							'name' => 'timezone',
							'value' => $timezone,
							'options' => explode(',', elgg_get_plugin_setting('timezone_string', 'missions'))
					));
?>

<div>
	<table class="mission-post-table">
		<tr>
			<td class="mission-post-table-lefty">
				<label><?php echo elgg_echo('missions:time_commitment') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty"> <div>
				<?php echo $input_flexibility; ?>
			</div> </td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty">
				<label><?php echo elgg_echo('missions:timezone') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty"> <div>
				<?php echo $input_timezone; ?>
			</div> </td>
		</tr>
		<tr>
			<td colspan="2">
				<?php
					echo elgg_view('page/elements/time-table', $vars);
				?>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty">
				<label><?php echo elgg_echo('missions:work_remotely') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty"> <div>
				<?php echo $input_remotely; ?>
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
	<br>
	<div>
		<?php 
			echo elgg_view('page/elements/language-dropdown', $vars);
		?>
	</div>
</div>

<div class="form-button"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:next'))); ?> </div>