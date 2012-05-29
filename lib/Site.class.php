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
	 * Массив навигации
	 * @var array
	 */
	private $routing;

	/**
	 * Конструктор
	 * @param $settings Массив настроек
	 */
	function __construct($settings = null, $routing = null) {
		if (!is_null($settings))
			$this->settings = $settings;

		if (!is_null($routing))
			$this->routing = $routing;
	}

	/**
	 * Метод постороение сайта
	 * TODO:
	 * 		1. Сделать нормальный router с регистрацией, а не простую проверку на длинну
	 * 		2. Собрать факторки в кучу
	 * 		3. Наследование от handler - кажется не корректным. Понять идею иерархии
	 *   	4. Разделение на Run-Callback и Generate-Show стоит делать не фабричными методами, а либо фабрикой, либо прототипами, либо строителем.
	 *   	5. Добавить модель лингвистики
	 */
	function Build() {
		// Routing (Shubert 29.05.1012)
			$behavior = array("type"=>"page", "name"=> $this->settings['Pages']['default']);
			foreach($this->$routing as $path -> $info) {
				if (preg_match($path,$_SERVER["REQUEST_URI"]) > 0) {
					if (isset($info["page"]))
						$behavior = array("type"=>"page"  , "name"=>$info["page"]  );
					else
						$behavior = array("type"=>"action", "name"=>$info["action"]);
					break;
				}
			}
		// <- Routing


		// В первую очередь выполняем "действия"
		if ($behavior["type"] == "action") {
			$action = ActionsFactory::GetAction($behavior["name"]);

			Dependencies::Init($action->GetDependencies(), $this->settings);

			$action->Run();
			$action->Callback();
		} else { // И только если делать нечего, то показываем страницу
			$page = PagesFactory::GetPage($behavior["name"]);

			Dependencies::Init($page->GetDependencies(), $this->settings);

			$page->Generate();
			$page->Show();
		}
	}
}

/**
 * Основной класс для обработки исключений
 * @author Роман Чаругин <roman-charugin@ya.ru>
 * TODO построить иерархию ошибок, факторку/строитель, обработчик-регистратор
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
			fwrite($log, date('H:i:s') ." :: {$this->getFile()} ({$this->getLine()}) :: {$this->desc}\r\n");
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
			'www_dir' => WWW_DIR,
			'desc' => $this->desc
		));
		$tpl->display('epicfailed.tpl');
	}
}

?>