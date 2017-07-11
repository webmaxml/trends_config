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
		$this->products = Products::getInstance();
	}

	public function update( $values ) {
		return $this->db->update( 'order', false, $values );
	}

	public function getData() {
		require 'data/order.php';
		return $content;
	}

	public function formOrderData( $input ) {
		$order_data = $this->getData();
		$land = $this->lands->getDataById( $input[ 'land_id' ] );
		$product_id = $this->products->getCrmId( $land[ 'product' ] );

		// if auto take the country detected from user
		if ( $order_data[ 'country' ] === 'auto' ) {
			$country = $input[ 'country' ];
		} else {
			$country = $order_data[ 'country' ];
		}

		// products set
		$products = array(
		    1 => array( 
		            'product_id' => $product_id, 
		            'price'      => $input[ 'price' ], 
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
		    'bayer_name'      => $input[ 'name' ],
		    'phone'           => $input[ 'phone' ],
		    'email'           => '',
		    'comment'         => $input[ 'comment' ],
		    'site'            => $input[ 'host' ],
		    'ip'              => $input[ 'ip' ],
		    'delivery'        => $order_data[ 'delivery_id' ],
		    'delivery_adress' => '',
		    'payment'         => $order_data[ 'payment_id' ],
		    'utm_source'      => $input[ 'utm_source' ],		    
		    'utm_medium'      => $input[ 'utm_medium' ],
		    'utm_term'        => $input[ 'utm_term' ],   
		    'utm_content'     => $input[ 'utm_content' ],    
		    'utm_campaign'    => $input[ 'utm_campaign' ]
		);

		return $data;
	}

	public function formOrderPlatformData( $input ) {
		$data = [
			'api_key' => $this->platform->getData()[ 'key' ],
			'ip' => $input[ 'ip' ],
			'uid' => $input[ 'uid' ],
			'user_agent' => $input[ 'user_agent' ],
			'title' => $input[ 'title' ],
			'price' => $input[ 'price' ],
			'utm_source' => $input[ 'utm_source' ],
			'utm_medium' => $input[ 'utm_medium' ],
			'utm_term' => $input[ 'utm_term' ],
			'utm_content' => $input[ 'utm_content' ],
			'utm_campaign' => $input[ 'utm_campaign' ],
			'name' => $input[ 'name' ],
			'phone' => $input[ 'phone' ],
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