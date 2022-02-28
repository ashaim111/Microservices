<?php

	use prodigyview\network\Request;

	require 'vendor/autoload.php';
	require 'mongo_connection/connection.inc';
	require 'headers/api_headers.inc';

	# Connect to lists database
	$client = $client->lists;

	$request = new Request();

	$method = strtolower($request->getRequestMethod());

	$data = $request->getRequestData('array');

	if($method == "get" && isset($data['api'])) {
		switch($data['api']) {
			case 'getCountries':
				getCountries();
			break;
			
			default:
				hello();
		}
	} else {
		hello();
	}

	function hello() {
		$response  = array();
		$response['success'] = true;
		$response['message'] = "Hello!";
		echo json_encode($response);
	}

	function getCountries() {
		global $client;

		# Need countries collection from lists
		$collection = $client->countries->find();

		$countries_list = array();

		foreach($collection as $document) {
			array_push($countries_list, $document['country_name']);
		}

		$response  = array();
		$response['success'] = true;
		$response['data'] = $countries_list;
		
		echo json_encode($response);
	}