<?php

try {
	include('bootstrap.php');

	if (isset($_REQUEST['act']) && strlen($_REQUEST['act'])) {
		// Здесь будет действо!
	} else {
		if (isset($_REQUEST['page']) && strlen($_REQUEST['page']))
			$page = Page::GetPage($_REQUEST['page']);
		else
			$page = Page::GetPage($settings['Pages']['default']);

		$page->Create();
		$page->Show();
	}
} catch (Exception $e) {
	exit($e->getMessage());
}

?>