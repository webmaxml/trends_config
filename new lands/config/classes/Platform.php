<?
class Platform {

	public function __construct( $client ) {
		$this->client = $client;
		$this->uid = '';
		$this->cookie = '';
		$this->utm = '';
	}

	public function init() {
		$this->setUserCookie();
		$this->uid = $this->retrieveUid();

		if ( $this->uid ) {
            $this->utm = $this->utm();
        }
	}

	private function setUserCookie() {
        $cookie_name = 'drop';

        if ( isset( $_COOKIE[ $cookie_name ] ) !== false ) {
            $this->cookie = $_COOKIE[ $cookie_name ];
        } else {
            $value = md5( microtime() );
            setcookie( $cookie_name, $value, strtotime('tomorrow') );
            $this->cookie = $value;
        }
    }

    private function retrieveUid() {
        if ( isset( $_GET['uid'] ) && $_GET['uid'] != '' ) {
            $uid = $this->filter( $_GET['uid'] );

            setcookie( 'uid', $uid, time() + 60 * 60 * 24 * 30 );

            return $uid;
        } else {
            if ( isset( $_COOKIE['uid'] ) && $_COOKIE['uid'] != '' ) {
                return $this->filter( $_COOKIE['uid'] );
            } else {
                return false;
            }
        }
    }

    private function filter( $value ) {
    	return preg_replace( "/[^a-zA-Z0-9_]+/", "", $value );
    }

    private function utm() {
        $utms = [
            'utm_source',
            'utm_medium',
            'utm_term',
            'utm_content',
            'utm_campaign',
        ];

        $data = [];

        foreach ( $utms as $utm ) {
            $data[ $utm ] = ( isset( $_GET[ $utm ] ) && $_GET[ $utm ] != '' ) ? $this->filter( $_GET[$utm] ) : '';
        }

        return $data;
    }

    public function getDataForConfig() {
    	$data = [
            'uid'        => $this->uid,
            'ip'         => $this->client->ip,
            'user_agent' => $this->client->agent . $this->client->ip . $this->cookie,
        ];

        $data = $data + $this->utm();

        return $data;
    }

}