<?
class MainVars {

	public function __construct() {
		$this->head_top = '';
		$this->head_bottom = '';
		$this->body_top = '';
		$this->body_bottom = '';

		$this->init();
	}

	public function init() {
		global $config_host;

		$this->addHeadTop( '<script src="'. $config_host .'/assets/vendors/jquery/dist/jquery.min.js"></script>' );
		$this->addBodyBottom('<script src="'. $config_host .'/assets/vendors/maskedInput/jquery.maskedinput.js"></script>' . 
			'<script type="text/javascript">' .
				'jQuery(function($){' . 
					'$("input[ name=\'phone\' ]").mask("\+38(0*9) 999-99-99");' . 
				'}); </script>' );
	}

	public function addHeadTop( $html ) {
		$this->head_top .= $html;
	}

	public function addHeadBottom( $html ) {
		$this->head_bottom .= $html;
	}

	public function addBodyTop( $html ) {
		$this->body_top .= $html;
	}

	public function addBodyBottom( $html ) {
		$this->body_bottom .= $html;
	}

	public function addIndexMetrics( $data ) {
		$this->addHeadTop( $data->metric_head_index );
	    $this->addBodyTop( $data->metric_body_index );
	}

	public function addThanksMetrics( $data ) {
		$this->addHeadTop( $data->metric_head_thanks );
	    $this->addBodyTop( $data->metric_body_thanks );
	}

	public function getMainVars() {
		return [
			'head_top' => $this->head_top,
			'head_bottom' => $this->head_bottom,
			'body_top' => $this->body_top,
			'body_bottom' => $this->body_bottom,
		];
	}

}