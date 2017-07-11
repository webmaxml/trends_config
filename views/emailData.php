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
                    <h2>Отправка Email</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?
                        $seller_data = Seller::getInstance()->getDataForOutput();
                        $seller_email = $seller_data[ 'info_email' ];
                        $seller_sender = $seller_data[ 'sender' ];
                        $seller_subject = $seller_data[ 'subject' ];
                        $seller_message = $seller_data[ 'message' ];
                    ?>
                    
                    <!-- BEGIN SELLER FORM -->                                         
                    <form class="form-horizontal form-label-left" action="/email-update" method="post">

                        <div class="form-group">
                            <label for="sellerEmail" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Email
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="email" class="form-control" name="info_email" id="sellerEmail" value="<?= $seller_email ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sellerSender" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Отправитель
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="sender" id="sellerSender" value="<?= $seller_sender ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sellerSubject" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Тема письмa
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="subject" id="sellerSubject" value="<?= $seller_subject ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sellerMessage" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Текст письма
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea rows="10" class="form-control" name="message" id="sellerMessage"><?= $seller_message ?></textarea>
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