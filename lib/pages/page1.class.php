<?php

/**
 * Первая страница сайта
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
class page1 extends Page {
	/**
	 * Функция создания страницы
	 */
	public function Generate() {
		$this->tpl->assign('varr', 'Переменная, заассайненная в методе Create страницы page1!');
	}
}

?>