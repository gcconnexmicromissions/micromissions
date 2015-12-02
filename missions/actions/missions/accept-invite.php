<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$applicant = get_user(get_input('applicant'));
$mission = get_entity(get_input('mission'));
$manager = get_user($mission->owner_guid);

$err = '';

$relationships = elgg_get_entities_from_relationship(array(
        'relationship' => 'mission_tentative',
        'relationship_guid' => $mission->guid
    ));
 
$target = '';
foreach($relationships as $relationship) {
    if($relationship->guid_two == $applicant_guid) {
        $target = $relationship;
    }
}

if($target == '') {
    $err .= elgg_echo('missions:error:no_longer_invited');
}
else {
    remove_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid);
    
    if($mission == '') {
        $err .= elgg_echo('missions:error:entity_does_not_exist');
    }
    else {
        $relationship_count = elgg_get_entities_from_relationship(array(
            'relationship' => 'mission_accepted',
            'relationship_guid' => $mission->guid,
            'count' => true
        ));
    
        if($relationship_count >= $mission->number) {
            $err .= elgg_echo('missions:error:mission_full');
        }
        else {
            add_entity_relationship($mission->guid, 'mission_accepted', $applicant->guid);
    
            $mission_link = elgg_view('output/url', array(
                'href' => $mission->getURL(),
                'text' => $mission->title
            ));
    
            $subject = $applicant->name . elgg_echo('missions:accepts_invitation', array(), $manager->language);
            $body = $applicant->name . elgg_echo('missions:accepts_invitation_more', array(), $manager->language) . $mission_link . '.';
            notify_user($manager->guid, $applicant->guid, $subject, $body);
        }
    }
}

if ($err != '') {
    register_error($err);
}
forward(elgg_get_site_url() . 'messages/inbox/' . $applicant->username);