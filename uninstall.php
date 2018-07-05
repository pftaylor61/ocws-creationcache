<?php
// functions for uninstalling

	//if uninstall not called from WordPress exit
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();
	
	// delete the special directory
	unlink(OCWSCC_GPX);








?>