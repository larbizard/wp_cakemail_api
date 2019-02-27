<?php 
	/*
		Author: Savoir-Faire Linux
		Contributor: Gharib Larbi
		Function: cakemail_api_client
	
		How to use:

		1- Contact Cakemail (or one of their distributors ex: Courilleur) and ask for you api_key that is related to you email and password

		2- Once you get these informations use the following curl command to get your related user_key:
		curl -H 'apikey: YOUR_API_KEY_PROVIDED_BY_CAKEMAIL' -d 'email=YOUR_EMAIL&password=YOUR_PASSWORD' https://api.wbsrvc.com/User/Login

		3- Add this code in the functions.php file in your Wordpress Theme and use [compteur_signatures lang="fr"] or [compteur_signatures] shortcode anywhere in your Wordpress pages or posts
	*/

	/*
		Global configuration:
	*/
	$unique_api_key = 'YOUR_API_KEY_PROVIDED_BY_CAKEMAIL';
	$unique_user_key = 'YOUR_USER_KEY_PROVIDED_BY_CAKEMAIL';
	$unique_list_id = 'YOUR_CAKEMAIL_LIST_ID';

	function cakemail_api_client_list_counter($list_id, $api_key, $user_key){
		$url = 'https://api.wbsrvc.com/List/Show/';
		$result = wp_remote_post( $url, array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array('apikey' => $api_key),
			'body' => array(
				'user_key' => $user_key, 
				'list_id' => $list_id,
				'count'     => 'true',
				'status'    => 'active',
				),
			'cookies' => array()
			)
		);

		if ( is_wp_error( $result ) ) {
			$error_message = $result->get_error_message();
			return "Something went wrong: $error_message";
		} else {
			if (isset($result)) {
				$json_object = json_decode($result[body], true);
				if ($json_object['status'] == 'success') {
					foreach($json_object['data'] as $key => $value) {
						if($key=="count")
						{
							return $value;
						}
						else{
							return "ERROR no Key count found: " . print_r($result);
						}
					}
				} else {
					return "Curl API Request failed: " . print_r($result);
				}
			}
		}
	}

	function get_sign_count($atts)
	{
		$a = shortcode_atts( array(
			'lang' => 'fr'
		), $atts );
		
		$lang = $a['lang'];

		$count = cakemail_api_client_list_counter($unique_list_id, $unique_api_key, $unique_user_key);
		
		if(is_numeric($count)){
			if($lang == 'en'){
				$formattedNumber = number_format($count);
			}else{
				$formattedNumber = number_format($count, 0, ',', ' ');
			}
		}
		else{
			$formattedNumber = $count;
		}

		
		return $formattedNumber;
			
	}
	add_shortcode( 'subscribers_counter', 'get_sign_count' );
?>