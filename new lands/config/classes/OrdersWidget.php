<?
class OrdersWidget {

	public function __construct( $mainVars ) {
		$this->vars = $mainVars;
	}

	public function init( $data ) {
		$this->pol = $data->script_sex;
		$this->country = $data->script_country;
		$this->vsego = $data->script_windows;
		$this->tovar = $data->script_items;
		$this->product = $data->product;
		$this->price = $data->price1;
		$this->valuta = $data->currency;

		$this->vars->addBodyBottom( $this->getWidgetContent() );
		$this->addAssets();
	}

	private function addAssets() {
		global $config_host;

		ob_start(); 
	    ?>

	    <link rel="stylesheet" href="<?= $config_host ?>/assets/css/uved.css">

	    <?

	    $html = ob_get_contents();
	    ob_end_clean();

	    $this->vars->addHeadBottom( $html );
	}

	private function getWidgetContent() {
		global $config_host;

		$name_w = array("Татьяна", "Светлана", "Елена", "Алина", "Екатерина", "Дарья", "Анжела", "Кристина", "Мирослава","Валерия","Маргарита","Евгения","Александра","Виктория","Анастасия","Мария","Ольга","Карина","Ксения","Наталья");
		$surname_w = array("Смирновa","Абрамовa","Авдеевa","Блиновa","Большаковa","Волковa","Дмитриевa","Зуевa","Капустинa","Котовa","Макаровa","Моисеевa","Никоновa","Осиповa","Поповa","Русаковa","Селезнёвa","Соболевa","Трофимовa","Федотовa","Черновa","Щукинa","Репникова");
		$surname_n = array("Кравец","Кравченко","Ковальчук","Матвиенко","Удовиченко","Мережко","Полищук","Вдовиченко","Бутенко","Дзюба","Гончарук","Кондратюк","Рубан","Лавренко","Овчаренко","Косенко","Тимченко","Сербиненко","Прокопенко","Кавун","Голуб","Маланюк","Пилипенко","Сердюк","Говоруха","Верховодько","Ткаченко","Лещенко","Собчак","Гузенко","Горобец","Воробей","Тимошенко","Романюк","Мишкевич","Винич","Бутко","Казакевич","Котвич","Клочко","Горбенко","Авдиенко","Мусиенко","Енченко","Луценко","*******");
		$name_m = array("Игорь", "Владимир", "Алексей", "Андрей", "Сергей", "Вячеслав", "Максим", "Григорий", "Георгий","Валерий","Михаил","Евгений","Александр","Виктор","Анатолий","Дмитрий","Олег","Павел","Петр","Контантин");
		$surname_m = array("Смирнов","Абрамов","Авдеев","Блинов","Большаков","Волков","Дмитриев","Зуев","Капустин","Котов","Макаров","Моисеев","Никонов","Осипов","Попов","Русаков","Селезнёв","Соболев","Трофимов ","Федотов","Чернов","Щукин","Репников");
		$city_ua=array("Киев","Харьков","Одесса","Днепр","  Запорожье","Львов","Кривой Рог","Николаев","Мариуполь","Винница","Херсон","Чернигов","Полтава","Черкассы","Хмельницкий","Сумы","Житомир","Черновцы","Ровно","Каменское ","Кропивницкий","Ивано-Франковск","Кременчуг","Тернополь","Луцк","Белая Церковь","Никополь","Бердянск","Павлоград","Каменец-Подольский");
		$city_ru=array("Москва","Санкт-Петербург","Новосибирск","Екатеринбург","Нижний Новгород","Казань","Челябинск","Омск","Самара","Ростов-на-Дону","Уфа","Красноярск","Пермь","Воронеж","Волгоград","Краснодар","Саратов","Тюмень","Тольятти","Ижевск","Барнаул","Иркутск","Ульяновск","Хабаровск","Ярославль");

		if ( $this->country === "ua" ) {
		    $city = $city_ua; 
		} elseif ( $this->country === "ru" ) {
		    $city = $city_ru;
		} else {
		    $city = array_merge( $city_ua, $city_ru );
		}


		if ( $this->pol === "m" ) { 
		    $name = $name_m; 
		    $surname_all = array_merge( $surname_m, $surname_n );
		} elseif ( $this->pol === "w" ) { 
		    $name = $name_w; 
		    $surname_all = array_merge( $surname_w, $surname_n );
		} else {
		    $name = array_merge( $name_w, $name_m ); 
		    $surname_all = $surname_n; 
		} 

		ob_start();
		?>

		<script>
		$( document ).ready( function(){

		    var i = 0;

		    function yved() {
		        i = 1;
		        $( '.yved:nth-child('+i+')' ).fadeIn( 500 ).delay( 5000 ).fadeOut( 500 );
		    }

		    setTimeout( function() {

		        setInterval( function() {
		            i = i + 1;
		            if ( i > 10 ) {
		                i = 1; //10 - количество уведомлений
		            }
		            $( '.yved:nth-child('+i+')' ).fadeIn( 500 ).delay( 5000 ).fadeOut( 500 );
		        }, 30000 );
		        yved();

		    }, 10000 );

		} );

		var ip = "<?= $_SERVER['REMOTE_ADDR'] ?>";

		$.ajax ({
		    type: "GET",
		    url: "http://ipgeobase.ru:7020/geo/?ip=" + ip,
		    dataType: "xml",
		    success: function(xml) {
		        var region = $( xml ).find( 'city' ).text();
		        $( ".geocity" ).text( region );
		    },
		    error: function() {
		      $( ".geocity" ).text( "не определен" );
		    }
		});

		</script>

		<div class="yvedw">

		    <? 
		    for ( $i = 1; $i <= $this->vsego; $i++ ) { 
		        $yved = mt_rand( 1, 2 ); 

		        if ( $this->tovar > 1 ) {
		            $kvo = mt_rand( 1, $this->tovar );
		            $sht = "(".$kvo." шт.)";
		        } else {
		        	$kvo = 1; 
		        }
		    ?>
		        <div class="yved yvedf<?= $yved ?>">
		            <img src="<?= $config_host ?>/assets/images/yico<?= $yved ?>.png" alt="" class="yvedi">
		            <div class="yvedvt">
		                <div class="yvedt">
		                    <?= "{$name[array_rand($name)]} {$surname_all[array_rand($surname_all)]}" ?> 
		                    <br>г. 

		                    <? 
		                        if ( $i == 1 ) {
		                            echo '<span class="geocity"></span>';
		                        } else {
		                            echo $city[ array_rand( $city ) ];
		                        } 
		                    ?>
		                    ,<br>

		                    <? if ( $yved == 1 ) { ?> 
		                        только что заказал(а) <?= $this->product ?> 
		                    <? 
	                            if ( $sht != 1 ) {
	                                echo " {$sht} "; ?> 
		                            на <?= $this->price * $kvo ?> <?= $this->valuta ?>
		                        <? }
		                       } else { ?> 
		                        оставил(а) заявку на обратный звонок
		                    <? } ?>
		                </div>
		            </div>
		        </div>
		    <? } ?>
		        
		</div>

		<?
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

}