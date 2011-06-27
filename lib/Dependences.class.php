<?php

/**
 * Класс, отвечающий за зависимости
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
class Dependences {
	/**
	 * Конструктор
	 * @param $dependences Массив зависимостей
	 */
	public function __construct($dependences) {
		
		/**
		 * если передается строка
		 * в каком виде вы обычно передаете параметры в строке?
		 * предположим что через точку с запятой
		 * $dependences = eplode(';', strtolower(trim($dependences)));
		 */
		
		foreach($dependences AS $dependency) {
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