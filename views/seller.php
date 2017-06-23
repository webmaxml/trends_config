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
                    <h2>Данные продавца</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?
                        $seller_data = Seller::getInstance()->getData();
                        $seller_name = $seller_data[ 'name' ];
                        $seller_address = $seller_data[ 'address' ];
                        $seller_phone1 = $seller_data[ 'phone1' ];
                        $seller_phone2 = $seller_data[ 'phone2' ];
                        $seller_email = $seller_data[ 'email' ];
                    ?>
                    
                    <!-- BEGIN SELLER FORM -->                                         
                    <form class="form-horizontal form-label-left" action="/seller-update" method="post">

                        <div class="form-group">
                            <label for="sellerName" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Организация
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="name" id="sellerName" value="<?= $seller_name ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sellerAddress" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Адресс
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="address" id="sellerAddress" value="<?= $seller_address ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sellerPhone1" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Телефон
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="phone1" id="sellerPhone1" value="<?= $seller_phone1 ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sellerPhone2" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Телефон
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="phone2" id="sellerPhone2" value="<?= $seller_phone2 ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sellerEmail" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Email
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="email" class="form-control" name="email" id="sellerEmail" value="<?= $seller_email ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </div>

                    </form>
                    <!-- END SELLER FORM --> 

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<? require 'footer.php' ?>