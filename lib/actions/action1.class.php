<?php

namespace Action;

/**
 * Действие номер раз - простая арифметическая операция и вывод результата в формате JSON
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
class action1 extends \Action {
	/**
	 * Сама арифметичекая опреация - возведение в квадрат
	 */
	public function Run() {
		if (isset($_GET['num']) && is_numeric($_GET['num']))
			$this->result = $_GET['num'] * $_GET['num'];
		else
			$this->result = 0.0;
	}

	/**
	 * Обработчик результата - вывод в формате JSON
	 */
	public function CallBack() {
		echo("{result: \"{$this->result}\"}");
	}
}

?>