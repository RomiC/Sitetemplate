<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title>{$_header}</title>
	<base href="{$www_dir}/" />

	<link type="text/css" rel="stylesheet" href="css/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
	<link rel="icon" href="../favicon.ico" type="image/x-icon">

	<!-- Загрузка библиотек -->
	<script type="text/javascript" src="../js/lib/jquery.js"></script>
	<script type="text/javascript" src="js/lib/jquery.ui.js"></script>
	<script type="text/javascript" src="js/lib/jquery.ocupload.js"></script>
	<script type="text/javascript" src="js/lib/bootstrap.js"></script>
	<script type="text/javascript" src="js/lib/tiny_mce/jquery.tinymce.js"></script>
	<script type="text/javascript" src="js/init.js"></script>

	<!-- Загрузка управляющего скрипта -->
	<script type="text/javascript" src="js/admin.js"></script>

	<!-- Загрузка скрипта страницы -->
	<script type="text/javascript" src="js/pages/{$_name}.js"></script>
</head>

<body>
	<div id="page">
		<div id="header" class="container">
			<a href="" id="logo"><img src="images/logo.png" width="160"/></a>
			<ul class="nav nav-tabs">
				<li {if $_name == main} class="active"{/if}><a href="./?page=main">Первая</a></li>
				<li class="pull-right"><a href="../">Перейти на сайт</a></li>
			</ul>
		</div>
	