<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Handles the call to the database using elgg_get_entities_from_metadata.
 * Sets the resulting array and count of the array to SESSION variables if the count is not 0.
 * Also handles intersecting with any array that currently exists within SESSION.
 */
function mm_search_database($query_array, $query_operand, $refinement)
{
    $options = array();
    $mission_count = '';
    $missions = '';

    $filtered_array = array_filter($query_array);
    if (empty($filtered_array)) {
        register_error(elgg_echo('missions:error:no_search_values'));
        return false;
    }

    // Setting options with which the query will be built.
    $options['type'] = 'object';
    $options['subtype'] = 'mission';
    $options['metadata_name_value_pairs'] = $filtered_array;
    $options['metadata_name_value_pairs_operator'] = $query_operand;
    $options['metadata_case_sensitive'] = false;
    $options['limit'] = elgg_get_plugin_setting('search_limit', 'missions');
    $missions = elgg_get_entities_from_metadata($options);

    // Deprecated merge logic
    /*
     * if(is_array($minute_clause)) {
     * $options['metadata_name_value_pairs'] = $minute_clause;
     * $missions_clause = elgg_get_entities_from_metadata($options);
     * $missions = array_merge($missions, $missions_clause);
     * }
    */

    // Compares mission guids and keeps those that appear in both arrays.
    if ($refinement && ! empty($_SESSION['mission_search_set'])) {
        $missions = array_uintersect($missions, $_SESSION['mission_search_set'], 'mm_compare_guid');
    }

    $mission_count = count($missions);

    if ($mission_count == 0) {
        register_error(elgg_echo('missions:error:entity_does_not_exist'));
        return false;
    } else {
        $_SESSION['mission_count'] = $mission_count;
        $_SESSION['mission_search_set'] = $missions;

        return true;
    }
}

/*
 * Small function to compare missions according to their guid.
 */
function mm_compare_guid($a, $b)
{
    if ($a->guid == $b->guid) {
        return 0;
    }
    if ($a->guid > $b->guid) {
        return 1;
    }
    return - 1;
}

/*
 * Analyzes the selection values and selection element values in order to construct a WHERE statement.
 * This is for when Javascript is enabled.
 */
function mm_analyze_selection($place, $array)
{
    $returner = array();

    switch ($array['selection_' . $place]) {
        // Returns an empty array if
        case '':
            break;
            
        case elgg_echo('missions:portfolio'):
            if($array['selection_' . $place . '_element_value'] != '') {
                $name_option = '';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element_value'] . '%';
                switch($array['selection_' . $place . '_element']) {
                    case elgg_echo('missions:title'):
                        $name_option = 'title';
                        break;
                    case elgg_echo('missions:end_year'):
                        $name_option = 'pubdate';
                        $operand_option = $array['selection_' . $place . '_element_operand'];
                        $value_option = $array['selection_' . $place . '_element_value'];
                        break;
                }
                $returner['name'] = $name_option;
                $returner['operand'] = $operand_option;
                $returner['value'] = $value_option;
                $returner['extra_option'] = 'portfolio';
            }
            break;

        case elgg_echo('missions:skill'):
            if($array['selection_' . $place . '_element'] != '') {
                $returner['name'] = 'title';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
                $returner['extra_option'] = 'MySkill';
            }
            break;

        case elgg_echo('missions:experience'):
            if($array['selection_' . $place . '_element_value'] != '') {
                $name_option = '';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element_value'] . '%';
                switch($array['selection_' . $place . '_element']) {
                    case elgg_echo('missions:title'):
                        $name_option = 'title';
                        break;
                    case elgg_echo('missions:organization'):
                        $name_option = 'organization';
                        break;
                    case elgg_echo('missions:end_year'):
                        $name_option = 'endyear';
                        $operand_option = $array['selection_' . $place . '_element_operand'];
                        $value_option = $array['selection_' . $place . '_element_value'];
                        break;
                }
                $returner['name'] = $name_option;
                $returner['operand'] = $operand_option;
                $returner['value'] = $value_option;
                $returner['extra_option'] = 'experience';
            }
            break;

        case elgg_echo('missions:education'):
            if($array['selection_' . $place . '_element_value'] != '') {
                $name_option = '';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element_value'] . '%';
                switch($array['selection_' . $place . '_element']) {
                    case elgg_echo('missions:title'):
                        $name_option = 'title';
                        break;
                    case elgg_echo('missions:degree'):
                        $name_option = 'degree';
                        break;
                    case elgg_echo('missions:field'):
                        $name_option = 'field';
                        break;
                    case elgg_echo('missions:end_year'):
                        $name_option = 'endyear';
                        $operand_option = $array['selection_' . $place . '_element_operand'];
                        $value_option = $array['selection_' . $place . '_element_value'];
                        break;
                }
                $returner['name'] = $name_option;
                $returner['operand'] = $operand_option;
                $returner['value'] = $value_option;
                $returner['extra_option'] = 'education';
            }
            break;

        case elgg_echo('missions:duration'):
            if ($array['selection_' . $place . '_element_hour'] || $array['selection_' . $place . '_element_min']) {
                $name_option = '';
                // Selects which day will be searched.
                switch ($array['selection_' . $place . '_element']) {
                    case elgg_echo('missions:mon'):
                        $name_option = 'mon';
                        break;
                    case elgg_echo('missions:tue'):
                        $name_option = 'tue';
                        break;
                    case elgg_echo('missions:wed'):
                        $name_option = 'wed';
                        break;
                    case elgg_echo('missions:thu'):
                        $name_option = 'thu';
                        break;
                    case elgg_echo('missions:fri'):
                        $name_option = 'fri';
                        break;
                    case elgg_echo('missions:sat'):
                        $name_option = 'sat';
                        break;
                    case elgg_echo('missions:sun'):
                        $name_option = 'sun';
                        break;
                }
                $name_option .= '_duration';
                $operand_option = '<=';
                // Packs the input hour and time for comparison with the packed elements in the database.
                $option_value = mm_pack_time($array['selection_' . $place . '_element_hour'], $array['selection_' . $place . '_element_min'], $name_option);
                $returner['name'] = $name_option;
                $returner['operand'] = $operand_option;
                $returner['value'] = $option_value;
            }
            break;

        // Selects time element which requires packing.
        case elgg_echo('missions:time'):
            if ($array['selection_' . $place . '_element_hour'] != '') {
                $name_option = '';
                // Selects which day will be searched.
                switch ($array['selection_' . $place . '_element']) {
                    case elgg_echo('missions:mon'):
                        $name_option = 'mon';
                        break;
                    case elgg_echo('missions:tue'):
                        $name_option = 'tue';
                        break;
                    case elgg_echo('missions:wed'):
                        $name_option = 'wed';
                        break;
                    case elgg_echo('missions:thu'):
                        $name_option = 'thu';
                        break;
                    case elgg_echo('missions:fri'):
                        $name_option = 'fri';
                        break;
                    case elgg_echo('missions:sat'):
                        $name_option = 'sat';
                        break;
                    case elgg_echo('missions:sun'):
                        $name_option = 'sun';
                        break;
                }
                $name_option .= '_start';
                $operand_option = '>=';
                // Packs the input hour and time for comparison with the packed elements in the database.
                $option_value = mm_pack_time($array['selection_' . $place . '_element_hour'], $array['selection_' . $place . '_element_min'], $name_option);
                $returner['name'] = $name_option;
                $returner['operand'] = $operand_option;
                $returner['value'] = $option_value;
            }
            break;

            // Selects language element which requires packing.
        case elgg_echo('missions:language'):
            if ($array['selection_' . $place . '_element_lwc'] != '' || $array['selection_' . $place . '_element_lwe'] != '' || $array['selection_' . $place . '_element_lop'] != '') {
                $name_option = '';
                // Selects which language will be searched
                switch ($array['selection_' . $place . '_element']) {
                    case elgg_echo('missions:english'):
                        $name_option = 'english';
                        break;
                    case elgg_echo('missions:french'):
                        $name_option = 'french';
                        break;
                }
                // Packs the input written comprehension, written expression and oral proficiency for comparison with the packed elements in the database.
                $option_value = mm_pack_language($array['selection_' . $place . '_element_lwc'], $array['selection_' . $place . '_element_lwe'], $array['selection_' . $place . '_element_lop'], $name_option);
                $returner['name'] = $name_option;
                $returner['operand'] = '>=';
                $returner['value'] = $option_value;
            }
            break;

            // The next 3 are select elements that require a MySQL LIKE comparison.
        case elgg_echo('missions:key_skills'):
            if ($array['selection_' . $place . '_element'] != '') {
                $returner['name'] = 'key_skills';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
            }
            break;

        case elgg_echo('missions:location'):
            if ($array['selection_' . $place . '_element'] != '') {
                $returner['name'] = 'location';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
            }
            break;

        case elgg_echo('missions:type'):
            if ($array['selection_' . $place . '_element'] != '') {
                $returner['name'] = 'job_type';
                $returner['operand'] = 'LIKE';
                $returner['value'] = '%' . $array['selection_' . $place . '_element'] . '%';
            }
            break;

            // The next 3 are selects elements that require a direct equivalence comparison.
        case elgg_echo('missions:title'):
            if ($array['selection_' . $place . '_element'] != '') {
                $returner['name'] = 'job_title';
                $returner['value'] = $array['selection_' . $place . '_element'];
            }
            break;

        case elgg_echo('missions:security'):
            if ($array['selection_' . $place . '_element'] != '') {
                $returner['name'] = 'security';
                $returner['value'] = $array['selection_' . $place . '_element'];
            }
            break;

        case elgg_echo('missions:department'):
            if ($array['selection_' . $place . '_element'] != '') {
                $returner['name'] = 'department';
                $returner['value'] = $array['selection_' . $place . '_element'];
            }
            break;
    }

    return $returner;
}

/*
 * Analyzes the selection values and selection element values in order to construct a WHERE statement.
 * This is for when Javascript is disabled.
 */
function mm_analyze_backup($place, $array)
{
    $returner = array();

    $name_option = '';
    $operand_option = '';
    $value_option = '';
    $extra_option = '';

    // If the selection element has been chosen.
    if ($array['selection_' . $place] != '') {
        // Base operand and value.
        $operand_option = '=';
        $value_option = $array['backup_' . $place];
        // Modifies name, operand and/or value depending on which selection element was chosen.
        switch ($array['selection_' . $place]) {
            case elgg_echo('missions:title'):
                $name_option = 'job_title';
                break;
            case elgg_echo('missions:type'):
                $name_option = 'job_type';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['backup_' . $place] . '%';
                break;
            case elgg_echo('missions:department'):
                $name_option = 'department';
                break;
            case elgg_echo('missions:location'):
                $name_option = 'location';
                break;
            case elgg_echo('missions:key_skills'):
                $name_option = 'key_skills';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['backup_' . $place] . '%';
                break;
            case elgg_echo('missions:security'):
                $name_option = 'security';
                break;
                // In the language case, the value needs to have the format {language}{LWC}{LWE}{LOP}
            case elgg_echo('missions:language'):
                switch ($array['backup_' . $place]) {
                    case (strpos($array['backup_' . $place], 'english') !== false):
                        $name_option = 'english';
                        break;
                    case (strpos($array['backup_' . $place], 'french') !== false):
                        $name_option = 'french';
                        break;
                    default:
                        return array();
                }
                $operand_option = '>=';
                break;
                // In the time case, the value needs to have the format {day}_{start/end}{hour}:{min}
            case elgg_echo('missions:time'):
                switch ($array['backup_' . $place]) {
                    case (strpos($array['backup_' . $place], 'mon_start') !== false):
                        $name_option = 'mon_start';
                        break;
                    case (strpos($array['backup_' . $place], 'mon_duration') !== false):
                        $name_option = 'mon_duration';
                        break;
                    case (strpos($array['backup_' . $place], 'tue_start') !== false):
                        $name_option = 'tue_start';
                        break;
                    case (strpos($array['backup_' . $place], 'tue_duration') !== false):
                        $name_option = 'tue_duration';
                        break;
                    case (strpos($array['backup_' . $place], 'wed_start') !== false):
                        $name_option = 'wed_start';
                        break;
                    case (strpos($array['backup_' . $place], 'wed_duration') !== false):
                        $name_option = 'wed_duration';
                        break;
                    case (strpos($array['backup_' . $place], 'thu_start') !== false):
                        $name_option = 'thu_start';
                        break;
                    case (strpos($array['backup_' . $place], 'thu_duration') !== false):
                        $name_option = 'thu_duration';
                        break;
                    case (strpos($array['backup_' . $place], 'fri_start') !== false):
                        $name_option = 'fri_start';
                        break;
                    case (strpos($array['backup_' . $place], 'fri_duration') !== false):
                        $name_option = 'fri_duration';
                        break;
                    case (strpos($array['backup_' . $place], 'sat_start') !== false):
                        $name_option = 'sat_start';
                        break;
                    case (strpos($array['backup_' . $place], 'sat_duration') !== false):
                        $name_option = 'sat_duration';
                        break;
                    case (strpos($array['backup_' . $place], 'sun_start') !== false):
                        $name_option = 'sun_start';
                        break;
                    case (strpos($array['backup_' . $place], 'sun_duration') !== false):
                        $name_option = 'sun_duration';
                        break;
                    default:
                        return array();
                }
                switch ($array['backup_' . $place]) {
                    case (strpos($array['backup_' . $place], 'start') !== false):
                        $operand_option = '>=';
                        break;
                    case (strpos($array['backup_' . $place], 'duration') !== false):
                        $operand_option = '<=';
                        break;
                }
                break;
            case elgg_echo('missions:skill'):
                $name_option = 'title';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element'] . '%';
                $extra_option = 'MySkill';
                break;

            case elgg_echo('missions:experience'):
                $name_option = 'title';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element_value'] . '%';
                $extra_option = 'experience';
                break;

            case elgg_echo('missions:education'):
                $name_option = 'title';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element_value'] . '%';
                $extra_option = 'education';
                break;
            case elgg_echo('missions:portfolio'):
                $name_option = 'title';
                $operand_option = 'LIKE';
                $value_option = '%' . $array['selection_' . $place . '_element_value'] . '%';
                $extra_option = 'portfolio';
                break;
        }
        $returner['name'] = $name_option;
        $returner['operand'] = $operand_option;
        $returner['value'] = $value_option;
        $returner['extra_option'] = $extra_option;
    }

    return $returner;
}

/*
 * Basic search functionality for candidate searching.
 * Checks education, experience and skill attributes from user profiles.
 */
function mm_search_candidate_database($query_array, $query_operand)
{
    $options = array();

    $filtered_array = array_filter($query_array);
    if (empty($filtered_array)) {
        register_error(elgg_echo('missions:error:no_search_values'));
        return false;
    }

    // Setting options with which the query will be built.
    $options['type'] = 'object';
    $temp_string = 'INNER JOIN ' . elgg_get_config('dbprefix') . 'objects_entity g ON (g.guid = e.guid)';
    $options['joins'] = array($temp_string);
    $temp_string = "g." . $filtered_array[0]['name'] . " " . $filtered_array[0]['operand'] . " '" . $filtered_array[0]['value'] . "'";
    $options['wheres'] = array($temp_string);
    $options['limit'] = elgg_get_plugin_setting('search_limit', 'missions');
    $options['subtypes'] = array('education', 'experience', 'MySkill', 'portfolio');
    $entities = elgg_get_entities($options);

    $entity_owners = array();
    $search_feedback = array();
    $count = 0;
    foreach($entities as $entity) {
        $entity_owners[$count] = $entity->owner_guid;
        // Section for generating feedback which tells the user which search criteria the returned users met.
        if($entity->getSubtype() == 'education') {
            $identifier_string = elgg_echo('missions:school_name');
        }
        if($entity->getSubtype() == 'experience') {
            $identifier_string = elgg_echo('missions:job_title');
        }
        if($entity->getSubtype() == 'MySkill') {
            $identifier_string = elgg_echo('missions:skill');
        }
        if($entity->getSubtype() == 'portfolio') {
            $identifier_string = elgg_echo('missions:portfolio');
        }
        $search_feedback[$entity->owner_guid] .= $identifier_string . ': ' . $entity->title . ',';
        $count++;
    }

    $unique_owners = array_unique($entity_owners);

    // Turns the array of user GUIDs into an array of user objects.
    $count = 0;
    $unique_owners_entity = array();
    foreach($unique_owners as $unique_owner) {
        $unique_owners_entity[$count] = get_user($unique_owner);
        $count++;
    }

    $candidate_count = count($unique_owners_entity);

    if ($candidate_count == 0) {
        register_error(elgg_echo('missions:error:candidate_does_not_exist'));
        return false;
    } else {
        $_SESSION['candidate_count'] = $candidate_count;
        $_SESSION['candidate_search_set'] = $unique_owners_entity;
        $_SESSION['candidate_search_feedback'] = $search_feedback;

        return true;
    }
}

/*
 * Advanced search functionality for candidate searching.
 * Checks education, experience and skill attributes and metadata from user profiles.
 */
function mm_adv_search_candidate_database($query_array, $query_operand) {
    $users_returned_by_attribute = array();
    $users_returned_by_metadata = array();
    $users_returned_by_combo = array();
    $is_attribute_searched = false;
    $is_metadata_searched = false;
    $candidates = array();

    $filtered_array = array_filter($query_array);
    if (empty($filtered_array)) {
        register_error(elgg_echo('missions:error:no_search_values'));
        return false;
    }

    // Handles each query individually.
    foreach($filtered_array as $array) {
        // Handles the skill array setup.
        /*if($array['name-two'] != '') {
         $options_attribute['type'] = 'object';
         $options_attribute['subtype'] = 'MySkill';
         $options_attribute['joins'] = array('INNER JOIN ' . elgg_get_config('dbprefix') . 'objects_entity g ON (g.guid = e.guid)');
         $options_attribute['wheres'] = array("g." . $array['name'] . " " . $array['operand'] . " '" . $array['value'] . "'");
         $options_attribute['limit'] = elgg_get_plugin_setting('search_limit', 'missions');
         $entities = elgg_get_entities($options_attribute);

         $entity_owners = array();
         $count = 0;
         foreach($entities as $entity) {
         $entity_owners[$count] = $entity->owner_guid;
         }
         $entity_owners_first = array_unique($entity_owners);

         $options_attribute['type'] = 'object';
         $options_attribute['subtype'] = 'MySkill';
         $options_metadata['metadata_name_value_pairs'] = array('name' => $array['name'], 'operand' => $array['operand'], 'value' => $array['value']);
         $options_attribute['limit'] = elgg_get_plugin_setting('search_limit', 'missions');
         $entities = elgg_get_entities_from_metadata($options);

         $entity_owners = array();
         $count = 0;
         foreach($entities as $entity) {
         $entity_owners[$count] = $entity->owner_guid;
         }
         $entity_owners_second = array_unique($entity_owners);

         $entity_owners = array_intersect($entity_owners_first,  $entity_owners_second);
         $users_returned_by_combo = array_unique(array_merge($users_returned_by_combo, $entity_owners));
         }*/

        // Sets up an education and experience array search for title (not metadata).
        if($array['name'] == 'title') {
            $options_attribute['type'] = 'object';
            $options_attribute['subtypes'] = $array['extra_option'];
            $options_attribute['joins'] = array('INNER JOIN ' . elgg_get_config('dbprefix') . 'objects_entity g ON (g.guid = e.guid)');
            $options_attribute['wheres'] = array("g." . $array['name'] . " " . $array['operand'] . " '" . $array['value'] . "'");
            $options_attribute['limit'] = elgg_get_plugin_setting('search_limit', 'missions');
            $entities = elgg_get_entities($options_attribute);

            $entity_owners = array();
            $count = 0;
            foreach($entities as $entity) {
                $entity_owners[$count] = $entity->owner_guid;
                $count++;
            }

            // Adds the results of the query to a pool of results.
            if(empty($users_returned_by_attribute)) {
                $users_returned_by_attribute = array_unique($entity_owners);
            }
            else {
                $users_returned_by_attribute = array_unique(array_intersect($users_returned_by_attribute, $entity_owners));
            }
            // Notes that attributes have been searched during this function call.
            $is_attribute_searched = true;
        }

        // Sets up metadata serach.
        else {
            $operand_temp = htmlspecialchars_decode($array['operand']);
            
            $options_metadata['type'] = 'object';
            $options_metadata['subtypes'] = $array['extra_option'];
            $options_metadata['metadata_name_value_pairs'] = array(array('name' => $array['name'], 'operand' => $operand_temp, 'value' => $array['value']));
            $options_metadata['limit'] = elgg_get_plugin_setting('search_limit', 'missions');
            $options_metadata['metadata_case_sensitive'] = false;
            $entities = elgg_get_entities_from_metadata($options_metadata);

            $entity_owners = array();
            $count = 0;
            foreach($entities as $entity) {
                $entity_owners[$count] = $entity->owner_guid;
                $count++;
            }

            // Adds the results of the query to a pool of results.
            if(empty($users_returned_by_metadata)) {
                $users_returned_by_metadata = array_unique($entity_owners);
            }
            else {
                $users_returned_by_metadata = array_unique(array_intersect($users_returned_by_metadata, $entity_owners));
            }
            // Notes that metadata have been searched during this function call.
            $is_metadata_searched = true;
        }
    }

    /*if(!empty($users_returned_by_combo)) {
     if(!empty($users_returned_by_attribute)) {
     $candidates = array_intersect($users_returned_by_combo, $users_returned_by_attribute);
     if(!empty($users_returned_by_metadata)) {
     $candidates = array_intersect($candidates, $users_returned_by_metadata);
     }
     }
     elseif(!empty($users_returned_by_metadata)) {
     $candidates = array_intersect($users_returned_by_combo, $users_returned_by_metadata);
     }
     else {
     $candidates = $users_returned_by_combo;
     }
     }
     else if(!empty($users_returned_by_attribute)) {
     if(!empty($users_returned_by_metadata)) {
     $candidates = array_intersect($users_returned_by_attribute, $users_returned_by_metadata);
     }
     else {
     $candidates = $users_returned_by_attribute;
     }
     }
     else if(!empty($users_returned_by_metadata)) {
     $candidates = $users_returned_by_metadata;
     }*/

    // Intersects the results into a single pool.
    if($is_attribute_searched && $is_metadata_searched) {
        $candidates = array_intersect($users_returned_by_attribute, $users_returned_by_metadata);
    }
    // If only metadata or only attributes have been searched then intersection is unecessary.
    if($is_attribute_searched && !$is_metadata_searched) {
        $candidates = $users_returned_by_attribute;
    }
    if(!$is_attribute_searched && $is_metadata_searched) {
        $candidates = $users_returned_by_metadata;
    }

    // Turns an array of guids into an array of entities.
    $count = 0;
    $candidates_users = array();
    foreach($candidates as $candidate) {
        $candidates_users[$count] = get_user($candidate);
        $count++;
    }

    $candidate_count = count($candidates_users);

    if ($candidate_count == 0) {
        register_error(elgg_echo('missions:error:candidate_does_not_exist'));
        return false;
    } else {
        $_SESSION['candidate_count'] = $candidate_count;
        $_SESSION['candidate_search_set'] = $candidates_users;
        $_SESSION['candidate_search_feedback'] = '';

        return true;
    }
}