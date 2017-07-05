<?
class OrderForm {

	public function __construct( $client ) {
		$this->client = $client;
		$this->hidden_input = '';
	}

	public function init( $data ) {
		$this->setHiddenInput( $data->id );
	}

	private function setHiddenInput( $land_id ) {
	    $inputs = '<input type="hidden" name="id" value="' . $land_id . '">';
	    $inputs .= '<input type="hidden" name="ip" value="' . $this->client->ip . '">';
	    $inputs .= '<input type="hidden" name="host" value="' . $_SERVER[ 'SERVER_NAME' ] . '">';
	    $inputs .= '<input type="hidden" name="country" value="' . $this->client->country . '">';
	    $inputs .= '<input type="hidden" name="utm_source" value="' . $_GET[ 'utm_source' ] . '">';
	    $inputs .= '<input type="hidden" name="utm_medium" value="' . $_GET[ 'utm_medium' ] . '">';
	    $inputs .= '<input type="hidden" name="utm_term" value="' . $_GET[ 'utm_term' ] . '">';
	    $inputs .= '<input type="hidden" name="utm_content" value="' . $_GET[ 'utm_content' ] . '">';
	    $inputs .= '<input type="hidden" name="utm_campaign" value="' . $_GET[ 'utm_campaign' ] . '">';

	    $this->hidden_input = $inputs;
	}

	public function getHiddenInput() {
		return $this->hidden_input;
	}

}