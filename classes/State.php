<?php

class State {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->source = Platform::getInstance()->getData()[ 'source' ];

		switch ( $this->source ) {
			case 'platform': $this->state = new PlatformState();  break;
			case 'config':   $this->state = new ConfigState();    break;
		}
	}

	public function getApiData( $input ) {
		return $this->state->getApiData( $input );
	}

	public function makeOrder( $input ) {
		return $this->state->makeOrder( $input );
	}
}

class PlatformState {

	public function __construct() {
		$this->platform = Platform::getInstance();
		$this->apiManager = ApiManager::getInstance();
		$this->order = Order::getInstance();
		$this->seller = Seller::getInstance();
	}

	public function getApiData( $input ) {
		$platform_data = $this->platform->getStatistics( $input );

		if ( $platform_data[ 'errors' ] ) {
			return $platform_data[ 'errors' ];
		} else {
			return $this->apiManager->getDataWithPlatform( $input, $platform_data );
		}
	}

	public function makeOrder( $input ) {
		$orderData = $this->order->formOrderPlatformData( $input );
		$result = $this->order->sendOrderToPlatform( $orderData );

		if ( !$result->errors ) {
			$mailData = $this->seller->getConfigMailData( $input );
			$mail_result = $this->seller->sendMail( $mailData );

			return $mail_result ? $result : $mail_result;
		}

		return $result;
	}

}

class ConfigState {

	public function __construct() {
		$this->apiManager = ApiManager::getInstance();
		$this->order = Order::getInstance();
		$this->seller = Seller::getInstance();
	}

	public function getApiData( $input ) {
		return $this->apiManager->getDataWithConfig( $input );
	}

	public function makeOrder( $input ) {
		$orderData = $this->order->formOrderData( $input );
		$result = $this->order->sendOrder( $orderData );

		if ( $result->status === 'ok' ) {
			$mailData = $this->seller->getConfigMailData( $input );
			$mail_result = $this->seller->sendMail( $mailData );

			return $mail_result ? $result : $mail_result;
		}

		return $result;
	}

}