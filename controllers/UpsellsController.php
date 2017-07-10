<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class UpsellsController {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->upsells = Upsells::getInstance();
	}

	public function createUpsell() {
		global $config;

		$input = [];
		foreach ( $_POST as $key => $value ) {
			$input[ $key ] = htmlspecialchars( $value );
		}

		$result = $this->upsells->create( $input );

		if ( $result === false ) {
			header( "Location: " . $config[ 'base_url' ] . '/upsells?upsell_status=2' );
			exit;
		} else {
			header( "Location: " . $config[ 'base_url' ] . '/upsells?upsell_status=1' );
			exit;
		} 
	}

	public function getUpsellData() {
		$data = $this->upsells->getDataById( $_GET[ 'id' ] );

		echo json_encode( $data );
		die();
	}

	public function updateUpsell() {
		$values = array();

		$input = [];
		foreach ( $_GET as $key => $value ) {
			$input[ $key ] = htmlspecialchars( $value );
		}

		$result = $this->upsells->update( $_GET[ 'id' ], $input );
		$result === false ? false : true;

		echo json_encode( array( 'success' => $result ) );
		die();
	}

	public function deleteUpsell() {
		$result = $this->upsells->delete( $_GET[ 'id' ] );
		$result === false ? false : true;

		echo json_encode( array( 'success' => $result ) );
		die();
	}

}