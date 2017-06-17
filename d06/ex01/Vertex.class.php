<?php

require_once 'Color.class.php';

class Vertex
{
	private $_x, $_y, $_z, $_w, $_color;

	public static $verbose = False;

	public static function doc()
	{
		return (file_get_contents('./Vertex.doc.txt'));
	}

	function __toString()
	{
		if (self::$verbose)
			return (sprintf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f, %s )",
				$this->_x, $this->_y, $this->_z, $this->_w, $this->_color));
		else
			return (sprintf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f )",
				$this->_x, $this->_y, $this->_z, $this->_w));
	}

	function __construct(array $keys)
	{
		if (!isset($keys['x']) || !isset($keys['y']) || !isset($keys['z']))
			exit("Invalid parameters".PHP_EOL);
		$this->_x = $keys['x'];
        $this->_y = $keys['y'];
        $this->_z = $keys['z'];
        if (isset($keys['w']))
        	$this->_w = $keys['w'];
        else
        	$this->_w = 1.0;
        if (isset($keys['color']) && empty($keys['color']) === False
        	&& $keys['color'] instanceof Color)
            $this->_color = $keys['color'];
        else
            $this->_color = new Color(array('rgb' => 0xffffff));

		if (self::$verbose)
			echo $this." constructed".PHP_EOL;
	}

	function __destruct()
	{
		if (self::$verbose)
			echo $this." destructed".PHP_EOL;
	}

	public function setX($value)
	{
		$this->_x = $value;
	}

	public function setY($value)
	{
		$this->_y = $value;
	}

	public function setZ($value)
	{
		$this->_z = $value;
	}

	public function setW($value)
	{
		$this->_w = $value;
	}

	public function setColor($value)
	{
		$this->_color = $value;
	}


	public function getX()
	{
		return ($this->_x);
	}

	public function getY()
	{
		return ($this->_y);
	}

	public function getZ()
	{
		return ($this->_z);
	}

	public function getW()
	{
		return ($this->_w);
	}

	public function getColor()
	{
		return ($this->_color);
	}
}
?>