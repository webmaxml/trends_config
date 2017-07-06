<?
class ConfigController {

	public function __construct() {
		$this->request = new Request();
		$this->client = new Client();
		$this->mainVars = new MainVars();
		$this->orderForm = new OrderForm( $this->client );
		$this->transit = new Transit();
		$this->upsells = new Upsells( $this->mainVars );
		$this->ordersWidget = new OrdersWidget( $this->mainVars );

		$this->templateVars = [];
	}

	public function init() {
		global $isIndex;

		// set client data
		$this->client->setClientData();

		// get data from config
		$data_for_config = $this->getDataForConfig();
		$data = $this->request->getConfigData( $data_for_config );

		// debug
		echo '<pre>';
		print_r( $data );
		echo '</pre>';

		// redirection
		if ( $data->ab_test === 'on' && is_array( $data->redirections ) ) {
			$this->request->redirect( $data->redirections );
		}

		// adding metrics
		if ( $isIndex ) {
			$this->mainVars->addIndexMetrics( $data );
		} else {
			$this->mainVars->addThanksMetrics( $data );
		}

		// order form settings
		$this->orderForm->init( $data );

		// transit
		if ( !empty( $data->layer_target ) ) {
			$this->transit->setTargetUrl( $data->layer_target, 'utm_medium' );
		} 

		// upsells
		$upsellsIsOn = $isIndex && $data->upsell_index === 'on' ||
		 	  		  !$isIndex && $data->upsell_thanks === 'on';
		if ( $upsellsIsOn && is_array( $data->upsells ) ) {
			$this->upsells->init( $data );
		}

		// ordersWidget
		if ( $data->script_active === 'on' && $isIndex ) {
			$this->ordersWidget->init( $data );
		}

		// setting vars for template
		$this->setTemplateVars( $data );
	}

	private function getDataForConfig() {
		$data = [
			'host' => 'http://' . $_SERVER[ 'HTTP_HOST' ] . '/',
			'uid' => $this->client->uid,
			'ip' => $this->client->ip,
			'user_agent' => $this->client->agent_for_platform,
			'utm_source' => $this->client->utm[ 'utm_source' ],
            'utm_medium' => $this->client->utm[ 'utm_medium' ],
            'utm_term' => $this->client->utm[ 'utm_term' ],
            'utm_content' => $this->client->utm[ 'utm_content' ],
            'utm_campaign' => $this->client->utm[ 'utm_campaign' ],
            'transit_url' => isset( $_GET[ 'url' ] ) ? $_GET[ 'url' ] : '',
		];

		return $data;
	}

	private function setTemplateVars( $data ) {
		$this->templateVars = [
			'upsells' => $this->upsells->getUpsells(),
			'transit_target' => $this->transit->getUrl(),
			'hidden_input' => $this->orderForm->getHiddenInput(),

			// product vars
			'product' => isset( $data->product ) ? $data->product : '',
			'price_new' => isset( $data->price1 ) ? $data->price1 : 0,
			'price_2' => isset( $data->price1 ) ? $data->price2 : 0,
			'price_3' => isset( $data->price1 ) ? $data->price3 : 0,
			'price_4' => isset( $data->price1 ) ? $data->price4 : 0,
			'price_5' => isset( $data->price1 ) ? $data->price5 : 0,
			'price_6' => isset( $data->price1 ) ? $data->price6 : 0,
			'price_7' => isset( $data->price1 ) ? $data->price7 : 0,
			'price_8' => isset( $data->price1 ) ? $data->price8 : 0,
			'price_9' => isset( $data->price1 ) ? $data->price9 : 0,
			'price_10' => isset( $data->price1 ) ? $data->price10 : 0,
			'skidka' => isset( $data->discount ) ? $data->discount : 0,
			'valuta' => isset( $data->currency ) ? $data->currency : '',
			'price_old' => $data->price1 / ( $data->discount * 0.01 ),
		];

		$this->templateVars = array_merge( $this->templateVars, $this->mainVars->getMainVars() );
	}

	public function getTemplateVars() {
		return $this->templateVars;
	}

}