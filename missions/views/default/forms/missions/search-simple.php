<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	$simple = get_input('ss');
	
	if (elgg_is_sticky_form('searchsimplefill')) {
		extract(elgg_get_sticky_values('searchsimplefill'));
		elgg_clear_sticky_form('searchsimplefill');
	}
	
	$input_simple_text = elgg_view('input/text', array(
			'name' => 'simple',
			'value' => $simple,
	));
?>

<div>
	<table class="mission-post-table">
		<tr>
			<td class="mission-post-table-lefty">
				<?php echo $input_simple_text; ?>
			</td>
			<td class="mission-post-table-righty"> <div>
				<div class="form-button mission-search-simple-button" style="text-align:left;"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:search'))); ?> </div>
			</div> </td>
		</tr>
	</table>
</div>