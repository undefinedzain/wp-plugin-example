<?php
	include 'bootstrap.php';
	include_once '../../../wp-load.php';
	global $wpdb;
	$table_name = $wpdb->prefix . 'backlink_management';
	
	$url = $_POST['domain'];
	$id = $_POST['id'];
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

	$wpdb->update(
		$table_name,
		array(
			'id' => $id,
			'domain' => $url
		),
		array(
			'domain_authority' => $response['pda']
		)
	);
	echo $response['pda'];
?>