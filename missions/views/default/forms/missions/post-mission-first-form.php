<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
$name = get_input('fn');
$department = get_input('fd');
$email = get_input('fe');
$phone = get_input('fp');

if (elgg_is_sticky_form('firstfill')) {
    extract(elgg_get_sticky_values('firstfill'));
    // elgg_clear_sticky_form('firstfill');
}

$input_name = elgg_view('input/text', array(
    'name' => 'name',
    'value' => $name,
    'id' => 'post-mission-name-text-input'
));
$input_department = elgg_view('input/text', array(
    'name' => 'department',
    'value' => $department,
    'id' => 'post-mission-department-text-input'
));
$input_email = elgg_view('input/text', array(
    'name' => 'email',
    'value' => $email,
    'id' => 'post-mission-email-text-input'
));
$input_phone = elgg_view('input/text', array(
    'name' => 'phone',
    'value' => $phone,
    'id' => 'post-mission-phone-text-input'
));
?>

<p>
	<?php echo elgg_echo('missions:first_post:paragraph_one');?>
</p>
<div>
	<table class="mission-post-table">
		<tr>
			<td class="mission-post-table-lefty"><label for='post-mission-name-text-input'><?php echo elgg_echo('missions:your_name') . '*:';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_name; ?>
			</div>
			</td>
		</tr>
		<tr>
			<td class="mission-post-table-lefty"><label for='post-mission-department-text-input'><?php echo elgg_echo('missions:your_department') . '*:';?></label><br />
			</td>
			<td class="mission-post-table-righty">
				<div>
				<?php echo $input_department; ?>
			</div>
			</td>
		</tr>
	</table>
</div>
<p>
	<?php echo elgg_echo('missions:first_post:paragraph_two');?>
</p>
<div>
	<table class="mission-post-table">
		<td class="mission-post-table-lefty"><label for='post-mission-email-text-input'><?php echo elgg_echo('missions:your_email') . '*:';?></label><br />
		</td>
		<td class="mission-post-table-righty">
			<div>
			<?php echo $input_email; ?>
		</div>
		</td>
	</table>
</div>
<p>
	<?php echo elgg_echo('missions:first_post:paragraph_three');?>
</p>
<div>
	<table class="mission-post-table">
		<td class="mission-post-table-lefty"><label for='post-mission-phone-text-input'><?php echo elgg_echo('missions:your_phone') . ':';?></label><br />
		</td>
		<td class="mission-post-table-righty">
			<div>
			<?php echo $input_phone; ?>
		</div>
		</td>
	</table>
</div>
<p>
	<?php echo elgg_echo('missions:first_post:paragraph_four');?>
</p>
<p>
	<?php echo elgg_echo('missions:required_fields_star');?>
</p>
<div class="form-button"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:next'))); ?> </div>
