<?php

	require_once __DIR__ . '/vendor/autoload.php';

	$redirect = 'http://packetcode.com/apps/fblogin5/';
	
	$fb = new Facebook\Facebook([
	  'app_id' => '164735766925437',
	  'app_secret' => 'f995936dfc78e3057fdaca03fc470fe9',
	  'default_graph_version' => 'v2.5',
	]);

	

$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

	// Sets the default fallback access token so we don't have to pass it to each request
	$fb->setDefaultAccessToken($accessToken);

	try {
	  $response = $fb->get('/me');
	  $userNode = $response->getGraphUser();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  // When Graph returns an error
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  // When validation fails or other local issues
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}

	echo 'Logged in as ' . $userNode->getName();
	
}

