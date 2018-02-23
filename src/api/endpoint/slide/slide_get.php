<?php
/*
*  ====>
*
*  *Get the data of a slide.*
*
*  GET parameters
*    * id = The id of the slide to get.
*
*  Return value
*    * id      = The ID of the slide.
*    * name    = The name of the slide.
*    * index   = The index of the slide.
*    * time    = The time the slide is shown.
*    * markup  = The markup of the slide.
*    * error   = An error code or API_E_OK on success.
*
*  <====
*/

require_once($_SERVER['DOCUMENT_ROOT'].'/common/php/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/php/auth/auth.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/api/api.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/api/slide.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/api/api_error.php');

$SLIDE_GET = new APIEndpoint(array(
	APIEndpoint::METHOD		=> API_METHOD['GET'],
	APIEndpoint::RESPONSE_TYPE	=> API_RESPONSE['JSON'],
	APIEndpoint::FORMAT => array(
		'id' => API_P_STR
	)
));
session_start();
api_endpoint_init($SLIDE_GET, auth_session_user());

$list = get_slides_id_list();

if (in_array($SLIDE_GET->get('id'), $list)) {
	// Get by ID.
	$slide = new Slide();
	$slide->load($SLIDE_GET->get('id'));

	$SLIDE_GET->resp_set($slide->get_data());
	$SLIDE_GET->send();
}

throw new APIException(
	API_E_INVALID_REQUEST,
	"Slide doesn't exist."
);