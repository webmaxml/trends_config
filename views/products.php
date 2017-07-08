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
                    <h2>Товары</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <!-- BEGIN MODALS -->
                    <? switch ( $_GET[ 'product_status' ] ) { 
                        case '1': ?>
                            <div class="alert alert-success alert-dismissible fade in">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                Товар успешно создан.
                            </div>
                    <? break; ?>
                    <? case '2' ?>
                            <div class="alert alert-danger alert-dismissible fade in">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                Произошла ошибка при создании товара!
                            </div>
                    <? break; ?>
                    <? } ?>
                    <!-- END MODALS -->

                    <div style="margin: 20px 0;">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createProductModal">Создать товар</button>
                    </div>

                    <!-- BEGIN TABLE -->
                    <table id="datatable-responsive" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle;">ID</th>
                                <th style="text-align: center; vertical-align: middle;">Название</th>
                                <th style="text-align: center; vertical-align: middle;">ID в CRM</th>
                                <th style="text-align: center; vertical-align: middle;">Редактировать</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach( Products::getInstance()->getData() as $product ) { ?>
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;"><?= $product[ 'id' ] ?></td>
                                    <td style="text-align: center; vertical-align: middle;"><?= $product[ 'name' ] ?></td>
                                    <td style="text-align: center; vertical-align: middle;"><?= $product[ 'crm_id' ] ?></td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <button type="button" class="products__config-btn btn btn-primary" data-toggle="modal" data-target="#configProductModal" data-product-id="<?= $product[ 'id' ] ?>">
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
<div id="createProductModal" class="modal fade" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title">Создать товар</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN PRODUCT-CREATE FORM -->                                         
                <form class="form-horizontal form-label-left" action="/product-create" method="post">

                    <div class="form-group">
                        <label for="productName" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Название
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="name" id="productName" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productId" class="control-label col-md-3 col-sm-3 col-xs-12">
                            ID в CRM
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="productId" class="form-control col-md-7 col-xs-12" name="crm_id" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Создать</button>
                        </div>
                    </div>

                </form>
                <!-- END PRODUCT-CREATE FORM --> 

            </div>
        </div>
    </div>
</div>

<div id="configProductModal" class="modal fade" style="z-index: 99999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>x</span>
                </button>
                <h4 class="modal-title" id="productConfigTitle">Редактировать товар</h4>
            </div>
            <div class="modal-body">

                <!-- BEGIN PRODUCT-CONFIG FORM -->                                         
                <form id="productConfigForm" class="form-horizontal form-label-left" action="" method="post">

                    <input type="hidden" id="productConfigId" name="id">

                    <div class="form-group">
                        <label for="productName2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Название
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="name" id="productName2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productId2" class="control-label col-md-3 col-sm-3 col-xs-12">
                            ID в CRM
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="productId2" class="form-control col-md-7 col-xs-12" name="crm_id">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Обновить</button>
                            <button type="button" id="deleteProductBtn" class="btn btn-danger">Удалить</button>
                        </div>
                    </div>

                </form>
                <!-- END PRODUCT-CONFIG FORM --> 

            </div>
        </div>
    </div>
</div>
<!-- END MODALS -->

<? require 'footer.php' ?>