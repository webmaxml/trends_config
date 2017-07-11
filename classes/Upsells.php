<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class Upsells {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->db = FileDB::getInstance();
		$this->images = Images::getInstance();
		$this->lands = Lands::getInstance();
		$this->platform = Platform::getInstance();
	}

	public function create( $data ) {
		return $this->db->create( 'upsells', array(
			'name' => $data[ 'name' ],
			'title' => $data[ 'title' ],
			'description' => $data[ 'description' ],
			'image' => $data[ 'image' ],
			'land' => $data[ 'land' ],
			'stream' => $data[ 'stream' ],
			'price' => $data[ 'price' ],
			'currency' => $data[ 'currency' ],
		) );
	}

	public function update( $id, $values ) {
		return $this->db->update( 'upsells', $id, $values );
	}

	public function getData() {
		require 'data/upsells.php';
		return $content;
	} 

	public function getDataById( $id ) {
		require 'data/upsells.php';

		foreach( $content as $upsell ) {
			if ( $upsell[ 'id' ] === (string) $id ) {
				return $upsell;
			}
		}

		return false;
	}





	// delete in future

	public function getApiData( $id ) {
		$upsell = $this->getDataById( $id );
		$source = $this->platform->getData()[ 'source' ];

		switch ( $source ) {
			case 'config':
				$target_land = $this->lands->getDataById( $upsell[ 'land' ] );
				if ( $target_land ) {
					$upsell[ 'url' ] = $target_land[ 'url' ];
					$upsell[ 'price' ] = $this->lands->getPrices( $target_land[ 'id' ] )[ 'price1' ];
					$upsell[ 'currency' ] = $this->lands->getCurrency( $target_land[ 'id' ] );
				} else {
					$upsell[ 'url' ] = '';
					$upsell[ 'price' ] = '';
					$upsell[ 'currency' ] = '';
				}
				
				break;
			case 'platform':
				$upsell[ 'url' ] = $upsell[ 'stream' ];
				break;
		}

		$upsell[ 'image' ] = $this->images->getUrlById( $upsell[ 'image' ] );
				
		return $upsell;
	}










	public function getConfigApiData( $id ) {
		$upsell = $this->getDataById( $id );

		if ( $upsell ) {
			$target_land = $this->lands->getDataById( $upsell[ 'land' ] );
			if ( $target_land ) {
				$upsell[ 'url' ] = $target_land[ 'url' ];
				$upsell[ 'price' ] = $this->lands->getPrices( $target_land[ 'id' ] )[ 'price1' ];
				$upsell[ 'currency' ] = $this->lands->getCurrency( $target_land[ 'id' ] );
			} else {
				$upsell[ 'url' ] = '';
				$upsell[ 'price' ] = '';
				$upsell[ 'currency' ] = '';
			}

			$upsell[ 'image' ] = $this->images->getUrlById( $upsell[ 'image' ] );

			return $upsell;
		} else {
			return false;
		}
	}

	public function getPlatformApiData( $id ) {
		$upsell = $this->getDataById( $id );

		if ( $upsell ) {
			$upsell[ 'url' ] = $upsell[ 'stream' ];
			$upsell[ 'image' ] = $this->images->getUrlById( $upsell[ 'image' ] );
			return $upsell;
		} else {
			return false;
		}
	}

	public function getNameById( $id ) {
		require 'data/upsells.php';

		foreach( $content as $upsell ) {
			if ( $upsell[ 'id' ] === (string) $id ) {
				return $upsell[ 'name' ];
			}
		}

		return false;
	}

	public function delete( $id ) {
		return $this->db->delete( 'upsells', $id );
	}

}