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
			 $main_params = array_merge($main_params, is_array($beside) ? $beside : array($beside));

		$params = array();
		foreach(array_merge($_GET, $_POST) AS $key => $val)
			if (!in_array($key, $main_params))
				$params[$key] = $val;
		return $params;
	}

	/**
	 * Метод для получения конкретного параметра из запроса
	 * @param string $name Имя параметра
	 * @return string|null Значение параметра, либо null в случае если такого параметра не существует, либо он пуст
	 */
	protected function GetParam($name) {
		if (!empty($_POST[$name]))
			return $_POST[$name];

		if (!empty($_GET[$name]))
			return $_GET[$name];

		return null;
	}

	/**
	 * Получение списка параметров, отсортированного в соответствии с необходимой функцией или методом
	 * @param string $function Имя функции или метода
	 * @param string|object $class Имя класса или ссылка на экземпляр класса, соответсвующего метода
	 * @return array|false Ассоциативный массив параметров, расположенных в нужном порядке, false - в случае ошибки
	 */
	public function GetOrderedParams($function, $class = null) {
		try {
			$ref = !is_null($class) ? new ReflectionMethod($class, $function) : new ReflectionFunction($function);

			$res = array();

			$method_params = $ref->getParameters();
			foreach ($method_params as $mp) {
				$user_param = $this->GetParam($mp->name);
				$res[$mp->name] = !is_null($user_param) ? $user_param : ($mp->isDefaultValueAvailable() ? $mp->getDefaultValue() : null);
			}

			return $res;
		} catch (ReflectionException $e) {
			return false;
		}
	}
}