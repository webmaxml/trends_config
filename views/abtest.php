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
                    <h2>Лендинги - АБ тестирование</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <!-- BEGIN MODALS -->
                    <? switch ( $_GET[ 'test_status' ] ) { 
                        case '1': ?>
                            <div class="alert alert-success alert-dismissible fade in">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                Тест успешно создан.
                            </div>
                    <? break; ?>
                    <? case '2' ?>
                            <div class="alert alert-danger alert-dismissible fade in">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                Произошла ошибка при создании теста!
                            </div>
                    <? break; ?>
                    <? } ?>
                    <!-- END MODALS -->

                    <div style="margin: 20px 0;">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createTestModal">Cоздать тест</button>
                    </div>

                    <!-- BEGIN TABLE -->
                    <table id="datatable-responsive" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle;">ID</th>
                                <th style="text-align: center; vertical-align: middle;">Название</th>
                                <th style="text-align: center; vertical-align: middle;">URL</th>
                                <th style="text-align: center; vertical-align: middle;">Направления</th>
                                <th style="text-align: center; vertical-align: middle;">Статус</th>
                                <th style="text-align: center; vertical-align: middle;">Редактировать</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach( Lands::getInstance()->getTestLands() as $land ) { ?>

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
                                            foreach( $land[ 'redirections' ] as $landId ) {
                                                $landName = Lands::getInstance()->getDataById( $landId )[ 'name' ];

                                                echo '<div>'; 
                                                echo $landName;
                                                echo '</div>';
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <? 
                                            if ( $land[ 'ab_test' ] === 'on' ) {
                                                echo '<input type="checkbox" class="test__toggle" data-land-id="' . $land[ "id" ] . '" checked>';
                                            } else {
                                                echo '<input type="checkbox" class="test__toggle" data-land-id="' . $land[ "id" ] . '">';
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <button type="button" class="test__config-btn btn btn-primary" data-toggle="modal" data-target="#configTestModal" data-land-id="<?= $land[ 'id' ] ?>">
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
<div id="createTestModal" class="modal fade" tabindex="-1" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title">Создать тест</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN TEST-CREATE FORM -->                                         
                <form class="form-horizontal form-label-left" action="/test-create" method="post">

                    <div class="form-group">
                        <label for="testEntry" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Точка входа
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="testEntry" class="select2 form-control col-md-7 col-xs-12" name="entry" required>
                                <? foreach ( Lands::getInstance()->getLandsData() as $land ) { ?>

                                    <option value="<?= $land[ 'id' ] ?>"><?= $land[ 'name' ] ?></option>

                                <? } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="testRedirects" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Направления
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="testRedirects" class="select2_multiple form-control col-md-7 col-xs-12" multiple="multiple" style="width: 100%;" name="redirects[]" required>
                                <? foreach ( Lands::getInstance()->getLandsData() as $land ) { ?>

                                    <option value="<?= $land[ 'id' ] ?>"><?= $land[ 'name' ] ?></option>

                                <? } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Создать</button>
                        </div>
                    </div>

                </form>
                <!-- END TEST-CREATE FORM --> 

            </div>
        </div>
    </div>
</div>

<div id="configTestModal" class="modal fade" tabindex="-1" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title" id="landConfigTitle">Редактировать Тест</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN TEST-CONFIG FORM -->                                         
                <form id="testConfigForm" class="form-horizontal form-label-left" action="" method="post">

                    <input type="hidden" id="landId3" name="entry">

                    <div class="form-group">
                        <label for="testRedirects2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Направления
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="testRedirects2" class="select2_multiple form-control col-md-7 col-xs-12" multiple="multiple" style="width: 100%;" name="redirects[]" require>
                                <? foreach ( Lands::getInstance()->getLandsData() as $land ) { ?>

                                    <option value="<?= $land[ 'id' ] ?>"><?= $land[ 'name' ] ?></option>

                                <? } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Обновить</button>
                            <button type="button" id="deleteTestBtn" class="btn btn-danger">Удалить</button>
                        </div>
                    </div>

                </form>
                <!-- END TEST-CONFIG FORM --> 

            </div>
        </div>
    </div>
</div>
<!-- END MODALS -->

<? require 'footer.php' ?>