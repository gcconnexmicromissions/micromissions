<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
$current_uri = $_SERVER['REQUEST_URI'];
$exploded_uri = explode('/', $current_uri);
$current_guid = array_pop($exploded_uri);
$_SESSION['mid_act'] = $current_guid;

$mission = get_entity($current_guid);
//$applicant_list = $mission->applicant_list;
$applicant_list = get_entity_relationships($mission->guid);

/*if (! is_array($applicants_list)) {
    $storage_temp = $applicant_list;
    $applicant_list = array();
    $applicant_list[0] = $storage_temp;
}*/

// Creates a set of input field equal to the number of opportunities.
for ($i = 0; $i < $mission->number; $i ++) {
    $applicant = '';
    echo '<label for="fill-mission-applicant-' . $i . '-text-input" class="mission-emphasis-extra">' . elgg_echo('missions:applicant') . ' ' . ($i + 1) . ': </label>';
    if($applicant_list[$i]->relationship == 'mission_accepted'){
        $applicant = get_user($applicant_list[$i]->guid_two);
    }
    $readonly = false;
    if($applicant) {
        $readonly = true;
    }
    echo elgg_view('input/text', array(
        'name' => 'applicant_' . $i,
        'value' => $applicant->username,
        'class' => 'advanced-text-email',
        'readonly' => $readonly,
        'id' => 'fill-mission-applicant-' . $i . '-text-input'
    ));
    if($readonly) {
        echo elgg_view('output/url', array(
            'href' => elgg_get_site_url() . 'action/missions/remove-applicant?mission_applicant=' . $applicant->guid,
            'text' => elgg_echo('missions:remove'),
            'is_action' => true,
            'class' => 'elgg-button'
        ));
    }
}
?>

<div class="form-button"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:add'))); ?> </div>