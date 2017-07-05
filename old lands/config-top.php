<?php

// functions
function getConfigData( $url ) {
    $handler = curl_init();
    curl_setopt( $handler, CURLOPT_URL, $url );
    curl_setopt( $handler, CURLOPT_RETURNTRANSFER, true );
    $data = json_decode( curl_exec( $handler ) );
    curl_close( $handler );

    return $data;
}

function getUpsellQuery( $param_name ) {
    $query = '';
    $upsell_from = $_SERVER[ 'HTTP_HOST' ];

    $has_query = $_SERVER[ 'QUERY_STRING' ] !== '';
    $has_param = isset( $_GET[ $param_name ] );

    if( $has_query ) {

        if ( $has_param ) {
            $param_origin = '/'. $param_name .'='. $_GET[ $param_name ] .'/';
            $param_replace = $param_name .'=' . $_GET[ $param_name ] . ', doprodazha-iz-' . $upsell_from;

            $query .= '?' . preg_replace( $param_origin, $param_replace, $_SERVER[ 'QUERY_STRING' ] );
        } else {
            $query .= '?'. $_SERVER[ 'QUERY_STRING' ] .'&'. $param_name .'=doprodazha-iz-'. $upsell_from;
        }

    } else {
        $query .= '?'. $param_name .'=doprodazha-iz-'. $upsell_from;
    }

    return $query;
}

function getLayerTargetUrl( $domain, $param_name ) {
    $layer_name = $_SERVER[ 'HTTP_HOST' ];
    $query = '';
    $has_query = $_SERVER['QUERY_STRING'] !== '';
    $has_param = isset( $_GET[ $param_name ] );

    if( $has_query ) {

        if ( $has_param ) {
            $param_origin = '/'. $param_name .'='. $_GET[ $param_name ] .'/';
            $param_replace = $param_name .'=' . $_GET[ $param_name ] . ', prokladka-' . $layer_name;

            $query .= '?' . preg_replace( $param_origin, $param_replace, $_SERVER['QUERY_STRING'] );
        } else {
            $query .= '?' . $_SERVER['QUERY_STRING'] .'&'. $param_name .'=prokladka-' . $layer_name;
        }

    } else {
        $query .= '?'. $param_name .'=prokladka-'. $layer_name;
    }

    return $domain . $query;
}

function doRedirection( $urls ) {
    $query = '';
    if( $_SERVER['QUERY_STRING'] !== '' ) {
        $query .= '?' . $_SERVER['QUERY_STRING'];
    }

    $redirect = $urls[ array_rand( $urls ) ];

    // avoiding cicle
    if ( $redirect !== 'http://' . $_SERVER[ 'HTTP_HOST' ] . '/' ) {
        header( "Location: " . $redirect . $query );
        die();
    }
}

// vars
$config_host = 'http://config.all-trends.top';
$config_url = $config_host . '/api?host=' . urlencode( 'http://' . $_SERVER[ 'HTTP_HOST' ] . '/' );
$config_data = getConfigData( $config_url );
$isIndex = stripos( $_SERVER[ 'PHP_SELF' ], 'index' ) === false ? false : true;

// ab testing
if ( $config_data->ab_test === 'on' &&
     is_array( $config_data->redirections ) ) {

    doRedirection( $config_data->redirections );
}

// debug
// echo '<pre>';
// print_r( $config_data );
// echo '</pre>';