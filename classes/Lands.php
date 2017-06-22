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
		$this->upsells = Upsells::getInstance();
		$this->images = Images::getInstance();
	}

	public function create( $name, $url, $layer = 'false', $layer_target = '' ) {
		$this->db->create( 'lands', array(
			'name' => $name,
			'url' => $url,
			'product_id' => '',
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
			'layer' => $layer,
			'layer_target' => $layer_target,
			'ab_test' => 'off',
			'redirections' => '',
			'metric_head_index' => '',
			'metric_body_index' => '',
			'metric_head_thanks' => '',
			'metric_body_thanks' => '',
			'script_active' => '',
			'script_country' => '',
			'script_sex' => '',
			'script_windows' => '',
			'script_items' => ''
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

	public function delete( $id ) {
		return $this->db->delete( 'lands', $id );
	}

	public function getOutsourceData( $url ) {
		require 'data/lands.php';

		foreach( $content as $land ) {
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
						$redirect = $this->getDataById( $redirectId );
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
					$target = $this->getDataById( $land[ 'layer_target' ] );
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

}