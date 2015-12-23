<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Name and value of the dropdown box which called this view.
 * The dropdown name indicates which row is being modified.
 */
$dropdown_name = $vars['caller_name'];
$dropdown_value = $vars['caller_value'];
$further = $vars['caller_further'];

$content = '';
$append = '';
$array_sec = explode(',', elgg_get_plugin_setting('security_string', 'missions'));
$array_lang = explode(',', elgg_get_plugin_setting('language_string', 'missions'));
$array_day = explode(',', elgg_get_plugin_setting('day_string', 'missions'));
$array_hour = explode(',', elgg_get_plugin_setting('hour_string', 'missions'));
$array_min = explode(',', elgg_get_plugin_setting('minute_string', 'missions'));
$array_duration = explode(',', elgg_get_plugin_setting('duration_string', 'missions'));

// Builds input field content depending on what type the user selected.
// This handles input fields for mission and candidate searching.
if($further == 'true') {
    switch ($dropdown_value) {
        case elgg_echo('missions:publication_date'):
        	$content .= '<span class="missions-inline-drop">';
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_operand',
                'value' => '=',
                'options' => array('=', '>=', '<='),
                'class' => 'advanced-element'
            ));
            $content .= '</span>';
            $content .= '<span class="missions-inline-drop">';
            $content .= elgg_view('input/date', array(
                'name' => $dropdown_name . '_value',
                'value' => '',
                'class' => 'advanced-element'
            ));
            $content .= '</span>';
            break;
            
        case elgg_echo('missions:end_year'):
        	$content .= '<span class="missions-inline-drop">';
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_operand',
                'value' => '=',
                'options' => array('=', '>=', '<='),
                'class' => 'advanced-element'
            ));
            $content .= '</span>';
            
        default:
        	$content .= '<span class="missions-inline-drop">';
            $content .= elgg_view('input/text', array(
                'name' => $dropdown_name . '_value',
                'value' => '',
                'class' => 'advanced-element'
            ));
            $content .= '</span>';
            break;
    }
}
else {
    switch ($dropdown_value) {
        case '':
            break;
        
        case elgg_echo('missions:portfolio'):
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element',
                'value' => '',
                'options' => array('', elgg_echo('missions:title')/*, elgg_echo('missions:publication_date')*/),
                'class' => 'advanced-element',
                'onchange' => 'element_switch(this)'
            ));
            break;
            
        case elgg_echo('missions:education'):
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element',
                'value' => '',
                'options' => array('', elgg_echo('missions:title'), elgg_echo('missions:degree'), elgg_echo('missions:field'), elgg_echo('missions:end_year')),
                'class' => 'advanced-element',
                'onchange' => 'element_switch(this)'
            ));
            break;
            
        case elgg_echo('missions:experience'):
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element',
                'value' => '',
                'options' => array('', elgg_echo('missions:title'), elgg_echo('missions:organization'), elgg_echo('missions:end_year')),
                'class' => 'advanced-element',
                'onchange' => 'element_switch(this)'
            ));
            break;
        
        case elgg_echo('missions:duration'):
        case elgg_echo('missions:time'):
            if($dropdown_value == elgg_echo('missions:time')) {
                $time_or_duration = $array_hour;
            }
            if($dropdown_value == elgg_echo('missions:duration')) {
                $time_or_duration = $array_duration;
            }
            
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element',
                'value' => elgg_echo('missions:mon'),
                'options' => $array_day,
                'class' => 'advanced-element'
            ));
            $content .= '</br>';
            $content .= '<span class="missions-inline-drop">';
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element_hour',
                'value' => '',
                'options' => $time_or_duration,
                'class' => 'advanced-element time-dropdown'
            ));
            $content .= '</span>';
            $content .= '<span style="font-size:16pt;"> :</span>';
            $content .= '<span class="missions-inline-drop">';
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element_min',
                'value' => '',
                'options' => $array_min,
                'class' => 'advanced-element time-dropdown'
            ));
            $content .= '</span>';
            break;
        
        case elgg_echo('missions:language'):
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element',
                'value' => elgg_echo('missions:english'),
                'options' => array(
                    elgg_echo('missions:english'),
                    elgg_echo('missions:french')
                ),
                'class' => 'advanced-element'
            ));
            $content .= '</br>';
            $content .= elgg_echo('missions:reading') . ':';
            $content .= '<span class="missions-inline-drop">';
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element_lwc',
                'value' => '',
                'options' => $array_lang,
                'class' => 'advanced-element language-dropdown'
            ));
            $content .= '</span>';
            $content .= elgg_echo('missions:writing') . ':';
            $content .= '<span class="missions-inline-drop">';
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element_lwe',
                'value' => '',
                'options' => $array_lang,
                'class' => 'advanced-element language-dropdown'
            ));
            $content .= '</span>';
            $content .= elgg_echo('missions:oral') . ':';
            $content .= '<span class="missions-inline-drop">';
            $content .= elgg_view('input/dropdown', array(
                'name' => $dropdown_name . '_element_lop',
                'value' => '',
                'options' => $array_lang,
                'class' => 'advanced-element language-dropdown'
            ));
            $content .= '</span>';
            break;
        
        case elgg_echo('missions:security_clearance'):
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
}

echo $content;