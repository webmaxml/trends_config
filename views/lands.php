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
                    <h2>Лендинги - допродажа</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <!-- BEGIN MODALS -->
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
                    <!-- END MODALS -->

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
                                <th style="text-align: center; vertical-align: middle;">Допродажи</th>
                                <th style="text-align: center; vertical-align: middle;">Хит продаж</th>
                                <th style="text-align: center; vertical-align: middle;">Допродажа на главной</th>
                                <th style="text-align: center; vertical-align: middle;">Допродажа на "спасибо"</th>
                                <th style="text-align: center; vertical-align: middle;">Редактировать</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach( Lands::getInstance()->getLandsData() as $land ) { ?>

                                <tr>
                                    <td style="text-align: center; vertical-align: middle;"><?= $land[ 'id' ] ?></td>
                                    <td style="text-align: center; vertical-align: middle;"><?= $land[ 'name' ] ?></td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <a class="config__url-link" href="<?= $land[ 'url' ] ?>" target="_blank">
                                            <?= $land[ 'url' ] ?>     
                                        </a>    
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <? 
                                            if ( $land[ 'upsells' ] === '' ) {
                                                echo 'нет';
                                            } elseif ( is_array( $land[ 'upsells' ] ) ) {
                                                foreach( $land[ 'upsells' ] as $key => $upsellId ) {
                                                    $upsellName = Upsells::getInstance()->getNameById( $upsellId );
                                                    if ( !$upsellName ) { $upsellName = 'Удалено'; }

                                                    echo '<div>'; 
                                                    echo $upsellName;
                                                    echo '</div>';
                                                }
                                            } else {
                                                echo 'Ошибка!';
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <? 
                                            if ( $land[ 'upsell_hit' ] === '' ) {
                                                echo 'нет';
                                            } else  {
                                                echo '<div style="color: #d41c1c;">'; 
                                                echo Upsells::getInstance()->getNameById( $land[ 'upsell_hit' ] );
                                                echo '</div>';
                                            } 
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <? 
                                            $landId = $land[ "id" ];
                                            if ( $land[ 'upsell_index' ] === 'on' ) {
                                                 echo '<input type="checkbox" class="upsell__toggle" data-land-id="' . $landId . '" data-upsell-type="index" checked>';
                                            } else {
                                                echo '<input type="checkbox" class="upsell__toggle" data-upsell-type="index" data-land-id="' . $landId . '">';
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <? 
                                            if ( $land[ 'upsell_thanks' ] === 'on' ) {
                                                echo '<input type="checkbox" class="upsell__toggle" data-upsell-type="thanks" data-land-id="' . $landId . '" checked>';
                                            } else {
                                                echo '<input type="checkbox" class="upsell__toggle" data-upsell-type="thanks" data-land-id="' . $landId . '">';
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <button type="button" class="land__config-btn btn btn-primary" data-toggle="modal" data-target="#configLandModal" data-land-id="<?= $land[ 'id' ] ?>">
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

<div id="configLandModal" class="modal fade" tabindex="-1" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title" id="landConfigTitle">Редактировать лендинг</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN LANDING-CONFIG FORM -->                                         
                <form id="landConfigForm" class="form-horizontal form-label-left" action="" method="post">

                    <input type="hidden" id="landId2" name="id">

                    <div class="form-group">
                        <label for="landName2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Название
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="name" id="landName2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="landUrl2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            URL
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="url" id="landUrl2" class="form-control col-md-7 col-xs-12" name="url">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="landUpsells2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Допродажи
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="landUpsells2" class="select2_multiple form-control col-md-7 col-xs-12" multiple="multiple" style="width: 100%;" name="upsells[]">
                                <? foreach ( Upsells::getInstance()->getData() as $upsell ) { ?>

                                    <option value="<?= $upsell[ 'id' ] ?>"><?= $upsell[ 'name' ] ?></option>

                                <? } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="landUpsell_hit2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Хит продаж
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="landUpsell_hit2" class="select2 form-control col-md-7 col-xs-12" name="upsell_hit">
                                <option value="">Нет</option>
                                <? foreach ( Upsells::getInstance()->getData() as $upsell ) { ?>

                                    <option value="<?= $upsell[ 'id' ] ?>"><?= $upsell[ 'name' ] ?></option>

                                <? } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Обновить</button>
                            <button type="button" id="deleteLandBtn" class="btn btn-danger">Удалить</button>
                        </div>
                    </div>

                </form>
                <!-- END LANDING-CONFIG FORM --> 

            </div>
        </div>
    </div>
</div>
<!-- END MODALS -->

<? require 'footer.php' ?>