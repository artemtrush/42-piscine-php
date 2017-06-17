<?php
class Map
{
	private $_field = array();

	public static function doc()
	{
		return ("lol");
	}

	public function __construct($filename)
	{
		$mas = file_get_contents($filename);
		$j = 0;
		for ($i = 0; $i < 15000; $i++)
		{ 
			while ($mas[$j] && $mas[$j] != '.' && $mas[$j] != 'X')
				$j++;
			if ($mas[$j] == '.')
				$this->_field[$i] = 0;
			else
				$this->_field[$i] = -1;
			$j++;
		}
	}

	public function getMap()
	{
		return ($this->_field);
	}
}
?>