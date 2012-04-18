<?php

namespace Page;

/**
 * Класс для вывода модальных окон
 * @author Роман Чаругин <charugin@tdigitals.ru>
 */
class modal extends \Page {
	/**
	 * Зависимости страницы
	 * @var string
	 */
	protected $dependencies = 'db';

	public function Generate() {
		try {
			$object = $this->GetParam('object');
			$object = strtoupper($object[0]).substr($object, 1);
			$method = $this->GetParam('method');

			$this->tpl->assign(array(
				'_object' => $object,
				'_method' => $method
			));
			
			$object = strtolower($object);
			$method = strtolower($method);

			// реализуем дополнительную логику модального окна, если таковая имеется
			if (class_exists('Page\modal_'.$object) && method_exists('Page\modal_'.$object, $method))
				$this->tpl->assign(call_user_func("Page\\modal_{$object}::{$method}"));

			$tpl = strtolower("modal/{$object}.{$method}");

			if (!file_exists(TEMPLATES_DIR ."/{$tpl}.tpl"))
				throw new \Exception('Не найден шаблон формы', 1);

			$this->tpl_name = $tpl;
		} catch (\Exception $e) {
			$this->tpl->assign('error', $e->getMessage());
			$this->tpl_name = 'modal/error';
		}
	}
}

?>