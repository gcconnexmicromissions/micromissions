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
$email_body = get_input('eb');

if (elgg_is_sticky_form('applicationfill')) {
    extract(elgg_get_sticky_values('applicationfill'));
    elgg_clear_sticky_form('applicationfill');
}

$input_email_body = elgg_view('input/longtext', array(
    'name' => 'email_body',
    'value' => $email_body,
    'id' => 'apply-mission-body-text-input'
));
?>

<div>
	<label for='apply-mission-body-text-input'><?php echo elgg_echo('missions:message_to_manager'); ?> </label>
</div>
</br>
<div>
	<?php echo $input_email_body; ?>
</div>
<div class="form-button"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:next'))); ?> </div>