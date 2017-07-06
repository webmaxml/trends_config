<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class Platform {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->db = FileDB::getInstance();
	}

	public function update( $values ) {
		return $this->db->update( 'platform', false, $values );
	}

	public function getData() {
		require 'data/platform.php';
		return $content;
	}

	public function getStatistics( $data ) {
		$platform_data = $this->getData();

		$data[ 'api_key' ] = $platform_data[ 'key' ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $platform_data[ 'url' ] . '/statistics' );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode( $response, true );

        return $response;
	}
}