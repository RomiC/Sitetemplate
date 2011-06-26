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
	 * Функция загрузки класса страницы на основе параметра
	 * @param string $P имя класса страницы, может содержать только символы английского алфавита и цифры
	 * @return object объект класса соответвующей страницы
	 */
	public static function GetPage($P) {
		$page = strtolower(trim($P));

		if (preg_match('/[^a-z\d]/', $page))
			throw new SiteException("Неверное имя страницы!");

		if (!class_exists($page))
			throw new SiteException("Невозможно создать объект класса {$page}!");

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
}

?>