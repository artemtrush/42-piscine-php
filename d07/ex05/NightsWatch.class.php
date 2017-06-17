<?php
class NightsWatch
{
	private $_champ = array();

	public function recruit($fighter)
	{
		$this->_champ[] = $fighter;
	}

	public function fight()
	{
		foreach ($this->_champ as $key => $fighter)
		{
			if (method_exists(get_class($fighter), "fight"))
				$fighter->fight();
		}
	}
}
?>