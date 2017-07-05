<?
class Request {

	public function __construct() {
	}

	public function getConfigData( $data ) {
		global $config_url;

		$handler = curl_init();
		curl_setopt( $handler, CURLOPT_URL, $config_url );
		curl_setopt( $handler, CURLOPT_POST, 1 );
		curl_setopt( $handler, CURLOPT_POSTFIELDS, http_build_query( $data ) );
		curl_setopt( $handler, CURLOPT_RETURNTRANSFER, true );
		$data = json_decode( curl_exec( $handler ) );
		curl_close( $handler );

		return $data;
	}

	public function redirect( $urls ) {
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

}
?>