<?php

require_once 'Vertex.class.php';

class Vector
{
	private $_x, $_y, $_z, $_w;

	public static $verbose = False;

	public static function doc()
	{
		return (file_get_contents('./Vector.doc.txt'));
	}

	public function magnitude()
	{
		return (float)(sqrt(pow($this->_x, 2) + pow($this->_y, 2) + pow($this->_z, 2)));
	}

	public function normalize()
	{
		$length = $this->magnitude();
		return (new Vector(array('dest' => new Vertex(array(
			'x' => $this->_x / $length,
			'y' => $this->_y / $length,
			'z' => $this->_z / $length)))));
	}

	public function add(Vector $rhs)
	{
		return (new Vector(array('dest' => new Vertex(array(
			'x' => $this->_x + $rhs->getX(),
			'y' => $this->_y + $rhs->getY(),
			'z' => $this->_z + $rhs->getZ())))));
	}

	public function sub(Vector $rhs)
	{
		return (new Vector(array('dest' => new Vertex(array(
			'x' => $this->_x - $rhs->getX(),
			'y' => $this->_y - $rhs->getY(),
			'z' => $this->_z - $rhs->getZ())))));
	}

	public function opposite()
	{
		return (new Vector(array('dest' => new Vertex(array(
			'x' => $this->_x * -1,
			'y' => $this->_y * -1,
			'z' => $this->_z * -1)))));
	}

	public function scalarProduct($k)
	{
		return (new Vector(array('dest' => new Vertex(array(
			'x' => $this->_x * $k,
			'y' => $this->_y * $k,
			'z' => $this->_z * $k)))));
	}

	public function dotProduct(Vector $rhs)
	{
		return (float)($this->_x * $rhs->getX() + $this->_y * $rhs->getY() + $this->_z * $rhs->getZ());
	}

	public function cos(Vector $rhs)
	{
		return (float)($this->dotProduct($rhs) / ($this->magnitude() * $rhs->magnitude()));
	}

	public function crossProduct(Vector $rhs)
	{
		return (new Vector(array('dest' => new Vertex(array(
			'x' => $this->_y * $rhs->getZ() - $this->_z * $rhs->getY(),
			'y' => $this->_z * $rhs->getX() - $this->_x * $rhs->getZ(),
			'z' => $this->_x * $rhs->getY() - $this->_y * $rhs->getX())))));
	}

	function __toString()
	{
		if (self::$verbose)
			return (sprintf("Vector( x:%0.2f, y:%0.2f, z:%0.2f, w:%0.2f )",
				$this->_x, $this->_y, $this->_z, $this->_w));
	}

	function __construct(array $keys)
	{
		if (!isset($keys['dest']) || empty($keys['dest']) || !($keys['dest'] instanceof Vertex))
			exit("Invalid parameters".PHP_EOL);
		if (!isset($keys['orig']) || empty($keys['orig']))
			$keys['orig'] = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 1));
		$this->_x = $keys['dest']->getX() - $keys['orig']->getX();
		$this->_y = $keys['dest']->getY() - $keys['orig']->getY();
		$this->_z = $keys['dest']->getZ() - $keys['orig']->getZ();
		$this->_w = 0.0;

		if (self::$verbose)
			echo $this." constructed".PHP_EOL;
	}

	function __destruct()
	{
		if (self::$verbose)
			echo $this." destructed".PHP_EOL;
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
}
?>