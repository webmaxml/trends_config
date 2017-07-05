<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class Platform {

	private static $instance;

	private $url = 'http://alltrends.biz/api/cpa';
    private $api_key = 'base64:RDE8gd6Lydf/KduN4ofRiHjadZCr7ySe2qIJHOlmD14=';

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		
	}

	public function getStatistics( $data ) {
		$data[ 'api_key' ] = $this->api_key;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . '/statistics' );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode( $response, true );

        return $response;
	}
}