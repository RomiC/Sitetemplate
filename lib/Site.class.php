<?php

/*
 * Site - класс сайт, содержит основной функционал движка
 * Концепция движка следующая: пользователь сайта может либо открыть страницу, 
 * либо выполнить одно из ранее определенных действий (зарегистрироваться, загрузить файл и т.д.).
 * Каждая страница и действие представляет собой файл, подключаемый во время выполнения.
 * Через параметр в запросе определяем, что именно необходимо сделать:
 * если задан параметр action
 */
class Site {
	private $Parametrs;			// параметры запроса

	private $log;

	/*
	 * Конструктор
	 */
	public function Site() {
		
	}

	/*
	 * Основная функция сайта
	 */
	public function Start() {
		$this->Connect2Database();
		
		
	}

	/*
	 * Метод, загружает настройки
	 */
	private function LoadSettings() {
		$this->Settings = array();
		
		$this->Settings['need_database'] = ((defined('NEED_DATABASE')) ? NEED_DATABASE : true);
		
		$this->Settings['db_host'] = ((defined('DB_HOST')) ? DB_HOST : 'localhost');
		$this->Settings['db_user'] = ((defined('DB_USER')) ? DB_USER : 'root');
		$this->Settings['db_pass'] = ((defined('DB_PASS')) ? DB_PASS : false);
		$this->Settings['db_name'] = ((defined('DB_NAME')) ? DB_NAME : false);
		$this->Settings['db_encoding'] = ((defined('DB_ENCODING')) ? DB_ENCODING : 'utf8');
	}

	/*
	 * метод возвращает необходимую настройку
	 * 	$N - имя настройки
	 */
	public function GetSetting($N) {
		return ((isset($this->Settings[$N])) ? $this->Settings[$N] : false);
	}

	/*
	 * функция подключения к БД
	 */
	private function Connect2Database() {
		if (!@mysql_connect(DB_HOST, DB_USER, DB_PASS))
			throw new SiteException("(!) Site temporarily inaccessible. Please try later". mysql_error());
		
		if (!@mysql_select_db(DB_NAME, $db)) {
			exit("(!) Site temporarily inaccessible. Please try later.<br>". mysql_error());
		}
		
		if (!@mysql_query("SET NAMES '". DB_ENCODING ."'")) {
			exit("(!) Site temporarily inaccessible. Please try later.<br>". mysql_error());
		}
	}
	
	/*
	 * функция разбора запроса
	 */
	public function ParseRequest() {
		
	}
	
	/*
	 * выполняем некое действие
	 */
	public function DoFunction() {
		
	}
	
	/*
	 * 
	 */
}

class SiteException extends Exception {
	
}

?>