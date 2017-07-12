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
	}

	public static function getSourceState() {
		$source = Platform::getInstance()->getData()[ 'source' ];

		switch ( $source ) {
			case 'platform': return new PlatformState();			
			case 'config':   return new ConfigState();
		}
	}

	public static function getLayerState( $land_id ) {
		$isLayer = Lands::getInstance()->isLayer( $land_id );

		if ( $isLayer ) {
			return new IsLayerState();
		} else {
			return new NotLayerState();
		}
	}

}




class ConfigState implements ISourceState {

	public function __construct() {
		$this->apiManager = ApiManager::getInstance();
		$this->order = Order::getInstance();
		$this->seller = Seller::getInstance();
		$this->upsells = Upsells::getInstance();
		$this->lands = Lands::getInstance();
	}

	public function getState() {
		return 'config';
	}

	public function getApiData( $input ) {
		return $this->apiManager->getData( $input );
	}

	public function makeOrder( $input ) {
		$orderData = $this->order->formOrderData( $input );
		$result = $this->order->sendOrder( $orderData );

		return $result;
	}

	public function sendMail( $input ) {
		$mailData = $this->seller->getConfigMailData( $input );
		$result = $this->seller->sendMail( $mailData );

		return $result;
	}

	public function getUpsellsData( $upsell_id ) {
		return $this->upsells->getConfigApiData( $upsell_id );
	}

	public function getTestData( $land_id ) {
		return $this->lands->getTestData( $land_id );
	}

	public function getLayerData( $land_id ) {
		return $this->lands->getLayerData( $land_id );
	}

	public function getScriptData( $land_id ) {
		$layerState = State::getLayerState( $land_id );

		return $layerState->getScript( $land_id );
	}

	public function getPrices( $land_id, $platform_data = false ) {
		$layerState = State::getLayerState( $land_id );

		return $layerState->getPrices( $land_id );
	}

	public function getMetrics( $land_id, $platform_data = false ) {
		$layerState = State::getLayerState( $land_id );

		return $layerState->getMetrics( $land_id );
	}

	public function getTitle( $land_id, $platform_data = false ) {
		return '';
	}

}


class PlatformState implements ISourceState {

	public function __construct() {
		$this->platform = Platform::getInstance();
		$this->apiManager = ApiManager::getInstance();
		$this->order = Order::getInstance();
		$this->seller = Seller::getInstance();
		$this->upsells = Upsells::getInstance();
		$this->lands = Lands::getInstance();
	}

	public function getState() {
		return 'platform';
	}

	public function getApiData( $input ) {
		$platform_data = $this->platform->getStatistics( $input );

		if ( $platform_data[ 'errors' ] ) {
			return $platform_data[ 'errors' ];
		} else {
			return $this->apiManager->getData( $input, $platform_data );
		}
	}

	public function makeOrder( $input ) {
		$orderData = $this->order->formOrderPlatformData( $input );
		$result = $this->order->sendOrderToPlatform( $orderData );

		return $result;
	}

	public function sendMail( $input ) {
		$mailData = $this->seller->getConfigMailData( $input );
		$result = $this->seller->sendMail( $mailData );

		return $result;
	}

	public function getUpsellsData( $upsell_id ) {
		return $this->upsells->getPlatformApiData( $upsell_id );
	}

	public function getTestData( $land_id ) {
		return $this->lands->getDisabledTestData();
	}

	public function getLayerData( $land_id ) {
		return $this->lands->getDisabledLayerData();
	}

	public function getScriptData( $land_id ) {
		return $this->lands->getScriptData( $land_id );
	}

	public function getPrices( $land_id, $platform_data = false ) {
		$prices = $this->lands->getPrices( $land_id );

		if ( !$platform_data ) {
			throw new Exception( 'Need to have platform data to form prices for platform state' );
		}

		$prices[ 'price1' ] = $platform_data[ 'price' ];

		return $prices;
	}

	public function getMetrics( $land_id, $platform_data = false ) {
		if ( !$platform_data ) {
			throw new Exception( 'Need to have platform data to form metrics for platform state' );
		}

		$metrics = [];
		$metrics[ 'metric_head_index' ] = '';
		$metrics[ 'metric_body_index' ] = $platform_data[ 'counters' ][ 'yandex_metrika' ];
		$metrics[ 'metric_head_thanks' ] = '';
		$metrics[ 'metric_body_thanks' ] = $platform_data[ 'counters' ][ 'yandex_metrika' ] . 
										   $platform_data[ 'counters' ][ 'google_analytics' ];

		return $metrics;
	}

	public function getTitle( $land_id, $platform_data = false ) {
		return $platform_data[ 'title' ];
	}

}





class IsLayerState implements ILayerState {

	public function __construct() {
		$this->lands = Lands::getInstance();
	}

	public function getPrices( $land_id ) {
		return $this->lands->getPricesFromTarget( $land_id );
	}

	public function getDiscount( $land_id ) {
		return $this->lands->getDiscountFromTarget( $land_id );
	}

	public function getCurrency( $land_id ) {
		return $this->lands->getCurrencyFromTarget( $land_id );
	}

	public function getMetrics( $land_id ) {
		return $this->lands->getMetricsFromTarget( $land_id );
	}

	public function getScript( $land_id ) {
		return $this->lands->getDisabledScriptData();
	}

}

class NotLayerState implements ILayerState {

	public function __construct() {
		$this->lands = Lands::getInstance();
	}

	public function getPrices( $land_id ) {
		return $this->lands->getPrices( $land_id );
	}

	public function getDiscount( $land_id ) {
		return $this->lands->getDiscount( $land_id );
	}

	public function getCurrency( $land_id ) {
		return $this->lands->getCurrency( $land_id );
	}

	public function getMetrics( $land_id ) {
		return $this->lands->getMetrics( $land_id );
	}

	public function getScript( $land_id ) {
		return $this->lands->getScriptData( $land_id );
	}
	
}