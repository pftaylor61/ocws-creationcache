<?php
// initialize file
// this file contains the necessary initialize functions for the plugin to work

// This routine ensures that the plugin requires the Capability Manager Enhanced plugin
function ocwscci__register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Classic Editor',
			'slug'      => 'classic-editor',
			'required'  => true,
		),
		
		// This is an example of how to include a plugin bundled with a theme.
		array(
			'name'               => 'Capability Manager Enhanced', // The plugin name.
			'slug'               => 'capability-manager-enhanced', // The plugin slug (typically the folder name).
			'source'             => dirname( __FILE__ ) . '/lib/plugins/capability-manager-enhanced.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'creationcache',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'creationcache' ),
			'menu_title'                      => __( 'Install Plugins', 'creationcache' ),
			/* translators: %s: plugin name. */
			'installing'                      => __( 'Installing Plugin: %s', 'creationcache' ),
			/* translators: %s: plugin name. */
			'updating'                        => __( 'Updating Plugin: %s', 'creationcache' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'creationcache' ),
			'notice_can_install_required'     => _n_noop(
				 /* translators: 1: plugin name(s). */
				'The Creation Cache plugin requires the following plugin: %1$s.',
				'The Creation Cache plugin requires the following plugins: %1$s.',
				'creationcache'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). */
				'The Creation Cache plugin recommends the following plugin: %1$s.',
				'The Creation Cache plugin recommends the following plugins: %1$s.',
				'creationcache'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). */
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'creationcache'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). */
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'creationcache'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). */
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'creationcache'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). */
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'creationcache'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'creationcache'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'creationcache'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'creationcache'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'creationcache' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'creationcache' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'creationcache' ),
			/* translators: 1: plugin name. */
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'creationcache' ),
			/* translators: 1: plugin name. */
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'creationcache' ),
			/* translators: 1: dashboard link. */
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'creationcache' ),
			'dismiss'                         => __( 'Dismiss this notice', 'creationcache' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'creationcache' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'creationcache' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		
	);

	tgmpa( $plugins, $config );
} // end function ocwscci__register_required_plugins

// Our custom post type function
function creationcache_posttype_init() {
	
	// CPT Options
	$args = array(
				'labels' => array(
					'name' => __( CCNAME_PL , CCSLUG),
					'singular_name' => __( CCNAME_SG , CCSLUG),
					'add_new' => __( 'Add New', CCSLUG ),
					'add_new_item' => __( 'Add New '.CCNAME_SG, CCSLUG ),
					'edit_item' => __( 'Edit '.CCNAME_SG, CCSLUG ),
					'new_item' => __( 'New '.CCNAME_SG, CCSLUG ),
					'view_item' => __( 'View '.CCNAME_SG, CCSLUG ),
					'search_items' => __( 'Search '.CCNAME_PL, CCSLUG ),
					'not_found' => __( 'No '.CCNAME_PL.' found', CCSLUG ),
					'not_found_in_trash' => __( 'No '.CCNAME_PL.' found in Trash', CCSLUG ),
					'parent_item_colon' => __( 'Parent '.CCNAME_SG.':', CCSLUG ),
					'menu_name' => __( CCNAME_PL, CCSLUG ),
				),
				'public' => true,
				'show_ui' => true,
				'capability_type' => CCSLUG,
                'capabilities' => array(
					'publish_posts' => 'publish_'.CCSLUG.'s',
					'edit_posts' => 'edit_'.CCSLUG.'s',
					'edit_others_posts' => 'edit_others_'.CCSLUG.'s',
					'delete_posts' => 'delete_'.CCSLUG.'s',
					'delete_others_posts' => 'delete_others_'.CCSLUG.'s',
					'read_private_posts' => 'read_private_'.CCSLUG.'s',
					'edit_post' => 'edit_'.CCSLUG,
					'delete_post' => 'delete_'.CCSLUG,
					'read_post' => 'read_'.CCSLUG,
				), 
				'map_meta_cap' => true,
				'hierarchical' => false,
				'query_var' => true,
				'menu_icon' => OCWSCC_BASE_URL.'/images/'.CC_LOGO16,
				'has_archive' => true,
				'rewrite' => array('slug' => CCSLUG),
				'supports' => array(
					'title',
					'editor',
					'excerpt',
					'trackbacks',
					'custom-fields',
					'comments',
					'revisions',
					'thumbnail',
					'author',
					'page-attributes',
					),
				/*'taxonomies' => array( 'cachetype' )*/
				);
    register_post_type( CCSLUG,$args);
	add_filter('manage_edit-'.CCSLUG.'_columns', 'add_new_creationcache_columns');
	add_action('manage_'.CCSLUG.'_posts_custom_column', 'manage_creationcache_columns', 10, 2);
	add_filter( 'manage_edit-'.CCSLUG.'_sortable_columns', 'creationcache_sortable_columns' );
	/* Only run our customization on the 'edit.php' page in the admin. */
	add_action( 'load-edit.php', 'my_edit_creationcache_load' );
	
	
} // end function create_posttype

/* Sort out capabilities for Creation Cache CPT */
add_filter( 'map_meta_cap', 'my_map_meta_cap', 10, 4 );

function my_map_meta_cap( $caps, $cap, $user_id, $args ) {

	/* If editing, deleting, or reading a movie, get the post and post type object. */
	if ( 'edit_'.CCSLUG == $cap || 'delete_'.CCSLUG == $cap || 'read_'.CCSLUG == $cap ) {
		$post = get_post( $args[0] );
		$post_type = get_post_type_object( $post->post_type );

		/* Set an empty array for the caps. */
		$caps = array();
	}

	/* If editing a movie, assign the required capability. */
	if ( 'edit_'.CCSLUG == $cap ) {
		if ( $user_id == $post->post_author )
			$caps[] = $post_type->cap->edit_posts;
		else
			$caps[] = $post_type->cap->edit_others_posts;
	}

	/* If deleting a movie, assign the required capability. */
	elseif ( 'delete_'.CCSLUG == $cap ) {
		if ( $user_id == $post->post_author )
			$caps[] = $post_type->cap->delete_posts;
		else
			$caps[] = $post_type->cap->delete_others_posts;
	}

	/* If reading a private movie, assign the required capability. */
	elseif ( 'read_'.CCSLUG == $cap ) {

		if ( 'private' != $post->post_status )
			$caps[] = 'read';
		elseif ( $user_id == $post->post_author )
			$caps[] = 'read';
		else
			$caps[] = $post_type->cap->read_private_posts;
	}

	/* Return the capabilities required by the user. */
	return $caps;
}

function add_theme_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'edit_'.CCSLUG ); 
    $admins->add_cap( 'edit_'.CCSLUG.'s' ); 
    $admins->add_cap( 'edit_other_'.CCSLUG.'s' ); 
    $admins->add_cap( 'publish_'.CCSLUG.'s' ); 
    $admins->add_cap( 'read_'.CCSLUG ); 
    $admins->add_cap( 'read_private_'.CCSLUG.'s' ); 
    $admins->add_cap( 'delete_'.CCSLUG ); 
}
add_action( 'admin_init', 'add_theme_caps');

/* End section on capabilities */

// create a taxonomy based on cache-type

function cache_type_taxonomy() {
    register_taxonomy(
        'cachetype',
        CCSLUG,
        array(
            'hierarchical' => true,
            'label' => 'Cache Type',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'cachetype',
                'with_front' => false
				)
			)
    );
}


// Function used to automatically create Creation Cache page.
function create_creation_cache_pages()
  {
   	
   //post status and options
    $post = array(
          'comment_status' => 'open',
          'ping_status' =>  'closed' ,
          'post_date' => date('Y-m-d H:i:s'),
          'post_name' => CCSLUG,
          'post_status' => 'publish' ,
          'post_title' => CCNAME_PL,
          'post_type' => 'page',
    );
    //insert page and save the id
    $newvalue = wp_insert_post( $post, false );
    //save the id in the database
    update_option( 'ccpage', $newvalue );
	

  }
  
 // // Activates function if plugin is activated
register_activation_hook( __FILE__, 'create_creation_cache_pages');

?>
