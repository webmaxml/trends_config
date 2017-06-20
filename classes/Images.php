<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class Images {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->db = FileDB::getInstance();
		$this->uploadDir = __DIR__ . '/../assets/images/';
	}

	public function getImageData() {
		require 'data/images.php';
		return $content;
	}

	public function getUrlById( $id ) {
		require 'data/images.php';

		foreach ( $content as $image ) {
			if ( $image[ 'id' ] === (string) $id ) {
				return $image[ 'url' ];
			}
		}

		return false;
	}

	public function upload( $name, $tmp_name ) {
		require 'data/images.php';
		global $config;

		$name_exist = false;
		foreach( $content as $image ) {
			if ( $image[ 'name' ] === $name ) {
				$name_exist = true;
			}
		}

		if ( $name_exist ) {
			// if name exist we only upload file to change existing image
			return move_uploaded_file( $tmp_name, $this->uploadDir . $name );
		} else {
			$this->db->create( 'images', array(
				'name' => $name,
				'url' => $config[ 'base_url' ] . '/assets/images/' . $name
			) );

			return move_uploaded_file( $tmp_name, $this->uploadDir . $name );
		}
	}

	public function delete( $id, $name ) {
		$this->db->delete( 'images', $id );
		return unlink( $this->uploadDir . $name );
	}

}