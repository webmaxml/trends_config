<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class ApiManager {

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
		$this->seller = Seller::getInstance();
		$this->platform = Platform::getInstance();
		$this->products = Products::getInstance();
	}

	public function getData( $input, $platform_data = false ) {
		$land = $this->lands->getDataByUrl( $input[ 'host' ] );
		$sourceState = State::getSourceState();
		$layerState = State::getLayerState( $land[ 'id' ] );

		if ( !$land ) { return false; }

		$data = [
			'id' => $land[ 'id' ],
			'state' => $sourceState->getState(),
			'title' => $sourceState->getTitle( $land[ 'id' ], $platform_data ),
			'product' => $this->products->getProductById( $land[ 'product' ] )[ 'name' ],
			'hit' => $land[ 'upsell_hit' ],
			'upsell_index' => $land[ 'upsell_index' ],
			'upsell_thanks' => $land[ 'upsell_thanks' ],
		];

		// prices
		$data += $sourceState->getPrices( $land[ 'id' ], $platform_data );
		$data[ 'discount' ] = $layerState->getDiscount( $land[ 'id' ] );
		$data[ 'currency' ] = $layerState->getCurrency( $land[ 'id' ] ); 

		// metrics
		$data += $sourceState->getMetrics( $land[ 'id' ], $platform_data );

		// upsells
		if ( is_array( $land[ 'upsells' ] ) ) { 
			$upsells = array();
			foreach ( $land[ 'upsells' ] as $upsellId ) {
				$upsells[] = $sourceState->getUpsellsData( $upsellId );
			}

			$data[ 'upsells' ] = $upsells;
		} else {
			$data[ 'upsells' ] = '';
		}

		// ab test
		$data += $sourceState->getTestData( $land[ 'id' ] );

		// layer
		$data += $sourceState->getLayerData( $land[ 'id' ] );

		// seller
		$seller_data = $this->seller->getData();
		$data[ 'seller_name' ] = $seller_data[ 'name' ];
		$data[ 'seller_address' ] = $seller_data[ 'address' ];
		$data[ 'seller_phone1' ] = $seller_data[ 'phone1' ];
		$data[ 'seller_phone2' ] = $seller_data[ 'phone2' ];
		$data[ 'seller_email' ] = $seller_data[ 'email' ];

		// script
		$data += $sourceState->getScriptData( $land[ 'id' ] );

		return $data;
	}

}