<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

// classes
require 'classes/AltoRouter.php';
require 'classes/FileDB.php';
require 'classes/User.php';
require 'classes/Lands.php';
require 'classes/Images.php';
require 'classes/Upsells.php';
// controllers
require 'controllers/FrontController.php';
require 'controllers/ApiController.php';
// config
require 'data/config.php';

$router = new AltoRouter;

/**
 * Web routes
 */

// pages
$router->map( 'GET', '/', function() {
	FrontController::getInstance()->getRoot();
} );

$router->map( 'GET', '/upsells', function() {
	FrontController::getInstance()->getUpsells();
} );

$router->map( 'GET', '/image-upload', function() {
	FrontController::getInstance()->getImageUpload();
} );

$router->map( 'GET', '/images', function() {
	FrontController::getInstance()->getImages();
} );


// actions
$router->map( 'POST', '/login', function() {
	FrontController::getInstance()->loginUser();
} );

$router->map( 'POST', '/logout', function() {
	FrontController::getInstance()->logoutUser();
} );

$router->map( 'POST', '/image-upload', function() {
	FrontController::getInstance()->uploadImage();
} );

$router->map( 'POST', '/land-create', function() {
	FrontController::getInstance()->createLand();
} );

$router->map( 'POST', '/upsell-create', function() {
	FrontController::getInstance()->createUpsell();
} );

/**
 * API routes
 */

$router->map( 'GET', '/land-data', function() {
	ApiController::getInstance()->getLandData();
} );

$router->map( 'GET', '/land-update', function() {
	ApiController::getInstance()->updateLand();
} );

$router->map( 'GET', '/land-delete', function() {
	ApiController::getInstance()->deleteLand();
} );

$router->map( 'GET', '/land-upsell-toggle', function() {
	ApiController::getInstance()->toggleLandUpsell();
} );

$router->map( 'GET', '/upsell-data', function() {
	ApiController::getInstance()->getUpsellData();
} );

$router->map( 'GET', '/upsell-update', function() {
	ApiController::getInstance()->updateUpsell();
} );

$router->map( 'GET', '/upsell-delete', function() {
	ApiController::getInstance()->deleteUpsell();
} );

$router->map( 'GET', '/image-delete', function() {
	ApiController::getInstance()->deleteImage();
} );

$router->map( 'GET', '/land-upsells', function() {
	ApiController::getInstance()->getLandUpsells();
} );


/**
 * for router to start processing requests
 */ 

$match = $router->match();

if( $match && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	FrontController::getInstance()->get404();
}