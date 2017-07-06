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
		$this->lands = Lands::getInstance();
		$this->platform = Platform::getInstance();
	}

	public function update( $values ) {
		return $this->db->update( 'order', false, $values );
	}

	public function getData() {
		require 'data/order.php';
		return $content;
	}

	public function formOrderData( $values ) {
		$order_data = $this->getData();
		$land_data = $this->lands->getDataById( $values[ 'land_id' ] );

		// if auto take the country detected from user
		if ( $order_data[ 'country' ] === 'auto' ) {
			$country = $values[ 'country' ];
		} else {
			$country = $order_data[ 'country' ];
		}

		// products set
		$products = array(
		    1 => array( 
		            'product_id' => $land_data[ 'product_id' ], 
		            'price'      => $values[ 'price' ], 
		            'count'      => '1'    
		    ),  
		);
		
		// total data
		$data = array(
			'key' 			  => $order_data[ 'key' ],
			'order_id' 		  => number_format( round( microtime( true ) * 10), 0, '.', '' ),
			'country' 		  => $country,
		    'office'          => $order_data[ 'office_id' ],                  
		    'products'        => urlencode( serialize( $products ) ),
		    'bayer_name'      => $values[ 'name' ],
		    'phone'           => $values[ 'phone' ],
		    'email'           => '',
		    'comment'         => '',
		    'site'            => $values[ 'host' ],
		    'ip'              => $values[ 'ip' ],
		    'delivery'        => $order_data[ 'delivery_id' ],
		    'delivery_adress' => '',
		    'payment'         => $order_data[ 'payment_id' ],
		    'utm_source'      => $values[ 'utm_source' ],		    
		    'utm_medium'      => $values[ 'utm_medium' ],
		    'utm_term'        => $values[ 'utm_term' ],   
		    'utm_content'     => $values[ 'utm_content' ],    
		    'utm_campaign'    => $values[ 'utm_campaign' ]
		);

		return $data;
	}

	public function formOrderPlatformData( $values ) {
		$data = [
			'api_key' => $this->platform->getData()[ 'key' ],
			'ip' => $values[ 'ip' ],
			'uid' => $values[ 'uid' ],
			'user_agent' => $values[ 'user_agent' ],
			'title' => $values[ 'title' ],
			'price' => $values[ 'price' ],
			'utm_source' => $values[ 'utm_source' ],
			'utm_medium' => $values[ 'utm_medium' ],
			'utm_term' => $values[ 'utm_term' ],
			'utm_content' => $values[ 'utm_content' ],
			'utm_campaign' => $values[ 'utm_campaign' ],
			'name' => $values[ 'name' ],
			'phone' => $values[ 'phone' ],
		];

		return $data;
	}

	public function sendOrder( $data ) {
		$order_data = $this->getData();

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $order_data[ 'url' ] );
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		$result = json_decode( curl_exec($curl) );
		curl_close($curl);

		return $result;
	}

	public function sendOrderToPlatform( $data ) {
		$order_url = $this->platform->getData()[ 'url' ] . '/order';

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $order_url );
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		$result = json_decode( curl_exec($curl) );
		curl_close($curl);

		return $result;
	}

}