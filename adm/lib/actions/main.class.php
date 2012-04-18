<?php

namespace Action;

/**
 * Единственное действие
 * @author Смагин Артем <asmagin@tdigitals.ru>, Роман Чаругин <charugin@tdigitals.ru>
 */
class main extends \Action {
	protected $dependencies = 'db';

	public function Run() {
		$this->result = true;
	}

	/**
	 * Обработчик результата
	 */
	public function CallBack() {
		if ($this->result === true)
			echo json_encode(array('result' => true));
		elseif(is_array($this->result))
			echo json_encode($this->result);
		else
			echo json_encode(array('result' => false, 'desc' => $this->result));
	}
}

?>