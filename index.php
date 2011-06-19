<?php

try {
	include('bootstrap.php');

	if (isset($_REQUEST['action']) && strlen($_REQUEST['action'])) {
		$action = Action::GetAction($_REQUEST['action']);

		$action->Take();
		$action->Callback();
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