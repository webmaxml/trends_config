<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class RequestController {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->state = State::getInstance();
	}

	public function getData() {
		$data = $this->state->getApiData( $_POST );
		echo json_encode( $data );
	}

	public function processOrder() {
		if ( empty( $_POST[ 'land_id' ] ) || 
			 empty( $_POST[ 'ip' ] ) ||
			 empty( $_POST[ 'host' ] ) ||
			 empty( $_POST[ 'name' ] ) ||
			 empty( $_POST[ 'price' ] ) ||
			 empty( $_POST[ 'phone' ] ) ) {
			echo 'Передача неполных данных';
			die();
		}

		$values = [];
		foreach ( $_POST as $key => $value ) {
			$values[ $key ] = htmlspecialchars( $value );
		}

		$result = $this->state->makeOrder( $values );

		if ( $result->status === 'ok' || !$result->errors ) {
			header( 'Location: http://' . $values[ 'host' ] . '/form-ok.php' );
			die();
		} else {
			echo '<pre>';
			print_r( $result );
			echo '</pre>';
		}
	}

}