<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */

	// Name and value of the dropdown box which called this view.
	// The dropdown name indicates which row is being modified.
	$dropdown_name = $vars['caller_name'];
	$dropdown_value = $vars['caller_value'];
	
	$content = '';
	$append = '';
	$array_sec = explode(',', elgg_get_plugin_setting('security_string', 'missions'));
	$array_lang = explode(',', elgg_get_plugin_setting('language_string', 'missions'));
	$array_day = explode(',', elgg_get_plugin_setting('day_string', 'missions'));
	$array_hour = explode(',', elgg_get_plugin_setting('hour_string', 'missions'));
	$array_min = explode(',', elgg_get_plugin_setting('minute_string', 'missions'));
	
	// Builds input field content depending on what type the user selected.
	switch($dropdown_value) {
		case '':
			break;
		case elgg_echo('missions:time'):
			$content .= elgg_view('input/dropdown', array(
					'name' => $dropdown_name . '_element',
					'value' => elgg_echo('missions:mon'),
					'options' => $array_day,
					'class' => 'advanced-element'
			));
			$content .= '</br>';
			$content .= elgg_view('input/dropdown', array(
					'name' => $dropdown_name . '_element_bound',
					'value' => elgg_echo('missions:start'),
					'options' => array(elgg_echo('missions:start'), elgg_echo('missions:end')),
					'class' => 'advanced-element'
			));
			$content .= elgg_view('input/dropdown', array(
					'name' => $dropdown_name . '_element_hour',
					'value' => '',
					'options' => $array_hour,
					'class' => 'advanced-element time-dropdown'
			));
			$content .= '<span style="font-size:16pt;"> :</span>';
			$content .= elgg_view('input/dropdown', array(
					'name' => $dropdown_name . '_element_min',
					'value' => '',
					'options' => $array_min,
					'class' => 'advanced-element time-dropdown'
			));
			break;
		case elgg_echo('missions:language'):
			$content .= elgg_view('input/dropdown', array(
					'name' => $dropdown_name . '_element',
					'value' => elgg_echo('missions:english'),
					'options' => array(elgg_echo('missions:english'), elgg_echo('missions:french')),
					'class' => 'advanced-element'
			));
			$content .= '</br>';
			$content .= elgg_echo('missions:reading') . ':';
			$content .= elgg_view('input/dropdown', array(
					'name' => $dropdown_name . '_element_lwc',
					'value' => '',
					'options' => $array_lang,
					'class' => 'advanced-element language-dropdown'
			));
			$content .= elgg_echo('missions:writing') . ':';
			$content .= elgg_view('input/dropdown', array(
					'name' => $dropdown_name . '_element_lwe',
					'value' => '',
					'options' => $array_lang,
					'class' => 'advanced-element language-dropdown'
			));
			$content .= elgg_echo('missions:oral') . ':';
			$content .= elgg_view('input/dropdown', array(
					'name' => $dropdown_name . '_element_lop',
					'value' => '',
					'options' => $array_lang,
					'class' => 'advanced-element language-dropdown'
			));
			break;
		case elgg_echo('missions:security'):
			$content .= elgg_view('input/dropdown', array(
					'name' => $dropdown_name . '_element' . $append,
					'value' => '',
					'options' => $array_sec,
					'class' => 'advanced-element'
			));
			break;
		default:
			$content .= elgg_view('input/text', array(
				'name' => $dropdown_name . '_element',
				'value' => '',
				'class' => 'advanced-element'
			));
	}
	
	echo $content;