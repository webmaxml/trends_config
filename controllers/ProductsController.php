<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class ProductsController {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->products = Products::getInstance();
	}

	public function createProduct() {
		global $config;

		$input = [];
		foreach ( $_POST as $key => $value ) {
			$input[ $key ] = htmlspecialchars( $value );
		}

		$result = $this->products->create( $input[ 'name' ], $input[ 'crm_id' ] );

		if ( $result === false ) {
			header( "Location: " . $config[ 'base_url' ] . '/products?product_status=2' );
			exit;
		} else {
			header( "Location: " . $config[ 'base_url' ] . '/products?product_status=1' );
			exit;
		} 
	}

	public function getProductData() {
		$data = $this->products->getProductById( $_GET[ 'id' ] );

		echo json_encode( $data );
		die();
	}

	public function updateProduct() {
		$input[ 'name' ] = htmlspecialchars(  $_GET[ 'name' ] );
		$input[ 'crm_id' ] = htmlspecialchars(  $_GET[ 'crm_id' ] );

		$result = $this->products->update( $_GET[ 'id' ], $input );
		$result === false ? false : true;

		echo json_encode( array( 'success' => $result ) );
		die();
	}

	public function deleteProduct() {
		$result = $this->products->delete( $_GET[ 'id' ] );
		$result === false ? false : true;

		echo json_encode( array( 'success' => $result ) );
		die();
	}
}