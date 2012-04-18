<?php

namespace Page;

/**
 * Главная страница
 * @author Смагин Артем <asmagin@tdigitals.ru>
 */
class main extends \Page {
	/**
	 * Зависимости страницы
	 * @var string
	 */
	protected $dependencies = 'db';

	/**
	 * Заголовок страницы
	 * @var string
	 */
	protected $header = 'Главная';

	/**
	 * Функция создания страницы
	 */
	public function Generate() {

	}
}

?>