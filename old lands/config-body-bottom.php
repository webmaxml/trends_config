<? if ( $config_data->layer === 'true' ) { 
    $layer_target = getLayerTargetUrl( $config_data->layer_target, 'utm_medium' );
?>
    <script type="text/javascript">
        function probrosUtm(url, _blank){
            $('a').attr('href',url);
            if(_blank){ 
                $('a').attr('target','_blank')
            } else {
                $('a').attr('target','_self')
            }
        }

        $(function(){
            //true - открывает ссылку в новом окне, false в текущем
            probrosUtm( "<?= $layer_target ?>", true );  
        });  
    </script>

<? } ?>