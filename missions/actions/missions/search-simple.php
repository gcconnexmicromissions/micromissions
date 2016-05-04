<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
elgg_make_sticky_form('searchsimplefill');

$err = '';
$search_form = elgg_get_sticky_values('searchsimplefill');

// Currently no error checking is being done for the search form
if ($err != '') {
    register_error($err);
    forward(REFERER);
} else {
    $array = array();
    
    switch($_SESSION['mission_search_switch']) {
        case 'candidate':
            // A multipurpose query which will be applied to skills, experience and education objects.
            if (! empty($search_form['simple'])) {
            	$string_to_array = explode(',', str_replace(', ', ',', $search_form['simple']));
            	
            	foreach($string_to_array as $key => $value) {
            		$array[$key] = array(
		                    'name' => 'title',
		                    'operand' => 'LIKE',
		                    'value' => '%' . $value . '%',
	                		'case_sensitive' => false
	                );
            	}
            }
            
            $returned = mm_search_candidate_database($array, 'OR', $search_form['limit']);
            break;
        default:
            // A broad range search which determines whether the input text exists within the title, type or description of the mission.
            if (! empty($search_form['simple'])) {
                $array[0] = array(
                    'name' => 'job_title',
                    'operand' => 'LIKE',
                    'value' => '%' . $search_form['simple'] . '%'
                );
                $array[1] = array(
                    'name' => 'job_type',
                    'operand' => 'LIKE',
                    'value' => '%' . $search_form['simple'] . '%'
                );
                $array[2] = array(
                    'name' => 'descriptor',
                    'operand' => 'LIKE',
                    'value' => '%' . $search_form['simple'] . '%'
                );
            }
            
            // This function executes the query and returns true or false depending on how succesful that query was.
            $returned = mm_search_database($array, 'OR', $search_form['limit']);
    }
    
    if (! $returned) {
        forward(REFERER);
    } else {
        elgg_clear_sticky_form('searchsimplefill');
        if($search_form['hidden_return']) {
        	forward(REFERER);
        }
        forward(elgg_get_site_url() . 'missions/display-search-set');
    }
}