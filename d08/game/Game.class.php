<?php
class Game
{
	private $_p1, $_p2;
	private $_current_ship;
	public  $turn;
	private $_standart_map, $_map, $_flot;
	private $_ad_dmg;
	private $_ad_spd;
	private $_PP, $_SP;

	public $result, $END;

	public function __construct($keys)
	{
		$this->_p1 = $keys['p1'];
		$this->_p2 = $keys['p2'];
		$this->_standart_map = $keys['map'];
		$this->_flot = $keys['flot'];
		$this->_current_ship = 1;
		$this->turn = 1;
		$this->_ad_spd = 0;
		$this->_ad_dmg = 0;
		$this->_PP = 3;
		$this->_SP = $this->_flot[1]->getSP();
		$this->END = False;
	}

	private function check_ships()
	{
		$c1 = 0;
		$c2 = 0;
		for ($i = 1; $i <= count($this->_flot); $i += 2)
			if ($this->_flot[$i]->getHP() > 0)
				$c1++;
		for ($i = 2; $i <= count($this->_flot); $i += 2)
			if ($this->_flot[$i]->getHP() > 0)
				$c2++;
		
		if ($c1 > 0 && $c2 > 0)
			return (NULL);
		if ($c1 + $c2 == 0)
			return ('Draw !');
		else if ($c1 > 0)
			return ($this->_p1->getName().' wins!');
		return ($this->_p2->getName().' wins!');
	}

	public function next_ship()
	{
		$this->_current_ship += 2;
		if ($this->_current_ship > count($this->_flot))
		{
			if ($this->_current_ship % 2 == 0)
				$this->_current_ship = 1;
			else
				$this->_current_ship  = 2;
		}

		if (($name = $this->check_ships()))
		{
			$this->turn = 0;
			$this->END = True;
			$this->result = $name;
			return ;
		}

		if ($this->_flot[$this->_current_ship]->getHP() <= 0)
			$this->next_ship();

		$this->_ad_spd = 0;
		$this->_ad_dmg = 0;
		$this->_PP = 3;
		$this->_SP = $this->_flot[$this->_current_ship]->getSP();
		$this->turn = 1;
	}

	public function next_turn()
	{
		$this->turn++;
		if ($this->turn == 2)
			$this->_SP += $this->_ad_spd;
		if ($this->turn > 3)
			$this->next_ship();
	}

	private function vector($x, $y, $v)
	{
		$map = $this->_map;
		$ship = $this->_flot[$this->_current_ship];
		$count = 1;
		while ($count <= 6)
		{
			switch ($v)
			{
				case 0:
					$i = $y - $count;
					$j = $x;
					break;
				case 1:
					$i = $y - $count;
					$j = $x + $count;
					break;
				case 2:
					$i = $y;
					$j = $x + $count;
					break;
				case 3:
					$i = $y + $count;
					$j = $x + $count;
					break;
				case 4:
					$i = $y + $count;
					$j = $x;
					break;
				case 5:
					$i = $y + $count;
					$j = $x - $count;
					break;
				case 6:
					$i = $y;
					$j = $x - $count;
					break;
				case 7:
					$i = $y - $count;
					$j = $x - $count;
					break;
			}
			if ($j < 0 || $j > 149 || $i < 0 || $i > 99 || $map[$i * 150 + $j] == -1)
				break ;
			if ($map[$i * 150 + $j] > 0 && $map[$i * 150 + $j] != $ship->id)
			{
				$this->_flot[$map[$i * 150 + $j]]->take_dmg($ship->getD() + $this->_ad_dmg);
				break ;
			}
		$count++;
		}
	}

	private function pulke($dir, $x, $y)
	{
		$map = 	$this->_map;
		$ship = $this->_flot[$this->_current_ship];	
		if ($dir % 2 == 1)
		{
			while ($map[$y * 150 + $x] == $ship->id)
			{
				if ($dir == 1)
				{
					$this->vector($x, $y, 7);
					$this->vector($x, $y, 0);
					$this->vector($x, $y, 1);
				}
				else if ($dir == 3)
				{
					$this->vector($x, $y, 5);
					$this->vector($x, $y, 4);
					$this->vector($x, $y, 3);
				}
				$x++;
			}
		}
		else
		{
			while ($map[$y * 150 + $x] == $ship->id)
			{
				if ($dir == 2)
				{
					$this->vector($x, $y, 1);
					$this->vector($x, $y, 2);
					$this->vector($x, $y, 3);
				}
				else if ($dir == 4)
				{
					$this->vector($x, $y, 7);
					$this->vector($x, $y, 6);
					$this->vector($x, $y, 5);
				}
				$y++;
			}
		}
	}

	private function shot($value)
	{
		$ship = $this->_flot[$this->_current_ship];
		$info = $ship->get_ship_map();
		$x = $info['x'] + 4;
		$y = $info['y'] + 4;
		$dir = $ship->get_dir();
		if ($value == 'Right')
			$dir++;
		else if ($value == 'Left')
			$dir--;
		else if ($value == 'Down')
			$dir += 2;
		if ($dir < 1)
			$dir += 4;
		if ($dir > 4)
			$dir -= 4;
		switch ($dir)
		{
			case 1:
			while ($y > 0 && $this->_map[($y - 1) * 150 + $x] == $ship->id)
				$y--;
			while ($this->_map[$y * 150 + $x - 1] == $ship->id)
				$x--;
				break;
			case 3:
			while ($y < 99 && $this->_map[($y + 1) * 150 + $x] == $ship->id)
				$y++;
			while ($this->_map[$y * 150 + $x - 1] == $ship->id)
				$x--;
			case 4:
			while ($x > 0 && $this->_map[$y * 150 + $x - 1] == $ship->id)
				$x--;
			while ($this->_map[($y - 1) * 150 + $x] == $ship->id)
				$y--;
			break;
			case 2:
			while ($x < 149 && $this->_map[$y * 150 + $x + 1] == $ship->id)
				$x++;
			while ($this->_map[($y - 1) * 150 + $x] == $ship->id)
				$y--;
			break;
		}
		$this->pulke($dir, $x, $y);
	}

	public function make_changes($value)
	{
		if ($value == 'Right' || $value == 'Down'
			|| $value == 'Left' || $value == 'Up')
		{
			$this->shot($value);
			$this->next_ship();
			return ;
		}
		$ship = $this->_flot[$this->_current_ship];
		switch ($value)
		{
			case "Go!":
				$ship->forward();
				$this->_SP -= 1;
				break;
			case "LeftR":
				if ($this->_SP > 1)
				{
					$ship->rotate_left();
					$this->_SP -= 2;
				}
				break;
			case "RightR":
				if ($this->_SP > 1)
				{
					$ship->rotate_right();
					$this->_SP -= 2;
				}
				break;
			case "Skip Phase":
				$this->next_turn();
				break;
			case "Damage":
				$this->_PP--;
				$this->_ad_dmg++;
				break;
			case "Speed":
				$this->_PP--;
				$this->_ad_spd += 5;
				break;
			case "Shield":
				if ($ship->setShield(10))
					$this->_PP--;
				break;
		}
		if ($this->turn == 1 && $this->_PP == 0)
			$this->next_turn();
		if ($this->turn == 2 && $this->_SP == 0)
			$this->next_turn();
	}

	private function set_ship($ship, $map)
	{
		$sh_info = $ship->get_ship_map();
		$mx = $sh_info['x'];
		$my = $sh_info['y'];
		$txr = $sh_info['txr'];
		for ($i = 0; $i < 9; $i++)
			for ($j = 0; $j < 9; $j++)
				if ($txr[$i * 9 + $j] != 0)
				{
					$tp = ($my + $i) * 150 + $mx + $j;
					if (($mx + $j < 0) || ($my + $i < 0) || ($mx + $j > 149)
						|| ($my + $i > 99) || ($map[$tp] == -1))
					{
						$ship->take_dmg(-1);
						$this->next_ship();
						return ($map);
					}
					if ($map[$tp] > 0)
					{
						$enemy = NULL;
						foreach ($this->_flot as $value)
						{
							if ($value->id == $map[$tp])
							{
								$enemy = $value;
								break ;
							}
						}
						$sh_hp = $ship->getHP() + $ship->getShield();
						$ship->take_dmg($enemy->getHP() + $enemy->getShield());
						$enemy->take_dmg($sh_hp);
						if ($enemy->getHP() <= 0)
						{
							foreach ($map as $ch)
								if ($ch == $enemy->id)
									$ch = 0;
						}
						if ($ship->getHP() <= 0)
						{
							$this->next_ship();
							return ($map);
						}
					}
				}
		for ($i = 0; $i < 9; $i++)
			for ($j = 0; $j < 9; $j++)
				if ($txr[$i * 9 + $j] != 0)
					$map[($my + $i) * 150 + $mx + $j] = $ship->id;
		return ($map);
	}

	public function generate_map()
	{
		$map = $this->_standart_map;
		foreach ($this->_flot as $ship)
		{
			if ($ship->getHP() > 0)
				$map = $this->set_ship($ship, $map);
		}
		$this->_map = $map;
		return ($map);
	}

	public function get_player_name()
	{
		if ($this->_current_ship % 2 == 0)
			return ($this->_p2->getName());
		else
			return ($this->_p1->getName());
	}

	public function getPP()
	{
		return ($this->_PP);
	}

	public function getSP()
	{
		return ($this->_SP);
	}

	public function getHP()
	{
		return ($this->_flot[$this->_current_ship]->getHP());
	}

	public function getSH()
	{
		return ($this->_flot[$this->_current_ship]->getShield());
	}

	public static function doc()
	{
		return ("doc");
	}
}
?>