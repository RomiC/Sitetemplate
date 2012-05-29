<?php

/**
 * Абстрактный класс, описывающий действия пользователя
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
abstract class Action extends Handler {
	/**
	 * Результат операции
	 * @var mixed
	 */
	protected $result;

	/**
	 * Виртуальная функция выполнения действия
	 */
	abstract public function Run();

	/**
	 * Виртуальная функция обработчика результата
	 */
	abstract public function Callback();
}

?>