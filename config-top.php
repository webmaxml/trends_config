<?php
// vars
$config_host = 'http://config.all-trends.top';
$config_url = $config_host . '/api?host=' . urlencode( 'http://' . $_SERVER[ 'HTTP_HOST' ] . '/' );
$isIndex = stripos( $_SERVER[ 'PHP_SELF' ], 'index' ) === false ? false : true;

// data request
$handler = curl_init();
curl_setopt( $handler, CURLOPT_URL, $config_url );
curl_setopt( $handler, CURLOPT_RETURNTRANSFER, true );
$config_data = json_decode( curl_exec( $handler ) );
curl_close( $handler );

// upsell query config 
// setting data info upsell transit to a query param
$upsell_query = '';
$param_name = 'utm_medium';
$upsell_from = $_SERVER[ 'HTTP_HOST' ];

$has_query = $_SERVER[ 'QUERY_STRING' ] !== '';
$has_param = isset( $_GET[ $param_name ] );

if( $has_query ) {

    if ( $has_param ) {
        $param_origin = '/'. $param_name .'='. $_GET[ $param_name ] .'/';
        $param_replace = $param_name .'=' . $_GET[ $param_name ] . ', doprodazha-iz-' . $upsell_from;

        $upsell_query .= '?' . preg_replace( $param_origin, $param_replace, $_SERVER[ 'QUERY_STRING' ] );
    } else {
        $upsell_query .= '?'. $_SERVER[ 'QUERY_STRING' ] .'&'. $param_name .'=doprodazha-iz-'. $upsell_from;
    }

} else {
    $upsell_query .= '?'. $param_name .'=doprodazha-iz-'. $upsell_from;
}

// ab testing
if ( $config_data->ab_test === 'on' &&
	 is_array( $config_data->redirections ) ) {

	$redirect_query = '';
    if( $_SERVER['QUERY_STRING'] !== '' ) {
        $redirect_query .= '?' . $_SERVER['QUERY_STRING'];
    }

    $redirect = $config_data->redirections[ array_rand( $config_data->redirections ) ];
    header( "Location: " . $redirect . $redirect_query );
}

// debug
// echo '<pre>';
// print_r( $config_data );
// echo '</pre>';