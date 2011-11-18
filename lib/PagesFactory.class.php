<?php

/**
 * Абстрактный класс, описывающий страницы сайта
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
abstract class PagesFactory {
	/**
	 * Функция загрузки класса страницы на основе параметра
	 * @param string $P имя класса страницы, может содержать только символы английского алфавита и цифры
	 * @return object объект класса соответвующей страницы
	 */
	public static function GetPage($P) {
		$page = strtolower(trim($P));

		if (preg_match('/[^a-z\d]/', $page))
			throw new SiteException("Неверное имя страницы!");

		// Добавляем соответствующий namespace
		$page = 'Page\\'. $page;

		if (!class_exists($page))
			throw new SiteException("Невозможно создать объект класса {$page}!");

		return new $page;
	}
}

?>