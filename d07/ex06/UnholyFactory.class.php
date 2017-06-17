<?php
class UnholyFactory
{
	private $_army = array();

	public function absorb($fighter)
	{
		if (get_parent_class($fighter) == 'Fighter')
		{
			$name = $fighter->getFighter_name();
			if (!isset($this->_army[$name]))
			{
				print("(Factory absorbed a fighter of type ".$name.")".PHP_EOL);
				$this->_army[$name] = $fighter;
			}
			else
				print("(Factory already absorbed a fighter of type ".$name.")".PHP_EOL);
		}
		else
			print("(Factory can't absorb this, it's not a fighter)".PHP_EOL);
	}

	public function fabricate($fighter_name)
	{
		if (isset($this->_army[$fighter_name]))
		{
			print("(Factory fabricates a fighter of type ".$fighter_name.")".PHP_EOL);
			return (clone($this->_army[$fighter_name]));
		}
		print("(Factory hasn't absorbed any fighter of type ".$fighter_name.")".PHP_EOL);
		return (NULL);
	}
}
?>