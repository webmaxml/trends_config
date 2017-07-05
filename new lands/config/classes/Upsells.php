<?
class Upsells {

	public function __construct( $mainVars ) {
		$this->vars = $mainVars;
		$this->upsells = '';
	}

	public function init( $data ) {
		$this->upsells = $data->upsells;
		$this->hit = $data->hit;
		$this->query = $this->getQuery( 'utm_medium' );

		$this->setUpsells();
		$this->addAssets();
	}

	private function getQuery( $param_name ) {
	    $query = '';
	    $upsell_from = $_SERVER[ 'HTTP_HOST' ];

	    $has_query = $_SERVER[ 'QUERY_STRING' ] !== '';
	    $has_param = isset( $_GET[ $param_name ] );

	    if( $has_query ) {

	        if ( $has_param ) {
	            $param_origin = '/'. $param_name .'='. $_GET[ $param_name ] .'/';
	            $param_replace = $param_name .'=' . $_GET[ $param_name ] . ', doprodazha-iz-' . $upsell_from;

	            $query .= '?' . preg_replace( $param_origin, $param_replace, $_SERVER[ 'QUERY_STRING' ] );
	        } else {
	            $query .= '?'. $_SERVER[ 'QUERY_STRING' ] .'&'. $param_name .'=doprodazha-iz-'. $upsell_from;
	        }

	    } else {
	        $query .= '?'. $param_name .'=doprodazha-iz-'. $upsell_from;
	    }

	    return $query;
	}

	public function setUpsells() {
		ob_start();
		?>
		<section id="allTrend" class="all-trend">
			<h1 class="all-trend__header">7 ИЗ 10 КЛИЕНТОВ ПРИОБРЕТАЮТ ПО ДОПОЛНИТЕЛЬНОЙ СКИДКЕ 
				<span class="all-trend__header-accent">30-50%</span> 
				ТАКИЕ ТОВАРЫ
			</h1>
			<ul class="all-trend__item-list">

				<?
					// show hit first
					foreach ( $this->upsells as $upsell ) {
						if ( $upsell->id === $this->hit ) { ?>

							<li class="all-trend__item all-trend__item--hit">
								<a href="<?= $upsell->url . $this->query ?>" class="all-trend__item-link" target="_blank">
									<h2 class="all-trend__item-header"><?= $upsell->title ?></h2>
									<div class="all-trend__item-img-wrap">
										<img class="all-trend__item-img" src="<?= $upsell->image ?>" alt="<?= $upsell->title ?>">
									</div>
									<p class="all-trend__item-about"><?= $upsell->description ?></p>
									<div class="all-trend__price-wrap">
										<strong class="all-trend__price"><?= $upsell->price ?> <?= $upsell->currency ?></strong>
									</div>
									<div class="all-trend__btn-wrap">
										<button type="button" class="all-trend__btn">Подробнее</button>
									</div>
								</a>
								<p class="all-trend__hit">XИТ ПРОДАЖ</p>
							</li>

						<? 
							break;
						}
					} 
					// show not hits
					foreach ( $this->upsells as $upsell ) { 
						if ( $upsell->id === $this->hit ) { continue; } ?>

						<li class="all-trend__item">
							<a href="<?= $upsell->url . $this->query ?>" class="all-trend__item-link" target="_blank">
								<h2 class="all-trend__item-header"><?= $upsell->title ?></h2>
								<div class="all-trend__item-img-wrap">
									<img class="all-trend__item-img" src="<?= $upsell->image ?>" alt="<?= $upsell->title ?>">
								</div>
								<p class="all-trend__item-about"><?= $upsell->description ?></p>
								<div class="all-trend__price-wrap">
									<strong class="all-trend__price"><?= $upsell->price ?> <?= $upsell->currency ?></strong>
								</div>
								<div class="all-trend__btn-wrap">
									<button type="button" class="all-trend__btn">Подробнее</button>
								</div>
							</a>
						</li>

				<? } ?>

			</ul>
		</section>
		<?
		$html = ob_get_contents();
		ob_end_clean();

		$this->upsells = $html;
	}

	private function addAssets() {
		global $config_host;
		global $isIndex;

		ob_start(); 
	    ?>

	    <link rel="stylesheet" href="<?= $config_host ?>/assets/css/allTrends.css">

	    <?
	    if ( !empty( $this->config_data->upsells ) && 
	    	 count( $this->config_data->upsells ) === 2 && 
	    	 $isIndex ) { 
	    ?>
	  
	    <style>
	        @media only screen and (min-width: 768px) {
	            .all-trend__item:first-child {
	                margin-left: 130px !important;
	            }

	            .all-trend__item:last-child {
	                 margin-right: 130px !important;
	            }
	        }
	    </style>

	    <? }

	    $html = ob_get_contents();
	    ob_end_clean();

	    $this->vars->addHeadBottom( $html );
	}

	public function getUpsells() {
		return $this->upsells;
	}

} 
