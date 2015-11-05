<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	$array_day = explode(',', elgg_get_plugin_setting('day_string', 'missions'));

	$day = get_input('sd');
	$start_hour = get_input('ssh');
	$start_min = get_input('ssm');
	$end_hour = get_input('seh');
	$end_min = get_input('sem');
	
	if (elgg_is_sticky_form('searchtimefill')) {
		extract(elgg_get_sticky_values('searchtimefill'));
		elgg_clear_sticky_form('searchtimefill');
	}
	
	$input_day = elgg_view('input/dropdown', array(
			'name' => 'day',
			'value' => elgg_echo('missions:monday'),
			'options' => $array_day
	));
?>

<div>
	<table class="mission-post-table">
		<tr>
			<td class="mission-post-table-lefty">
				<label><?php echo elgg_echo('missions:day') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty"> <div>
				<?php echo $input_day; ?>
			</div> </td>
		</tr>
		<tr>
			<td colspan="2"> <div>
				<?php echo elgg_view('page/elements/time-table-day', $vars); ?>
			</div> </td>
		</tr>
	</table>
</div>

<div class="form-button"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:next'))); ?> </div>