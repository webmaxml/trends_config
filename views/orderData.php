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
                    <h2>Настрока заказов</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?
                        $order_data = Order::getInstance()->getData();
                        $order_url = $order_data[ 'url' ];
                        $order_key = $order_data[ 'key' ];
                        $order_country = $order_data[ 'country' ];
                        $order_office_id = $order_data[ 'office_id' ];
                        $order_delivery_id = $order_data[ 'delivery_id' ];
                        $order_payment_id = $order_data[ 'payment_id' ];
                    ?>
                    
                    <!-- BEGIN ORDER-DATA FORM -->                                         
                    <form class="form-horizontal form-label-left" action="/order-update" method="post">

                        <div class="form-group">
                            <label for="orderUrl" class="control-label col-md-3 col-sm-3 col-xs-12">
                                СRM URL 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="url" id="orderUrl" value="<?= $order_url ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="orderKey" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Api ключ
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="key" id="orderKey" value="<?= $order_key ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="orderCountry" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Страна
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="country" id="orderCountry" value="<?= $order_country ?>">
                                    <option value="auto"
                                        <? if ( $order_country === 'auto' ) { echo 'selected'; } ?>
                                    >Авто ( по ip посетителя )</option>
                                    <option value="UA"
                                        <? if ( $order_country === 'UA' ) { echo 'selected'; } ?>
                                    >Украина</option>
                                    <option value="RU"
                                        <? if ( $order_country === 'RU' ) { echo 'selected'; } ?>
                                    >Россия</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="orderOffice" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Офис
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="office_id" id="orderOffice" value="<?= $order_office_id ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="orderDelivery" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Доставка
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="delivery_id" id="orderDelivery" value="<?= $order_delivery_id ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="orderPayment" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Оплата
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="payment_id" id="orderPayment" value="<?= $order_payment_id ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </div>

                    </form>
                    <!-- END ORDER-DATA FORM --> 

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<? require 'footer.php' ?>