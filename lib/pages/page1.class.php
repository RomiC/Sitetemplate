<?php

namespace Page;

/**
 * Первая страница сайта
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
class page1 extends \Page {
	/**
	 * Массив зависимостей для конкретной страницы
	 * @var mixed
	 */
	protected $dependencies = 'db';

	/**
	 * Функция создания страницы
	 */
	public function Generate() {
		global $db;
		$q = $db->query('SELECT `about` FROM users');
		$this->tpl->assign('varr', nl2br(print_r(array('uno', 'duos', 'tres'), true)));
	}
}

?>