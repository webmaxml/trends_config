<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class Products {

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

	public function create( $name, $id ) {
		return $this->db->create( 'products', array(
			'name' => $name,
			'crm_id' => $id
		) );
	}

	public function update( $id, $values ) {
		return $this->db->update( 'products', $id, $values );
	}

	public function getData() {
		require 'data/products.php';
		return $content;
	}

	public function getProductById( $id ) {
		require 'data/products.php';

		foreach( $content as $product ) {
			if ( $product[ 'id' ] === (string) $id ) {
				return $product;
			}
		}

		return false;
	}

	public function delete( $id ) {
		return $this->db->delete( 'products', $id );
	}

}