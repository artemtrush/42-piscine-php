<?php
class Fighter
{
	private $_Fighter_name;

	public function __construct($name)
	{
		$this->_Fighter_name = $name;
	}

	public function getFighter_name()
	{
		return ($this->_Fighter_name);
	}
}
?>