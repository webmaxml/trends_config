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
			'upsells' => '',
			'upsell_hit' => '',
			'upsell_index' => 'on',
			'upsell_thanks' => 'on',
			'layer' => $layer,
			'layer_target' => $layer_target,
			'ab_test' => 'off',
			'redirections' => '',
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
					'hit' => $land[ 'upsell_hit' ],
					'upsell_index' => $land[ 'upsell_index' ],
					'upsell_thanks' => $land[ 'upsell_thanks' ],
					'ab_test' => $land[ 'ab_test' ],
					'layer' => $land[ 'layer' ]
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