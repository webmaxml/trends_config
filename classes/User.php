<?php
if ( session_status() == PHP_SESSION_NONE ) { session_start(); }

class User {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {}

	public function isLogged() {
		require 'data/user.php';

		if ( $_SESSION[ 'login' ] === $login &&
			 $_SESSION[ 'password' ] === $password ) {
			return true;
		}

		return false;
	}

	public function logIn( $userLogin, $userPassword ) {
		require 'data/user.php';

		$post_login = $userLogin;
		$post_pwd = md5( $userPassword );

		if ( $post_login === $login &&
			 $post_pwd === $password ) {

			$_SESSION[ 'login' ] = $post_login;
			$_SESSION[ 'password' ] = $post_pwd;

			return true;
		} else {
			return false;
		}

	}

	public function logOut() {
		$_SESSION[ 'login' ] = '';
		$_SESSION[ 'password' ] = '';
	}

}

?>