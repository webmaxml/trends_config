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
                    <h2>Лендинги - данные</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <!-- BEGIN MODALS -->
                    <? if ( isset( $_GET[ 'land_status' ] ) ) { ?>
                        <? switch ( $_GET[ 'land_status' ] ) { 
                            case '1': ?>
                                <div class="alert alert-success alert-dismissible fade in">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    Лендинг успешно подключен.
                                </div>
                        <? break; ?>
                        <? case '2' ?>
                                <div class="alert alert-danger alert-dismissible fade in">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    Произошла ошибка при подключении лендинга!
                                </div>
                        <? break; ?>
                        <? } ?>
                    <? } ?>
                    <!-- END MODALS -->

                    <p>
                        Если <span class="label label-info">Прокладка</span>: 
                        <ul>
                            <li>Цены, скидка, валюта, метрики используются из целевого лендинга</li>
                            <li>Скрипт конверсии отключается</li>
                        </ul>
                        Вы все еще можете редактировать эти данные для прокладки, однако использоваться они будут только если лендинг перестанет быть прокладкой
                    </p>

                    <div style="margin: 20px 0;">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createLandModal">Подключить лендинг</button>
                    </div>

                    <!-- BEGIN TABLE -->
                    <table id="datatable-responsive" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle;">ID</th>
                                <th style="text-align: center; vertical-align: middle;">Название</th>
                                <th style="text-align: center; vertical-align: middle;">URL</th>
                                <th style="text-align: center; vertical-align: middle;">Продукт</th>
                                <th style="text-align: center; vertical-align: middle;">Цены</th>
                                <th style="text-align: center; vertical-align: middle;">Скидка, %</th>
                                <th style="text-align: center; vertical-align: middle;">Валюта</th>
                                <th style="text-align: center; vertical-align: middle;">Метрики</th>
                                <th style="text-align: center; vertical-align: middle;">Скрипт конверсии</th>
                                <th style="text-align: center; vertical-align: middle;"><i class="fa fa-gears"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? 
                                $source = Platform::getInstance()->getData()[ 'source' ];
                                $lands = Lands::getInstance();

                                foreach( $lands->getLandsData() as $land ) { ?>
                                
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;"><?= $land[ 'id' ] ?></td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <div><?= $land[ 'name' ] ?></div>
                                        <? 
                                            if ( $lands->isLayer( $land[ 'id' ] ) ) { 
                                                echo '<div><span class="label label-info">Прокладка</span></div>';
                                            }

                                            if ( $lands->hasTest( $land[ 'id' ] ) ) { 
                                                echo '<div><span class="label label-danger">AB тест</span></div>';
                                            } 
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <a class="config__url-link" href="<?= $land[ 'url' ] ?>" target="_blank">
                                            <?= $land[ 'url' ] ?>     
                                        </a>    
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <?
                                            $product = Products::getInstance()->getProductById( $land[ 'product' ] );
                                            echo $product[ 'name' ];
                                         ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <? 
                                            if ( $lands->isLayer( $land[ 'id' ] ) && $source === 'config' ) {
                                                $prices = $lands->getPricesFromTarget( $land[ 'id' ] );
                                                if ( $prices ) {
                                                    foreach ( $prices as $price ) {
                                                        echo '<div><span class="label label-info">'. $price .'</span></div>';
                                                    }
                                                }
                                                
                                            } else {
                                                $prices = $lands->getPrices( $land[ 'id' ] );
                                                if ( $prices ) {
                                                    foreach ( $prices as $price ) {
                                                        echo '<div>'. $price .'</div>';
                                                    }
                                                }

                                            }

                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <? 
                                            if ( $lands->isLayer( $land[ 'id' ] ) && $source === 'config' ) {
                                                $discount = $lands->getDiscountFromTarget( $land[ 'id' ] );
                                                echo '<span class="label label-info">'. $discount .'</span>';
                                            } else {
                                                $discount = $lands->getDiscount( $land[ 'id' ] );
                                                echo $discount;
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <? 
                                            if ( $lands->isLayer( $land[ 'id' ] ) && $source === 'config' ) {
                                                $currency = $lands->getCurrencyFromTarget( $land[ 'id' ] );
                                                echo '<span class="label label-info">'. $currency .'</span>';
                                            } else {
                                                $currency = $lands->getCurrency( $land[ 'id' ] );
                                                echo $currency;
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <button type="button" class="land-data__metric-btn btn btn-warning" data-toggle="modal" data-target="#metricLandDataModal" data-land-id="<?= $land[ 'id' ] ?>">
                                            <i class="fa fa-feed"></i>
                                        </button>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <button type="button" class="land-data__script-btn btn btn-danger" data-toggle="modal" data-target="#scriptLandDataModal" data-land-id="<?= $land[ 'id' ] ?>">
                                            <i class="fa fa-shopping-cart"></i>
                                        </button>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <button type="button" class="land-data__config-btn btn btn-primary" data-toggle="modal" data-target="#configLandDataModal" data-land-id="<?= $land[ 'id' ] ?>">
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
<div id="createLandModal" class="modal fade" tabindex="-1" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title">Подключить лендинг</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN LANDING-CREATE FORM -->                                         
                <form class="form-horizontal form-label-left" action="/land-create" method="post">

                    <div class="form-group">
                        <label for="landName" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Название
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="name" id="landName" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="landUrl" class="control-label col-md-3 col-sm-3 col-xs-12">
                            URL
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="url" id="landUrl" class="form-control col-md-7 col-xs-12" name="url" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Подключить</button>
                        </div>
                    </div>

                </form>
                <!-- END LANDING-CREATE FORM --> 

            </div>
        </div>
    </div>
</div>

<div id="metricLandDataModal" class="modal fade" tabindex="-1" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title" id="landMetricTitle">Редактировать метрики</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN LANDING-METRIC FORM -->                                         
                <form id="metricLandForm" class="form-horizontal form-label-left" action="" method="post">

                    <input type="hidden" id="metricLandId" name="id">

                    <div id="accordion" class="accordion col-xs-12 col-sm-10 col-md-10 col-sm-push-1" style="margin-bottom: 20px;">
                        <div class="panel">
                            <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h4 class="panel-title">Главная страница</h4>
                            </a>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label for="metricIndexHead" class="control-label col-md-2 col-sm-2 col-xs-12">
                                            Head
                                        </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <textarea rows="10" class="form-control" name="metric_head_index" id="metricIndexHead"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="metricIndexBody" class="control-label col-md-2 col-sm-2 col-xs-12">
                                            Body
                                        </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <textarea rows="10" class="form-control" name="metric_body_index" id="metricIndexBody"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                <h4 class="panel-title">Страница спасибо</h4>
                            </a>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                        
                                    <div class="form-group">
                                        <label for="metricThanksHead" class="control-label col-md-2 col-sm-2 col-xs-12">
                                            Head
                                        </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <textarea rows="10" class="form-control" name="metric_head_thanks" id="metricThanksHead"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="metricThanksBody" class="control-label col-md-2 col-sm-2 col-xs-12">
                                            Body
                                        </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <textarea rows="10" class="form-control" name="metric_body_thanks" id="metricThanksBody"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" style="text-align: center;">
                            <button type="submit" class="btn btn-primary">Обновить</button>
                        </div>
                    </div>

                </form>
                <!-- END LANDING-METRIC FORM --> 

            </div>
        </div>
    </div>
</div>


<div id="scriptLandDataModal" class="modal fade" tabindex="-1" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title" id="landScriptTitle">Редактировать скрипт</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN LANDING-SCRIPT FORM -->                                         
                <form id="scriptLandForm" class="form-horizontal form-label-left" action="" method="post">

                    <input type="hidden" id="scriptLandId" name="id">

                    <div class="form-group">
                        <label for="scriptActiveCheckbox" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Статус
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="scriptActiveCheckbox" type="checkbox" class="script__toggle" name="script_active">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="scriptCountry" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Страна
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="scriptCountry" class="form-control" name="script_country">
                                <option value="ua">Украина</option>
                                <option value="ru">Россия</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="scriptSex" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Пол
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="scriptSex" class="form-control" name="script_sex">
                                <option value="m">Мужчины</option>
                                <option value="w">Женщины</option>
                                <option value="all">Все</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="scriptWindows" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Кол-во окон
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" id="scriptWindows" class="form-control" name="script_windows">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="scriptItems" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Кол-во товара
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" id="scriptItems" class="form-control" name="script_items">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" style="text-align: center;">
                            <button type="submit" class="btn btn-primary">Обновить</button>
                        </div>
                    </div>

                </form>
                <!-- END LANDING-SCRIPT FORM --> 

            </div>
        </div>
    </div>
</div>


<div id="configLandDataModal" class="modal fade" tabindex="-1" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title" id="landConfigTitle">Редактировать лендинг</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN LANDING-DATA-CONFIG FORM -->                                         
                <form id="landDataConfigForm" class="form-horizontal form-label-left" action="" method="post">

                    <input type="hidden" id="landDataId" name="id">

                    <div class="form-group">
                        <label for="landDataName" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Название
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="name" id="landDataName">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="landDataUrl" class="control-label col-md-3 col-sm-3 col-xs-12">
                            URL
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="url" id="landDataUrl" class="form-control col-md-7 col-xs-12" name="url">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="landDataProduct" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Продукт
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="landDataProduct" class="form-control" name="product">
                                <?
                                    $products = Products::getInstance()->getData();
                                    foreach ( $products as $product ) {
                                        echo '<option value="'. $product[ 'id' ] .'">'. $product[ 'name' ] .'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="landDataPrice1" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Цена
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" id="landDataPrice1" class="form-control col-md-7 col-xs-12" name="price1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="landDataDiscount" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Скидка, %
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" id="landDataDiscount" class="form-control col-md-7 col-xs-12" name="discount">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="landDataCurrency" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Валюта
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="landDataCurrency" class="form-control col-md-7 col-xs-12" name="currency">
                        </div>
                    </div>

                    <div id="accordion2" class="accordion col-xs-12 col-sm-10 col-md-10 col-sm-push-1" style="margin-bottom: 20px;">
                        <div class="panel">
                            <a class="panel-heading collapsed" role="tab" id="headingOne2" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
                                <h4 class="panel-title">Дополнительные цены</h4>
                            </a>
                            <div id="collapseOne2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne2">
                                <div class="panel-body">
                                    
                                    <div class="form-group">
                                        <label for="landDataPrice2" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Цена 2
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="landDataPrice2" class="form-control col-md-7 col-xs-12" name="price2">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="landDataPrice3" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Цена 3
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="landDataPrice3" class="form-control col-md-7 col-xs-12" name="price3">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="landDataPrice4" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Цена 4
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="landDataPrice4" class="form-control col-md-7 col-xs-12" name="price4">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="landDataPrice5" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Цена 5
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="landDataPrice5" class="form-control col-md-7 col-xs-12" name="price5">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="landDataPrice6" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Цена 6
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="landDataPrice6" class="form-control col-md-7 col-xs-12" name="price6">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="landDataPrice7" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Цена 7
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="landDataPrice7" class="form-control col-md-7 col-xs-12" name="price7">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="landDataPrice8" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Цена 8
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="landDataPrice8" class="form-control col-md-7 col-xs-12" name="price8">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="landDataPrice9" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Цена 9
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="landDataPrice9" class="form-control col-md-7 col-xs-12" name="price9">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="landDataPrice10" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Цена 10
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" id="landDataPrice10" class="form-control col-md-7 col-xs-12" name="price10">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Обновить</button>
                            <button type="button" id="deleteLandDataBtn" class="btn btn-danger">Удалить лендинг</button>
                        </div>
                    </div>

                </form>
                <!-- END LANDING-DATA-CONFIG FORM --> 

            </div>
        </div>
    </div>
</div>
<!-- END MODALS -->

<? require 'footer.php' ?>