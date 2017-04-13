<?php 

require_once 'wonderplugin-gallery-functions.php';

class WonderPlugin_Gallery_Model {

	private $controller;
	
	function __construct($controller) {
		
		$this->controller = $controller;
	}
	
	function get_upload_path() {
		
		$uploads = wp_upload_dir();
		return $uploads['basedir'] . '/wonderplugin-gallery/';
	}
	
	function get_upload_url() {
	
		$uploads = wp_upload_dir();
		return $uploads['baseurl'] . '/wonderplugin-gallery/';
	}
	
	function eacape_html_quotes($str) {
	
		$result = str_replace("\'", "&#39;", $str);
		$result = str_replace('\"', '&quot;', $result);
		$result = str_replace("'", "&#39;", $result);
		$result = str_replace('"', '&quot;', $result);
		return $result;
	}
	
	function generate_body_code($id, $has_wrapper) {
		
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_gallery";
		
		$ret = "";
		$item_row = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
		if ($item_row != null)
		{
			$data = json_decode($item_row->data);
			
			if (isset($data->customcss) && strlen($data->customcss) > 0)
			{
				$customcss = str_replace("\r", " ", $data->customcss);
				$customcss = str_replace("\n", " ", $customcss);
				$ret .= '<style type="text/css">' . $customcss . '</style>';
			}
			
			$ret .= '<div style="';
			
			if ( (isset($data->fullwidth) && strtolower($data->fullwidth) === 'true') || (isset($data->responsive) && strtolower($data->responsive) === 'true' && !isset($data->fullwidth)) )
				$ret .= 'max-width:100%;';
			else
				$ret .= 'max-width:' . $data->width . 'px;';
			
			
			if ($has_wrapper)
				$ret .= 'margin:0 auto 180px;';
			else
				$ret .= 'margin:0 auto;';
			
			$ret .= '">';
			
			// div data tag
			$ret .= '<div class="wonderplugingallery" data-width="' . $data->width . '" data-height="' . $data->height . '" data-skin="' . $data->skin . '"';
			
			if (isset($data->dataoptions) && strlen($data->dataoptions) > 0)
			{
				$ret .= ' ' . stripslashes($data->dataoptions);
			}
			
			$boolOptions = array('autoslide', 'autoplayvideo', 'html5player', 'responsive', 'fullwidth', 'showtitle', 'showdescription', 'showplaybutton', 'showfullscreenbutton', 'showtimer', 'showcarousel', 'galleryshadow', 'slideshadow', 'thumbshowtitle', 'thumbshadow', 'lightboxshowtitle', 'lightboxshowdescription');
			foreach ( $boolOptions as $key )
			{
				if (isset($data->{$key}) )
					$ret .= ' data-' . $key . '="' . ((strtolower($data->{$key}) === 'true') ? 'true': 'false') .'"';
			}
			
			$valOptions = array('resizemode', 'imagetoolboxmode', 'effect', 'padding', 'bgcolor', 'bgimage', 'thumbwidth', 'thumbheight', 'thumbgap', 'thumbrowgap', 'lightboxtextheight', 'lightboxtitlecss', 'lightboxdescriptioncss', 'titlecss', 'descriptioncss');
			foreach ( $valOptions as $key )
			{
				if (isset($data->{$key}) )
					$ret .= ' data-' . $key . '="' . $data->{$key} . '"';
			}
				
			$ret .= ' data-jsfolder="' . WONDERPLUGIN_GALLERY_URL . 'engine/"'; 
			$ret .= ' style="display:none;" >';
			
			if (isset($data->slides) && count($data->slides) > 0)
			{
				foreach ($data->slides as $slide)
				{
					$ret .= '<a';
					if ($slide->type == 0)
					{
						$ret .=' href="' . $slide->image . '"';
					}
					else if ($slide->type == 1)
					{
						$ret .=' href="' . $slide->mp4 . '"';
						if (isset($slide->image) && $slide->image)
							$ret .=' data-poster="' . $slide->image . '"';
						if (isset($slide->hdmp4) && $slide->hdmp4)
							$ret .=' data-hd="' . $slide->hdmp4 . '"';
						if (isset($slide->webm) && $slide->webm)
							$ret .=' data-webm="' . $slide->webm . '"';
						if (isset($slide->hdwebm) && $slide->hdwebm)
							$ret .=' data-hdwebm="' . $slide->hdwebm . '"';
					}
					else if ($slide->type == 2 || $slide->type == 3 || $slide->type == 4)
					{
						$ret .=' href="' . $slide->video . '"';
						if (isset($slide->image) && $slide->image)
							$ret .=' data-poster="' . $slide->image . '"';
					}
					
					if (isset($slide->weblink) && strlen($slide->weblink) > 0)
					{
						$ret .= ' data-link="' . $slide->weblink . '"';
						if (isset($slide->linktarget) && strlen($slide->linktarget) > 0)
							$ret .= ' data-linktarget="' . $slide->linktarget . '"';
					}
					$ret .= '><img src="' . $slide->thumbnail . '" alt="' . $this->eacape_html_quotes($slide->title) . '"';
					if (isset($slide->description) && strlen($slide->description) > 0)
						$ret .= ' data-description="' . $this->eacape_html_quotes($slide->description) . '"';
					$ret .= '></a>';
				}
			}
			if ('F' == 'F')
				$ret .= '<div class="wonderplugin-engine"><a href="http://www.wonderplugin.com/wordpress-gallery/" title="'. get_option('wonderplugin-gallery-engine')  .'">' . get_option('wonderplugin-gallery-engine') . '</a></div>';
			$ret .= '</div>';
			
			$ret .= '</div>';
		}
		else
		{
			$ret = '<p>The specified gallery id does not exist.</p>';
		}
		return $ret;
	}
	
	function delete_item($id) {
		
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_gallery";
		
		$ret = $wpdb->query( $wpdb->prepare(
				"
				DELETE FROM $table_name WHERE id=%s
				",
				$id
		) );
		
		return $ret;
	}
	
	function clone_item($id) {
	
		global $wpdb, $user_ID;
		$table_name = $wpdb->prefix . "wonderplugin_gallery";
		
		$cloned_id = -1;
		
		$item_row = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
		if ($item_row != null)
		{
			$time = current_time('mysql');
			$authorid = $user_ID;
			
			$ret = $wpdb->query( $wpdb->prepare(
					"
					INSERT INTO $table_name (name, data, time, authorid)
					VALUES (%s, %s, %s, %s)
					",
					$item_row->name,
					$item_row->data,
					$time,
					$authorid
			) );
				
			if ($ret)
				$cloned_id = $wpdb->insert_id;
		}
	
		return $cloned_id;
	}
	
	function is_db_table_exists() {
	
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_gallery";
	
		return ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name );
	}
	
	function is_id_exist($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_gallery";
	
		$slider_row = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
		return ($slider_row != null);
	}
	
	function create_db_table() {
	
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_gallery";
		
		$charset = '';
		if ( !empty($wpdb -> charset) )
			$charset = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( !empty($wpdb -> collate) )
			$charset .= " COLLATE $wpdb->collate";
	
		$sql = "CREATE TABLE $table_name (
		id INT(11) NOT NULL AUTO_INCREMENT,
		name tinytext DEFAULT '' NOT NULL,
		data MEDIUMTEXT DEFAULT '' NOT NULL,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		authorid tinytext NOT NULL,
		PRIMARY KEY  (id)
		) $charset;";
			
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	
	function save_item($item) {
		
		if ( !$this->is_db_table_exists() )
			$this->create_db_table();
				
		global $wpdb, $user_ID;
		$table_name = $wpdb->prefix . "wonderplugin_gallery";
		
		$id = $item["id"];
		$name = $item["name"];
		
		unset($item["id"]);
		$data = json_encode($item);
		
		$time = current_time('mysql');
		$authorid = $user_ID;
		
		if ( ($id > 0) && $this->is_id_exist($id) )
		{
			$ret = $wpdb->query( $wpdb->prepare(
					"
					UPDATE $table_name
					SET name=%s, data=%s, time=%s, authorid=%s
					WHERE id=%d
					",
					$name,
					$data,
					$time,
					$authorid,
					$id
			) );
			
			if (!$ret)
			{
				return array(
						"success" => false,
						"id" => $id, 
						"message" => "Cannot update the gallery in database"
					);
			}
		}
		else
		{
			$ret = $wpdb->query( $wpdb->prepare(
					"
					INSERT INTO $table_name (name, data, time, authorid)
					VALUES (%s, %s, %s, %s)
					",
					$name,
					$data,
					$time,
					$authorid
			) );
			
			if (!$ret)
			{
				return array(
						"success" => false,
						"id" => -1,
						"message" => "Cannot insert the gallery to database"
				);
			}
			
			$id = $wpdb->insert_id;
		}
		
		return array(
				"success" => true,
				"id" => intval($id),
				"message" => "Gallery published!"
		);
	}
	
	function get_list_data() {
		
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_gallery";
		
		$rows = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A);
		
		$ret = array();
		
		if ( $rows )
		{
			foreach ( $rows as $row )
			{
				$ret[] = array(
							"id" => $row['id'],
							'name' => $row['name'],
							'data' => $row['data'],
							'time' => $row['time'],
							'author' => $row['authorid']
						);
			}
		}
	
		return $ret;
	}
	
	function get_item_data($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_gallery";
	
		$ret = "";
		$item_row = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
		if ($item_row != null)
		{
			$ret = $item_row->data;
		}

		return $ret;
	}
	
	function get_settings() {
		
		$userrole = get_option( 'wonderplugin_gallery_userrole' );
		if ( $userrole == false )
		{
			update_option( 'wonderplugin_gallery_userrole', 'manage_options' );
			$userrole = 'manage_options';
		}
		
		$keepdata = get_option( 'wonderplugin_gallery_keepdata', 1 );
		
		$settings = array(
			"userrole" => $userrole,
			"keepdata" => $keepdata
		);
		
		return $settings;
	}
	
	function save_settings($options) {
		
		if (!isset($options) || !isset($options['userrole']))
			$userrole = 'manage_options';
		else if ( $options['userrole'] == "Editor") 
			$userrole = 'moderate_comments';
		else if ( $options['userrole'] == "Author")
			$userrole = 'upload_files';
		else
			$userrole = 'manage_options';
		update_option( 'wonderplugin_gallery_userrole', $userrole );
		
		if (!isset($options) || !isset($options['keepdata']))
			$keepdata = 0;
		else
			$keepdata = 1;
		update_option( 'wonderplugin_gallery_keepdata', $keepdata );
	}
}
