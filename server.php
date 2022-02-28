<?php
include ('vendor/autoload.php');

use prodigyview\network\Request;
use prodigyview\network\Response;

//Create And Process The Current Request
$request = new Request();

//Get The Request Method(GET, POST, PUT, DELETE)
$method = strtolower($request->getRequestMethod());

//RETRIEVE Data From The Request
$data = $request->getRequestData('array');

//Route The Request
if ($method == 'get') {
	get($data);
} else if ($method == 'post') {
	post($data);
} else if ($method == 'put') {
	parse_str($data,$data);
	put($data);
} else if ($method == 'delete') {
	parse_str($data,$data);
	delete($data);
}

/**
 * Process all GET data to find information
 */
function get($data) {
	global $articles;
	
	$response  = array();
	
	$response['message'] = 'Hello World';
	echo Response::createResponse(200, json_encode($response));
	exit();
};

/**
 * Process all POST data to create data
 */
function post($data) {
	global $articles;
	
	$response  = array();
	
	if(isset($data['title']) && isset($data['description'])) {
		$articles[] = $data;
		$response = array('status' => 'Article Successfully Added');
	} else {
		$response = array('status' => 'Unable To Add Article');
	}
	
	echo Response::createResponse(200, json_encode($response));
	exit();

};

/**
 * Process all PUT data to update information
 */
function put($data) {
	global $articles;
	
	$response  = array();
	
	if(isset($data['id']) && isset($articles[$data['id']])) {
		if(isset($data['title'])) {
			$articles[$data['id']]['title'] = $data['title'];
		}
		
		if(isset($data['description'])) {
			$articles[$data['id']]['description'] = $data['description'];
		}
		$response = array('status' => 'Article Successfully Updated', 'content' => $articles[$data['id']]);
	} else {
		$response = array('status' => 'Unable To Update Article');
	}
	
	echo Response::createResponse(200, json_encode($response));
	exit();

};

/**
 * Process DELETE to remove data
 */
function delete($data) {
	global $articles;
	
	$response  = array();
	
	if(isset($data['id']) && isset($articles[$data['id']])) {
		unset($articles[$data['id']]);
		$response = array('status' => 'Article Deleted', 'content' => $articles);
	} else{
		$response = array('status' => 'Unable To Update Article');
	}
	
	echo Response::createResponse(200, json_encode($response));
	exit();

};