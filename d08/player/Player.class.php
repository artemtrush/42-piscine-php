<?php
class Player
{
	private $_name;
	public $ships_id = array();

	public static function doc()
	{
		return ("doc");
	}

	public function __construct($pname)
	{
		$this->_name = $pname;
	}

	public function getName()
	{
		return ($this->_name);
	}
}
?>