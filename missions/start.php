<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
// This occurs when the plugin is loaded.
elgg_register_event_handler('init', 'system', missions_init);

/*
 * This method runs whenever the plugin is initialized.
 * It mostly handles registration and any other functions that need to run immediately.
 */
function missions_init() {
	// Register the custom library of methods for use in the plugin
	elgg_register_library('elgg:missions', elgg_get_plugins_path() . 'missions/lib/missions.php');
	elgg_load_library('elgg:missions');
	
	// Register a method to react to the plugin page setup event for the right side menu.
	elgg_register_event_handler('pagesetup', 'system', 'missions_setup_sidebar_menus');
	
	// Register a handler for page navigation.
	elgg_register_page_handler('missions', 'missions_main_page_handler');
	
	// Extends the original ELGG CSS with our own
	/*elgg_extend_view('css/elgg', 'css/elements/tabbar');
	elgg_extend_view('css/elgg', 'css/forms/tabform');
	elgg_extend_view('css/elgg', 'css/elements/print');
	elgg_extend_view('css/elgg', 'css/elements/menu');
	elgg_extend_view('css/elgg', 'css/forms/advancedform');*/
	elgg_extend_view('css/elgg', 'css/all-mission-css');
	
	// Register our action files found in missions/action/
	elgg_register_action("missions/post-mission-first-form", elgg_get_plugins_path() . "missions/actions/missions/post-mission-first-form.php");
	elgg_register_action("missions/post-mission-second-form", elgg_get_plugins_path() . "missions/actions/missions/post-mission-second-form.php");
	elgg_register_action("missions/post-mission-third-form", elgg_get_plugins_path() . "missions/actions/missions/post-mission-third-form.php");
	elgg_register_action("missions/search-form", elgg_get_plugins_path() . "missions/actions/missions/search-form.php");
	elgg_register_action("missions/display-more", elgg_get_plugins_path() . "missions/actions/missions/display-more.php");
	elgg_register_action("missions/close-from-display", elgg_get_plugins_path() . "missions/actions/missions/close-from-display.php");
	elgg_register_action("missions/search-simple", elgg_get_plugins_path() . "missions/actions/missions/search-simple.php");
	elgg_register_action("missions/search-prereq", elgg_get_plugins_path() . "missions/actions/missions/search-prereq.php");
	elgg_register_action("missions/search-language", elgg_get_plugins_path() . "missions/actions/missions/search-language.php");
	elgg_register_action("missions/search-time", elgg_get_plugins_path() . "missions/actions/missions/search-time.php");
	elgg_register_action("missions/browse-display", elgg_get_plugins_path() . "missions/actions/missions/browse-display.php");
	elgg_register_action("missions/advanced-form", elgg_get_plugins_path() . "missions/actions/missions/advanced-form.php");
	elgg_register_action("missions/application-form", elgg_get_plugins_path() . "missions/actions/missions/application-form.php");
	
	// Register a new subtype of object for categorizing our mission object.
	elgg_register_entity_type('object', 'mission');
	
	// Register an ajax view for the advanced search page.
	elgg_register_ajax_view('missions/element-select');
	
	// Adds a menu item to the original GCConnex sidebar that links to our plugin main page left side menu.
	$item = new ElggMenuItem('mission_main', elgg_echo('missions:micromissions'), 'missions/main');
	elgg_register_menu_item('site', $item);
}

/*
 * Creates a right side sidebar menu when our main page is being setup.
 * Menu items have priority as an alternate method to determine the order of items.
 * Lower priority means they are higher on the list.
 */ 
function missions_setup_sidebar_menus() {
	if(elgg_get_context() == 'missions') {
		elgg_register_menu_item('mission_main', array(
				'name' => 'post_opportunity',
				'href' => elgg_get_site_url() . 'missions/post-mission-first-tab',
				'text' => elgg_echo('missions:post_opportunity'),
				'priority' => 5
		));
		/*elgg_register_menu_item('mission_main', array(
				'name' => 'find_opportunity',
				'href' => elgg_get_site_url() . 'missions/search-mission',
				'text' => elgg_echo('missions:find_opportunity'),
				'priority' => 10
		));
		elgg_register_menu_item('mission_main', array(
				'name' => 'close_opportunity',
				'href' => elgg_get_site_url() . 'missions/close-mission',
				'text' => elgg_echo('missions:close_opportunity'),
				'priority' => 10
		));*/
		elgg_register_menu_item('mission_main', array(
				'name' => 'search',
				'href' => elgg_get_site_url() . 'missions/search',
				'text' => elgg_echo('missions:search'),
				'priority' => 10
		));
		/*elgg_register_menu_item('mission_search', array(
				'name' => 'simple',
				'href' => elgg_get_site_url() . 'missions/search/simple',
				'text' => elgg_echo('missions:simple_search'),
				'priority' => 5
		));
		elgg_register_menu_item('mission_search', array(
				'name' => 'prereq',
				'href' => elgg_get_site_url() . 'missions/search/prereq',
				'text' => elgg_echo('missions:prereq_search'),
				'priority' => 10
		));
		elgg_register_menu_item('mission_search', array(
				'name' => 'language',
				'href' => elgg_get_site_url() . 'missions/search/language',
				'text' => elgg_echo('missions:language_search'),
				'priority' => 10
		));
		elgg_register_menu_item('mission_search', array(
				'name' => 'time',
				'href' => elgg_get_site_url() . 'missions/search/time',
				'text' => elgg_echo('missions:time_search'),
				'priority' => 10
		));
		elgg_register_menu_item('mission_refine', array(
				'name' => 'prereq',
				'href' => elgg_get_site_url() . 'missions/search/prereq?ref=true',
				'text' => elgg_echo('missions:prereq_refine'),
				'priority' => 20
		));
		elgg_register_menu_item('mission_refine', array(
				'name' => 'language',
				'href' => elgg_get_site_url() . 'missions/search/language?ref=true',
				'text' => elgg_echo('missions:language_refine'),
				'priority' => 20
		));
		elgg_register_menu_item('mission_refine', array(
				'name' => 'time',
				'href' => elgg_get_site_url() . 'missions/search/time?ref=true',
				'text' => elgg_echo('missions:time_refine'),
				'priority' => 20
		));*/
		elgg_register_menu_item('mission_main', array(
				'name' => 'browse',
				'href' => elgg_get_site_url() . 'action/missions/browse-display',
				'text' => elgg_echo('missions:browse_missions'),
				'priority' => 20,
				'is_action' => true
		));
		elgg_register_menu_item('mission_main', array(
				'name' => 'advanced',
				'href' => elgg_get_site_url() . 'missions/advanced-search',
				'text' => elgg_echo('missions:advanced_search'),
				'priority' => 15
		));
	}
}

/*
 * Handles all defined url endings ($segments[0]) by loading the appropriate pages file.
 */ 
function missions_main_page_handler($segments) {
	switch($segments[0]) {
		case 'main':
			include elgg_get_plugins_path() . 'missions/pages/missions/main.php';
			break;
		case 'post-mission-first-tab':
			include elgg_get_plugins_path() . 'missions/pages/missions/post-mission-first-tab.php';
			break;
		case 'post-mission-second-tab':
			include elgg_get_plugins_path() . 'missions/pages/missions/post-mission-second-tab.php';
			break;
		case 'post-mission-third-tab':
			include elgg_get_plugins_path() . 'missions/pages/missions/post-mission-third-tab.php';
			break;
		case 'search-mission':
			include elgg_get_plugins_path() . 'missions/pages/missions/search-mission.php';
			break;
		case 'display-search-set':
			include elgg_get_plugins_path() . 'missions/pages/missions/display-search-set.php';
			break;
		/*
		 * The search case is a bit different since it is a single page with different possible forms.
		 * The 'search_page_helper' SESSION variable determines which form will be used.
		 */
		case 'search':
			switch($segments[1]) {
				case 'simple':
					$_SESSION['search_page_type'] = 'simple';
					break;
				case 'prereq':
					$_SESSION['search_page_type'] = 'prereq';
					break;
				case 'time':
					$_SESSION['search_page_type'] = 'time';
					break;
				case 'language':
					$_SESSION['search_page_type'] = 'language';
					break;
				default:
					$_SESSION['search_page_type'] = 'simple';
			}
			include elgg_get_plugins_path() . 'missions/pages/missions/search.php';
			break;
		case 'advanced-search':
			include elgg_get_plugins_path() . 'missions/pages/missions/advanced-search.php';
			break;
		case 'mission-application':
			include elgg_get_plugins_path() . 'missions/pages/missions/mission-application.php';
			break;
	}
}