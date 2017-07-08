<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class LandsController {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->lands = Lands::getInstance();
		$this->products = Products::getInstance();
	}

	public function createLand() {
		global $config;

		$input = [];
		foreach ( $_POST as $key => $value ) {
			$input[ $key ] = htmlspecialchars( $value );
		}		

		$result = $this->lands->create( $input[ 'name' ], $input[ 'url' ] );

		if ( $result === false ) {
			header( "Location: " . $config[ 'base_url' ] . '/?land_status=2' );
			exit;
		} else {
			header( "Location: " . $config[ 'base_url' ] . '/?land_status=1' );
			exit;
		} 
	}

	public function getLandData() {
		$data = $this->lands->getDataById( $_GET[ 'id' ] );

		echo json_encode( $data );
		die();
	}

	public function updateLand() {
		// replace all ' with " cause it breaks file system
		$values = array();
		foreach ( $_GET as $key => $value ) {
			$values[ $key ] = preg_replace( '/\'/', '"', $value );
		}

		$result = $this->lands->update( $_GET[ 'id' ], $values );
		$result === false ? false : true;

		echo json_encode( array( 'success' => $result ) );
		die();
	}

	public function updateLandScript() {
		$values = array();

		if ( isset( $_GET[ 'script_active' ] ) ) {
			$values[ 'script_active' ] = 'on';
		} else {
			$values[ 'script_active' ] = 'off';
		}

		$values[ 'script_country' ] = isset( $_GET[ 'script_country' ] ) ? $_GET[ 'script_country' ] : '';
		$values[ 'script_sex' ] = isset( $_GET[ 'script_sex' ] ) ? $_GET[ 'script_sex' ] : '';
		$values[ 'script_windows' ] = isset( $_GET[ 'script_windows' ] ) ? $_GET[ 'script_windows' ] : '';
		$values[ 'script_items' ] = isset( $_GET[ 'script_items' ] ) ? $_GET[ 'script_items' ] : '';

		$result = $this->lands->update( $_GET[ 'id' ], $values );
		$result === false ? false : true;

		echo json_encode( array( 'success' => $result ) );
		die();
	}

	public function deleteLand() {
		$result = $this->lands->delete( $_GET[ 'id' ] );
		$result === false ? false : true;

		echo json_encode( array( 'success' => $result ) );
		die();
	}

	public function updateLandUpsells() {
		$values = array();

		$values[ 'name' ] = isset( $_GET[ 'name' ] ) ? $_GET[ 'name' ] : '';
		$values[ 'url' ] = isset( $_GET[ 'url' ] ) ? $_GET[ 'url' ] : '';

		if ( isset( $_GET[ 'upsells' ] ) ) {
			$values[ 'upsells' ] = $_GET[ 'upsells' ];
			$values[ 'upsell_hit' ] = isset( $_GET[ 'upsell_hit' ] ) ? $_GET[ 'upsell_hit' ] : '';
		} else {
			$values[ 'upsells' ] = '';
			$values[ 'upsell_hit' ] = '';
		}

		$result = $this->lands->update( $_GET[ 'id' ], $values );
		$result === false ? false : true;

		echo json_encode( array( 'success' => $result ) );
		die();
	}

	public function toggleLandUpsell() {
		$values = array();

		if ( $_GET[ 'type' ] === 'index' ) {
			$values[ 'upsell_index' ] = $_GET[ 'value' ] === 'true' ? 'on' : 'off';
		} else {
			$values[ 'upsell_thanks' ] = $_GET[ 'value' ] === 'true' ? 'on' : 'off';
		}

		$result = $this->lands->update( $_GET[ 'id' ], $values );
		$result === false ? false : true;

		echo json_encode( array( 'success' => $result, 'data' => $_GET[ 'value' ] ) );
		die();
	}

	public function createLayer() {
		global $config;

		$values = array(
			'layer' => 'true',
			'layer_target' => htmlspecialchars( $_POST[ 'target' ] )
		);

		$result = $this->lands->update( $_POST[ 'layer' ], $values );

		if ( $result === false ) {
			header( "Location: " . $config[ 'base_url' ] . '/layers?layer_status=2' );
			exit;
		} else {
			header( "Location: " . $config[ 'base_url' ] . '/layers?layer_status=1' );
			exit;
		} 
	}

	public function deleteLayer() {
		$values = array(
			'layer' => 'false',
			'layer_target' => ''
		);

		$result = $this->lands->update( $_GET[ 'id' ], $values );

		echo json_encode( array( 'success' => $result ) );
		die();
	}

}