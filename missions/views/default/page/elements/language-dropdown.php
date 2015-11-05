<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	 
	/*
	 * View which display 3 dropdown fields for each required language.
	 * The required languages are english and french and the dropdown fields represent written comprehension, written expression and oral proficiency.
	 * Values in the dropdownfields are extracted from the language_string found in settings.
	 */
	$array = explode(',', elgg_get_plugin_setting('language_string', 'missions'));

	$language_written_comprehension_english = get_input('ilwce');
	$language_written_comprehension_french = get_input('ilwcf');
	$language_written_expression_english = get_input('ilwee');
	$language_written_expression_french = get_input('ilwef');
	$language_oral_proficiency_english = get_input('ilope');
	$language_oral_proficiency_french = get_input('ilopf');
	
	if (elgg_is_sticky_form('ldropfill')) {
		extract(elgg_get_sticky_values('ldropfill'));
		//elgg_clear_sticky_form('thirdfill');
	}
	
	$input_english_written_comprehension = elgg_view('input/dropdown', array(
			'name' => 'lwc_english',
			'value' => $language_written_comprehension_english,
			'options' => $array,
			'class' => 'language-dropdown',
	));
	$input_french_written_comprehension = elgg_view('input/dropdown', array(
			'name' => 'lwc_french',
			'value' => $language_written_comprehension_french,
			'options' => $array,
			'class' => 'language-dropdown',
	));
	$input_english_written_expression = elgg_view('input/dropdown', array(
			'name' => 'lwe_english',
			'value' => $language_written_expression_english,
			'options' => $array,
			'class' => 'language-dropdown',
	));
	$input_french_written_expression = elgg_view('input/dropdown', array(
			'name' => 'lwe_french',
			'value' => $language_written_expression_french,
			'options' => $array,
			'class' => 'language-dropdown',
	));
	$input_english_oral_proficiency = elgg_view('input/dropdown', array(
			'name' => 'lop_english',
			'value' => $language_oral_proficiency_english,
			'options' => $array,
			'class' => 'language-dropdown',
	));
	$input_french_oral_proficiency = elgg_view('input/dropdown', array(
			'name' => 'lop_french',
			'value' => $language_oral_proficiency_french,
			'options' => $array,
			'class' => 'language-dropdown',
	));
?>

<table class="mission-post-table-two">
	<tr>
		<td class="mission-post-table-lefty">
			<label><?php echo elgg_echo('missions:language_requirements');?></label><br />
		</td>
		<td class="mission-post-table-center"> <div>
			<?php echo elgg_echo('missions:english');?>
		</div> </td>
		<td class="mission-post-table-center"> <div>
			<?php echo elgg_echo('missions:french');?>
		</div> </td>
	</tr>
	<tr>
		<td class="mission-post-table-lefty">
			<label><?php echo elgg_echo('missions:written_comprehension') . ':';?></label><br />
		</td>
		<td class="mission-post-table-center"> <div>
			<?php echo $input_english_written_comprehension; ?>
		</div> </td>
			<td class="mission-post-table-center"> <div>
			<?php echo $input_french_written_comprehension; ?>
		</div> </td>
	</tr>
	<tr>
		<td class="mission-post-table-lefty">
			<label><?php echo elgg_echo('missions:written_expression') . ':';?></label><br />
		</td>
		<td class="mission-post-table-center"> <div>
			<?php echo $input_english_written_expression; ?>
		</div> </td>
		<td class="mission-post-table-center"> <div>
			<?php echo $input_french_written_expression; ?>
		</div> </td>
	</tr>
	<tr>
		<td class="mission-post-table-lefty">
			<label><?php echo elgg_echo('missions:oral_proficiency') . ':';?></label><br />
		</td>
		<td class="mission-post-table-center"> <div>
			<?php echo $input_english_oral_proficiency; ?>
		</div> </td>
		<td class="mission-post-table-center"> <div>
			<?php echo $input_french_oral_proficiency; ?>
		</div> </td>
	</tr>
</table>