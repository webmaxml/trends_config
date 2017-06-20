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
	}

	public function create( $data ) {
		$this->db->create( 'upsells', array(
			'name' => $data[ 'name' ],
			'title' => $data[ 'title' ],
			'description' => $data[ 'description' ],
			'price' => $data[ 'price' ],
			'currency' => $data[ 'currency' ],
			'image' => $data[ 'image' ],
			'url' => $data[ 'url' ]
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