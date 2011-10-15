<?php

/**
 * Класс обработчика запроса пользователя
 * 
 * @author Собканюк Андрей <4apay@mail.ru>, Нечаев Ярослав <nechaev@expertkey.ru>
 */
class Handler {
	/**
	 * Список зависимостей
	 * @var mixed
	 */
	protected $dependencies;

	/**
	 * Список категорий пользователей, которым доступно выполнение данного экшена
	 * @var mixed
	 */
	protected $access;

	/**
	 * Геттер для dependency
	 * 
	 * @return array Список зависимостей этого класса от подключаемых модулей
	 */
	public function GetDependencies() {
		return $this->dependencies;
	}

	/**
	 * Геттер для access;
	 * 
	 * @return array Список категорий пользователей, которым доступно выполнение данного экшена
	 */
	public function GetAccess() {
		return $this->access;
	}
	
	/**
	 * Метод для получения "чистого" списка параметров запроса
	 * @return array Ассоциативный массив параметров
	 */
	protected function GetParams() {
		$main_params = array('page', 'action');
		$params = array();
		foreach(array_merge($_GET, $_POST) AS $key => $val)
			if (!in_array($key, $main_params))
				$params[$key] = $val;
		return $params;
	}
}
