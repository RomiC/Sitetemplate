<?php

/**
 * Класс сайт, отвечающий за весь сайт целиком
 * @author Роман Чаругин <roman-charugin@ya.ru>
 */
class Site {
	/**
	 * Массив настроек
	 * @var array
	 */
	private $settings;
	
	/**
	 * Подключение к БД, ресурс PDO
	 * @var object
	 */
	private $db;

	/**
	 * Конструктор
	 * @param $settings Массив настроек
	 */
	function __construct($settings = null) {
		if (!is_null($settings))
			$this->settings = $settings;
	}

	/**
	 * Закрытый метод подключения к БД
	 */
	private function ConnectDB() {
		$host = isset($this->settings['DB']['host']) ? $this->settings['DB']['host'] : 'localhost';
		$user = isset($this->settings['DB']['user']) ? $this->settings['DB']['user'] : 'root';
		$password = isset($this->settings['DB']['password']) ? $this->settings['DB']['password'] : '';
		$database = isset($this->settings['DB']['database']) ? $this->settings['DB']['database'] : 'test';

		$this->db = new PDO("mysql:host={$host};dbname={$database}", $user, $password);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * Метод постороение сайта
	 */
	function Build() {
		// В первую очередь выполняем "действия"
		if (isset($_REQUEST['action']) && strlen($_REQUEST['action'])) {
			$action = Action::GetAction($_REQUEST['action']);

			if ($action->RequireDB())
				$this->ConnectDB();

			$action->Take();
			$action->Callback();
		} else { // И только если делать нечего, то показываем страницу
			if (isset($_REQUEST['page']) && strlen($_REQUEST['page']))
				$page = Page::GetPage($_REQUEST['page']);
			else
				$page = Page::GetPage($settings['Pages']['default']);


			if ($page->RequireDB())
				$this->ConnectDB();

			$page->Create();
			$page->Show();
		}
	}
}

/**
 * Основной класс для обработки исключений
 * @author Роман Чаругин <roman-charugin@ya.ru>
 */
class SiteException extends Exception {
	/**
	 * Текстовое описание ошибки
	 * @var string
	 */
	private $desc;

	/**
	 * Конструктор
	 * @param string $type тип исключения: warning - предупреждение, error - ошибка
	 * @param string $desc тесктовое описание ошибки
	 */
	function __construct($desc) {
		$this->desc = (string)$desc;
		$this->WriteLog();
		$this->EpicFailed();
	}

	/**
	 * Приватный метод записи логов
	 */
	private function WriteLog() {
		$log = fopen(WORKING_DIR .'/log/'. date('Y-m-d') .'.log', 'a');

		if ($log) {
			fwrite($log, date('H:i:s') ." :: {$this->type} :: {$this->desc}\n\r");
			fclose($log);
		}
	}

	/**
	 * Метод-обработчик ошибки типа error
	 */
	private function EpicFailed() {
		$tpl = new Smarty();
		$tpl->template_dir = TEMPLATES_DIR .'/';
		$tpl->compile_dir = TEMPLATES_DIR .'/compiled/';
		$tpl->config_dir = TEMPLATES_DIR .'/configs/';
		$tpl->cache_dir = TEMPLATES_DIR .'/cache/';

		$tpl->assign(array(
			'type' => $this->type,
			'desc' => $this->desc
		));
		$tpl->display('epicfailed.tpl');
	}
}

?>