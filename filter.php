<?php 
	
	global $wpdb;
	$pattern = $_POST['filter'];
	echo $pattern;

	if ($pattern == 'comment') {
		header("location:../../../wp-admin/admin.php?page=backlink-management&filter=comment");
	}elseif ($pattern == 'profile') {
		header("location:../../../wp-admin/admin.php?page=backlink-management&filter=profile");
	}elseif ($pattern == 'contextual') {
		header("location:../../../wp-admin/admin.php?page=backlink-management&filter=contextual");
	}elseif($pattern == 'social bookmark') {
		header("location:../../../wp-admin/admin.php?page=backlink-management&filter=social-bookmark");
	}elseif ($pattern == 0) {
		header("location:../../../wp-admin/admin.php?page=backlink-management");
	}
?>