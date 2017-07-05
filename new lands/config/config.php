<?
$config_host = 'http://config.all-trends.top';
$order_url = 'http://config.all-trends.top/order';
// $config_url = $config_host . '/api?host=' . urlencode( 'http://' . $_SERVER[ 'HTTP_HOST' ] . '/' );
$config_url = $config_host . '/api';
$isIndex = stripos( $_SERVER[ 'PHP_SELF' ], 'index' ) === false ? false : true;