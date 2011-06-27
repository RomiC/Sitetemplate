<?php

/** 
 * Абстрактный класс, описывающий действия пользователя
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
abstract class ActionsFactory {
	/**
	 * Статичная функция выбора действия в зависимости от параметра
	 * @param string $A название действия, может содержать лишь буквы латиницы и цифры
	 * @return object объект класса соответствующего класса
	 */
	static public function GetAction($A) {
		$action = strtolower(trim($A));

		if (preg_match('/[^a-z\d]/', $action))
			throw new SiteException("Неверное действие!");

		if (!class_exists($action))
			throw new SiteException("Невозможно создать объект класса {$action}!");

		return new $action;
	}
}
	
?>