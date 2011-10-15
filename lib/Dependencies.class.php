<?php

/**
 * Класс, отвечающий за зависимости
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
class Dependencies {
	/**
	 * Инициализация зависимостей
	 * @param mixed $dependences Массив (или строка) зависимостей
	 * @param array $settings Массив настроек
	 */
	public static function Init($dependencies, $settings) {
		if (is_string($dependencies))
			$deps = explode(',', $dependencies);
		elseif (is_array($dependencies))
			$deps = $dependencies;
		else
			return false;

		foreach($deps AS $dependence) {
			switch ($dependence) {
				case 'db':
					$GLOBALS[$dependence] = mysql_connect($settings['DB']['host'], $settings['DB']['user'], $settings['DB']['password']);
					break;
				default:
					// Надо подумать!
					$GLOBALS[$dependence] = false; // Подумать трижды!!!
			}
		}
	}
}

?>