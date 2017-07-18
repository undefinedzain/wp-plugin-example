<?php 
	
	include_once '../../../wp-load.php';
	global $wpdb;
	$table_name = $wpdb->prefix . 'backlink_management';

	$id = $_POST['id'];
	$domain = $_POST['domain'];

	$wpdb->delete(
		$table_name,
		array(
			'id' => $id,
			'domain' => $domain
			)
		);
?>