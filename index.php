<?php

try {
	include('bootstrap.php');

	$site = new Site($settings,$routing);
	$site->Build();
} catch (Exception $e) {
	echo('');
}

?>