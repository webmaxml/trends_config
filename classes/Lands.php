<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class Lands {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->db = FileDB::getInstance();
		$this->products = Products::getInstance();
	}

	public function create( $name, $url ) {
		return $this->db->create( 'lands', array(
			'name' => $name,
			'url' => $url,
			'product' => '',
			'price1' => '0',
			'price2' => '',
			'price3' => '',
			'price4' => '',
			'price5' => '',
			'price6' => '',
			'price7' => '',
			'price8' => '',
			'price9' => '',
			'price10' => '',
			'discount' => '0',
			'currency' => 'грн',
			'upsells' => '',
			'upsell_hit' => '',
			'upsell_index' => 'on',
			'upsell_thanks' => 'on',
			'layer' => 'false',
			'layer_target' => '',
			'ab_test' => 'off',
			'redirections' => '',
			'metric_head_index' => '',
			'metric_body_index' => '',
			'metric_head_thanks' => '',
			'metric_body_thanks' => '',
			'script_active' => 'on',
			'script_country' => 'ua',
			'script_sex' => 'all',
			'script_windows' => '10',
			'script_items' => '3'
		) );
	}

	public function update( $id, $values ) {
		return $this->db->update( 'lands', $id, $values );
	}

	public function getLandsData() {
		require 'data/lands.php';
		return $content;
	}

	public function getDataById( $id ) {
		require 'data/lands.php';

		foreach( $content as $land ) {
			if ( $land[ 'id' ] === (string) $id ) {
				return $land;
			}
		}

		return false;
	}

	public function getDataByUrl( $url ) {
		require 'data/lands.php';

		foreach( $content as $land ) {
			if ( $land[ 'url' ] === $url ) {
				return $land;
			}
		}

		return false;
	}

	public function delete( $id ) {
		return $this->db->delete( 'lands', $id );
	}

	public function getTestLands() {
		require 'data/lands.php';

		$test_lands = array();
		foreach ( $content as $land ) {
			if ( is_array( $land[ 'redirections' ] ) ) {
				$test_lands[] = $land;
			}
		}

		return $test_lands;
	}

	public function getPricesFromTarget( $id ) {
		$land = $this->getDataById( $id );
		$target = $this->getDataById( $land[ 'layer_target' ] );

		if ( $target ) {
			$prices = [];
			for ( $i = 1; $i <= 10; $i++ ) {
	            $prices[ 'price'.$i ] = $target[ 'price'.$i ];
	        }

	        return $prices;
		} else {
			return false;
		}
	}

	public function getPrices( $id ) {
		$land = $this->getDataById( $id );

		if ( $land ) {
			$prices = [];
			for ( $i = 1; $i <= 10; $i++ ) {
	            $prices[ 'price'.$i ] = $land[ 'price'.$i ];
	        }

	        return $prices;
		} else {
			return false;
		}
	}

	public function getDiscountFromTarget( $id ) {
		$land = $this->getDataById( $id );
		$target = $this->getDataById( $land[ 'layer_target' ] );

		if ( $target ) {
			return $target[ 'discount' ];
		} else {
			return false;
		}
	}

	public function getDiscount( $id ) {
		$land = $this->getDataById( $id );

		if ( $land ) {
			return $land[ 'discount' ];
		} else {
			return false;
		}
	}

	public function getCurrencyFromTarget( $id ) {
		$land = $this->getDataById( $id );
		$target = $this->getDataById( $land[ 'layer_target' ] );

		if ( $target ) {
			return $target[ 'currency' ];
		} else {
			return false;
		}
	}

	public function getCurrency( $id ) {
		$land = $this->getDataById( $id );

		if ( $land ) {
			return $land[ 'currency' ];
		} else {
			return false;
		}
	}

	public function getMetricsFromTarget( $id ) {
		$land = $this->getDataById( $id );
		$target = $this->getDataById( $land[ 'layer_target' ] );

		if ( $target ) {
			$metrics = [
				'metric_head_index' => $target[ 'metric_head_index' ],
				'metric_body_index' => $target[ 'metric_body_index' ],
				'metric_head_thanks' => $target[ 'metric_head_thanks' ],
				'metric_body_thanks' => $target[ 'metric_body_thanks' ]
			];

			return $metrics;
		} else {
			return false;
		}
	}

	public function getMetrics( $id ) {
		$land = $this->getDataById( $id );

		if ( $land ) {
			$metrics = [
				'metric_head_index' => $land[ 'metric_head_index' ],
				'metric_body_index' => $land[ 'metric_body_index' ],
				'metric_head_thanks' => $land[ 'metric_head_thanks' ],
				'metric_body_thanks' => $land[ 'metric_body_thanks' ]
			];

			return $metrics;
		} else {
			return false;
		}
	}

	public function isLayer( $id ) {
		$land = $this->getDataById( $id );

		if ( $land ) {
			return $land[ 'layer' ] === 'true';
		} else {
			return false;
		}
	}

	public function hasTest( $id ) {
		$land = $this->getDataById( $id );

		if ( $land ) {
			return $land[ 'ab_test' ] === 'on';
		} else {
			return false;
		}
	}

	public function getProductName( $id ) {
		$land = $this->getDataById( $id );

		if ( $land ) {
			return $this->products->getProductById( $land[ 'product' ] )[ 'name' ];
		} else {
			return false;
		}
	}

}