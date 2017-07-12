<?php

interface ISourceState {

	public function getState();
	public function getApiData( $input );
	public function makeOrder( $input );
	public function sendMail( $input );
	public function getUpsellsData( $upsell_id );
	public function getTestData( $land_id );
	public function getLayerData( $land_id );
	public function getScriptData( $land_id );
	public function getPrices( $land_id, $platform_data = false );
	public function getMetrics( $land_id, $platform_data = false );
	public function getTitle( $land_id, $platform_data = false );
}