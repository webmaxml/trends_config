<?php

class FileDB {

	private static $instance;

	public static function getInstance() {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
	}

	public function create( $filename, $values ) {
		$filepath = 'data/' . $filename . '.php';
		require $filepath;

		$content[] = array_merge( [ 'id' => $this->setId() ], $values );

		$text = $this->formText( $content );
		return $this->writeToFile( $filepath, $text );
	}

	public function update( $filename, $id, $values ) {
		$filepath = 'data/' . $filename . '.php';
		require $filepath;

		$updated = array();
		foreach ( $content as $item ) {
			if ( $item[ 'id' ] === (string) $id ) {
				$updated[] = array_merge( $item, $values );
			} else {
				$updated[] = $item;
			}
		}

		$text = $this->formText( $updated );
		return $this->writeToFile( $filepath, $text );
	}

	public function delete( $filename, $id ) {
		$filepath = 'data/' . $filename . '.php';
		require $filepath;

		$updated = array();
		foreach ( $content as $item ) {
			if ( $item[ 'id' ] !== (string) $id ) {
				$updated[] = $item;
			}
		}

		$text = $this->formText( $updated );
		return $this->writeToFile( $filepath, $text );
	}

	private function formText( $values ) {
		$text = "";
		foreach ( $values as $key => $value ) {
			if ( is_int( $key ) ) {

				if ( is_array( $value ) ) {
					$text .= "[\n";
					$text .= $this->formText( $value );
					$text .= "],\n";
				} elseif ( is_bool( $value ) ) {
					$value = $value ? 'true' : 'false';
					$text .= "'{$value}',\n";
				} else {
					$text .= "'{$value}',\n";
				}

			} else {

				if ( is_array( $value ) ) {
					$text .= "'" . $key . "'" . "=>" . "[\n";
					$text .= $this->formText( $value );
					$text .= "],\n";
				} elseif ( is_bool( $value ) ) {
					$value = $value ? 'true' : 'false';
					$text .= "'" . $key . "'" . "=>" . "'{$value}',\n";
				} else {
					$text .= "'" . $key . "'" . "=>" . "'{$value}',\n";
				}

			}
		}

		return $text;
	}

	private function writeToFile( $filepath, $text ) {
		$file = fopen( $filepath, 'w+' );
		flock( $file, LOCK_EX );

		$input = "<?php\n";
		$input .= "$" . "content = array(\n";
		$input .= $text;
		$input .= ");";

		$result = fwrite($file, $input);
		flock( $file, LOCK_UN );

		return $result;
	}

	private function setId() {
		require 'data/id.php';
		$id = $content[ 'lastId' ] = ++$content[ 'lastId' ];

		$text = $this->formText( $content );
		$this->writeToFile( 'data/id.php', $text );

		return $id;
	}
}