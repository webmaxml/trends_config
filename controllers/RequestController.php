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
	}

	public function getData() {
		$state = State::getSourceState();

		$data = $state->getApiData( $_POST );
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

		$state = State::getSourceState();

		$values = [];
		foreach ( $_POST as $key => $value ) {
			$values[ $key ] = htmlspecialchars( $value );
		}

		$result = $state->makeOrder( $values );

		if ( $result->status === 'ok' || !$result->errors ) {
			$mail_result = $state->sendMail( $values );

			if ( $mail_result ) {
				header( 'Location: http://' . $values[ 'host' ] . '/form-ok.php' );
				die();
			}

		} 
		
		// if something goes wrong
		echo '<pre>';
		print_r( $result );
		echo '</pre><br><br>';
		echo 'mail status:<br>';
		echo var_dump( $result );
	}

}