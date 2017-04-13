<?php 

require_once 'class-wonderplugin-gallery-model.php';
require_once 'class-wonderplugin-gallery-view.php';

class WonderPlugin_Gallery_Controller {

	private $view, $model;

	function __construct() {

		$this->model = new WonderPlugin_Gallery_Model($this);	
		$this->view = new WonderPlugin_Gallery_View($this);
		$this->init();
	}
	
	function init() {
		
		$engine = array("WordPress Gallery Plugin", "WordPress Photo Gallery Plugin", "WordPress Video Gallery Plugin", "WordPress YouTube Gallery Plugin");
		$option_name = 'wonderplugin-gallery-engine';
		if ( get_option( $option_name ) == false )
			update_option( $option_name, $engine[array_rand($engine)] );
	}
	
	function add_metaboxes()
	{
		$this->view->add_metaboxes();
	}
	
	function show_overview() {
		
		$this->view->print_overview();
	}
	
	function show_items() {
	
		$this->view->print_items();
	}
	
	function add_new() {
		
		$this->view->print_add_new();
	}
	
	function show_item()
	{
		$this->view->print_item();
	}
	
	function edit_item()
	{
		$this->view->print_edit_item();
	}
	
	function edit_settings()
	{
		$this->view->print_edit_settings();
	}
	
	function save_settings($options)
	{
		$this->model->save_settings($options);
	}
	
	function get_settings() 
	{
		return $this->model->get_settings();
	}
	
	function generate_body_code($id, $has_wrapper) {
		
		return $this->model->generate_body_code($id, $has_wrapper);
	}
	
	function delete_item($id)
	{
		return $this->model->delete_item($id);
	}
	
	function clone_item($id)
	{
		return $this->model->clone_item($id);
	}
	
	function save_item($item)
	{
		return $this->model->save_item($item);	
	}
	
	function get_list_data() {
	
		return $this->model->get_list_data();
	}
	
	function get_item_data($id) {
		
		return $this->model->get_item_data($id);
	}
}