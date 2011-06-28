<?php

/**
 * Абстрактный класс, описывающий страницы сайта
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
abstract class Page {
	/**
	 * Объект Smarty
	 * @var object
	 */
	protected $tpl;

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
	abstract public function Generate();

	/**
	 * Функция отображения станицы
	 */
	public function Show() {
		$this->tpl->display(get_class($this) .'.tpl');
	}
}

?>