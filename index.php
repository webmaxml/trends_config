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
require 'classes/Products.php';
// controllers
require 'controllers/FrontController.php';
require 'controllers/ApiController.php';
require 'controllers/RequestController.php';
require 'controllers/ProductsController.php';
require 'controllers/LandsController.php';
require 'controllers/MediaController.php';
require 'controllers/UpsellsController.php';
// config
require 'data/config.php';

$router = new AltoRouter;


/**
 * pages
 */

$router->map( 'GET', '/', function() {
	FrontController::getInstance()->getRoot();
} );

$router->map( 'GET', '/products', function() {
	FrontController::getInstance()->getProducts();
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

$router->map( 'GET', '/platformData', function() {
	FrontController::getInstance()->getPlatformData();
} );

/**
 * products
 */

$router->map( 'POST', '/product-create', function() {
	ProductsController::getInstance()->createProduct();
} );

$router->map( 'GET', '/product-data', function() {
	ProductsController::getInstance()->getProductData();
} );

$router->map( 'GET', '/product-update', function() {
	ProductsController::getInstance()->updateProduct();
} );

$router->map( 'GET', '/product-delete', function() {
	ProductsController::getInstance()->deleteProduct();
} );

/**
 * landings
 */

$router->map( 'POST', '/land-create', function() {
	LandsController::getInstance()->createLand();
} );

$router->map( 'GET', '/land-data', function() {
	LandsController::getInstance()->getLandData();
} );

$router->map( 'GET', '/land-update', function() {
	LandsController::getInstance()->updateLand();
} );

$router->map( 'GET', '/land-update-script', function() {
	LandsController::getInstance()->updateLandScript();
} );

$router->map( 'GET', '/land-delete', function() {
	LandsController::getInstance()->deleteLand();
} );

$router->map( 'GET', '/land-update-upsells', function() {
	LandsController::getInstance()->updateLandUpsells();
} );

$router->map( 'GET', '/land-upsell-toggle', function() {
	LandsController::getInstance()->toggleLandUpsell();
} );

/**
 * layers
 */

$router->map( 'POST', '/layer-create', function() {
	LandsController::getInstance()->createLayer();
} );

$router->map( 'GET', '/layer-delete', function() {
	LandsController::getInstance()->deleteLayer();
} );

/**
 * media
 */

$router->map( 'POST', '/image-upload', function() {
	MediaController::getInstance()->uploadImage();
} );

$router->map( 'GET', '/image-delete', function() {
	MediaController::getInstance()->deleteImage();
} );

/**
 * upsells
 */

$router->map( 'POST', '/upsell-create', function() {
	UpsellsController::getInstance()->createUpsell();
} );

$router->map( 'GET', '/upsell-data', function() {
	UpsellsController::getInstance()->getUpsellData();
} );

$router->map( 'GET', '/upsell-update', function() {
	UpsellsController::getInstance()->updateUpsell();
} );

$router->map( 'GET', '/upsell-delete', function() {
	UpsellsController::getInstance()->deleteUpsell();
} );



// actions

$router->map( 'POST', '/login', function() {
	FrontController::getInstance()->loginUser();
} );

$router->map( 'POST', '/logout', function() {
	FrontController::getInstance()->logoutUser();
} );




$router->map( 'POST', '/test-create', function() {
	FrontController::getInstance()->createTest();
} );

$router->map( 'POST', '/seller-update', function() {
	FrontController::getInstance()->updateSeller();
} );

$router->map( 'POST', '/order-update', function() {
	FrontController::getInstance()->updateOrder();
} );

$router->map( 'POST', '/platform-update', function() {
	FrontController::getInstance()->updatePlatform();
} );


/**
 * API routes
 */

$router->map( 'GET', '/test-update', function() {
	ApiController::getInstance()->updateTest();
} );

$router->map( 'GET', '/land-test-toggle', function() {
	ApiController::getInstance()->toggleLandTest();
} );




$router->map( 'GET', '/api', function() {
	ApiController::getInstance()->getDataForUrl();
} );

$router->map( 'POST', '/api', function() {
	RequestController::getInstance()->getData();
} );

$router->map( 'POST', '/order', function() {
	RequestController::getInstance()->processOrder();
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
