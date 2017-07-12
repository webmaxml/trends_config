<?php

interface ILayerState {

	public function getPrices( $land_id );
	public function getDiscount( $land_id );
	public function getCurrency( $land_id );
	public function getMetrics( $land_id );
	public function getScript( $land_id );
}