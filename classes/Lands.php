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

	public function create( $name, $url ) {
		$this->db->create( 'lands', array(
			'name' => $name,
			'url' => $url,
			'upsells' => '',
			'upsell_hit' => '',
			'upsell_index' => 'on',
			'upsell_thanks' => 'on'
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

	public function getUpsellsByUrl( $url ) {
		require 'data/lands.php';

		foreach( $content as $land ) {
			if ( $land[ 'url' ] === $url ) {

				if ( $land[ 'upsells' ] === '' ) { return ''; }

				$data = array(
					'hit' => $land[ 'upsell_hit' ],
					'upsell_index' => $land[ 'upsell_index' ],
					'upsell_thanks' => $land[ 'upsell_thanks' ]
				);
				
				$upsells = array();
				foreach ( $land[ 'upsells' ] as $upsellId ) {
					$upsell = $this->upsells->getDataById( $upsellId );
					$upsell[ 'image' ] = $this->images->getUrlById( $upsell[ 'image' ] );

					$upsells[] = $upsell;
				}

				$data[ 'upsells' ] = $upsells;

				return $data;
			}
		}

		return false;
	}

}