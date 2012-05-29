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
	 * TODO: Переделать в DAO
	 */
	public static function Init($dependencies, $settings) {
		if (is_string($dependencies))
			$deps = explode(',', $dependencies);
		elseif (is_array($dependencies))
			$deps = $dependencies;
		else
			return false;

		foreach($deps AS $d) {
			switch ($d) {
				case 'db':
					$dbsn = "mysql:dbname={$settings['DB']['database']};host={$settings['DB']['host']}";

					try {
						$GLOBALS[$d] = new \PDO($dbsn, $settings['DB']['user'], $settings['DB']['password']);
						$GLOBALS[$d]->query("SET NAMES '{$settings['DB']['encoding']}';");
					} catch (PDOException $e) {
						throw new SiteException($e->getMessage());
					}

					break;
				default:
					// Надо подумать!
					$GLOBALS[$d] = false; // Подумать трижды!!!
			}
		}
	}
}

?>