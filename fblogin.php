<?php

	# 1. Installation
		# a. Start Session
		session_start();
		# b. Include the auto load file
		require_once __DIR__.'/vendor/autoload.php';
		# c. Facebook object with parameters
		$fb = new Facebook\Facebook([
			'app_id'=>'PUT YOUR APP ID HERE',
			'app_secret'=>'PUT YOUR APP SECRET HERE',
			'default_graph_version'=>'v2.5']);
		$redirect = 'http://pacektcode.com/apps/fblogin5/';

	# 2. Base Code
		$helper = $fb->getRedirectLoginHelper();

		try{
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

		# a. Print login url if no access code
		if(!isset($accessToken)){
			$permissions=['email'];
			$loginUrl=$helper->getLoginUrl($redirect,$permissions);
			echo '<a href="'.$loginUrl.'">Login with facebook!</a>';
		}
		# b. Else retrive the data
		else{
				$fb->setDefaultAccessToken($accessToken);
				$response= $fb->get('/me?fields=email,name');
				$userNode = $response->getGraphUser();

				echo 'Name: ' . $userNode->getName().'<br>';
				echo 'User ID: ' . $userNode->getId().'<br>';
				echo 'Email: ' . $userNode->getProperty('email').'<br><br>';

				$image = 'https://graph.facebook.com/'.$userNode->getId().'/picture?width=200';
				echo "Picture<br>";
				echo "<img src='$image' /><br><br>";
		}






















