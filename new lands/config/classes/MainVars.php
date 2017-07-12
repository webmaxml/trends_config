<?
class MainVars {

	public function __construct() {
		$this->head_top = '';
		$this->head_bottom = '';
		$this->body_top = '';
		$this->body_bottom = '';

		$this->init();
	}

	public function init() {
		global $config_host;

		$this->addHeadTop( '<script src="'. $config_host .'/assets/vendors/jquery/dist/jquery.min.js"></script>' );
		$this->addHeadBottom( '<link rel="stylesheet" href="'. $config_host .'/assets/css/conf.css"></link>' );
		$this->addBodyBottom( $this->getConfContent() );
		$this->addBodyBottom( '<script src="'. $config_host .'/assets/js/conf.js"></script>' );
		$this->addBodyBottom('<script src="'. $config_host .'/assets/vendors/maskedInput/jquery.maskedinput.js"></script>' . 
			'<script type="text/javascript">' .
				'jQuery(function($){' . 
					'$("input[ name=\'phone\' ]").mask("\+38(0*9) 999-99-99");' . 
				'}); </script>' );
	}

	public function addHeadTop( $html ) {
		$this->head_top .= $html;
	}

	public function addHeadBottom( $html ) {
		$this->head_bottom .= $html;
	}

	public function addBodyTop( $html ) {
		$this->body_top .= $html;
	}

	public function addBodyBottom( $html ) {
		$this->body_bottom .= $html;
	}

	public function addIndexMetrics( $data ) {
		$this->addHeadTop( $data->metric_head_index );
	    $this->addBodyTop( $data->metric_body_index );
	}

	public function addThanksMetrics( $data ) {
		$this->addHeadTop( $data->metric_head_thanks );
	    $this->addBodyTop( $data->metric_body_thanks );
	}

	public function getMainVars() {
		return [
			'head_top' => $this->head_top,
			'head_bottom' => $this->head_bottom,
			'body_top' => $this->body_top,
			'body_bottom' => $this->body_bottom,
		];
	}

	public function getConfContent() {
		ob_start(); ?>
	
		<div class="hidden-conf">
            <div class="conf-overlay close-conf"></div>
            <div class="conf-info">
                <div class="conf-head">Политика конфиденциальности</div>
                <h5>Защита личных данных</h5>
                <p>Для защиты ваших личных данных у нас внедрен ряд средств защиты, которые действуют при введении, передаче или работе с вашими личными данными.</p>
                <h5>Разглашение личных сведений и передача этих сведений третьим лицам</h5>
                <p>Ваши личные сведения могут быть разглашены нами только в том случае это необходимо для: (а) обеспечения соответствия предписаниям закона или требованиям судебного процесса в нашем отношении ; (б) защиты наших прав или собственности (в) принятия срочных мер по обеспечению личной безопасности наших сотрудников или потребителей предоставляемых им услуг, а также обеспечению общественной безопасности. Личные сведения, полученные в наше распоряжение при регистрации, могут передаваться третьим организациям и лицам, состоящим с нами в партнерских отношениях для улучшения качества оказываемых услуг. Эти сведения не будут использоваться в каких-либо иных целях, кроме перечисленных выше. Адрес электронной почты, предоставленный вами при регистрации может использоваться для отправки вам сообщений или уведомлений об изменениях, связанных с вашей заявкой, а также рассылки сообщений о происходящих в компании событиях и изменениях, важной информации о новых товарах и услугах и т.д. Предусмотрена возможность отказа от подписки на эти почтовые сообщения.</p>
                <h5>Использование файлов «cookie»</h5>
                <p>Когда пользователь посещает веб-узел, на его компьютер записывается файл «cookie» (если пользователь разрешает прием таких файлов). Если же пользователь уже посещал данный веб-узел, файл «cookie» считывается с компьютера. Одно из направлений использования файлов «cookie» связано с тем, что с их помощью облегчается сбор статистики посещения. Эти сведения помогают определять, какая информация, отправляемая заказчикам, может представлять для них наибольший интерес. Сбор этих данных осуществляется в обобщенном виде и никогда не соотносится с личными сведениями пользователей.</p>
                <p>Третьи стороны, включая компании Google, показывают объявления нашей компании на страницах сайтов в Интернете. Третьи стороны, включая компанию Google, используют cookie, чтобы показывать объявления, основанные на предыдущих посещениях пользователем наших вебсайтов и интересах в веб-браузерах. Пользователи могут запретить компаниям Google использовать cookie. Для этого необходимо посетить специальную страницу компании Google по этому адресу: http://www.google.com/privacy/ads/</p>
                <h5>Изменения в заявлении о соблюдении конфиденциальности</h5>
                <p>Заявление о соблюдении конфиденциальности предполагается периодически обновлять. При этом будет изменяться дата предыдущего обновления, указанная в начале документа. Сообщения об изменениях в данном заявлении будут размещаться на видном месте наших веб-узлов</p>
                <p class="s1">Благодарим Вас за проявленный интерес к нашей системе! </p>
                <div class="close-conf closeconf-but"></div>
            </div>
        </div>

		<? $html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

}