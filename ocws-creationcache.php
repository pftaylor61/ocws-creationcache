<?php

/*

Plugin Name: OCWS Creation Cache
Plugin URI: http://oldcastleweb.com/pws/plugins

Description: This plugin creates a new page type, called creationcache, which displays Creation caches - a version of the geocache system. The plugin has been produced by <a href="http://www.oldcastleweb.com" target="_blank">Old Castle Web Solutions</a>.<br /><br /> The actual name of the caches can be changed from Creation Caches to any other name that you choose, by ediiting a simple configuration file. In order to explain the game of creation caching, there is an extensive backend information page, which appears where a settings page would normally be. This page explains to the site owner how they can go about administering a Creation Cache section on their Wordpress website.<br /><br />I am quite satisfied with the way the system works so far. However, I would welcome reports to the website above.<br /><br />Note that the code for a Creation Cache page would be broken if the Gutenberg editor was used, so this plugin disables the use of Gutenberg, and requires the Classic Editor plugin.

Version: 2.1
Author: Paul Taylor
Author URI: http://oldcastleweb.com/pws/about
License: GPL2
GitHub Plugin URI: https://github.com/pftaylor61/ocws-creationcache
GitHub Branch:     master

*/

/*  Copyright 2015  Paul Taylor  (email : info@oldcastleweb.com)



    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

$ocwscc_base_dir = dirname( __FILE__ );
$ocwscc_base_url = plugins_url( '', __FILE__ );




// The configuration file can be amended, as the user sees fit
require_once("ocws-creationcache-config.php");

// let's get the functions loaded and the initialization done
// This applies the plugin's configuration file
require_once($ocwscc_base_dir."/class-tgm-plugin-activation.php");
require_once($ocwscc_base_dir."/ocws-creationcache-categoryimages.php");
require_once($ocwscc_base_dir."/functions.php");
require_once($ocwscc_base_dir."/initialize.php");



if (file_exists(OCWSCC_GPX.".gpx")) {
	unlink(OCWSCC_GPX.".gpx");
}
if (file_exists(OCWSCC_GPX.".loc")) {
	unlink(OCWSCC_GPX.".loc");
}


/* Initiation */

// make the new directory
		if (!file_exists(OCWSCC_GPX)) {
			mkdir(OCWSCC_GPX, 0777, true);
			//echo OCWSCC_GPX;
		}

// Prevent the use of Gutenberg in this plugin's UI
/* add_filter( ‘gutenberg_can_edit_post_type’, ‘my_gutenberg_can_edit_post_types’ );
function my_gutenberg_can_edit_post_types( $can_edit, $post_type ) {
    If ( in_array( $post_type, array( CCSLUG ) ) {
        return false;
    }

    return $can_edit;
}
*/

// require the Capability Manager plugin
add_action( 'tgmpa_register', 'ocwscci__register_required_plugins' );

// get the styles working
add_action( 'wp_enqueue_scripts', 'ocwscc_styles' );

// Hooking up our function to theme setup
add_action( 'init', 'creationcache_posttype_init' );

add_action( 'init', 'cache_type_taxonomy');

// make an info page, where the settings normally go
add_action('admin_menu', 'ocwscc_admin_menu');

$plugin = plugin_basename(__FILE__); 

add_filter("plugin_action_links_$plugin", 'ocws_creationcache_info_link' );

// let's make a dashboard widget to report my plugin
/* start dashboard widget code */
add_action( 'wp_dashboard_setup', 'ocwscc_dashboard_example_widgets' );

add_action('add_meta_boxes','ocwscc_mbe_create');
add_action('save_post', 'ocwscc_mbe_function_save');
add_filter( 'single_template', 'get_custom_post_type_template' );
add_filter( 'archive_template', 'get_custom_post_type_archtemplate' );

// Add to admin_init function



/* end dashboard widget code */


?>
