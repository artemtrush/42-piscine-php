<?php
class Ship
{
	public $id;

	private $_name;
	private $_health;
	private $_speed;
	private $_damage;
	private $_shield;
	private $_max_shld;

	private $_direction;
	private $_mx;
	private $_my;
	private $_texture = array();

	public static function doc()
	{
		return ("doc");
	}

	private function read_ship_txt($filename)
	{
		$tmp = array();
		$mas = file_get_contents($filename);
		$i = 0;
		while ($i < strlen($mas))
		{
			if ($mas[$i] == '.')
				$tmp[] = 0;
			else if ($mas[$i] == 'X')
				$tmp[] = $this->id;
			$i++;
		}
		$this->_name = substr($filename, 14, strlen($filename) - 4);
		return ($tmp);
	}

	public function __construct(array $keys)
	{
		$this->id = $keys['id'];
		$this->_texture = $this->read_ship_txt($keys['txt']);
		$this->_mx = $keys['x'];
		$this->_my = $keys['y'];
		$this->_speed = $keys['sp'];
		$this->_health = $keys['hp'];
		$this->_damage = $keys['dmg'];
		$this->_max_shld = $keys['shld'];
		$this->_shield = $keys['shld'];
		$this->_direction = 1;
		while ($this->_direction != $keys['dir'])
			$this->rotate_right();
	}

	public function forward()
	{
		switch ($this->_direction)
		{
			case 1:
				$this->_my--;
				break ;
			case 2:
				$this->_mx++;
				break ;
			case 3:
				$this->_my++;
				break ;
			case 4:
				$this->_mx--;
				break ;
		}
	}

	public function rotate_right()
	{
		$tmp = array();
		for ($i = 0; $i < 9; $i++)
		{ 
			for ($j = 0; $j < 9; $j++)
			{
				$tmp[$j * 9 + 8 - $i] = $this->_texture[$i * 9 + $j];
			}
		}
		$this->_direction++;
		if ($this->_direction == 5)
			$this->_direction = 1;
		$this->_texture = $tmp;
	}

	public function rotate_left()
	{
		$tmp = array();
		for ($i = 0; $i < 9; $i++)
		{ 
			for ($j = 0; $j < 9; $j++)
			{
				$tmp[(8 - $j) * 9 + $i] = $this->_texture[$i * 9 + $j];
			}
		}
		$this->_direction--;
		if ($this->_direction == 0)
			$this->_direction = 4;
		$this->_texture = $tmp;
	}

	public function get_ship_map()
	{
		return (array('txr' => $this->_texture, 'x' => $this->_mx, 'y' => $this->_my));
	}

	public function getHP()
	{
		return ($this->_health);
	}

	public function getSP()
	{
		return ($this->_speed);
	}

	public function getD()
	{
		return ($this->_damage);
	}

	public function setShield($value)
	{
		if ($this->_shield + $value <= $this->_max_shld)
		{
			$this->_shield += $value;
			return True;
		}
		return False;
	}

	public function getShield()
	{
		return ($this->_shield);
	}

	public function take_dmg($value)
	{
		if ($value === -1)
			$this->_health = 0;
		else
		{
			$this->_shield -= $value;
			while ($this->_shield < 0)
			{
				$this->_health--;
				$this->_shield++;
			}
		}
	}

	public function get_dir()
	{
		return ($this->_direction);
	}
}
?>