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
	 * Флажок подключения к БД: true (> 1) - нужно подключение, false (0) - подключение к БД не требуется
	 * @var bool
	 */
	private $requireDB;

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
	
	/**
	 * Виртуальная функция выполнения действия
	 */
	abstract public function Take();
	
	/**
	 * Виртуальная функция обработчика результата
	 */
	abstract public function Callback();

	/**
	 * Метод возвращающий флажок подключения к БД - требуется/не требуется
	 * @return bool true - если подключение необходимо, иначе - false
	 */
	public function RequireDB() {
		return (bool)$this->requireDB;
	}
}
	
?>