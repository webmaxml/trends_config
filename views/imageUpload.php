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
                    <h2>Загрузить изображения</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <p>Перетащите один или несколько файлов в зону загрузки или кликните для выбора файлов. Файлы с одиннаковым именем будут заменены.</p>
                    <form action="/image-upload" method="post" class="dropzone dz-clickable" enctype="multipart/form-data">
                        <div class="dz-default dz-message">
                            <span>Перенесите файлы сюда для загрузки</span>
                        </div>
                    </form>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<? require 'footer.php' ?>