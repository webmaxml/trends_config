<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class MediaController {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->images = Images::getInstance();
	}

	public function uploadImage() {
		return $this->images->upload( $_FILES[ 'file' ][ 'name' ], $_FILES[ 'file' ][ 'tmp_name' ] );
	}

	public function deleteImage() {
		$result =  $this->images->delete( $_GET[ 'id' ], $_GET[ 'name' ] );

		echo json_encode( array( 'success' => $result ) );
		die();
	}
}