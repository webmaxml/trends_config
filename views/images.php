<? 
global $config;
require 'header.php' 
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Изображения</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">

                        <? foreach ( Images::getInstance()->getImageData() as $image ) { ?>

                            <div class="col-md-55 image__item">
                                <div class="thumbnail" style="height: 171px;">
                                    <div class="image view view-first">
                                        <img src="<?= $image[ 'url' ] ?>" alt="<?= $image[ 'name' ] ?>" style="max-width: 100%; max-height: 100%;display: block; margin: 0 auto;">
                                        <div class="mask">
                                            <p>Удалить изображение</p>
                                            <div class="tools tools-bottom">
                                                <a href="javascript:void(0)" class="image__delete" data-image-id="<?= $image[ 'id' ] ?>" data-image-name="<?= $image[ 'name' ] ?>">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="caption">
                                        <p style="text-align: center; line-height: 26px;"><?= $image[ 'name' ] ?></p>
                                    </div>
                                </div>
                            </div>
                            
                        <? } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<? require 'footer.php' ?>