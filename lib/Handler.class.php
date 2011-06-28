<?php

/**
 * Класс обработчика запроса пользователя
 * 
 * @author Собканюк Андрей <4apay@mail.ru>, Нечаев Ярослав <nechaev@expertkey.ru>
 */
abstract class Handler {
	//Список зависимостей этого класса от подключаемых модулей
	abstract private $dependency;
	//Список категорий пользователей, которым доступно выполнение данного экшена
	abstract private $access;
	
	/**
	 * Геттер для dependency
	 * 
	 * @return array Список зависимостей этого класса от подключаемых модулей
	 */
	public function getDependencies() {
		return $this->dependency;
	}
	
	/**
	 * Геттер для access;
	 * 
	 * @return array Список категорий пользователей, которым доступно выполнение данного экшена
	 */
	public function getAccess() {
		return $this->access;
	} 
}
