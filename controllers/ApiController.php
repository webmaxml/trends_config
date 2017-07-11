<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class ApiController {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->lands = Lands::getInstance();
		$this->upsells = Upsells::getInstance();
		$this->images = Images::getInstance();
		$this->apiManager = ApiManager::getInstance();
		$this->platform = Platform::getInstance();
	}

	// need to go from get to post so delete in future
	public function getDataForUrl() {
		$result = $this->apiManager->getDataForUrl( $_GET );

		echo json_encode( $result );
		die();
	}

}

?>