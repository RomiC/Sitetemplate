<?php

/**
 * Абстрактный класс, описывающий страницы сайта
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
abstract class Page extends \Handler {
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

		$this->tpl->assign('www_dir', WWW_DIR);
	}

	/**
	 * Виртуальная функция, отвечающая за наполнение страницы
	 */
	abstract public function Generate();

	/**
	 * Функция отображения станицы
	 */
	public function Show() {
		$tpl_name = get_class($this);

		// Избавляемся от неймспейса в имени шаблона
		$tpl_name = substr($tpl_name, strrpos($tpl_name, '\\') + 1);

		$this->tpl->display("{$tpl_name}.tpl");
	}
}

?>