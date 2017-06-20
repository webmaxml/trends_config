<?php 
// if site is not connected = false
// if connected but has no upsells = ''
if ( $config_data ) {

	// checking if upsells are on
	if ( $isIndex && $config_data->upsell_index === 'on' ||
		 !$isIndex && $config_data->upsell_thanks === 'on' ) {

		$upsells = $config_data->upsells;
		$hit = $config_data->hit;
?>

<section id="allTrend" class="all-trend">
	<h1 class="all-trend__header">7 ИЗ 10 КЛИЕНТОВ ПРИОБРЕТАЮТ ПО ДОПОЛНИТЕЛЬНОЙ СКИДКЕ 
		<span class="all-trend__header-accent">30-50%</span> 
		ТАКИЕ ТОВАРЫ
	</h1>
	<ul class="all-trend__item-list">

		<?php 
			// show hit first
			foreach ( $upsells as $upsell ) {
				if ( $upsell->id === $hit ) { ?>

					<li class="all-trend__item all-trend__item--hit">
						<a href="<?= $upsell->url . $upsell_query ?>" class="all-trend__item-link" target="_blank">
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

				<?php 
					break;
				}
			} 
			// show not hits
			foreach ( $upsells as $upsell ) { 
				if ( $upsell->id === $hit ) { continue; } ?>

				<li class="all-trend__item">
					<a href="<?= $upsell->url . $upsell_query ?>" class="all-trend__item-link" target="_blank">
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

		<?php } ?>

	</ul>
</section>

<?php 
		}
	}
?>