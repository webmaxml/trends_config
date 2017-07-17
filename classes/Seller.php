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
		$this->lands = Lands::getInstance();
	}

	public function update( $values ) {
		return $this->db->update( 'seller', false, $values );
	}

	public function getData() {
		require 'data/seller.php';
		return $content;
	}

	public function getDataForOutput() {
		require 'data/seller.php';

		foreach ( $content as $key => $value ) {
			$content[ $key ] = stripslashes( htmlspecialchars( $value, ENT_QUOTES ) );
		}

		return $content;
	}

	public function getConfigMailData( $input ) {
		$seller_data = $this->getData();

		$price_new = $input[ 'price' ];
		$valuta = $input[ 'currency' ];
		$skidka = $input[ 'discount' ];
		$price_old = round( $price_new / ( ( 100 - $skidka ) / 100 ) );

		$utms = [
			'utm_source' => $input[ 'utm_source' ],
			'utm_medium' => $input[ 'utm_medium' ],
			'utm_content' => $input[ 'utm_content' ],
			'utm_term' => $input[ 'utm_term' ],
			'utm_campaign' => $input[ 'utm_campaign' ],
		];

		foreach ( $utms as $utm_key => $utm_value ) {
			$utmString .= "<b>". str_pad( $utm_key, 14, " ", STR_PAD_RIGHT ) ."</b> = {$utm_value}<br>\n";
		}

		$vars = [
			'product' => $this->lands->getProductName( $input[ 'land_id' ] ),
			'price_new' => $price_new,
			'price_old' => $price_old,
			'valuta' => $valuta,
			'skidka' => $skidka,
			'host' => $input[ 'host' ],
			'country_code' => $input[ 'country' ],
			'ip' => $input[ 'ip' ],
			'time' => date('m.d.Y H:i:s'),
			'name' => $input[ 'name' ],
			'phone' => $input[ 'phone' ],
			'comment' => $input[ 'comment' ],
			'lang' => $input[ 'lang' ],
			'agent' => $input[ 'agent' ],
			'device' => $input[ 'device' ],
			'os' => $input[ 'os' ],
			'browser' => $input[ 'browser' ],
			'refer' => $input[ 'referer' ],
			'utm' => $utmString
		];

		foreach ( $seller_data as $data_key => $data_value ) {

			foreach ( $vars as $name => $value ) {
				$data_value = str_replace( "%{$name}%", $value, $data_value );
			}

			$seller_data[ $data_key ] = $data_value;
		}
			
		$result = [
			'email' => $seller_data[ 'info_email' ],
			'sender' => $seller_data[ 'sender' ],
			'subject' => $seller_data[ 'subject' ],
			'message' => $seller_data[ 'message' ]
		];

		return $result;
	}


	public function getPlatformMailData() {
	}

	public function sendMail( $data ) {
		$sender = $data[ 'sender' ];
		$headers = "Content-type: text/html;charset=utf-8\r\nFrom: {$sender}";

		return mail( $data[ 'email' ], $data[ 'subject' ], $data[ 'message' ], $headers );
	}
}