<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class Seller {

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

	public function update( $values ) {
		return $this->db->update( 'seller', false, $values );
	}

	public function getData() {
		require 'data/seller.php';
		return $content;
	}

}