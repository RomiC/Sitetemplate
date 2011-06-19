<?php

/** 
 * Абстрактный класс, описывающий действия пользователя
 * @author Роман Чаругин <roman-charugin@ya.ru>
 */
abstract class Action {
	/**
	 * Результат операции
	 * @var mixed 
	 */
	protected $result;

	/**
	 * Статичная функция выбора действия в зависимости от параметра
	 * @param string $A название действия, может содержать лишь буквы латиницы и цифры
	 * @return object объект класса соответствующего класса
	 */
	static public function GetAction($A) {
		$action = strtolower(trim($A));

		if (preg_match('/[^a-z\d]/', $action))
			throw new Exception("Неверное действие!");

		if (!class_exists($action))
			throw new Exception("Невозможно создать объект класса {$action}!");

		return new $action;
	}
	
	/**
	 * Виртуальная функция выполнения действия
	 */
	abstract public function Take();
	
	/**
	 * Виртуальная функция обработчика результата
	 */
	abstract public function Callback();
}
	
?>