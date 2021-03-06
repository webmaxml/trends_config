<?php
session_start();

require 'config.php';
require 'controllers/ConfigController.php';

require 'classes/Request.php';
require 'classes/Client.php';
require 'classes/MainVars.php';
require 'classes/OrderForm.php';
require 'classes/Transit.php';
require 'classes/Upsells.php';
require 'classes/OrdersWidget.php';

$controller = new ConfigController();
$controller->init();

extract( $controller->getTemplateVars() );

// for platform title
function getTitle( $default ) {
	global $title;

	return empty( $title ) ? $default : $title;
}

// for additional old prices
function getOldPrice( $newPrice ) {
	global $skidka;

	return round( $newPrice / ( ( 100 - $skidka ) / 100 ) );
}
