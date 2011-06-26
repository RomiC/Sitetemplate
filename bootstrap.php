<?php

error_reporting(E_ALL);

session_start();

/**
 * Путь к рабочему каталогу сайта на сервере
 */
define("WORKING_DIR", dirname($_SERVER['SCRIPT_FILENAME']));

/**
 * WWW-путь к файлам на сервере
 */
define("WWW_DIR", substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')));

/**
 * Путь к файлу с настройками
 */
define("SETTINGS", WORKING_DIR .'/settings.ini');

/**
 * Путь к файлам-классам с действиями 
 */
define("ACTIONS_DIR", WORKING_DIR .'/lib/actions');

/**
 * Путь к файлам-классам со страницами
 */
define("PAGES_DIR", WORKING_DIR .'/lib/pages');

/**
 * Подключаем Smarty
 */
define("SMARTY_DIR", WORKING_DIR .'/lib/smarty/');

/**
 * Путь к шаблонам страниц
 */
define("TEMPLATES_DIR", WORKING_DIR .'/templates');

/**
 * Ассоциативный массив с настройками сайта
 * @var array
 */
$settings = parse_ini_file(SETTINGS, true);

/**
 * Функция автоподгрузки файлов с классам
 * @param string $N имя класса
 */
function __autoload($N) {
	if (file_exists(WORKING_DIR ."/lib/{$N}.class.php"))
		include_once(WORKING_DIR ."/lib/{$N}.class.php");
	elseif (file_exists(ACTIONS_DIR ."/{$N}.class.php"))
		include_once(ACTIONS_DIR ."/{$N}.class.php");
	elseif (file_exists(PAGES_DIR ."/{$N}.class.php"))
		include_once(PAGES_DIR ."/{$N}.class.php");
	elseif (file_exists(SMARTY_DIR ."{$N}.class.php"))
		include_once(SMARTY_DIR ."{$N}.class.php");
	elseif (file_exists(SMARTY_DIR .'sysplugins/'. strtolower($N) .'.php'))
		include_once(SMARTY_DIR .'sysplugins/'. strtolower($N) .'.php');
	else
		throw new SiteException("Невозможно подгрузить файл класса {$N}!");
}

?>