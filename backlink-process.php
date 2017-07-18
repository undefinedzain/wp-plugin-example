<?php

	include_once '../../../wp-load.php';
	global $wpdb;
	$table_name = $wpdb->prefix .'backlink_management';
	include 'bootstrap.php';
	
	$backlink_type = $_POST['backlink-type'];
	$url = $_POST['backlink'];
     //  access id and secret key from http://www.seomoz.org/api/keys
    $AccessID = 'mozscape-85dc2696';

	// Add your secretKey here
	$SecretKey = 'af2eff36218902dc3356fdca89e3714c';

	// Set the rate limit
	$rateLimit = 10;

	$authenticator = new Authenticator();
	$authenticator->setAccessID($AccessID);
	$authenticator->setSecretKey($SecretKey);
	$authenticator->setRateLimit($rateLimit);

	// URL to query
	// $objectURL = "https://facebook.com/messages";
	$objectURL = $url;

	// Metrics to retrieve (url_metrics_constants.php)
	$cols = URLMETRICS_COL_DEFAULT;

	$urlMetricsService = new URLMetricsService($authenticator);
	$response = $urlMetricsService->getUrlMetrics($objectURL, $cols);

	$main_domain = '';
	$domain = '';
	if (preg_match("/https/", $objectURL)) {
		$domain = parse_url($objectURL, PHP_URL_HOST);
		$main_domain = "https://".$domain;
	}elseif (preg_match("/http/", $objectURL)) {
		$domain = parse_url($objectURL, PHP_URL_HOST);
		$main_domain = "http://".$domain;
	}elseif (!preg_match("/http/", $objectURL)) {
		$main_domain = "http://".$url;
	}

	// pda = domain authority
	// upa = page authority
	// uu = domain
	$GLOBALS['wpdb']->insert(
		$table_name,
		array(
			'id' => '',
			'domain' => $main_domain,
			'domain_authority' => $response['pda'],
			'backlink_type' => $backlink_type
			)
		);
	header("location:../../../wp-admin/admin.php?page=backlink-management&success=true");

?>