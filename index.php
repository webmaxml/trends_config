<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

// classes
require 'classes/AltoRouter.php';
require 'classes/FileDB.php';
require 'classes/ApiManager.php';
require 'classes/Order.php';
require 'classes/Platform.php';
require 'classes/User.php';
require 'classes/Lands.php';
require 'classes/Images.php';
require 'classes/Upsells.php';
require 'classes/Seller.php';
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

$router->map( 'GET', '/land-upsells', function() {
	FrontController::getInstance()->getLandUpsells();
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

$router->map( 'GET', '/layers', function() {
	FrontController::getInstance()->getLayers();
} );

$router->map( 'GET', '/abtest', function() {
	FrontController::getInstance()->getAbtest();
} );

$router->map( 'GET', '/seller', function() {
	FrontController::getInstance()->getSeller();
} );

$router->map( 'GET', '/orderData', function() {
	FrontController::getInstance()->getOrderData();
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

$router->map( 'POST', '/test-create', function() {
	FrontController::getInstance()->createTest();
} );

$router->map( 'POST', '/layer-create', function() {
	FrontController::getInstance()->createLayer();
} );

$router->map( 'POST', '/seller-update', function() {
	FrontController::getInstance()->updateSeller();
} );

$router->map( 'POST', '/order-update', function() {
	FrontController::getInstance()->updateOrder();
} );


$router->map( 'POST', '/order', function() {
	FrontController::getInstance()->processOrder();
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

$router->map( 'GET', '/land-update-upsells', function() {
	ApiController::getInstance()->updateLandUpsells();
} );

$router->map( 'GET', '/land-update-script', function() {
	ApiController::getInstance()->updateLandScript();
} );

$router->map( 'GET', '/land-upsell-toggle', function() {
	ApiController::getInstance()->toggleLandUpsell();
} );

$router->map( 'GET', '/test-update', function() {
	ApiController::getInstance()->updateTest();
} );

$router->map( 'GET', '/land-test-toggle', function() {
	ApiController::getInstance()->toggleLandTest();
} );

$router->map( 'GET', '/land-delete', function() {
	ApiController::getInstance()->deleteLand();
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


$router->map( 'GET', '/api', function() {
	ApiController::getInstance()->getDataForUrl();
} );

$router->map( 'POST', '/api', function() {
	ApiController::getInstance()->getData();
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
