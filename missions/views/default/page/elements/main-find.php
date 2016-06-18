<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Page content for finding missions and a link to create them.
 */ 
if($_SESSION['mission_entities_per_page']) {
	$entities_per_page = $_SESSION['mission_entities_per_page'];
}

// Simple search form.
$simple_search_form = elgg_view_form('missions/search-simple');

// Advanced search form which gets hidden.
$advanced_search_form = elgg_view_form('missions/advanced-search-form', array(
		'class' => 'form-horizontal'
));
$advanced_field = elgg_view('page/elements/hidden-field', array(
		'toggle_text' => elgg_echo('missions:advanced_search'),
		'toggle_text_hidden' => elgg_echo('missions:simple_search'),
		'toggle_id' => 'advanced-search',
		'hidden_content' => $advanced_search_form,
		'hideable_pre_content' => $simple_search_form,
		'field_bordered' => true
));

// Displays the latest missions to be posted up to search_limit.
$options['type'] = 'object';
$options['subtype'] = 'mission';
$options['metadata_name_value_pairs'] = array(array(
		'name' => 'state',
		'operand' => '=',
		'value' => 'posted'
));
$options['metadata_name_value_pairs_operator'] = 'AND';
$options['limit'] = elgg_get_plugin_setting('search_limit', 'missions');

$entity_list = elgg_get_entities_from_metadata($options);

$count = count($entity_list);
$offset = (int) get_input('offset', 0);
if($entities_per_page) {
	$max = $entities_per_page;
}
else {
	$max = elgg_get_plugin_setting('search_result_per_page', 'missions');
}

$entity_list = mm_sort_mission_decider($_SESSION['missions_sort_field_value'], $_SESSION['missions_order_field_value'], $entity_list);

$max_reached = '';
if(($offset + $max) >= elgg_get_plugin_setting('search_limit', 'missions') && $count >= elgg_get_plugin_setting('search_limit', 'missions')) {
	$max_reached = '<div class="col-sm-12" style="font-style:italic;">' . elgg_echo('missions:reached_maximum_entities') . '</div>';
}

// Displays the list of mission entities.
$latest_missions = elgg_view_entity_list(array_slice($entity_list, $offset, $max), array(
		'count' => $count,
		'offset' => $offset,
		'limit' => $max,
		'pagination' => true,
		'list_type' => 'gallery',
		'gallery_class' => 'mission-gallery',
		'mission_full_view' => false
), $offset, $max);

$change_entities_per_page_form = elgg_view_form('missions/change-entities-per-page', array(
		'class' => 'form-horizontal'
), array(
		'entity_type' => 'mission',
		'number_per' => $entities_per_page
));

$sort_missions_form .= elgg_view_form('missions/sort-missions-form', array(
		'class' => 'form-horizontal'
));
$sort_field = elgg_view('page/elements/hidden-field', array(
		'toggle_text' => elgg_echo('missions:sort_options'),
		'toggle_text_hidden' => elgg_echo('missions:sort_options'),
		'toggle_id' => 'sort_options',
		'hidden_content' => $sort_missions_form,
		'alignment' => 'right'
));
?>

<div class="col-sm-12">
	<?php echo $create_button; ?>
</div>
<div class="col-sm-12">
	<h4><?php echo elgg_echo('missions:search_for_opportunities') . ':'; ?></h4>
	<?php 
		//echo $simple_search_form;
		echo $advanced_field;
	?>
</div>
<div class="col-sm-5 col-sm-offset-7">
	<?php echo $sort_field; ?>
</div>
<div class="col-sm-12">
	<h4><?php echo elgg_echo('missions:latest_opportunities'); ?></h4>
	<?php echo $max_reached; ?>
	<div class="col-sm-12">
		
		<?php echo $latest_missions; ?>
	</div>
</div>
<div hidden name="mission-total-count"><?php echo $count; ?></div>
<div class="col-sm-12">
	<?php echo $change_entities_per_page_form; ?>
</div>