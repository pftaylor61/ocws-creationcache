<?php
/**
* This is the plugin's configuration file
* Users can amend this file, so that their caches can have their own names
**/

// These are the main definitions

/* These constants can be amended for personal choice */
/* ================================================== */

define("CCNAME_SG","Creation Cache"); // Change 'Creation Cache' for the singular term for your caches
define("CCNAME_PL","Creation Caches"); // Change 'Creation Caches' for the plural term for your caches
define("CCNAME_ACT","Creation Caching"); // Change 'Creation Caching' for the activity present participle for your caches
define("CCSLUG","creationcache"); // Change creationcache for the slug used for your caches
define("CCVERSION","1.2.0"); // Set the version number
define("CC_LOGO16","celticcross16x16.png"); // Set this to the 16x16 logo that you want. Copy this logo into the plugin's image subfolder
define("CC_LOGO80","celticcross80x80.png"); // Set this to the 80x80 logo that you want. Copy this logo into the plugin's image subfolder
define("CC_PRFX","OCWSCC_"); // This is the prefix for the Creation Cache code

/* only edit the lines below if you know what you are doing */
/* ======================================================== */

$dash_url = get_bloginfo('url') . '/wp-admin/options-general.php?page=ocws_creationcache';
$dash_info = "<p>The OCWS Creationcache Plugin, version ".CCVERSION.", will display ".CCNAME_PL." and allow you to create, edit and delete them. You can also download .gpx and .loc files for your ".CCNAME_SG.".</p>";
$dash_info .= "<p>The plugin's <a href=\"".$dash_url."\">information page</a> might be helpful!</p>";
define("CCDASH_INFO",$dash_info); // Set the dashboard plugin info

/* Other constants - DO NOT CHANGE!!! */
/* ================================== */

define("OCWSCC_BASE_DIR",dirname(__FILE__));
define("OCWSCC_BASE_URL",plugins_url( '', __FILE__ ));
$cc_upload = wp_upload_dir();
$cc_rpath = realpath($cc_upload['basedir']);
$cc_upl_url = $cc_upload['baseurl'];
define("OCWSCC_GPX", $cc_rpath."/ocwscc_gpx/"); 
define("OCWSCC_GPX_URL", $cc_upl_url."/ocwscc_gpx/");
define("OCWSCC_EDITCONF",admin_url()."/plugin-editor.php?file=ocws-creationcache%2Focws-creationcache-config.php&plugin=ocws-creationcache%2Focws-creationcache.php");
define("OCWSCC_IMAGE_PLACEHOLDER",OCWSCC_BASE_URL."/images/placeholder.png")
?>