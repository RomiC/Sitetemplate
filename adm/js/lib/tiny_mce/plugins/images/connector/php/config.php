<?php

//Корневая директория сайта
define('SCRIPT_DIR', '/adm/js/');
define('DIR_ROOT', substr($_SERVER['SCRIPT_FILENAME'], 0, strpos($_SERVER['SCRIPT_FILENAME'], SCRIPT_DIR)));
//Директория с изображениями (относительно корневой)
define('DIR_IMAGES',	'/photos/');
//Директория с файлами (относительно корневой)
define('DIR_FILES',		'/photos/');

//Высота и ширина картинки до которой будет сжато исходное изображение и создана ссылка на полную версию
define('WIDTH_TO_LINK', 500);
define('HEIGHT_TO_LINK', 500);

//Атрибуты которые будут присвоены ссылке (для скриптов типа lightbox)
define('CLASS_LINK', 'lightview');
define('REL_LINK', 'lightbox');

date_default_timezone_set('Europe/Moscow');

?>
