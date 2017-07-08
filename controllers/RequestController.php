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
		$this->apiManager = ApiManager::getInstance();
		$this->platform = Platform::getInstance();

		$this->source = $this->platform->getData()[ 'source' ];

		switch ( $this->source ) {
			case 'platform': $this->state = new PlatformLandState();  break;
			case 'config':   $this->state = new ConfigLandState();    break;
			// case 'auto':     $this->state = new AutoLandState();      break;
		}
	}

	/* Post data
		(
		    [host] => http://test.all-trends.top/
		    [uid] => 595dd726607c2
		    [ip] => 46.118.100.247
		    [user_agent] => Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.3646.118.100.24724442abf33625a4fc4aa83bcea66ac58
		    [utm_source] =>
		    [utm_medium] =>
		    [utm_term] =>
		    [utm_content] =>
		    [utm_campaign] =>
		)
	*/

	public function getData() {
		$this->state->getData();
	}

	public function processOrder() {
		$values = [];
		foreach ( $_POST as $key => $value ) {
			$values[ $key ] = htmlspecialchars( $value );
		}

		$this->state->processOrder( $values );
	}

}


class PlatformLandState {

	public function __construct() {
		$this->platform = Platform::getInstance();
		$this->apiManager = ApiManager::getInstance();
		$this->order = Order::getInstance();
	}

	public function getData() {
		$platform_data = $this->platform->getStatistics( $_POST );

		if ( $platform_data[ 'errors' ] ) {
			$result = $platform_data[ 'errors' ];
		} else {
			$result = $this->apiManager->getDataWithPlatform( $_POST, $platform_data );
		}

		echo json_encode( $result );
	}

	public function processOrder( $values ) {
		$this->checkOrderInput();

		$orderData = $this->order->formOrderPlatformData( $values );
		$result = $this->order->sendOrderToPlatform( $orderData );
		
		if ( !$result->errors ) {
			header( 'Location: http://' . $values[ 'host' ] . '/form-ok.php' );
			die();
		} else {
			echo '<pre>';
			print_r( $result );
			echo '</pre>';
		}

	}

	public function checkOrderInput() {
		if ( empty( $_POST[ 'land_id' ] ) || 
			 empty( $_POST[ 'ip' ] ) ||
			 empty( $_POST[ 'uid' ] ) ||
			 empty( $_POST[ 'host' ] ) ||
			 empty( $_POST[ 'name' ] ) ||
			 empty( $_POST[ 'price' ] ) ||
			 empty( $_POST[ 'title' ] ) ||
			 empty( $_POST[ 'user_agent' ] ) ||
			 empty( $_POST[ 'phone' ] ) ) {
			echo 'Передача неполных данных';
			die();
		}
	}
}

class ConfigLandState {

	public function __construct() {
		$this->apiManager = ApiManager::getInstance();
		$this->order = Order::getInstance();
	}

	public function getData() {
		$result = $this->apiManager->getDataForUrl( $_POST );
		echo json_encode( $result );
	}

	public function processOrder( $values ) {
		$this->checkOrderInput();

		$orderData = $this->order->formOrderData( $values );
		$result = $this->order->sendOrder( $orderData );

		if ( $result->status === 'ok' ) {
			header( 'Location: http://' . $values[ 'host' ] . '/form-ok.php' );
			die();
		} else {
			echo '<pre>';
			print_r( $result );
			echo '</pre>';
		}
	}

	public function checkOrderInput() {
		if ( empty( $_POST[ 'land_id' ] ) || 
			 empty( $_POST[ 'ip' ] ) ||
			 empty( $_POST[ 'host' ] ) ||
			 empty( $_POST[ 'name' ] ) ||
			 empty( $_POST[ 'price' ] ) ||
			 empty( $_POST[ 'phone' ] ) ) {
			echo 'Передача неполных данных';
			die();
		}
	}
}

// class AutoLandState {

// 	public function __construct() {
// 		$this->platform = Platform::getInstance();
// 		$this->apiManager = ApiManager::getInstance();
// 		$this->order = Order::getInstance();
// 	}

// 	public function getData() {
// 		$platform_data = $this->platform->getStatistics( $_POST );

// 		if ( $platform_data[ 'errors' ] || !$platform_data ) {
// 			$result = $this->apiManager->getDataForUrl( $_POST );
// 		} else {
// 			$result = $this->apiManager->getDataWithPlatform( $_POST, $platform_data );
// 		}

// 		echo json_encode( $result );
// 	}

// 	public function processOrder( $values ) {
// 		$this->checkOrderInput();

// 		$orderData = $this->order->formOrderPlatformData( $values );
// 		$result = $this->order->sendOrderToPlatform( $orderData );
		
// 		if ( !$result->errors ) {
// 			header( 'Location: http://' . $values[ 'host' ] . '/form-ok.php' );
// 			die();
// 		} else {
// 			$orderData = $this->order->formOrderData( $values );
// 			$result = $this->order->sendOrder( $orderData );

// 			if ( $result->status === 'ok' ) {
// 				header( 'Location: http://' . $values[ 'host' ] . '/form-ok.php' );
// 				die();
// 			} else {
// 				echo '<pre>';
// 				print_r( $result );
// 				echo '</pre>';
// 			}
// 		}	
// 	}

// 	public function checkOrderInput() {
// 		if ( empty( $_POST[ 'land_id' ] ) || 
// 			 empty( $_POST[ 'ip' ] ) ||
// 			 empty( $_POST[ 'host' ] ) ||
// 			 empty( $_POST[ 'name' ] ) ||
// 			 empty( $_POST[ 'price' ] ) ||
// 			 empty( $_POST[ 'phone' ] ) ) {
// 			echo 'Передача неполных данных';
// 			die();
// 		}
// 	}
// }