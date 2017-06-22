<link rel="stylesheet" href="<?= $config_host ?>/assets/css/allTrends.css">
<script src="http://config.all-trends.top/assets/vendors/jquery/dist/jquery.min.js"></script>
<?php 
if ( isset( $config_data->upsells ) && count( $config_data->upsells) === 2 && $isIndex ) { ?>
	
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

<?php } ?>