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
	 * @param mixed $beside Дополнительныо исключаемые элементы (либо строка для одного элемента, либо массив для нескольких)
	 * @return array Ассоциативный массив параметров
	 */
	protected function GetParams($beside = null) {
		$main_params = array('page', 'action');
		if (!is_null($beside))
			$main_params = array_merge($main_params, $beside);

		$params = array();
		foreach(array_merge($_GET, $_POST) AS $key => $val)
			if (!in_array($key, $main_params))
				$params[$key] = $val;
		return $params;
	}
}
