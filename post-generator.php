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
    	// $table_name = $wpdb->prefix . 'backlink_management';
		// $result = $wpdb->get_results("SELECT * from $table_name ".$filter);
		if (isset($_GET['success']) && $_GET['success'] == 'true') { ?>
	
			<div id='message' class='updated notice notice-success is-dismissible' style='margin: 15px 2px;'>
			<p>Posts have been generated succesfully.</p>
			<button type='button' class='notice-dismiss'><span class='screen-reader-text'>Dismiss this notice.</span></button></div>
	
		<?php } ?>
    
	<h2 class="page-title">Auto generate post</h2>
	<div class="post-form">
		<label>Title</label>
		<input type="text" value="Pancake durian" class="form-control post_title" name="title" placeholder="Post title"><br>
		<label>Prefix</label>
		<input type="text" value="jual,info,harga" class="form-control post_prefix" name="prefix" placeholder="Post prefix"><br>
		<label>Sufix</label>
		<input type="text" value="Semarang,Jakarta,Aceh" class="form-control post_sufix" name="sufix" placeholder="Post sufix"><br>
		<label>Content</label>
		<textarea class="form-control post_content" placeholder="Post content">{halo|bro|sis} jual {murah|miring}</textarea><br>
		<button class="button button-primary button-large" id="post">Post</button>
		<!-- <button class="button button-primary button-large">Draft</button> -->
	</div>
	<!-- Pancake durian -->
	<!-- jual,info,harga -->
	<!-- Semarang,Jakarta,Aceh -->
	<!-- {halo|bro|sis} jual {murah|miring} -->
	<div id="loading">
		<div class="cssload-jar">
			<div class="cssload-mouth"></div>
			<div class="cssload-neck"></div>
			<div class="cssload-base">
				<div class="cssload-liquid"> </div>
				<div class="cssload-wave"></div>
				<div class="cssload-wave"></div>
				<div class="cssload-bubble"></div>
				<div class="cssload-bubble"></div>
			</div>
			<div class="cssload-bubble"></div>
			<div class="cssload-bubble"></div>
		</div>
		<h1>Loading ...</h1>
	</div>
	<div class="post-result">
		<ul class="post-results"></ul>
	</div>
	<script type='text/javascript' src='../wp-content/plugins/post-generator/jquery-2.1.4.min.js'></script>
<?php
	wp_enqueue_script('autogenerate-process','/wp-content/plugins/post-generator/process.js');
	$page = ob_get_contents();
   	ob_end_clean();
   	// echo halaman nya
   	echo $page;
}

?>