<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class FrontController {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->user = User::getInstance();
		$this->upsells = Upsells::getInstance();
		$this->images = Images::getInstance();
		$this->lands = Lands::getInstance();
	}

	public function getRoot() {
		if ( $this->user->isLogged() ) {
			require 'views/lands.php';
		} else {
			require 'views/login.php';
		}
	}

	public function getUpsells() {
		if ( $this->user->isLogged() ) {
			require 'views/upsells.php';
		} else {
			require 'views/login.php';
		}
	}

	public function getImageUpload() {
		if ( $this->user->isLogged() ) {
			require 'views/imageUpload.php';
		} else {
			require 'views/login.php';
		}
	}

	public function getImages() {
		if ( $this->user->isLogged() ) {
			require 'views/images.php';
		} else {
			require 'views/login.php';
		}
	}

	public function getAbtest() {
		if ( $this->user->isLogged() ) {
			require 'views/abtest.php';
		} else {
			require 'views/login.php';
		}
	}

	public function loginUser() {
		global $config;

		$result = $this->user->logIn( $_POST[ 'login' ], $_POST[ 'password' ] );

		if ( $result ) {
			header( "Location: " . $config[ 'base_url' ] . '/' );
			exit;
		} else {
			header( "Location: " . $config[ 'base_url' ] . '/?login_status=1' );
			exit;
		}
	}

	public function logoutUser() {
		global $config;

		$this->user->logOut();
		header( "Location: " . $config[ 'base_url' ] . '/' );
		exit;
	}

	public function uploadImage() {
		return $this->images->upload( $_FILES[ 'file' ][ 'name' ], $_FILES[ 'file' ][ 'tmp_name' ] );
	}

	public function get404() {
		require 'views/404.php';
	}

	public function createLand() {
		global $config;
		$result = $this->lands->create( $_POST[ 'name' ], $_POST[ 'url' ] );

		if ( $result === false ) {
			header( "Location: " . $config[ 'base_url' ] . '/?land_status=2' );
			exit;
		} else {
			header( "Location: " . $config[ 'base_url' ] . '/?land_status=1' );
			exit;
		} 
	}

	public function createUpsell() {
		global $config;
		$result = $this->upsells->create( array(
			'name' => $_POST[ 'name' ],
			'title' => $_POST[ 'title' ],
			'description' => $_POST[ 'description' ],
			'price' => $_POST[ 'price' ],
			'currency' => $_POST[ 'currency' ],
			'image' => $_POST[ 'image' ],
			'url' => $_POST[ 'url' ]
		) );

		if ( $result === false ) {
			header( "Location: " . $config[ 'base_url' ] . '/upsells?upsell_status=2' );
			exit;
		} else {
			header( "Location: " . $config[ 'base_url' ] . '/upsells?upsell_status=1' );
			exit;
		} 
	}

	public function createTest() {
		$values = array();
		$values[ 'redirections' ] = $_POST[ 'redirects' ];
		
		$result = $this->lands->update( $_POST[ 'entry' ], $values );

		if ( $result === false ) {
			header( "Location: " . $config[ 'base_url' ] . '/abtest?test_status=2' );
			exit;
		} else {
			header( "Location: " . $config[ 'base_url' ] . '/abtest?test_status=1' );
			exit;
		} 
	}

}

?>