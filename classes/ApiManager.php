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

	public function getDataForUrl( $input ) {
		$lands = $this->lands->getLandsData();

		foreach( $lands as $land ) {
			if ( $land[ 'url' ] === $input[ 'host' ] ) {

				$data = array(
					'id' => $land[ 'id' ],
					'title' => '',
					'product' => $this->products->getProductById( $land[ 'product' ] )[ 'name' ],
					'hit' => $land[ 'upsell_hit' ],
					'discount' => $this->lands->getDiscount( $land[ 'id' ] ),
					'currency' => $this->lands->getCurrency( $land[ 'id' ] ),
					'upsell_index' => $land[ 'upsell_index' ],
					'upsell_thanks' => $land[ 'upsell_thanks' ],
					'ab_test' => $land[ 'ab_test' ],
					'layer' => $land[ 'layer' ],
					'metric_head_index' => $land[ 'metric_head_index' ],
					'metric_body_index' => $land[ 'metric_body_index' ],
					'metric_head_thanks' => $land[ 'metric_head_thanks' ],
					'metric_body_thanks' => $land[ 'metric_body_thanks' ],
					'script_active' => $land[ 'script_active' ],
					'script_country' => $land[ 'script_country' ],
					'script_sex' => $land[ 'script_sex' ],
					'script_windows' => $land[ 'script_windows' ],
					'script_items' => $land[ 'script_items' ],
				);

				// prices
				$data += $this->lands->getPrices( $land[ 'id' ] );

				// upsells
				if ( is_array( $land[ 'upsells' ] ) ) { 
					$upsells = array();
					foreach ( $land[ 'upsells' ] as $upsellId ) {
						$upsells[] = $this->upsells->getApiData( $upsellId );
					}

					$data[ 'upsells' ] = $upsells;
				} else {
					$data[ 'upsells' ] = '';
				}

				// redirections
				if ( is_array( $land[ 'redirections' ] ) ) { 
					$redirections = array();
					foreach ( $land[ 'redirections' ] as $redirectId ) {
						$redirect = $this->lands->getDataById( $redirectId );
						if ( $redirect ) {
							$redirections[] = $redirect[ 'url' ];
						}
					}

					$data[ 'redirections' ] = $redirections;
				} else {
					$data[ 'redirections' ] = $land[ 'redirections' ];
				}

				// layer
				if ( $land[ 'layer' ] === 'true' ) {
					$target = $this->lands->getDataById( $land[ 'layer_target' ] );
					if ( $target ) {
						$data[ 'layer_target' ] = $target[ 'url' ];
					}
				} else {
					$data[ 'layer_target' ] = '';
				}

				// if it is transit in platform
				if ( !empty( $input[ 'transit_url' ] ) ) {
					$data[ 'layer_target' ] = $input[ 'transit_url' ];
				}

				// seller
				$seller_data = $this->seller->getData();
				$data[ 'seller_name' ] = $seller_data[ 'name' ];
				$data[ 'seller_address' ] = $seller_data[ 'address' ];
				$data[ 'seller_phone1' ] = $seller_data[ 'phone1' ];
				$data[ 'seller_phone2' ] = $seller_data[ 'phone2' ];
				$data[ 'seller_email' ] = $seller_data[ 'email' ];
			
				return $data;
			}
		}

		return false;
	}

	public function getDataWithPlatform( $input, $platform_data ) {
		$data = $this->getDataForUrl( $input );

		if ( $data ) {
			$data[ 'title' ] = $platform_data[ 'title' ];
			$data[ 'price1' ] = $platform_data[ 'price' ];
		}

		return $data;
	}

}