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

}