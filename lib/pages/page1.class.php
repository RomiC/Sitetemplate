<?php

/**
 * Первая страница сайта
 * @author Роман Чаругин <roman-charugin@ya.ru>
 */
class page1 extends Page {
	/**
	 * Функция создания страницы
	 */
	public function Create() {
		$this->tpl->assign('varr', 'Переменная, заассайненная в методе Create страницы page1!');
	}
}

?>