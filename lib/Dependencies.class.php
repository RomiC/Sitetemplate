<?php

/**
 * Класс, отвечающий за зависимости
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
class Dependencies {
	/**
	 * Конструктор
	 * @param $dependences Массив зависимостей
	 */
	public function __construct($dependencies) {
		foreach($dependencies AS $dependency) {
			switch ($dependency) {
				case 'mysql':
					$GLOBALS['mysql'] = mysql_connect("localhost", "root", "password");
					break;
				case 'smarty':
					$GLOBALS['smarty'] = new Smarty();
					break;
				default:
					// Надо подумать!
					$GLOBALS[$d] = false; // Подумать трижды!!!
			}
		}
	}
}

?>