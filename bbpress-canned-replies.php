<?php
/*
 * Plugin Name: bbPress - Canned Replies
 * Description: Allows you to create and quickly insert pre-defined responses in bbPress forum topics
 * Plugin URI: http://pippinsplugins.com/bbpress-canned-replies
 * Author: Pippin Williamson
 * Author URI: http://pippinsplugins.com
 * Version: 0.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class BBP_Canned_Replies {

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	public function __construct() {

		// load the plugin translation files
		add_action( 'init', array( $this, 'textdomain' ) );

		// register the post type
		add_action( 'init', array( $this, 'post_type' ) );

		// register css files
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );

		// register js files
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		// Add our front end markup
		add_action( 'bbp_theme_before_reply_form_content', array( $this, 'reply_form' ) );

	} // end constructor


	/**
	 * Load the plugin's text domain
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function textdomain() {
		load_plugin_textdomain( 'bbp-canned-replies', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}


	/**
	 * Register the post type
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function post_type() {

		if( ! class_exists( 'bbPress' ) )
			return;

		$labels = array(
			'name'              => _x( 'Canned Replies',                   'post type general name',  'bbp-canned-replies' ),
			'singular_name'     => _x( 'Canned Reply',                     'post type singular name', 'bbp-canned-replies' ),
			'add_new'           => __( 'Add New',                          'bbp-canned-replies' ),
			'add_new_item'      => __( 'Add New Canned Reply',             'bbp-canned-replies' ),
			'edit_item'         => __( 'Edit Canned Reply',                'bbp-canned-replies' ),
			'new_item'          => __( 'New Canned Reply',                 'bbp-canned-replies' ),
			'all_items'         => __( 'Canned Replies',                   'bbp-canned-replies' ),
			'view_item'         => __( 'View Canned Reply',                'bbp-canned-replies' ),
			'search_items'      => __( 'Search Canned Replies',            'bbp-canned-replies' ),
			'not_found'         => __( 'No Canned Replies found',          'bbp-canned-replies' ),
			'not_found_in_trash'=> __( 'No Canned Replies found in Trash', 'bbp-canned-replies' ),
			'parent_item_colon' => '',
			'menu_name'         => __( 'Canned Replies',                   'bbp-canned-replies' )
		);

		$args = array(
			'labels'            => $labels,
			'public'            => false,
			'show_ui'           => true,
			'show_in_menu'      => 'edit.php?post_type=' . bbp_get_forum_post_type(),
			'query_var'         => false,
			'rewrite'           => false,
			'capabilities'      => bbp_get_forum_caps(),
			'capability_type'   => array( 'forum', 'forums' ),
			'supports'          => array( 'editor', 'title' ),
			'can_export'        => true
		);

		register_post_type( 'bbp_canned_reply', $args );

	}


	/**
	 * Load the plugin's CSS files
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function styles() {
		$css_path = plugin_dir_path( __FILE__ ) . 'css/front-end.css';
	    wp_enqueue_style( 'bbp_canned_replies_style', plugin_dir_url( __FILE__ ) . 'css/front-end.css', filemtime( $css_path ) );
	}


	/**
	 * Load the plugin's js files
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function scripts() {
		$script_path = plugin_dir_path( __FILE__ ) . 'js/canned-replies.js';
	    wp_enqueue_script( 'bbp_canned_replies_script', plugin_dir_url( __FILE__ ) . 'js/canned-replies.js', filemtime( $script_path ) );
	}

	public function reply_form() {
		echo '<div class="bbp-canned-replies-wrapper">';

		echo '</div>';
	}

} // end class

// instantiate our plugin's class
$GLOBALS['bbp_canned_replies'] = new BBP_Canned_Replies();
