<?php

/**
 * Действие #2 - Запрос к БД и редирект на страницу 1
 * @author Роман Чаругин <roman-charugin@ya.ru>
 */
class action2 extends Action {
	/**
	 * Запрос к БД
	 */
	public function Take() {
		try {
			global $settings;
			$host = isset($settings['DB']['host']) ? $settings['DB']['host'] : 'localhost';
			$user = isset($settings['DB']['user']) ? $settings['DB']['user'] : 'root';
			$password = isset($settings['DB']['password']) ? $settings['DB']['password'] : '';
			$database = isset($settings['DB']['database']) ? $settings['DB']['database'] : 'test';

			$db = new PDO("mysql:host={$host};dbname={$database}", $user, $password);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
			header("Location: index.php?page=page1");
		else
			header("Location: index.php?page=page2");
	}
}

?>