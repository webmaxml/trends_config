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
	}

	public function getDataForUrl( $url ) {
		$lands = $this->lands->getLandsData();

		foreach( $lands as $land ) {
			if ( $land[ 'url' ] === $url ) {

				$data = array(
					'product' => $land[ 'product' ],
					'hit' => $land[ 'upsell_hit' ],
					'price1' => $land[ 'price1' ],
					'price2' => $land[ 'price2' ],
					'price3' => $land[ 'price3' ],
					'price4' => $land[ 'price4' ],
					'price5' => $land[ 'price5' ],
					'price6' => $land[ 'price6' ],
					'price7' => $land[ 'price7' ],
					'price8' => $land[ 'price8' ],
					'price9' => $land[ 'price9' ],
					'price10' => $land[ 'price10' ],
					'discount' => $land[ 'discount' ],
					'currency' => $land[ 'currency' ],
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

				// upsells
				if ( is_array( $land[ 'upsells' ] ) ) { 
					$upsells = array();
					foreach ( $land[ 'upsells' ] as $upsellId ) {
						$upsell = $this->upsells->getDataById( $upsellId );
						$upsell[ 'image' ] = $this->images->getUrlById( $upsell[ 'image' ] );

						$upsells[] = $upsell;
					}

					$data[ 'upsells' ] = $upsells;
				} else {
					$data[ 'upsells' ] = $land[ 'upsells' ];
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
					$data[ 'layer_target' ] = $land[ 'layer_target' ];
				}
			
				return $data;
			}
		}

		return false;
	}

}