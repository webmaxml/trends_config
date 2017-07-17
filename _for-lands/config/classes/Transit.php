<?
class Transit {

	public function __construct() {
		$this->url = '';
	}

	public function setTargetUrl( $domain, $param_name ) {
	    $layer_name = $_SERVER[ 'HTTP_HOST' ];
	    $query = '';
	    $has_query = $_SERVER['QUERY_STRING'] !== '';
	    $has_param = isset( $_GET[ $param_name ] );

	    if( $has_query ) {

	        if ( $has_param ) {
	            $param_origin = '/'. $param_name .'='. $_GET[ $param_name ] .'/';
	            $param_replace = $param_name .'=' . $_GET[ $param_name ] . ', prokladka-' . $layer_name;

	            $query .= '?' . preg_replace( $param_origin, $param_replace, $_SERVER['QUERY_STRING'] );
	        } else {
	            $query .= '?' . $_SERVER['QUERY_STRING'] .'&'. $param_name .'=prokladka-' . $layer_name;
	        }

	    } else {
	        $query .= '?'. $param_name .'=prokladka-'. $layer_name;
	    }

	    $this->url = $domain . $query;
	}

	public function setTargetPlatformUrl( $domain ) {
		$this->url = $domain;
	}

	public function getUrl() {
		return $this->url;
	}

}
?>