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
                    <h2>Допродажи</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <!-- BEGIN MODALS -->
                    <? switch ( $_GET[ 'upsell_status' ] ) { 
                        case '1': ?>
                            <div class="alert alert-success alert-dismissible fade in">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                Допродажа успешно создана.
                            </div>
                    <? break; ?>
                    <? case '2' ?>
                            <div class="alert alert-danger alert-dismissible fade in">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                Произошла ошибка при создании допродажи!
                            </div>
                    <? break; ?>
                    <? } ?>
                    <!-- END MODALS -->

                    <div style="margin: 20px 0;">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createUpsellModal">Создать допродажу</button>
                    </div>

                    <!-- BEGIN TABLE -->
                    <table id="datatable-responsive" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle;">ID</th>
                                <th style="text-align: center; vertical-align: middle;">Название</th>
                                <th style="text-align: center; vertical-align: middle;">Заголовок</th>
                                <th style="text-align: center; vertical-align: middle;">Краткое описание</th>
                                <th style="text-align: center; vertical-align: middle;">Цена</th>
                                <th style="text-align: center; vertical-align: middle;">Валюта</th>
                                <th style="text-align: center; vertical-align: middle;">Изображение</th>
                                <th style="text-align: center; vertical-align: middle;">URL</th>
                                <th style="text-align: center; vertical-align: middle;">Редактировать</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach( Upsells::getInstance()->getData() as $upsell ) { ?>

                                <tr>
                                    <td style="text-align: center; vertical-align: middle;"><?= $upsell[ 'id' ] ?></td>
                                    <td style="text-align: center; vertical-align: middle;"><?= $upsell[ 'name' ] ?></td>
                                    <td style="text-align: center; vertical-align: middle;"><?= $upsell[ 'title' ] ?></td>
                                    <td style="text-align: center; vertical-align: middle;"><?= $upsell[ 'description' ] ?></td>
                                    <td style="text-align: center; vertical-align: middle;"><?= $upsell[ 'price' ] ?></td>
                                    <td style="text-align: center; vertical-align: middle;"><?= $upsell[ 'currency' ] ?></td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <? 
                                            $imgUrl = Images::getInstance()->getUrlById( $upsell[ 'image' ] );
                                        ?>
                                        <img src="<?= $imgUrl ?>" alt="<?= $upsell[ 'name' ] ?>" style="max-width: 50px; max-height: 50px;">
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <a class="config__url-link" href="<?= $upsell[ 'url' ] ?>" target="_blank">
                                            <?= $upsell[ 'url' ] ?>     
                                        </a>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <button type="button" class="upsell__config-btn btn btn-primary" data-toggle="modal" data-target="#configUpsellModal" data-upsell-id="<?= $upsell[ 'id' ] ?>">
                                            <i class="fa fa-gears"></i>
                                        </button>
                                    </td>
                                </tr>

                            <? } ?>                  
                        </tbody>
                    </table>
                    <!-- END TABLE -->

                </div>
            </div>
        </div>

    </div>
</div>
<!-- /page content -->

<!-- BEGIN MODALS -->
<div id="createUpsellModal" class="modal fade" tabindex="-1" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title">Создать допродажу</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN UPSELL-CREATE FORM -->                                         
                <form class="form-horizontal form-label-left" action="/upsell-create" method="post">

                    <div class="form-group">
                        <label for="upsellName" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Название
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="upsellName" class="form-control col-md-7 col-xs-12" name="name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upsellTitle" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Заголовок
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="upsellTitle" class="form-control col-md-7 col-xs-12" name="title" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upsellDesc" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Краткое описание товара
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="upsellDesc" class="form-control col-md-7 col-xs-12" name="description" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upsellPrice" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Цена
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" id="upsellPrice" class="form-control col-md-7 col-xs-12" name="price" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upsellCurrency" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Валюта
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="upsellCurrency" class="form-control col-md-7 col-xs-12" name="currency" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upsellImg" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Изображение
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="upsellImg" class="form-control col-md-7 col-xs-12" name="image" required>

                                <? foreach ( Images::getInstance()->getImageData() as $image ) { ?>

                                    <option value="<?= $image[ 'id' ] ?>"><?= $image[ 'name' ] ?></option>

                                <? } ?>

                          </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upsellUrl" class="control-label col-md-3 col-sm-3 col-xs-12">
                            URL
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="url" id="upsellUrl" class="form-control col-md-7 col-xs-12" name="url" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Создать</button>
                        </div>
                    </div>

                </form>
                <!-- END UPSELL-CREATE FORM --> 

            </div>
        </div>
    </div>
</div>

<div id="configUpsellModal" class="modal fade" tabindex="-1" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title" id="upsellConfigTitle">Редактировать допродажу</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN UPSELL-CONFIG FORM -->                                         
                <form id="configUpsellForm" class="form-horizontal form-label-left" action="" method="post">

                    <input type="hidden" name="id" id="upsellId2">

                    <div class="form-group">
                        <label for="upsellName2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Название
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="upsellName2" class="form-control col-md-7 col-xs-12" name="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upsellTitle2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Заголовок
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="upsellTitle2" class="form-control col-md-7 col-xs-12" name="title" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upsellDesc2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Краткое описание товара
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="upsellDesc2" class="form-control col-md-7 col-xs-12" name="description">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upsellPrice2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Цена
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" id="upsellPrice2" class="form-control col-md-7 col-xs-12" name="price">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upsellCurrency2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Валюта
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="upsellCurrency2" class="form-control col-md-7 col-xs-12" name="currency">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upsellImg2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Изображение
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="upsellImg2" class="form-control col-md-7 col-xs-12" name="image">

                                <? foreach ( Images::getInstance()->getImageData() as $image ) { ?>

                                    <option value="<?= $image[ 'id' ] ?>"><?= $image[ 'name' ] ?></option>

                                <? } ?>

                          </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upsellUrl2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            URL
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="url" id="upsellUrl2" class="form-control col-md-7 col-xs-12" name="url">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Обновить</button>
                            <button type="button" id="deleteUpsellBtn" class="btn btn-danger">Удалить</button>
                        </div>
                    </div>

                </form>
                <!-- END UPSELL-CONFIG FORM --> 

            </div>
        </div>
    </div>
</div>
<!-- END MODALS -->

<? require 'footer.php' ?>