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
                    <h2>Прокладки</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <!-- BEGIN MODALS -->
                    <? switch ( $_GET[ 'layer_status' ] ) { 
                        case '1': ?>
                            <div class="alert alert-success alert-dismissible fade in">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                Прокладка успешно подключена.
                            </div>
                    <? break; ?>
                    <? case '2' ?>
                            <div class="alert alert-danger alert-dismissible fade in">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                Произошла ошибка при подключении прокладки!
                            </div>
                    <? break; ?>
                    <? } ?>
                    <!-- END MODALS -->

                    <div style="margin: 20px 0;">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createLayerModal">Подключить прокладку</button>
                    </div>

                    <!-- BEGIN TABLE -->
                    <table id="datatable-responsive" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle;">ID</th>
                                <th style="text-align: center; vertical-align: middle;">Название</th>
                                <th style="text-align: center; vertical-align: middle;">URL</th>
                                <th style="text-align: center; vertical-align: middle;">На лендинг</th>
                                <th style="text-align: center; vertical-align: middle;">Редактировать</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach( Lands::getInstance()->getLandsData() as $land ) { ?>
                                <? if ( $land[ 'layer' ] === 'false' ) { continue; } ?>
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
                                            if ( $land[ 'layer_target' ] === '' ) {
                                                echo 'нет';
                                            } else  {
                                                $target = Lands::getInstance()->getDataById( $land[ 'layer_target' ] );
                                                if ( !$target[ 'name' ] ) { 
                                                    $targetName = 'Удалено'; 
                                                } else {
                                                    $targetName = $target[ 'name' ];
                                                }

                                                echo '<div>'; 
                                                echo $targetName;
                                                echo '</div>';
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <button type="button" class="layer__config-btn btn btn-primary" data-toggle="modal" data-target="#configLayerModal" data-land-id="<?= $land[ 'id' ] ?>">
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
<div id="createLayerModal" class="modal fade" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title">Подключить прокладку</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN LAYER-CREATE FORM -->                                         
                <form class="form-horizontal form-label-left" action="/layer-create" method="post">

                    <div class="form-group">
                        <label for="layerName" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Название
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="name" id="layerName" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="layerUrl" class="control-label col-md-3 col-sm-3 col-xs-12">
                            URL
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="url" id="layerUrl" class="form-control col-md-7 col-xs-12" name="url" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="layerTarget" class="control-label col-md-3 col-sm-3 col-xs-12">
                            На лендинг
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="layerTarget" class="select2_group form-control col-md-7 col-xs-12" name="target" style="width: 100%;" required>
                                <optgroup label="Лендинги">
                                    <? foreach ( Lands::getInstance()->getLandsData() as $land ) { ?>
                                        <? if ( $land[ 'layer' ] === 'true' ) { continue; } ?> 
                                        <option value="<?= $land[ 'id' ] ?>"><?= $land[ 'name' ] ?></option>
                                    <? } ?>        
                                </optgroup>
                                <optgroup label="Прокладки">
                                    <? foreach ( Lands::getInstance()->getLandsData() as $land ) { ?>
                                        <? if ( $land[ 'layer' ] === 'false' ) { continue; } ?> 
                                        <option value="<?= $land[ 'id' ] ?>"><?= $land[ 'name' ] ?></option>
                                    <? } ?>        
                                </optgroup>                    
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Подключить</button>
                        </div>
                    </div>

                </form>
                <!-- END LAYER-CREATE FORM --> 

            </div>
        </div>
    </div>
</div>

<div id="configLayerModal" class="modal fade" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title" id="layerConfigTitle">Редактировать прокладку</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN LAYER-CONFIG FORM -->                                         
                <form id="layerConfigForm" class="form-horizontal form-label-left" action="" method="post">

                    <input type="hidden" id="layerId2" name="id">

                    <div class="form-group">
                        <label for="layerName2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Название
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="name" id="layerName2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="layerUrl2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            URL
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="url" id="layerUrl2" class="form-control col-md-7 col-xs-12" name="url">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="layerTarget2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            На лендинг
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="layerTarget2" class="select2_group form-control col-md-7 col-xs-12" name="layer_target" style="width: 100%;">
                                <optgroup label="Лендинги">
                                    <? foreach ( Lands::getInstance()->getLandsData() as $land ) { ?>
                                        <? if ( $land[ 'layer' ] === 'true' ) { continue; } ?> 
                                        <option value="<?= $land[ 'id' ] ?>"><?= $land[ 'name' ] ?></option>
                                    <? } ?>        
                                </optgroup>
                                <optgroup label="Прокладки">
                                    <? foreach ( Lands::getInstance()->getLandsData() as $land ) { ?>
                                        <? if ( $land[ 'layer' ] === 'false' ) { continue; } ?> 
                                        <option value="<?= $land[ 'id' ] ?>"><?= $land[ 'name' ] ?></option>
                                    <? } ?>        
                                </optgroup>  
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Обновить</button>
                            <button type="button" id="deleteLayerBtn" class="btn btn-danger">Удалить</button>
                        </div>
                    </div>

                </form>
                <!-- END LAYER-CONFIG FORM --> 

            </div>
        </div>
    </div>
</div>
<!-- END MODALS -->

<? require 'footer.php' ?>