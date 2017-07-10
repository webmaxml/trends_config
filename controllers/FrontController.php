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
		$this->seller = Seller::getInstance();
		$this->order = Order::getInstance();
		$this->platform = Platform::getInstance();
	}

	public function getRoot() {
		if ( $this->user->isLogged() ) {
			require 'views/landData.php';
		} else {
			require 'views/login.php';
		}
	}

	public function getProducts() {
		if ( $this->user->isLogged() ) {
			require 'views/products.php';
		} else {
			require 'views/login.php';
		}
	}

	public function getLandUpsells() {
		if ( $this->user->isLogged() ) {
			require 'views/landUpsells.php';
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

	public function getLayers() {
		if ( $this->user->isLogged() ) {
			require 'views/landLayers.php';
		} else {
			require 'views/login.php';
		}
	}

	public function getAbtest() {
		if ( $this->user->isLogged() ) {
			require 'views/landTest.php';
		} else {
			require 'views/login.php';
		}
	}

	public function getSeller() {
		if ( $this->user->isLogged() ) {
			require 'views/seller.php';
		} else {
			require 'views/login.php';
		}
	}

	public function getOrderData() {
		if ( $this->user->isLogged() ) {
			require 'views/orderData.php';
		} else {
			require 'views/login.php';
		}
	}

	public function getPlatformData() {
		if ( $this->user->isLogged() ) {
			require 'views/platform.php';
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

	public function get404() {
		require 'views/404.php';
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

	public function updateSeller() {
		$result = $this->seller->update( $_POST );

		if ( $result === false ) {
			echo 'Произошла ошибка при записи данных!';
		} else {
			header( "Location: " . $config[ 'base_url' ] . '/seller' );
			exit;
		}
	}

	public function updateOrder() {
		$result = $this->order->update( $_POST );

		if ( $result === false ) {
			echo 'Произошла ошибка при записи данных!';
		} else {
			header( "Location: " . $config[ 'base_url' ] . '/orderData' );
			exit;
		}
	}

	public function updatePlatform() {
		$result = $this->platform->update( $_POST );

		if ( $result === false ) {
			echo 'Произошла ошибка при записи данных!';
		} else {
			header( "Location: " . $config[ 'base_url' ] . '/platformData' );
			exit;
		}
	}

}

?>