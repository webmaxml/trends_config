<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class Order {

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
		return $this->db->update( 'order', false, $values );
	}

	public function getData() {
		require 'data/order.php';
		return $content;
	}
}