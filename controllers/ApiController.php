<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class ApiController {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->lands = Lands::getInstance();
		$this->upsells = Upsells::getInstance();
		$this->images = Images::getInstance();
		$this->apiManager = ApiManager::getInstance();
		$this->platform = Platform::getInstance();
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

	public function toggleLandTest() {
		$values = array();

		$values[ 'ab_test' ] = $_GET[ 'value' ] === 'true' ? 'on' : 'off';

		$result = $this->lands->update( $_GET[ 'id' ], $values );
		$result === false ? false : true;

		echo json_encode( array( 'success' => $result, 'data' => $_GET[ 'value' ] ) );
		die();
	}

	public function updateTest() {
		$values = array();
		$values[ 'redirections' ] = isset( $_GET[ 'redirects' ] ) ? $_GET[ 'redirects' ] : '';

		if ( !$_GET[ 'redirects' ] ) {
			$values[ 'ab_test' ] = 'off';
		}
		
		$result = $this->lands->update( $_GET[ 'entry' ], $values );
		$result === false ? false : true;

		echo json_encode( array( 'success' => $result ) );
		die();
	}

	public function getUpsellData() {
		$data = $this->upsells->getDataById( $_GET[ 'id' ] );

		echo json_encode( $data );
		die();
	}

	public function updateUpsell() {
		$values = array();

		$values[ 'name' ] = isset( $_GET[ 'name' ] ) ? $_GET[ 'name' ] : '';
		$values[ 'title' ] = isset( $_GET[ 'title' ] ) ? $_GET[ 'title' ] : '';
		$values[ 'description' ] = isset( $_GET[ 'description' ] ) ? $_GET[ 'description' ] : '';
		$values[ 'price' ] = isset( $_GET[ 'price' ] ) ? $_GET[ 'price' ] : '';
		$values[ 'currency' ] = isset( $_GET[ 'currency' ] ) ? $_GET[ 'currency' ] : '';
		$values[ 'image' ] = isset( $_GET[ 'image' ] ) ? $_GET[ 'image' ] : '';
		$values[ 'url' ] = isset( $_GET[ 'url' ] ) ? $_GET[ 'url' ] : '';

		$result = $this->upsells->update( $_GET[ 'id' ], $values );
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

	public function deleteImage() {
		$result =  $this->images->delete( $_GET[ 'id' ], $_GET[ 'name' ] );

		echo json_encode( array( 'success' => $result ) );
		die();
	}

	// need to go from get to post and getData() method so delete in future
	public function getDataForUrl() {
		$result = $this->apiManager->getDataForUrl( $_GET[ 'host' ] );

		echo json_encode( $result );
		die();
	}

	public function getData() {
		$result = $this->platform->getStatistics( $_POST );

		echo json_encode( $result );
	}

}

?>