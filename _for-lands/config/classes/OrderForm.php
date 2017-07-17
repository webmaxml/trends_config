<?
class OrderForm {

	public function __construct( $client ) {
		$this->client = $client;

		$this->hidden_input = '';
	}

	public function init( $data ) {
		$this->setHiddenInput( $data );
	}

	private function setHiddenInput( $data ) {
	    $inputs = '<input type="hidden" name="land_id" value="' . $data->id . '">';
	    $inputs .= '<input type="hidden" name="ip" value="' . $this->client->ip . '">';
	    $inputs .= '<input type="hidden" name="host" value="' . $_SERVER[ 'SERVER_NAME' ] . '">';
	    $inputs .= '<input type="hidden" name="country" value="' . $this->client->country . '">';
	    $inputs .= '<input type="hidden" name="uid" value="' . $this->client->uid . '">';

	    foreach ( $this->client->utm as $key => $value ) {
	    	$inputs .= '<input type="hidden" name="'. $key .'" value="'. $value .'">';
	    }

	    $inputs .= '<input type="hidden" name="agent" value="' . $this->client->agent . '">';
	    $inputs .= '<input type="hidden" name="user_agent" value="' . $this->client->agent_for_platform . '">';
	    $inputs .= '<input type="hidden" name="lang" value="' . $this->client->lang . '">';
	    $inputs .= '<input type="hidden" name="device" value="' . $this->client->device . '">';
	    $inputs .= '<input type="hidden" name="os" value="' . $this->client->os . '">';
	    $inputs .= '<input type="hidden" name="browser" value="' . $this->client->browser . '">';
	    $inputs .= '<input type="hidden" name="referer" value="' . $this->client->referer . '">';
	    $inputs .= '<input type="hidden" name="title" value="' . $data->title . '">';
	    $inputs .= '<input type="hidden" name="price" value="' . $data->price1 . '">';
	    $inputs .= '<input type="hidden" name="discount" value="' . $data->discount . '">';
	    $inputs .= '<input type="hidden" name="currency" value="' . $data->currency . '">';

	    $this->hidden_input = $inputs;
	}

	public function getHiddenInput() {
		return $this->hidden_input;
	}

}