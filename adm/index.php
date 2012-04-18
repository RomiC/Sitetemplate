<?php

try {
	include('bootstrap.php');

	$site = new Site($settings);
	$site->Build();
} catch (Exception $e) {
	echo($e->getMessage());
}

?>