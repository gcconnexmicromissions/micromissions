<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	$language_name = get_input('sln');
	$language_written_comprehension = get_input('slwc');
	$language_written_expression = get_input('slwe');
	$language_oral_proficiency = get_input('slop');

	if (elgg_is_sticky_form('searchlanguagefill')) {
		extract(elgg_get_sticky_values('searchlanguagefill'));
		elgg_clear_sticky_form('searchlanguagefill');
	}
	
	$input_language = elgg_view('input/dropdown', array(
			'name' => 'language_name',
			'value' => elgg_echo('missions:english'),
			'options' => array(elgg_echo('missions:english'), elgg_echo('missions:french'))
	));
?>

<div>
	<table class="mission-post-table">
		<tr>
			<td class="mission-post-table-lefty">
				<label><?php echo elgg_echo('missions:language') . ':';?></label><br />
			</td>
			<td class="mission-post-table-righty"> <div>
				<?php echo $input_language; ?>
			</div> </td>
		</tr>
	</table>
	</br>
	<div>
		<?php 
			echo elgg_view('page/elements/language-dropdown-single', $vars);
		?>
	</div>
	</br>
</div>

<div class="form-button"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:next'))); ?> </div>