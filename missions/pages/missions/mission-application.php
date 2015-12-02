<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
gatekeeper();

$title = elgg_echo('missions:apply_to_mission');
$content = elgg_view_title($title);
$content .= elgg_echo('missions:application_paragraph');
$content .= elgg_view_form('missions/application-form', array(
    'class' => 'mission-form'
));

$body = elgg_view_layout('one_sidebar', array(
    'content' => $content
));

echo elgg_view_page($title, $body);