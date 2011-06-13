<?php

/**
 * Абстрактный класс, описывающий страницы сайта
 * @author Роман Чаругин <roman-charugin@ya.ru>
 */
abstract class Page {
	/**
	 * Функция загрузки класса страницы на основе параметра
	 * @param string $P имя класса страницы, может содержать только символы английского алфавита и цифры
	 * @return object объект класса соответвующей страницы
	 */
	public static function GetPage($P) {
		$page = strtolower(trim($P));

		if (preg_match('/[^a-z\d]/', $page))
			throw new Exception("Неверное имя страницы!");

		if (!class_exists($page))
			throw new Exception("Невозможно создать объект класса {$page}!");

		return new $page;
	}
	
	/**
	 * Виртуальная функция, отвечающая за вывод страницы
	 */
	abstract public function Show();
}

?>