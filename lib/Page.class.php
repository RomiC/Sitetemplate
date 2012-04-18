<?php

/**
 * Абстрактный класс, описывающий страницы сайта
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
abstract class Page extends \Handler {
	/**
	 * Заголовок страницы
	 * @var string
	 */
	protected $header;

	/**
	 * Название шаблона страницы
	 * @var string
	 */
	protected $tpl_name;

	/**
	 * Объект Smarty
	 * @var object
	 */
	protected $tpl;

	/**
	 * Конструктор
	 */
	public function __construct() {
		$this->tpl = new \Smarty();
		$this->tpl->template_dir = TEMPLATES_DIR .'/';
		$this->tpl->compile_dir = TEMPLATES_DIR .'/compiled/';
		$this->tpl->cache_dir = TEMPLATES_DIR .'/cache/';

		if (empty($this->tpl_name))	{	// Если имя шаблона не задано явно,
			// то создадим его на основе имени класса
			$class_name = get_class($this);
			// Избавляемся от неймспейса в имени шаблона
			$this->tpl_name = substr($class_name, strrpos($class_name, '\\') + 1);
		}
	}

	/**
	 * Виртуальная функция, отвечающая за наполнение страницы
	 */
	abstract public function Generate();

	/**
	 * Функция отображения станицы
	 */
	public function Show() {
		global $settings;

		$this->tpl->assign(array(
			// Путь к корню сайта
			'www_dir' => WWW_DIR,
			// Имя шаблона страницы
			'_name' => $this->tpl_name,
			// Заголовок страницы
			'_header' => $settings['Site']['name'] . (!empty($this->header) ? " :: {$this->header}" : '')
		));

		$this->tpl->display("{$this->tpl_name}.tpl");
	}
}

?>