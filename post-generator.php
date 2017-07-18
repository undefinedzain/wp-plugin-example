<?php
/*
Plugin Name: Post generator
Description: Post generator
Version: 0.1
Author: Akhmad Romadlon Zainur Rofiq & Widada
Author URI: http://muslimevents.id
Text Domain: Post generator
License: GPLv2 or later
*/

// Gaboleh akses file langsung
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// fungsi yang kita panggil ketika plugin di install
register_activation_hook( __FILE__, 'backlink_management_install' );

// fungsi install
// disini kita bisa bikin tabel, dll.
// terserah mau ngapain pas plugin abis di install
function backlink_management_install() {
	// global $wpdb;
	// $table_name = $wpdb->prefix . 'backlink_management';
	// $charset_collate = $wpdb->get_charset_collate();
	// $sql = "CREATE TABLE IF NOT EXISTS $table_name (
	// 	id int(9) AUTO_INCREMENT,
	// 	user_id int(9),
	// 	domain varchar(1000),
	// 	domain_authority varchar(64),
	// 	backlink_type varchar(24),
	// 	primary key (id)
	// ) $charset_collate;";
	// $wpdb->query( $sql );
	// backlink_management_install_data();
}

function pre($data, $die=false){
    echo "<pre>".print_r($data, 1)."</pre>";
    if(!empty($die)){
        die();
    }
}

// nambahin css tambahan
wp_register_style( 'stylish', '/wp-content/plugins/post-generator/custom.css');
wp_enqueue_style('stylish');

// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
// Nambahin menu di sidebar halaman admin
add_action('admin_menu', 'mt_add_pages');

// nambah menu
function mt_add_pages() {
	$icon_url = plugin_dir_url( __FILE__ ). 'images/sintesa-admin-icon-new.png';
    add_menu_page(__('Post generator','Post generator'), __('Post generator','menu-test'), 'manage_options', 'post-generator', 'mt_toplevel_page',$icon_url, '23,56' );
}


// fungsi view halaman nya
function mt_toplevel_page() { 
	ob_start();
	?>
	<?php
    	global $wpdb;
    	$table_name = $wpdb->prefix . 'backlink_management';
    	$filter = '';
    	if (isset($_GET['filter'])) {
    		$filter = "WHERE backlink_type LIKE '".$_GET['filter']."' ";
    	}else{
    		$filter = '';
    	}

		$result = $wpdb->get_results("SELECT * from $table_name ".$filter);
		if (isset($_GET['success']) && $_GET['success'] == 'true') { ?>
	
			<div id='message' class='updated notice notice-success is-dismissible' style='margin: 15px 2px;'>
			<p>Posts have been generated succesfully.</p>
			<button type='button' class='notice-dismiss'><span class='screen-reader-text'>Dismiss this notice.</span></button></div>
	
		<?php } ?>
    
	<h2 class="page-title">Auto generate post</h2>
	<form class="post-form" style="width:50%;margin:0 auto;" action="../wp-content/plugins/post-generator/autogenerate-process.php" method='post'>
		<label>Title</label>
		<input type="text" class="form-control" name="title"><br>
		<label>Prefix</label>
		<input type="text" class="form-control" name="prefix"><br>
		<label>Sufix</label>
		<input type="text" class="form-control" name="sufix"><br>
		<label>Konten</label>
		<textarea class="form-control" style="min-height: 210px;resize: vertical;"></textarea><br>
		<button class="button button-primary button-large">Post</button>
		<button class="button button-primary button-large">Draft</button>
	</form>
	
	<script type='text/javascript' src='../wp-content/plugins/sintesa-backlink-management/jquery-2.1.4.min.js'></script>
<?php
	$page = ob_get_contents();
   	ob_end_clean();
   	// echo halaman nya
   	echo $page;
}

?>