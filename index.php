<?php

//////////////////////////
// Steps
//////////////////////////
//
// 1) Create new service account in the Buro 3 Instant Indexing project (Google Cloud Console)
// 2) Add service_account_file.json to json_files
// 3) Add the user to the project in Google Search Console
// 4) Add your links to the URL input
// 5) Set the action (getstatus / update / delete)
//

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

$client = new Google_Client();

// service_account_file.json is the private key that you created for your service account.
$client->setAuthConfig('json_files/transtune_service_account.json');
$client->addScope('https://www.googleapis.com/auth/indexing');

// Batch request.
$client->setUseBatch( true );

// init google batch and set root URL.
$service = new Google_Service_Indexing( $client );
$batch   = new Google_Http_Batch( $client, false, 'https://indexing.googleapis.com' );

// URL input
$url_input = array('https://www.transtune.nl/product/abarth-slip-on-line-ss/m-fi-ss-1h/', 'https://www.transtune.nl/chiptuning/uitlaten/');

// Action (gestatus / update)
$action = 'update';

foreach ( $url_input as $i => $url ) {
	$post_body = new Google_Service_Indexing_UrlNotification();
	if ( $action === 'getstatus' ) {
		$request_part = $service->urlNotifications->getMetadata( [ 'url' => $url ] ); // phpcs:ignore
	} else {
		$post_body->setType( $action === 'update' ? 'URL_UPDATED' : 'URL_DELETED' );
		$post_body->setUrl( $url );
		$request_part = $service->urlNotifications->publish( $post_body ); // phpcs:ignore
	}
	$batch->add( $request_part, 'url-' . $i );
}

$results   = $batch->execute();
$data      = [];
$res_count = count( $results );
foreach ( $results as $id => $response ) {
	// Change "response-url-1" to "url-1".
	$local_id = substr( $id, 9 );
	if ( is_a( $response, 'Google_Service_Exception' ) ) {
		$data[ $local_id ] = json_decode( $response->getMessage() );
	} else {
		$data[ $local_id ] = (array) $response->toSimpleObject();
	}
	if ( $res_count === 1 ) {
		$data = $data[ $local_id ];
	}
}

print_r_pre($data);


///////////////////////////////////////////////////////////////////////////////////////////////////// ALG - print_r_pre functie
function print_r_pre($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

?>