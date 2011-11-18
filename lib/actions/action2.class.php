<?php

namespace Action;

/**
 * Действие #2 - Запрос к БД и редирект на страницу 1
 * @author Роман Чаругин <roman-charugin@ya.ru>, Собканюк Андрей <4apay@mail.ru>
 */
class action2 extends \Action {
	protected $dependency = 'db';
	protected $access = 'both';
	
	/**
	 * Запрос к БД
	 */
	public function Run() {
		try {
			global $db;
			$query = $db->prepare('INSERT INTO `requests` (`ip`, `date`) VALUES (INET_ATON(?), NOW())');
			$query->bindParam(1, $_SERVER['REMOTE_ADDR']);

			$this->result = $query->execute();
		} catch (PDOException $e) {
			$this->result = $e->getMessage();
		}
	}

	/**
	 * Обработчик результата - редирект на страницу
	 */
	public function CallBack() {
		if ($this->result === true)
			header('Location: index.php?page=page1');
		else
			header('Location: index.php?page=page2');
	}
}

?>