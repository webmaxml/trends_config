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
                    <h2>Данные дропплатформы</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?
                        $platform_data = Platform::getInstance()->getData();
                        $platform_source = $platform_data[ 'source' ];
                        $platform_url = $platform_data[ 'url' ];
                        $platform_key = $platform_data[ 'key' ];
                    ?>
                    
                    <!-- BEGIN PLATFORM FORM -->                                         
                    <form class="form-horizontal form-label-left" action="/platform-update" method="post">

                        <div class="form-group">
                            <label for="platformSource" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Источник данных
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="source" id="platformSource" value="<?= $platform_source ?>">                                    
                                    <option value="platform"
                                        <? if ( $platform_source === 'platform' ) { echo 'selected'; } ?>
                                    >Дропплатформа</option>
                                    <option value="config"
                                        <? if ( $platform_source === 'config' ) { echo 'selected'; } ?>
                                    >Конфигуратор</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="platformUrl" class="control-label col-md-3 col-sm-3 col-xs-12">
                                URL
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="url" class="form-control" name="url" id="platformUrl" value="<?= $platform_url ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="platformKey" class="control-label col-md-3 col-sm-3 col-xs-12">
                                Api key
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="key" id="platformKey" value="<?= $platform_key ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </div>

                    </form>
                    <!-- END PLATFORM FORM --> 

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<? require 'footer.php' ?>