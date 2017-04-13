<?php
/*
Plugin Name: WonderPlugin Gallery
Plugin URI: http://www.wonderplugin.com
Description: WordPress Photo Video Gallery Plugin
Version: 3.1
Author: Magic Hills Pty Ltd
Author URI: http://www.wonderplugin.com
License: Copyright 2014 Magic Hills Pty Ltd, All Rights Reserved
*/

define('WONDERPLUGIN_GALLERY_VERSION', '3.1');
define('WONDERPLUGIN_GALLERY_URL', plugin_dir_url( __FILE__ ));
define('WONDERPLUGIN_GALLERY_PATH', plugin_dir_path( __FILE__ ));

require_once 'app/class-wonderplugin-gallery-controller.php';

class WonderPlugin_Gallery_Plugin {
	
	function __construct() {
	
		$this->init();
	}
	
	public function init() {
		
		// init controller
		$this->wonderplugin_gallery_controller = new WonderPlugin_Gallery_Controller();
		
		add_action( 'admin_menu', array($this, 'register_menu') );
		
		add_shortcode( 'wonderplugin_gallery', array($this, 'shortcode_handler') );
		
		add_action( 'init', array($this, 'register_script') );
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_script') );
		
		if ( is_admin() )
		{
			add_action( 'wp_ajax_wonderplugin_gallery_save_item', array($this, 'wp_ajax_save_item') );
			add_action( 'admin_init', array($this, 'admin_init_hook') );
		}
	}
	
	function register_menu()
	{
		$settings = $this->get_settings();
		$userrole = $settings['userrole'];
		
		$menu = add_menu_page(
				__('WonderPlugin Gallery', 'wonderplugin_gallery'),
				__('WonderPlugin Gallery', 'wonderplugin_gallery'),
				$userrole,
				'wonderplugin_gallery_overview',
				array($this, 'show_overview'),
				WONDERPLUGIN_GALLERY_URL . 'images/logo-16.png' );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'wonderplugin_gallery_overview',
				__('Overview', 'wonderplugin_gallery'),
				__('Overview', 'wonderplugin_gallery'),
				$userrole,
				'wonderplugin_gallery_overview',
				array($this, 'show_overview' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'wonderplugin_gallery_overview',
				__('New Gallery', 'wonderplugin_gallery'),
				__('New Gallery', 'wonderplugin_gallery'),
				$userrole,
				'wonderplugin_gallery_add_new',
				array($this, 'add_new' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'wonderplugin_gallery_overview',
				__('Manage Galleries', 'wonderplugin_gallery'),
				__('Manage Galleries', 'wonderplugin_gallery'),
				$userrole,
				'wonderplugin_gallery_show_items',
				array($this, 'show_items' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
	
		$menu = add_submenu_page(
				'wonderplugin_gallery_overview',
				__('Settings', 'wonderplugin_gallery'),
				__('Settings', 'wonderplugin_gallery'),
				'manage_options',
				'wonderplugin_gallery_edit_settings',
				array($this, 'edit_settings' ) );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				null,
				__('View Gallery', 'wonderplugin_gallery'),
				__('View Gallery', 'wonderplugin_gallery'),	
				$userrole,	
				'wonderplugin_gallery_show_item',	
				array($this, 'show_item' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				null,
				__('Edit Gallery', 'wonderplugin_gallery'),
				__('Edit Gallery', 'wonderplugin_gallery'),
				$userrole,
				'wonderplugin_gallery_edit_item',
				array($this, 'edit_item' ) );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
	}
	
	function register_script()
	{
		wp_register_script('wonderplugin-gallery-script', WONDERPLUGIN_GALLERY_URL . 'engine/wonderplugingallery.js', array('jquery'), WONDERPLUGIN_GALLERY_VERSION, false);
		wp_register_script('wonderplugin-gallery-creator-script', WONDERPLUGIN_GALLERY_URL . 'app/wonderplugin-gallery-creator.js', array('jquery'), WONDERPLUGIN_GALLERY_VERSION, false);
		wp_register_style('wonderplugin-gallery-admin-style', WONDERPLUGIN_GALLERY_URL . 'wonderplugingallery.css');
	}
	
	function enqueue_script()
	{
		wp_enqueue_script('wonderplugin-gallery-script');
	}
	
	function enqueue_admin_script($hook)
	{
		wp_enqueue_script('post');
		if (function_exists("wp_enqueue_media"))
		{
			wp_enqueue_media();
		}
		else
		{
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			wp_enqueue_script('media-upload');
		}
		wp_enqueue_script('wonderplugin-gallery-script');
		wp_enqueue_script('wonderplugin-gallery-creator-script');
		wp_enqueue_style('wonderplugin-gallery-admin-style');
	}

	function admin_init_hook()
	{
		// change text of history media uploader
		if (!function_exists("wp_enqueue_media"))
		{
			global $pagenow;
			
			if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
				add_filter( 'gettext', array($this, 'replace_thickbox_text' ), 1, 3 );
			}
		}
		
		// add meta boxes
		$this->wonderplugin_gallery_controller->add_metaboxes();
	}
	
	function replace_thickbox_text($translated_text, $text, $domain) {
		
		if ('Insert into Post' == $text) {
			$referer = strpos( wp_get_referer(), 'wonderplugin-gallery' );
			if ( $referer != '' ) {
				return __('Insert into gallery', 'wonderplugin_gallery' );
			}
		}
		return $translated_text;
	}
	
	function show_overview() {
		
		$this->wonderplugin_gallery_controller->show_overview();
	}
	
	function show_items() {
		
		$this->wonderplugin_gallery_controller->show_items();
	}
	
	function add_new() {
		
		$this->wonderplugin_gallery_controller->add_new();
	}
	
	function show_item() {
		
		$this->wonderplugin_gallery_controller->show_item();
	}
	
	function edit_item() {
	
		$this->wonderplugin_gallery_controller->edit_item();
	}
	
	function edit_settings() {
		
		$this->wonderplugin_gallery_controller->edit_settings();
	}
	
	function get_settings() {
		
		return $this->wonderplugin_gallery_controller->get_settings();
	}
	
	function shortcode_handler($atts) {
		
		if ( !isset($atts['id']) )
			return __('Please specify a gallery id', 'wonderplugin_gallery');
		
		return $this->wonderplugin_gallery_controller->generate_body_code( $atts['id'], false);
	}
	
	function wp_ajax_save_item() {

		$items = json_decode(stripcslashes($_POST["item"]), true);
		
		foreach ($items as $key => &$value)
		{
			if ($value === true)
				$value = "true";
				
			if ($value === false)
				$value = "false";
		}
		
		if (isset($items["slides"]) && count($items["slides"]) > 0)
		{
			foreach ($items["slides"] as $key => &$slide)
			{
				foreach ($slide as $key => &$value)
				{
					if ($value === true)
						$value = "true";
		
					if ($value === false)
						$value = "false";
				}
			}
		}
		
		header('Content-Type: application/json');
		echo json_encode($this->wonderplugin_gallery_controller->save_item($items));
		die();
	}
	
}

/**
 * Init the plugin
 */
$wonderplugin_gallery_plugin = new WonderPlugin_Gallery_Plugin();

/**
 * Global php function
 * @param $id
 */
function wonderplugin_gallery($id) {

	echo $wonderplugin_gallery_plugin->wonderplugin_gallery_controller->generate_body_code($id, false);
}

/**
 * Uninstallation
 */
function wonderplugin_gallery_uninstall() {

	global $wpdb;
	
	$keepdata = get_option( 'wonderplugin_gallery_keepdata', 1 );
	if ( $keepdata == 0 )
	{
		$table_name = $wpdb->prefix . "wonderplugin_gallery";
		$wpdb->query("DROP TABLE IF EXISTS $table_name");
	}
}

if ( function_exists('register_uninstall_hook') )
{
	register_uninstall_hook( __FILE__, 'wonderplugin_gallery_uninstall' );
}

define('WONDERPLUGIN_GALLERY_VERSION_TYPE', 'F');
