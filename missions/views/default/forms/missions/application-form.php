<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */
	$mid = get_input('mid');
	$_SESSION['mid_act'] = $mid;
	$email_body = get_input('eb');

	if (elgg_is_sticky_form('applicationfill')) {
		extract(elgg_get_sticky_values('applicationfill'));
		elgg_clear_sticky_form('applicationfill');
	}
	
	$input_email_body = elgg_view('input/longtext', array(
			'name' => 'email_body',
			'value' => $email_body
	));
?>

<div>
	<?php echo $input_email_body; ?>
</div>
<div class="form-button"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:next'))); ?> </div>