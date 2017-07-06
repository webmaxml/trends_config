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