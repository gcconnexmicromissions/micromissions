<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This view displays some of the mission metadata. It is meant to be a first glance summary.
 */
$mission = '';
$full_view = '';
if (isset($vars['entity'])) {
    $mission = $vars['entity'];
}
if (isset($vars['full_view'])) {
    $full_view = $vars['full_view'];
}

$pic_url = elgg_get_site_url() . 'mod/missions/graphics/person-icon.png';

$output_remote = '';
if (! empty($mission->remotely)) {
    $output_remote = elgg_view_icon('home') . elgg_echo('missions:work_from_home');
}

// Button for calling the extended mission view.
$read_more_button = elgg_view('output/url', array(
    'href' => $mission->getURL(),
    'text' => elgg_echo('missions:read_more'),
    'class' => 'elgg-button btn btn-default'
));

$class_string = 'class="mission-printer"';
$description_string = $mission->description;
if (! $full_view) {
    $class_string = 'class="mission-printer mission-less"';
    $description_string = elgg_get_excerpt($description_string, 200);
}

// Sets the buttons to the bottom of whichever view is used.
if(!$vars['override_buttons']) {
    $button_set = mm_create_button_set($mission, false);
}
?>

<div <?php echo $class_string; ?>>
	<table class="short-table">
		<tr>
			<td rowspan="3"><img src="<?php echo $pic_url; ?>"
				alt="Person Pictograph"></td>
			<td>
				<?php echo $output_remote;?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo elgg_view_icon('file') . ' ' . elgg_echo('missions:email_manager');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo elgg_view_icon('arrow-right') . ' ' . elgg_echo('missions:share_with_colleague');?>
			</td>
		</tr>
	</table>
	<div>
		<h2><?php echo $mission->job_title;?></h2>
	</div>
	<div>
		<h3><?php echo elgg_echo('missions:opportunity_type') . ':';?></h3> 
		<?php echo $mission->job_type;?>
	</div>
	<div>
		<?php echo $description_string;?>
	</div>
	<div>
		<h3><?php echo elgg_echo('missions:deadline') . ':';?></h3>
		<?php echo $mission->deadline;?>
	</div>
	<div class="mission-button-set">
		<?php
if (! $full_view) {
    echo $read_more_button;
    foreach ($button_set as $value) {
        echo $value;
    }
}
?>
	</div>
</div>