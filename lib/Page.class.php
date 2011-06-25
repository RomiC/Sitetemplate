<?php

/**
 * Абстрактный класс, описывающий страницы сайта
 * @author Роман Чаругин <roman-charugin@ya.ru>
 */
abstract class Page {
	/**
	 * Объект Smarty
	 * @var object
	 */
	protected $tpl;

	/**
	 * Флажок подключения к БД: true (> 1) - нужно подключение, false (0) - подключение к БД не требуется
	 * @var bool
	 */
	private $requireDB;

	/**
	 * Функция загрузки класса страницы на основе параметра
	 * @param string $P имя класса страницы, может содержать только символы английского алфавита и цифры
	 * @return object объект класса соответвующей страницы
	 */
	public static function GetPage($P) {
		$page = strtolower(trim($P));

		if (preg_match('/[^a-z\d]/', $page))
			throw new Exception("Неверное имя страницы!");

		if (!class_exists($page))
			throw new Exception("Невозможно создать объект класса {$page}!");

		return new $page;
	}

	/**
	 * Конструктор
	 */
	public function __construct() {
		$this->tpl = new Smarty();
		$this->tpl->template_dir = TEMPLATES_DIR .'/';
		$this->tpl->compile_dir = TEMPLATES_DIR .'/compiled/';
		$this->tpl->config_dir = TEMPLATES_DIR .'/configs/';
		$this->tpl->cache_dir = TEMPLATES_DIR .'/cache/';
		
		$this->tpl->assign('www_dir', WWW_DIR);
	}

	/**
	 * Виртуальная функция, отвечающая за наполнение страницы
	 */
	abstract public function Create();

	/**
	 * Функция отображения станицы
	 */
	public function Show() {
		$this->tpl->display(get_class($this) .'.tpl');
	}

	/**
	 * Метод возвращающий флажок подключения к БД - требуется/не требуется
	 * @return bool true - если подключение необходимо, иначе - false
	 */
	public function RequireDB() {
		return (bool)$this->requireDB;
	}
}

?>