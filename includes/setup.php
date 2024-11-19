<?php

class RS_ACFI_Setup {
	
	/**
	 * Initialized when the plugin is loaded
	 *
	 * @return void
	 */
	public static function init() {
		
		// Enqueue assets on the dashboard.
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_assets' ) );
		
		// Inserts "handles" to each field group that are used to create clickable links to edit the field group on the user and taxonomy pages.
		add_filter( 'acf/pre_render_fields', array( __CLASS__, 'acf_insert_group_handles' ), 20, 2 );
		
	}
	
	/**
	 * Enqueue assets on the wordpress dashboard (backend).
	 *
	 * @return void
	 */
	public static function enqueue_admin_assets() {
		wp_enqueue_style( 'rs-acfi-admin', RS_ACFI_URL . 'assets/rs-acfi-admin.css', array(), RS_ACFI_VERSION );
		wp_enqueue_script( 'rs-acfi-admin', RS_ACFI_URL . 'assets/rs-acfi-admin.js', array(), RS_ACFI_VERSION, true );
	}
	
	/**
	 * Displays a link to edit a field group in the title of a field group for user and taxonomy pages on the backend.
	 *
	 * @param $fields
	 * @param $post_id
	 *
	 *@return mixed
	 */
	public static function acf_insert_group_handles( $fields, $post_id ) {
		if ( !is_admin() ) return $fields;
		
		// Get the screen being viewed
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if ( ! $screen ) return $fields;
		
		// Ignore post types because they have a button already
		// (unless a taxonomy is defined, because a taxonomy also has a post type)
		if ( $screen->post_type && ! $screen->taxonomy ) return $fields;
		
		// Create a handle which will appear after the field group title (h2 tag)
		echo '<div class="rs-field-group-handle" data-post-id="'. esc_attr( $fields[0]['parent'] ) .'"></div>';
		
		return $fields;
	}
	
	
	
}

RS_ACFI_Setup::init();